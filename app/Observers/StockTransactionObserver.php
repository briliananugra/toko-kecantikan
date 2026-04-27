<?php

namespace App\Observers;

use App\Models\CashFlow;
use App\Models\StockTransaction;

class StockTransactionObserver
{
    // Otomatis update stok dan catat cash flow saat transaksi dibuat
    public function created(StockTransaction $stockTransaction): void
    {
        // Update stok produk otomatis
        $product = $stockTransaction->product;

        if ($stockTransaction->type === 'in') {
            // Barang masuk = tambah stok
            $product->increment('stock', $stockTransaction->quantity);
        } else {
            // Barang keluar = kurangi stok
            $product->decrement('stock', $stockTransaction->quantity);
        }

        // Catat otomatis di cash flow
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

    // Otomatis update stok dan cash flow saat transaksi diubah
    public function updated(StockTransaction $stockTransaction): void
    {
        // Ambil nilai lama sebelum diubah
        $original = $stockTransaction->getOriginal();
        $product = $stockTransaction->product;

        // Kembalikan stok ke kondisi sebelum transaksi diubah
        if ($original['type'] === 'in') {
            $product->decrement('stock', $original['quantity']);
        } else {
            $product->increment('stock', $original['quantity']);
        }

        // Terapkan stok baru sesuai transaksi yang diubah
        if ($stockTransaction->type === 'in') {
            $product->increment('stock', $stockTransaction->quantity);
        } else {
            $product->decrement('stock', $stockTransaction->quantity);
        }
    }
}