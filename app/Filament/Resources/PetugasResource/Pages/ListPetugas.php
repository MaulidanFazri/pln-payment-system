<?php

namespace App\Filament\Resources\PetugasResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\PetugasResource;

class ListPetugas extends ListRecords
{

    protected static ?string $title = 'Petugas';
    protected static string $resource = PetugasResource::class;

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
