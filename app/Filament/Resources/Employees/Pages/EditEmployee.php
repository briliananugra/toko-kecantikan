<?php

namespace App\Filament\Resources\Employees\Pages;

use App\Filament\Resources\Employees\EmployeeResource;
use Filament\Resources\Pages\EditRecord;

class EditEmployee extends EditRecord
{
    protected static string $resource = EmployeeResource::class;

    // Setelah save, kembali ke halaman daftar
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
