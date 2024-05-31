<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use phpseclib3\Crypt\RSA;

class RsaService
{
    private $privateKey;
    private $privateKeyRSA;
    private $publicKey;
    private $publicKeyRSA;

    public function __construct()
    {
        $this->privateKey = file_get_contents(storage_path('app/public/rsa/private.key'));
        $this->privateKeyRSA = file_get_contents(storage_path('rsa_private.pem'));
        $this->publicKey = file_get_contents(storage_path('app/public/rsa/public.key'));
        $this->publicKeyRSA = file_get_contents(storage_path('rsa_public.pem'));
    }

    public function encrypt($data)
    {
        if (openssl_public_encrypt($data, $encrypted, $this->publicKey)) {
            return base64_encode($encrypted);
        }
        return null;
    }

    public function encryptRsa($data){
        $rsa = RSA::load($this->publicKeyRSA);
        $encrypted = $rsa->encrypt($data);
        return base64_encode($encrypted);
    }

    public function decrypt($data)
    {
        $data = base64_decode($data);
        if (openssl_private_decrypt($data, $decrypted, $this->privateKey)) {
            return $decrypted;
        } else {
            // Debugging: Get error details
            $error = openssl_error_string();
            error_log("Decryption error: " . $error);
            return null;
        }
    }

    public function decryptRsa($data){
        $privateKey = RSA::load($this->privateKeyRSA);
        $ciphertext = base64_decode($data);

        $plaintext = $privateKey->decrypt($ciphertext);
        return $plaintext;
    }
}
