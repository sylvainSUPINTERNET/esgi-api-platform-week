<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;



class TkController extends AbstractController
{

    public function me(Request $request, JWTEncoderInterface $JWTEncoder, EntityManagerInterface $entityManager)
    {
        $data = json_decode($request->getContent(), true);

        try {
            $data = $JWTEncoder->decode($data["token"]);

            $dt = $entityManager->getRepository(User::class)->findBy([
                "email" => $data["username"]
            ]);

            return new JsonResponse([
                ['erorr' => false],
                ['message' => "token OK"],
                ['email' => $data["username"]],
                ['exp'=> $data["exp"]],
                ['roles' => $data["roles"][0]],
                ["id" => $dt[0]->getId()]
            ]);
        } catch (\Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException $e) {
            return new JsonResponse([['error' => true], ['message' => "token invalid"]]);
        }

    }

}
