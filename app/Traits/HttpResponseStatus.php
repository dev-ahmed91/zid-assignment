<?php


namespace App\Traits;


/**
 * Trait HttpResponseStatus
 * @package App\Traits
 */
trait HttpResponseStatus
{
    /**
     * @param array $data
     * @param string $message
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    protected function successResponse($data = [], $message = 'success')
    {
        return response([
            'success' => true,
            'status_code'  => 200,
            'message'  => $message,
            'data' => $data,
        ], 200);
    }

    /**
     * @param $status
     * @param $message
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    protected function failureResponse($status, $message)
    {
        return response([
            'success' => false,
            'status_code'  => $status,
            'message' => $message,
        ], $status);
    }
}