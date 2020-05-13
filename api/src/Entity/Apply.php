<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 *    @ApiResource(
 *     attributes={"security"="is_granted('ROLE_CANDIDAT')"},
 *     normalizationContext={"groups"={"get"}},
 *     itemOperations={
 *         "get",
 *         "put"={
 *             "normalization_context"={"groups"={"put"}},
 *             "denormalization_context"={"groups"={"put_in"}}
 *         }
 *     },
 *    collectionOperations={
 *          "get",
 *         "post"={
 *             "normalization_context"={"groups"={"post"}},
 *             "denormalization_context"={"groups"={"post_in"}}
 *         }
 *     }
 * )
 * @ApiFilter(SearchFilter::class, properties={"user.email": "exact"})
 * @ORM\Entity(repositoryClass="App\Repository\ApplyRepository")
 */
class Apply
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"get"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Groups({"get", "put", "post", "post_in"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Groups({"get", "put", "post", "post_in"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Groups({"get", "put", "post", "post_in"})
     */
    private $sexe;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Groups({"get", "put", "post", "post_in"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Groups({"get", "put", "post", "post_in"})
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Groups({"get", "put", "post", "post_in"})
     */
    private $adresse;

    /**
     * @ORM\Column(type="text",nullable=true)
     * @Groups({"get", "put", "post", "post_in"})
     */
    private $motivation;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Groups({"get", "put", "post", "post_in"})
     */
    private $salary;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get", "put", "put_in", "post", "post_in"})
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="Offre", inversedBy="applies")
     * @ORM\JoinColumn(name="offre_id", referencedColumnName="id")
     * @Groups({"get", "put", "put_in", "post", "post_in"})
     */
    private $offer;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\MediaObject", cascade={"persist", "remove"})
     * @Groups({"get", "put", "post", "post_in"})
     */
    private $profilePicture;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\MediaObject", cascade={"persist", "remove"})
     * @Groups({"get", "put", "post", "post_in"})
     */
    private $cv;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="applies")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @Groups({"get", "put", "post", "post_in", "put_in"})
     */
    private $user;

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

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

    public function getAge(): ?string
    {
        return $this->age;
    }

    public function setAge(string $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getMotivation(): ?string
    {
        return $this->motivation;
    }

    public function setMotivation(string $motivation): self
    {
        $this->motivation = $motivation;

        return $this;
    }

    public function getSalary(): ?string
    {
        return $this->salary;
    }

    public function setSalary(string $salary): self
    {
        $this->salary = $salary;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOffer()
    {
        return $this->offer;
    }

    /**
     * @param mixed $offer
     */
    public function setOffer($offer): void
    {
        $this->offer = $offer;
    }

    public function getProfilePicture(): ?MediaObject
    {
        return $this->profilePicture;
    }

    public function setProfilePicture(?MediaObject $profilePicture): self
    {
        $this->profilePicture = $profilePicture;

        return $this;
    }

    public function getCv(): ?MediaObject
    {
        return $this->cv;
    }

    public function setCv(?MediaObject $cv): self
    {
        $this->cv = $cv;

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
