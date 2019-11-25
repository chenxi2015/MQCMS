<?php


namespace App\Controller\api\v1;


use App\Controller\AbstractController;
use App\Middleware\Auth\AuthMiddleware;

class BaseController extends AbstractController
{
    public function getAuthHeaderInfo()
    {
        return AuthMiddleware::$authHeader;
    }

    public function validateAuthToken()
    {
        
    }
}