<?php

namespace App\Http\Controllers;

use App\Models\GenerateQR;
use App\Http\Requests\StoreGenerateQRRequest;
use App\Http\Requests\UpdateGenerateQRRequest;
use App\Models\GenareteQRFile;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Response\QrCodeResponse;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

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
    public function create(StoreGenerateQRRequest $request)
    {
        // Data sertifikat
        DB::beginTransaction();

        try {
            $data = [
                'serficate_number' => $request->serficate_number,
                'name' => $request->name,
                'jenis_pelatian' => $request->jenis_pelatian,
                'date_terbit' => $request->date_terbit,
                'name_penandatangan' => $request->name_penandatangan,
                'digital_code' =>  $request->digital_code,
                'fileInput' => $request->file('fileInput'),
            ];

            $model = new GenerateQR();
            $model->serficate_number = $data['serficate_number'];
            $model->name = $data['name'];
            $model->jenis_pelatian = $data['jenis_pelatian'];
            $model->date_terbit = $data['date_terbit'];
            $model->name_penandatangan = $data['name_penandatangan'];
            $model->digital_code = $data['digital_code'];
            $model->save();

            if (isset($data['fileInput'])) {
                $file = $data['fileInput'];

                $qrFile = GenareteQRFile::where('generate_qr_id', $model->id)->first();

                if (empty($qrFile)) {
                    $qrFile = new GenareteQRFile();
                }

                if (!empty($qrFile->path)) {
                    if (File::exists(storage_path('app/public/' . $qrFile->path))) {
                        File::delete(storage_path('app/public/' . $qrFile->path));
                    }
                }

                $changedName = time() . $file->getClientOriginalName();
                $path = 'sertifikat/' . $model->id;
                $qrFile->generate_qr_id = $model->id;
                $qrFile->name = $changedName;
                $qrFile->path = $path . '/' . $changedName;
                $qrFile->size = $file->getSize();
                $qrFile->type = 'file';
                $qrFile->ext = $file->getClientOriginalExtension();
                $file->storeAs('public/'.$path, $changedName);
                $qrFile->save();
            }

            // Konversi data ke format JSON

            // Buat QR code
            $isiQQR = url('preview/' . $model->id . '?rsa=' . $model->digital_code);
            $qrCode = new QrCode($isiQQR);
            $qrCode->setSize(200);
            $qrCode->setMargin(5);
            $qrCode->setEncoding(new Encoding('UTF-8'));
            $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::High);

            // Simpan QR code ke file
            $directoryPath = storage_path('app/public/sertifikat/' . $model->id);
            $nameQR = 'certificate_qr' . $model->id . '.png';
            $filePath = $directoryPath . '/' . $nameQR;

            // Ensure the directory exists
            if (!File::exists($directoryPath)) {
                File::makeDirectory($directoryPath, 0755, true);
            }

            if (File::exists($filePath)) {
                File::delete($filePath);
            }

            $writer = new PngWriter();
            $result = $writer->write($qrCode);
            $result->saveToFile($filePath); // Ensure path is correct

            $qrFileQR = new GenareteQRFile();
            $qrFileQR->generate_qr_id = $model->id;
            $qrFileQR->name = $nameQR;
            // $qrFileQR->path = 'app  /public/' . $model->id . '/' . $nameQR; // Path relative to the storage/public
            $qrFileQR->path = 'sertifikat/' . $model->id . '/' . $nameQR; // Path relative to the storage/public
            $qrFileQR->type = 'qr';

            $qrFileQR->save();

            DB::commit();

            return redirect()->route('preview', ['rsa' => $model->digital_code, 'id' => $model->id])->with('success', 'Certificate created successfully!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }


    public function handleUpload(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGenerateQRRequest $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('uploads', 'public');
            // $path = 'oke path';
            // dd($path);
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
