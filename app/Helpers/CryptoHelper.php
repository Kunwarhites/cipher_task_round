<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Crypt;

class CryptoHelper
{
    public static function encryptData($data, $key)
    {
        return openssl_encrypt($data, 'AES-256-CBC', base64_decode($key), 0, substr(base64_decode($key), 0, 16));
    }

    public static function decryptData($encryptedData, $key)
    {
        return openssl_decrypt($encryptedData, 'AES-256-CBC', base64_decode($key), 0, substr(base64_decode($key), 0, 16));
    }
}
