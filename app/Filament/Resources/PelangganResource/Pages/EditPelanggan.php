<?php

namespace App\Filament\Resources\PelangganResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\PelangganResource;

class EditPelanggan extends EditRecord
{
    protected static ?string $title = 'Edit Pelanggan';

    protected static string $resource = PelangganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function authorizeAccess(): void
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Forbidden');
        }
    }
}
