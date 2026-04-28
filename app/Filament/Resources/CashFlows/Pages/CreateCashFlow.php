<?php

namespace App\Filament\Resources\CashFlows\Pages;

use App\Filament\Resources\CashFlows\CashFlowResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCashFlow extends CreateRecord
{
    protected static string $resource = CashFlowResource::class;

    // Setelah create, kembali ke halaman daftar
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}