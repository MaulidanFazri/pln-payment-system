<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    protected $primaryKey = 'jenis_plg';  // Primary key diubah menjadi 'jenis_plg'
    public $incrementing = false;  // Karena bukan integer
    protected $keyType = 'string';
    protected $fillable = ['jenis_plg', 'biaya_beban', 'tarif_kwh', 'batas_daya'];

    public function pelanggan()
    {
        return $this->hasMany(Pelanggan::class, 'jenis_plg', 'jenis_plg');
    }
}
