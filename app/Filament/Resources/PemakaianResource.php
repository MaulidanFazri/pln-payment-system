<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Pelanggan;
use App\Models\Pemakaian;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Actions;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PemakaianResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PemakaianResource\RelationManagers;

class PemakaianResource extends Resource
{

    protected static ?string $navigationLabel = 'Pemakaian';

    protected static ?string $model = Pemakaian::class;

    protected static ?string $navigationIcon = 'heroicon-o-bolt';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        Select::make('no_kontrol')
                            ->label('No Kontrol')
                            ->relationship('pelanggan', 'no_kontrol')
                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->no_kontrol} - {$record->nama}")
                            ->searchable()
                            ->preload()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $pelanggan = Pelanggan::with('tarif')->where('no_kontrol', $state)->first();

                                // Isi meter_awal dari record sebelumnya
                                $lastRecord = Pemakaian::where('no_kontrol', $state)
                                    ->orderBy('tahun', 'desc')
                                    ->orderBy('bulan', 'desc')
                                    ->first();
                                $set('meter_awal', $lastRecord ? $lastRecord->meter_akhir : 0);

                                // Isi biaya_beban dari relasi tarif
                                if ($pelanggan && $pelanggan->tarif) {
                                    $set('biaya_beban', $pelanggan->tarif->biaya_beban);
                                    $set('tarif_kwh', $pelanggan->tarif->tarif_kwh);  // Simpan tarif_kwh untuk digunakan nanti
                                } else {
                                    $set('biaya_beban', 0);
                                    $set('tarif_kwh', 0);
                                }
                            }),

                        Select::make('tahun')
                            ->label('Tahun')
                            ->options([
                                '2025' => '2025',
                                '2026' => '2026',
                                '2027' => '2027',
                                '2028' => '2028',
                                '2029' => '2029',
                                '2030' => '2030',
                            ])
                            ->required(),

                        Select::make('bulan')
                            ->label('Bulan')
                            ->options([
                                '1'  => 'Januari',
                                '2'  => 'Februari',
                                '3'  => 'Maret',
                                '4'  => 'April',
                                '5'  => 'Mei',
                                '6'  => 'Juni',
                                '7'  => 'Juli',
                                '8'  => 'Agustus',
                                '9'  => 'September',
                                '10' => 'Oktober',
                                '11' => 'November',
                                '12' => 'Desember',
                            ])
                            ->required(),
                    ]),

                Grid::make(3)
                    ->schema([
                        TextInput::make('meter_awal')
                            ->label('Meter Awal')
                            ->required()
                            ->numeric()
                            ->minValue(0)

                            ->type('number')
                            ->reactive(),

                        TextInput::make('meter_akhir')
                            ->label('Meter Akhir')
                            ->required()
                            ->type('number')
                            ->numeric()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                $meterAwal = $get('meter_awal') ?? 0;

                                // Jika meter akhir lebih kecil dari meter awal, reset ke meter awal
                                if ($state < $meterAwal) {
                                    $set('meter_akhir', $meterAwal);
                                }

                                $jumlahPakai = max(0, $get('meter_akhir') - $meterAwal);
                                $set('jumlah_pakai', $jumlahPakai);

                                // Hitung biaya_pemakaian
                                $tarifKwh = $get('tarif_kwh') ?? 0;
                                $biayaPemakaian = $jumlahPakai * $tarifKwh;
                                $set('biaya_pemakaian', $biayaPemakaian);

                                $totalBayar = $biayaPemakaian + ($get('biaya_beban') ?? 0);
                                $set('total_bayar', $totalBayar);
                            })
                            ->rule(function (Closure $get) {
                                $meterAwal = $get('meter_awal') ?? 0;
                                return fn($state) => $state >= $meterAwal ? null : 'Meter Akhir tidak boleh lebih kecil dari Meter Awal.';
                            }),

                        TextInput::make('jumlah_pakai')
                            ->label('Jumlah Pakai')
                            ->numeric()
                            ->type('number')

                            ->required(),
                    ]),

                Grid::make(3)
                    ->schema([

                        TextInput::make('biaya_beban')
                            ->label('Biaya Beban')
                            ->type('number')
                            ->numeric()
                            ->required(),

                        TextInput::make('biaya_pemakaian')
                            ->label('Biaya Pemakaian')
                            ->type('number')
                            ->numeric()
                            ->required(),

                        TextInput::make('total_bayar')
                            ->label('Total Bayar')
                            ->type('number')
                            ->numeric()
                            ->required(),
                    ]),
            ]);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('tahun', 'desc')
            ->defaultSort('bulan', 'desc')
            ->columns([
                // TextColumn::make('id')
                //     ->label('ID'),

                TextColumn::make('no_kontrol')
                    ->label('No Kontrol')
                    ->searchable(),

                TextColumn::make('tahun')
                    ->label('Tahun')
                    ->sortable(),

                TextColumn::make('bulan')
                    ->label('Bulan'),

                TextColumn::make('pelanggan.nama')
                    ->label('Nama')
                    ->searchable(),

                TextColumn::make('pelanggan.alamat')
                    ->label('Alamat'),

                TextColumn::make('jumlah_pakai')
                    ->label('Jumlah Pakai'),

                TextColumn::make('biaya_beban')
                    ->label('Biaya Beban')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 2, ',', '.')),

                TextColumn::make('biaya_pemakaian')
                    ->label('Biaya Pemakaian')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 2, ',', '.')),

                TextColumn::make('total_bayar')
                    ->label('Total Bayar')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 2, ',', '.')),
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

                    Action::make('cetak')
                        ->label('Cetak')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->url(fn($record) => route('pemakaian.cetak', $record->id))
                        ->color('success')
                        ->openUrlInNewTab(),
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
            'index' => Pages\ListPemakaians::route('/'),
            'create' => Pages\CreatePemakaian::route('/create'),
            'edit' => Pages\EditPemakaian::route('/{record}/edit'),
        ];
    }
}
