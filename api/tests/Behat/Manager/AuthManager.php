<?php

namespace App\Tests\Behat\Manager;

use ApiPlatform\Core\Api\IriConverterInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Fidry\AliceDataFixtures\Loader\PersisterLoader;
use Fidry\AliceDataFixtures\ProcessorInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class AuthManager implements ProcessorInterface
{

    /**
     * @var PersisterLoader
     */
    private $fixtureLoader;
    private $fixtureManager;
    private $JWTManager;
    private $em;
    private $accessToken;

    public function __construct(IriConverterInterface $iriConverter, KernelInterface $kernel, FixtureManager $fixtureManager,JWTTokenManagerInterface $JWTManager, EntityManagerInterface $entityManager)
    {
        $this->fixtureLoader = $kernel->getContainer()->get('fidry_alice_data_fixtures.loader.doctrine');
        $this->fixtureManager = $fixtureManager;
        $this->em = $entityManager;
        $this->JWTManager = $JWTManager;
    }

    public function generateAccessToken($email, $password): string {
        $userRepository = $this->em->getRepository(User::class);
        $user = $userRepository->findBy([
            "email"=>$email
        ]);
        $accessToken = $this->JWTManager->create($user[0]);

        $this->accessToken = $accessToken;

        return $accessToken;
    }

    public function getAccessToken(){
        return $this->accessToken;
    }

    public function decodeToken($jwtToken){
        $tokenParts = explode(".", $jwtToken);
        $tokenHeader = base64_decode($tokenParts[0]);
        $tokenPayload = base64_decode($tokenParts[1]);
        $jwtHeader = json_decode($tokenHeader);
        $jwtPayload = json_decode($tokenPayload);
        return $jwtPayload;
    }

    public function preProcess(string $id, $object): void
    {
        // TODO: Implement preProcess() method.
    }

    public function postProcess(string $id, $object): void
    {
        // TODO: Implement postProcess() method.
    }
}
