<?php

namespace App\Http\Controllers;

use App\Models\Pemakaian;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index(Request $request)
    {
        $pemakaian = null;

        if ($request->isMethod('post')) {
            $request->validate([
                'no_kontrol' => 'required|string',
                'tahun' => 'required|integer',
                'bulan' => 'required|integer',
            ]);

            $id = $request->no_kontrol . $request->tahun . $request->bulan;
            $pemakaian = Pemakaian::where('id', $id)->first();
        }

        return view('front.index', compact('pemakaian'));
    }
}
