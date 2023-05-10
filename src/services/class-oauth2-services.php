<?php

namespace nGoogleLogin\Services;

class Oauth2Services
{
    public function __construct()
    {
    }

    public function getUserInfo($service)
    {

        try {
            $user_info = $service->userinfo->get();
            return json_encode($user_info);
        } catch (Exception $e) {
            return $e->getTrace();
        }
    }
}
