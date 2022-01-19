<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\APIBaseController;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;

class APIUserController extends APIBaseController
{
    public $baseUrl = 'https://apijkn-dev.bpjs-kesehatan.go.id/vclaim-rest-dev/';
    public $cons_id = "8761";
    public $secretKey = "5hTEA8A088";
    public $userkey = "43b7eeb0f3f8e1935b5a41677432e41c";

    public function getSignature()
    {
        date_default_timezone_set('UTC');
        $tStamp = strval(time() - strtotime('1970-01-01 00:00:00'));
        $signature = hash_hmac('sha256', $this->cons_id . "&" . $tStamp, $this->secretKey, true);
        $encodedSignature = base64_encode($signature);
        $response = array(
            'user_key' => $this->userkey,
            'X-cons-id' => $this->cons_id,
            'X-timestamp' => $tStamp,
            'X-signature' => $encodedSignature,
            'decrypt_key' =>$this->cons_id.$this->secretKey.$tStamp,
        );
        return $response;
    }
    function stringDecrypt($key, $string)
    {
        $encrypt_method = 'AES-256-CBC';
        $key_hash = hex2bin(hash('sha256', $key));
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
        $output = \LZCompressor\LZString::decompressFromEncodedURIComponent($output);
        return $output;
    }
    function decompress($string)
    {

        return \LZCompressor\LZString::decompressFromEncodedURIComponent($string);
    }
    public function index()
    {
        $url = $this->baseUrl . 'referensi/propinsi';
        $response = Http::withHeaders([
            'user_key' => $this->getSignature()['user_key'],
            'X-cons-id' => $this->getSignature()['X-cons-id'],
            'X-timestamp' => $this->getSignature()['X-timestamp'],
            'X-signature' => $this->getSignature()['X-signature'],
        ])->get($url);
        $response = json_decode($response, true);
        if (!empty($response)) {
            $decrypt = $this->stringDecrypt($this->getSignature()['decrypt_key'], $response['response']);
        }else{
            dd('error');
        }
        return $decrypt;
    }
    public function getKabupaten($key)
    {
        $key = 200;
        $url = $this->baseUrl . 'referensi/kabupaten/propinsi/'.$key;
        $response = Http::withHeaders([
            'user_key' => $this->getSignature()['user_key'],
            'X-cons-id' => $this->getSignature()['X-cons-id'],
            'X-timestamp' => $this->getSignature()['X-timestamp'],
            'X-signature' => $this->getSignature()['X-signature'],
        ])->get($url);
        $response = json_decode($response, true);
        if (!empty($response)) {
            $decrypt = $this->stringDecrypt($this->getSignature()['decrypt_key'], $response['response']);
        }else{
            dd('error');
        }
    }
    public function create()
    {
        return view('user::create');
    }
    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        return view('user::show');
    }

    public function edit($id)
    {
        return view('user::edit');
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
