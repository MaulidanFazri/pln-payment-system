<?php

namespace App\Filament\Resources\PemakaianResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PemakaianResource;

class CreatePemakaian extends CreateRecord
{
    protected static ?string $title = 'Buat Pemakaian';

    protected static string $resource = PemakaianResource::class;
}
