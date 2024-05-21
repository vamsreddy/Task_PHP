<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Annotations as OA;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests , DispatchesJobs;

    /**
         * @OA\OpenApi(
         *      @OA\Info(
         *          version="1.0.0",
         *          title="Swagger",
         *          description="API documentation using Swagger"
         *      )
         * )
         */
}
