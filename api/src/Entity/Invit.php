<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 *    @ApiResource(
 *     normalizationContext={"groups"={"get"}},
 *     itemOperations={
 *         "get",
 *         "delete"
 *     },
 *    collectionOperations={
 *         "get",
 *         "post"
 *     }
 * )
 * @ApiFilter(SearchFilter::class, properties={"token": "exact"})
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
     * @Groups({"get"})
     */
    private $token;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get"})
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
