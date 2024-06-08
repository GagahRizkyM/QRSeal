<?php

namespace App\Http\Controllers;

use App\Models\GenerateQR;
use App\Http\Requests\StoreGenerateQRRequest;
use App\Http\Requests\UpdateGenerateQRRequest;
use Illuminate\Support\Facades\Request;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Response\QrCodeResponse;

class GenerateQRController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [];
        return view('generate', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Data sertifikat
        $data = [
            'no_sertifikat' => $request->serficate_number,
            'nama_peserta' => $request->name,
            'jenis_pelatihan' => $request->jenis_pelatian,
            'tanggal_terbit' => $request->date_terbit,
            'penandatangan' => $request->name_penandatangan,
            'tanda_tangan_digital' =>  $request->digital_code
        ];

        // Konversi data ke format JSON
        $jsonData = json_encode($data);

        // Buat QR code
        $qrCode = new QrCode($jsonData);
        $qrCode->setSize(200);
        $qrCode->setMargin(10);
        $qrCode->setEncoding('UTF-8');
        $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH);

        // Simpan QR code ke file
        $filePath = public_path('qrcodes/certificate_qr.png');
        $qrCode->writeFile($filePath);

        // Atau langsung kirimkan QR code sebagai respons (opsional)
        // return response($qrCode->writeString(), 200)->header('Content-Type', $qrCode->getContentType());

        // Lakukan hal lain yang diperlukan dalam metode create, misalnya:
        // - Menyimpan informasi sertifikat ke database
        // - Mengirim respons ke view dengan data yang diperlukan

        return view('certificates.create', ['qrCodePath' => asset('qrcodes/certificate_qr.png')]);
    }

    public function handleUpload(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGenerateQRRequest $request)
    {
        if($request->hasFile('file')) {
            $file = $request->file('file');
            // $path = $file->store('uploads', 'public');
            $path = 'oke path';
            return response()->json(['path' => $path], 200);
        }

        return response()->json(['message' => 'No file uploaded'], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(GenerateQR $generateQR)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GenerateQR $generateQR)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGenerateQRRequest $request, GenerateQR $generateQR)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GenerateQR $generateQR)
    {
        //
    }
}
