<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function validateToken($token)
    {
        $secret = '00e3d043e7725fa6006e634f79c770c79d30b7f2a4b86afe5188cfe7bf6250b8';
        
        $token = \substr($token,7);
        
        $tokenParts = explode('.',$token);
        $header = \base64_decode($tokenParts[0]);
        $payload = \base64_decode($tokenParts[1]);
        $signatureProvided = $tokenParts[2];
        
        $expiration = Carbon::createFromTimestamp(json_decode($payload)->exp);
        $tokenExpired = (Carbon::now()->diffInSeconds($expiration,false)<0);

        

        $base64UrlHeader = \base64_encode($header);
        $base64UrlHeader = strtr($base64UrlHeader,'+/', '-_');
        $base64UrlHeader = rtrim($base64UrlHeader,'=');
        
        $base64UrlPayload = \base64_encode($payload);
        $base64UrlPayload = strtr($base64UrlPayload,'+/', '-_');
        $base64UrlPayload = rtrim($base64UrlPayload,'=');
        
        $data =$base64UrlHeader . "." . $base64UrlPayload;
        
        
        $signature = hash_hmac('SHA512',$data, $secret,true);
        
        $base64UrlSignature = \base64_encode($signature);
        $base64UrlSignature = strtr($base64UrlSignature,'+/', '-_');
        $base64UrlSignature = rtrim($base64UrlSignature,'=');
        // verify it matches the signature provided in the token
        $signatureValid = ($base64UrlSignature === $signatureProvided);
        
        if($tokenExpired){
            return 'Token Expirado, vuelva a iniciar sesión';
        }

        if(!$signatureValid){
            return 'Token Invalido, será redireccionado a la pantalla de inicio de sesión';
        }

        return 'ok';
    }
}
