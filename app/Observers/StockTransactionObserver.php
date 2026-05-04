<?php

namespace App\Observers;

use App\Models\CashFlow;
use App\Models\StockTransaction;
use Illuminate\Validation\ValidationException;

class StockTransactionObserver
{
    public function creating(StockTransaction $stockTransaction): void
    {
        // Validasi stok tidak boleh minus saat barang keluar
        if ($stockTransaction->type === 'out') {
            $product = $stockTransaction->product;
            if ($stockTransaction->quantity > $product->stock) {
                throw ValidationException::withMessages([
                    'quantity' => 'Stok tidak mencukupi! Stok tersedia: ' . $product->stock . ' ' . $product->unit,
                ]);
            }
        }
    }

    public function created(StockTransaction $stockTransaction): void
    {
        $product = $stockTransaction->product;

        if ($stockTransaction->type === 'in') {
            $product->increment('stock', $stockTransaction->quantity);
        } else {
            $product->decrement('stock', $stockTransaction->quantity);
        }

        CashFlow::create([
            'type' => $stockTransaction->type === 'in' ? 'expense' : 'income',
            'category' => $stockTransaction->type === 'in' ? 'pembelian_stok' : 'penjualan',
            'amount' => $stockTransaction->quantity * $stockTransaction->price_per_unit,
            'description' => $stockTransaction->type === 'in'
                ? 'Pembelian stok: ' . $product->name
                : 'Penjualan: ' . $product->name,
            'date' => $stockTransaction->date,
        ]);
    }

    public function updated(StockTransaction $stockTransaction): void
    {
        $original = $stockTransaction->getOriginal();
        $product = $stockTransaction->product;

        if ($original['type'] === 'in') {
            $product->decrement('stock', $original['quantity']);
        } else {
            $product->increment('stock', $original['quantity']);
        }

        if ($stockTransaction->type === 'in') {
            $product->increment('stock', $stockTransaction->quantity);
        } else {
            $product->decrement('stock', $stockTransaction->quantity);
        }
    }

    public function deleted(StockTransaction $stockTransaction): void
    {
        $product = $stockTransaction->product;

        if ($stockTransaction->type === 'in') {
            // Kalau transaksi masuk dihapus → kurangi stok
            if ($product->stock < $stockTransaction->quantity) {
                throw new \Exception("Tidak bisa hapus transaksi: stok produk tidak mencukupi untuk dikembalikan.");
            }
            $product->decrement('stock', $stockTransaction->quantity);
        } elseif ($stockTransaction->type === 'out') {
            // Kalau transaksi keluar dihapus → kembalikan stok
            $product->increment('stock', $stockTransaction->quantity);
        }
    }
}