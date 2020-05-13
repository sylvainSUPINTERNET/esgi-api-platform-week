<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;



class TkController extends AbstractController
{

    public function me(Request $request, JWTEncoderInterface $JWTEncoder)
    {
        $data = json_decode($request->getContent(), true);

        try {
            $data = $JWTEncoder->decode($data["token"]);
            return new JsonResponse([
                ['erorr' => false],
                ['message' => "token OK"],
                ['email' => $data["username"]],
                ['exp'=> $data["exp"]],
                ['roles' => $data["roles"][0]]
            ]);
        } catch (\Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException $e) {
            return new JsonResponse([['error' => true], ['message' => "token invalid"]]);
        }

    }

}
