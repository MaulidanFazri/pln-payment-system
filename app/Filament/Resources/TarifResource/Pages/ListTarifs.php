<?php

namespace App\Filament\Resources\TarifResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\TarifResource;
use Filament\Resources\Pages\ListRecords;


class ListTarifs extends ListRecords
{
    protected static string $resource = TarifResource::class;

    protected static ?string $title = 'Tarif';

    protected function authorizeAccess(): void
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Forbidden');
        }
    }



    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
