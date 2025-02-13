<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemakaian extends Model
{
    protected $table = 'pemakaians';
    public $incrementing = false;  // Nonaktifkan auto-increment
    protected $primaryKey = 'id';
    protected $fillable = ['no_kontrol', 'tahun', 'bulan', 'meter_awal', 'meter_akhir', 'jumlah_pakai', 'biaya_beban', 'biaya_pemakaian', 'total_bayar'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pemakaian) {
            if (empty($pemakaian->id)) {
                $pemakaian->id = "{$pemakaian->no_kontrol}{$pemakaian->tahun}{$pemakaian->bulan}";
            }
        });


        static::saving(function ($pemakaian) {
            // Ambil tarif_kwh dari relasi pelanggan → tarif
            $tarifKwh = $pemakaian->pelanggan->tarif->tarif_kwh ?? 0;

            // Hitung biaya_pemakaian
            $pemakaian->biaya_pemakaian = ($pemakaian->jumlah_pakai ?? 0) * $tarifKwh;

            // Hitung total_bayar
            $pemakaian->total_bayar = ($pemakaian->biaya_beban ?? 0) + ($pemakaian->biaya_pemakaian ?? 0);
        });
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'no_kontrol', 'no_kontrol');
    }

    public function tarif()
    {
        return $this->belongsToThrough(Tarif::class, Pelanggan::class, null, '', [Tarif::class => 'jenis_plg', Pelanggan::class => 'jenis_plg']);
    }

    public function cetak($id)
    {
        $pemakaian = Pemakaian::with('pelanggan.tarif')->findOrFail($id);

        // Jika ingin mengembalikan halaman HTML untuk cetak:
        return view('pemakaian.cetak', compact('pemakaian'));

        // Jika ingin langsung unduh sebagai PDF (gunakan Barryvdh DomPDF):
        // $pdf = Pdf::loadView('pemakaian.cetak', compact('pemakaian'));
        // return $pdf->download('rekening-listrik-' . $pemakaian->id . '.pdf');
    }
}
