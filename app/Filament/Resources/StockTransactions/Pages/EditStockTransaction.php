<?php

namespace App\Filament\Resources\StockTransactions\Pages;

use App\Filament\Resources\StockTransactions\StockTransactionResource;
use Filament\Resources\Pages\EditRecord;

class EditStockTransaction extends EditRecord
{
    protected static string $resource = StockTransactionResource::class;

    // Setelah save, kembali ke halaman daftar
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}