<?php

namespace App\Base;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

abstract class ApiController extends BaseController
{
    /**
     * @return Request
     */
    public function request()
    {
        return app(Request::class);
    }

    /**
     * @param array $data
     * @return JsonResponse
     */
    public function success(array $data = [])
    {
        return new JsonResponse($data);
    }

    /**
     * @param string $error
     * @return JsonResponse
     */
    public function error($error)
    {
        return new JsonResponse(compact('error'), 500);
    }
}
