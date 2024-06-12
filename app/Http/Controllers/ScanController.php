<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function scan()
    {
        return view('scan');
    }

    public function checkBarcode(Request $request)
    {
        $barcode = $request->input('barcode');
        $generate_qr_id = $request->input('generate_qr_id');

        $exists = GenerateQRFile::where('name', $barcode)
                                 ->where('generate_qr_id', $generate_qr_id)
                                   ->exists();

        return response()->json(['exists' => $exists]);
    }

}
