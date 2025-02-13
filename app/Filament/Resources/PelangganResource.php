<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Pelanggan;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PelangganResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PelangganResource\RelationManagers;

class PelangganResource extends Resource
{
    protected static ?string $navigationGroup = 'Account';

    protected static ?string $navigationLabel = 'Pelanggan';

    protected static ?string $model = Pelanggan::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

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
                TextInput::make('no_kontrol')
                    ->default(fn() => Pelanggan::generateNoKontrol())
                    ->label('No Kontrol')
                    ->required()
                    ->disabled(),

                TextInput::make('nama')
                    ->label('Nama')
                    ->required(),

                Textarea::make('alamat')
                    ->label('Alamat')
                    ->autosize()
                    ->required(),

                TextInput::make('telepon')
                    ->label('Nomor Telepon')
                    ->type('tel')
                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                    ->required(),

                Select::make('jenis_plg')
                    ->relationship('tarif', 'jenis_plg')
                    ->searchable()
                    ->label('Jenis Pelanggan')
                    ->preload()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no_kontrol')
                    ->label('No Kontrol')
                    ->searchable(),

                TextColumn::make('nama')
                    ->label('Nama'),

                TextColumn::make('alamat')
                    ->label('Alamat'),

                TextColumn::make('telepon')
                    ->label('Nomor Telepon'),

                TextColumn::make('tarif.jenis_plg')
                    ->label('Jenis Pelanggan'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    DeleteAction::make()
                    ->label('Hapus')
                    ->icon('heroicon-o-trash')
                    ->color('danger'),

                    Tables\Actions\EditAction::make()
                        ->color('warning'),
                ]),
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
            'index' => Pages\ListPelanggans::route('/'),
            'create' => Pages\CreatePelanggan::route('/create'),
            'edit' => Pages\EditPelanggan::route('/{record}/edit'),
        ];
    }
}
