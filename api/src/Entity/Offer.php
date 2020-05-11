<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     attributes={"security"="is_granted('ROLE_RECRUTEUR')"},
 *     collectionOperations={
 *         "get"={"security"="is_granted('ROLE_RECRUTEUR') or is_granted('ROLE_CANDIDAT') "},
 *         "post"={"security"="is_granted('ROLE_RECRUTEUR')"}
 *     },
 *     itemOperations={
 *          "get",
 *          "put",
 *          "patch",
 *          "delete"
 *
 *     }
)
 * @ORM\Entity(repositoryClass="App\Repository\OfferRepository")
 */
class Offer
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
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     */
    private $company_description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $start_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $working_place;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCompanyDescription(): ?string
    {
        return $this->company_description;
    }

    public function setCompanyDescription(string $company_description): self
    {
        $this->company_description = $company_description;

        return $this;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->start_at;
    }

    public function setStartAt(\DateTimeInterface $start_at): self
    {
        $this->start_at = $start_at;

        return $this;
    }

    public function getWorkingPlace(): ?string
    {
        return $this->working_place;
    }

    public function setWorkingPlace(string $working_place): self
    {
        $this->working_place = $working_place;

        return $this;
    }
}
