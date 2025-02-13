<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $primaryKey = 'no_kontrol';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['no_kontrol', 'nama', 'alamat', 'telepon', 'jenis_plg'];

    public static function generateNoKontrol()
    {
        // Format: YYYYMMDD + 3 digit counter
        $currentDate = date('Ymd');

        // Hitung jumlah pelanggan yang sudah terdaftar hari ini
        $countToday = Pelanggan::where('no_kontrol', 'like', $currentDate . '%')->count();

        // Tambahkan nomor urut (3 digit)
        $newNumber = str_pad($countToday + 1, 3, '0', STR_PAD_LEFT);

        // Gabungkan tanggal dan nomor urut
        return $currentDate . $newNumber;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pelanggan) {
            if (empty($pelanggan->no_kontrol)) {
                $pelanggan->no_kontrol = self::generateNoKontrol();
            }
        });
    }

    public function tarif()
    {
        return $this->belongsTo(Tarif::class, 'jenis_plg', 'jenis_plg');
    }

    public function pemakaian()
    {
        return $this->hasMany(Pemakaian::class, 'no_kontrol', 'no_kontrol');
    }
}
