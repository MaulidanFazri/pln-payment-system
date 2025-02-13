<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Tarif;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TarifResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TarifResource\RelationManagers;

class TarifResource extends Resource
{


    protected static ?string $navigationLabel = 'Tarif';

    protected static ?string $model = Tarif::class;


    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();
        return $user instanceof User && $user->role === 'admin';
    }


    public static function canViewAny(): bool
    {
        $user = Auth::user();
        return $user && $user->role === 'admin';
    }

    public static function canCreate(): bool
    {
        $user = Auth::user();
        return $user && $user->role === 'admin';
    }

    public static function canDelete(Model $record): bool
    {
        $user = Auth::user();
        return $user && $user->role === 'admin';
    }

    public static function canEdit(Model $record): bool
    {
        $user = Auth::user();
        return $user && $user->role === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('jenis_plg')
                    ->label('Jenis Pelanggan')
                    ->required()
                    ->unique(),

                TextInput::make('biaya_beban')
                    ->label('Biaya Beban')
                    ->type('number')
                    ->numeric()
                    ->minValue(0)
                    ->inputMode('decimal')
                    ->required(),

                TextInput::make('tarif_kwh')
                    ->label('Tarif KWH')
                    ->type('number')
                    ->numeric()
                    ->minValue(0)
                    ->inputMode('decimal')
                    ->required(),

                TextInput::make('batas_daya')
                    ->label('Batas Daya')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('jenis_plg')
                    ->label('Jenis Pelanggan')
                    ->searchable(),

                TextColumn::make('biaya_beban')
                    ->label('Biaya Beban')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 2, ',', '.')),


                TextColumn::make('tarif_kwh')
                    ->label('Tarif KWH')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 2, ',', '.')),

                TextColumn::make('batas_daya')
                    ->label('Batas Daya'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTarifs::route('/'),
            'create' => Pages\CreateTarif::route('/create'),
            'edit' => Pages\EditTarif::route('/{record}/edit'),
        ];
    }
}
