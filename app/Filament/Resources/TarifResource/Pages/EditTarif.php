<?php

namespace App\Filament\Resources\TarifResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\TarifResource;

class EditTarif extends EditRecord
{
    protected static ?string $title = 'Edit Tarif';

    protected static string $resource = TarifResource::class;

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
