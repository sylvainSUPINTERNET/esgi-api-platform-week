<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 *    @ApiResource(
 *     attributes={"security"="is_granted('ROLE_RECRUTEUR')"},
 *     normalizationContext={"groups"={"get"}},
 *     itemOperations={
 *         "get"
 *     },
 *    collectionOperations={
 *         "get",
 *         "post"
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\InvitRepository")
 */
class Invit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $token;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
