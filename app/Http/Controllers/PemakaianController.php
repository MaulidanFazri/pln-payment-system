<?php

namespace App\Http\Controllers;

use App\Models\Pemakaian;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PemakaianController extends Controller
{
    public function cetak($id)
    {
        $pemakaian = Pemakaian::with('pelanggan.tarif')->findOrFail($id);

        // Atur ukuran halaman custom (misalnya ukuran struk kecil)
        $pdf = Pdf::loadView('pemakaian.cetak', compact('pemakaian'))
            ->setPaper([0, 0, 310, 385]); // Lebar 80mm, Tinggi disesuaikan (1 inch = 72 points)

        // Return PDF sebagai download
        return $pdf->download('rekening-listrik-' . $pemakaian->id . '.pdf');
    }
}
