<?php

namespace App\Filament\Resources\PetugasResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\PetugasResource;

class EditPetugas extends EditRecord
{
    protected static ?string $title = 'Edit Petugas';

    protected static string $resource = PetugasResource::class;

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
