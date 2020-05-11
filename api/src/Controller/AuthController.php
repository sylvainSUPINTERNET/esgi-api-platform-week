<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends AbstractController
{

    public function register(Request $request, UserRepository $userRepository)
    {

        $roles[] = $request->request->get('roles');

        $newUserData['email']    = $request->request->get('email');
        $newUserData['password'] = $request->request->get('password');
        
        $newUserData['roles'] = $roles;

        $user = $userRepository->createNewUser($newUserData);


        return new JsonResponse(['username'=>$user->getUsername(), 'email' => $user->getEmail(), 'roles' => $user->getRoles()[0]]);
    }

}
