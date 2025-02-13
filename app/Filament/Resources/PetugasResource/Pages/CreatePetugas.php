<?php

namespace App\Filament\Resources\PetugasResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PetugasResource;

class CreatePetugas extends CreateRecord
{
    protected static ?string $title = 'Buat Petugas';

    protected static string $resource = PetugasResource::class;

    protected function authorizeAccess(): void
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Forbidden');
        }
    }
}
