<?php

namespace App\Filament\Resources\PelangganResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PelangganResource;

class CreatePelanggan extends CreateRecord
{
    protected static ?string $title = 'Buat Pelanggan';

    protected static string $resource = PelangganResource::class;

    protected function authorizeAccess(): void
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Forbidden');
        }
    }
}
