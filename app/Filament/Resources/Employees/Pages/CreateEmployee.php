<?php

namespace App\Filament\Resources\Employees\Pages;

use App\Filament\Resources\Employees\EmployeeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;

    // Setelah create, kembali ke halaman daftar
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
