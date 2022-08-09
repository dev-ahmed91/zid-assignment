<?php


namespace App\Traits;


use Illuminate\Support\Facades\Log;

/**
 * Trait LoggingTrait
 * @package App\Traits
 */
trait LoggingTrait
{
    /**
     * @param $method
     * @param null $message
     */
    public function logInfo($method, $message = null){
        Log::info($message ? $message : "Entered to method " . $method, [
            "class"         => static::class,
            "method"        => "",
            "user_id"       => auth()->check() ? auth()->user()->id : "",
            "payload"       => request()->all(),
            "request"       => request(),
            "ip"            => request()->ip(),
            "headers"       => request()->headers,
            "status"        => 200,
        ]);
    }


    /**
     * @param $method
     * @param \Exception $exception
     * @param null $message
     * @return mixed
     */
    public function logError($method, \Exception $exception, $message = null){
        $data = [
            "error_code"    => uniqid() . time(),
            "class"         => static::class,
            "method"        => "",
            "user_id"       => auth()->check() ? auth()->user()->id : "",
            "payload"       => request()->all(),
            "request"       => request(),
            "ip"            => request()->ip(),
            "headers"       => request()->headers,
            "exception"     => [
                "code"  => $exception->getCode(),
                "message"  => $exception->getMessage(),
                "file"  => $exception->getFile(),
                "line"  => $exception->getLine(),
            ]
        ];
        Log::info($message ? $message : "Entered to method " . $method,  $data);
        return $data['error_code'];
    }
}