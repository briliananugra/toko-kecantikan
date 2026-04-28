<?php

namespace App\Filament\Resources\StockTransactions\Pages;

use App\Filament\Resources\StockTransactions\StockTransactionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStockTransaction extends CreateRecord
{
    protected static string $resource = StockTransactionResource::class;

    // Setelah create, kembali ke halaman daftar
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}