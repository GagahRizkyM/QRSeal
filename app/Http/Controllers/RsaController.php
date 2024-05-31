<?php

namespace App\Http\Controllers;

use App\Services\RsaService;
use Illuminate\Http\Request;

use phpseclib3\Crypt\RSA;

class RsaController extends Controller
{
    protected $rsaService;

    public function __construct(RsaService $rsaService)
    {
        $this->rsaService = $rsaService;
    }

    public function encrypt(Request $request)
    {
        $data = $request->input('data');
        $encryptedData = $this->rsaService->encrypt($data);
        $encryptRsa = $this->rsaService->encryptRsa($data);
        $result = [
            'encrypted' => $encryptedData,
            'encryptedRsa' => $encryptRsa,
        ];
        return response()->json($result);
    }

    public function decrypt(Request $request)
    {
        $data1 = $request->input('data1');
        $data2 = $request->input('data2');
        $decryptedData = $this->rsaService->decrypt($data1);
        $decryptRsa = $this->rsaService->decryptRsa($data2);
        $result = [
            'decrypted' => $decryptedData,
            'decryptRsa' => $decryptRsa,
        ];

        return response()->json($result);
    }

    public function testEncryptionDecryption(Request $request)
    {
        $data = $request->input('kata');
        $encryptedData = $this->rsaService->encrypt($data);

        if ($encryptedData) {
            $decryptedData = $this->rsaService->decrypt($encryptedData);
            return response()->json(['original' => $data, 'encrypted' => $encryptedData, 'decrypted' => $decryptedData]);
        }

        return response()->json(['error' => 'Encryption failed'], 500);
    }
}
