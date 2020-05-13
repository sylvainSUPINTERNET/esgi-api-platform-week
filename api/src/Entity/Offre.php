<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 *   @ApiResource(
 *     normalizationContext={"groups"={"get"}},
 *     itemOperations={
 *         "get",
 *         "put"={
 *             "normalization_context"={"groups"={"put"}},
 *             "denormalization_context"={"groups"={"put_in"}}
 *         }
 *    },
 *    collectionOperations={
 *         "post"={
 *             "normalization_context"={"groups"={"post"}},
 *             "denormalization_context"={"groups"={"post_in"}},
 *             "security"="is_granted('ROLE_RECRUTEUR')"
 *         }
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\OfferRepository")
 */
class Offre
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"get"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get", "put", "put_in", "post_in"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get", "put", "put_in", "post_in"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get", "put", "put_in", "post_in"})
     */
    private $companyDescription;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"get", "put", "put_in", "post_in"})
     */
    private $startAt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get", "put", "put_in","post","post_in"})
     */
    private $workingPlace;


    /**
     * @ORM\OneToMany(targetEntity="Apply", mappedBy="offre")
     * @Groups({"get", "put", "put_in","post"})
     */
    private $applies;


    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="offres")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @Groups({"get", "put", "post", "post_in"})
     */
    private $user;

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
        return $this->companyDescription;
    }

    public function setCompanyDescription(string $companyDescription): self
    {
        $this->companyDescription = $companyDescription;

        return $this;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeInterface $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getWorkingPlace(): ?string
    {
        return $this->workingPlace;
    }

    public function setWorkingPlace(string $workingPlace): self
    {
        $this->workingPlace = $workingPlace;

        return $this;
    }


    public function removeApply(Apply $apply): self
    {
        if ($this->applies->contains($apply)) {
            $this->applies->removeElement($apply);
            // set the owning side to null (unless already changed)
            if ($apply->getOffer() === $this) {
                $apply->setOffer(null);
            }
        }
        return $this;
    }

    public function addApplies(Apply $apply): self
    {
        if (!$this->applies->contains($apply)) {
            $this->applies[] = $apply;
            $apply->setOffer($this);
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }
}
