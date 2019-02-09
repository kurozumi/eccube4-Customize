<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Customize\Security\Http\Logout;

use Symfony\Component\Security\Http\Logout\LogoutHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Description of LogoutHander
 *
 * @author Akira Kurozumi <info@a-zumi.net>
 */
class LogoutHander implements LogoutHandlerInterface {

    public function logout(Request $request, Response $response, TokenInterface $token)
    {
        var_dump(get_class($token));
        exit;
    }

}
