<?php

namespace App\Observers;

use App\Models\CashFlow;
use App\Models\StockTransaction;

class StockTransactionObserver
{
    // Otomatis buat cash flow saat transaksi stok dibuat
    public function created(StockTransaction $stockTransaction): void
    {
        CashFlow::create([
            // Kalau barang masuk = pengeluaran (beli stok)
            // Kalau barang keluar = pemasukan (hasil jual)
            'type' => $stockTransaction->type === 'in' ? 'expense' : 'income',

            // Kategori otomatis berdasarkan jenis transaksi
            'category' => $stockTransaction->type === 'in' ? 'pembelian_stok' : 'penjualan',

            // Jumlah uang = jumlah barang x harga per satuan
            'amount' => $stockTransaction->quantity * $stockTransaction->price_per_unit,

            // Keterangan otomatis
            'description' => $stockTransaction->type === 'in'
                ? 'Pembelian stok: ' . $stockTransaction->product->name
                : 'Penjualan: ' . $stockTransaction->product->name,

            // Tanggal sama dengan tanggal transaksi stok
            'date' => $stockTransaction->date,
        ]);
    }

    // Otomatis update cash flow saat transaksi stok diubah
    public function updated(StockTransaction $stockTransaction): void
    {
        // Hapus cash flow lama lalu buat yang baru
        CashFlow::where('description', 'like', '%' . $stockTransaction->product->name . '%')
            ->whereDate('date', $stockTransaction->date)
            ->delete();

        $this->created($stockTransaction);
    }
}