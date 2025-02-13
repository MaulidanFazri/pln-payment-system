<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Pelanggan;
use App\Models\Pemakaian;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $petugas = User::where('role', 'petugas')->count();
        $pelanggan = Pelanggan::count();
        $pendapatan = Pemakaian::sum('total_bayar');

        return [
            Stat::make('Total Petugas', $petugas)
                ->icon('heroicon-s-user')
                ->chart([20, 10, 15, 5, 10, 15, 1])
                ->color('primary'),
            Stat::make('Total Pelanggan', $pelanggan)
                ->icon('heroicon-s-user-group')
                ->chart([1, 4, 8, 2, 6, 5, 7])
                ->color('primary'),
            Stat::make('Pendapatan', 'Rp ' . number_format($pendapatan, 2, ',', '.'))
                ->icon('heroicon-s-currency-dollar')
                ->chart([10, 2, 10, 3, 15, 4, 17])
                ->color('primary'),

        ];
    }
}
