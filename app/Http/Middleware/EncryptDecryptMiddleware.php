<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\CryptoHelper;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
class EncryptDecryptMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $encryptionKey = $request->header('Encryption-Key');
        // dd($encryptionKey);
        if (!$encryptionKey) {
            return response()->json(['message' => 'Missing Encryption-Key header'], 401);
        }
        if ($request->isMethod('post') || $request->isMethod('put') || $request->isMethod('patch')) {
            $this->encryptRequestData($request, $encryptionKey);
        }

        $response = $next($request);

        if ($response->isSuccessful() && $request->isMethod('get')) {
            $this->decryptResponseData($response, $encryptionKey);
        }

        return $response;
    }

    private function encryptRequestData(Request $request, $key)
    {
        $encryptedData = [];

        foreach ($request->all() as $field => $value) {
            if (is_string($value)) {
                $encryptedData[$field] = CryptoHelper::encryptData($value, $key);
            } else {
                $encryptedData[$field] = $value;
            }
        }

        $request->merge($encryptedData);
    }

    private function decryptResponseData(Response $response, $key)
    {
        $content = json_decode($response->getContent(), true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($content)) {
            foreach ($content as $field => $value) {
                if (is_string($value)) {
                    $decrypted = CryptoHelper::decryptData($value, $key);
                    if ($decrypted !== false) {
                        $content[$field] = $decrypted;
                    }
                }
            }

            $response->setContent(json_encode($content));
        }
    }
}
