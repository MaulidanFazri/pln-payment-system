<?php

namespace App\Filament\Resources\PemakaianResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\PemakaianResource;

class ListPemakaians extends ListRecords
{
    protected static ?string $title = 'Pemakaian';
    protected static string $resource = PemakaianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
