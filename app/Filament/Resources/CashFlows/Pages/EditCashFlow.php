<?php

namespace App\Filament\Resources\CashFlows\Pages;

use App\Filament\Resources\CashFlows\CashFlowResource;
use Filament\Resources\Pages\EditRecord;

class EditCashFlow extends EditRecord
{
    protected static string $resource = CashFlowResource::class;

    // Setelah save, kembali ke halaman daftar
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}