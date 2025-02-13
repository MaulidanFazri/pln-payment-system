<?php

namespace App\Filament\Resources\PelangganResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\PelangganResource;

class ListPelanggans extends ListRecords
{
    protected static string $resource = PelangganResource::class;

    protected static ?string $title = 'Pelanggan';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function authorizeAccess(): void
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Forbidden');
        }
    }
}
