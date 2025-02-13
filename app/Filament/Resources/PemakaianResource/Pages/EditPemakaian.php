<?php

namespace App\Filament\Resources\PemakaianResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\PemakaianResource;

class EditPemakaian extends EditRecord
{

    protected static ?string $title = 'Edit Pemakaian';
    protected static string $resource = PemakaianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
