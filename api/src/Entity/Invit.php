<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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

    /**
     * @ORM\ManyToOne(targetEntity="Offre", inversedBy="invits")
     * @ORM\JoinColumn(name="offre_id", referencedColumnName="id")
     * @Groups({"post", "get"})
     */
    private $offre;

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

    /**
     * @return mixed
     */
    public function getOffre()
    {
        return $this->offre;
    }

    /**
     * @param mixed $offre
     */
    public function setOffre($offre): void
    {
        $this->offre = $offre;
    }

}
