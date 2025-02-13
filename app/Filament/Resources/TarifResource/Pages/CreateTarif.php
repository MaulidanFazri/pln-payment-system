<?php

namespace App\Filament\Resources\TarifResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\TarifResource;
use Filament\Resources\Pages\CreateRecord;


class CreateTarif extends CreateRecord
{
    protected static ?string $title = 'Buat Tarif';

    protected static string $resource = TarifResource::class;

    protected function authorizeAccess(): void
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Forbidden');
        }
    }
}
