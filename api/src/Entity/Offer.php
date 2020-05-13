<?php

//namespace App\Entity;

//use ApiPlatform\Core\Annotation\ApiResource;
//use Doctrine\ORM\Mapping as ORM;
//use Doctrine\Common\Collections\ArrayCollection;
//use Doctrine\ORM\Mapping\OneToMany;
//use Symfony\Component\Serializer\Annotation\Groups;

// normalize -> ouput
// denormalize -> input

/*
/**
 *  * @ApiResource(
 *     normalizationContext={"groups"={"get"}},
 *     itemOperations={
 *         "get",
 *         "put"={
 *             "normalization_context"={"groups"={"put"}},
 *             "denormalization_context"={"groups"={"put_in"}}
 *         }
 *     },
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


//class Offer
//{
//  /**
//   * @ORM\Id()
//   * @ORM\GeneratedValue()
//   * @ORM\Column(type="integer")
//   * @Groups({"get"})
//   */
//  private $id;
//
//  /**
//   * @ORM\Column(type="string", length=255)
//   * @Groups({"get", "put", "put_in", "post_in"})
//   */
//  private $name;
//
//  /**
//   * @ORM\Column(type="text")
//   * @Groups({"get", "put", "put_in","post_in"})
//   */
//  private $description;
//
//  /**
//   * @ORM\Column(type="text")
//   * @Groups({"get", "put", "put_in","post_in"})
//   */
//  private $company_description;
//
//  /**
//     * @ORM\Column(type="datetime")
//   * @Groups({"get", "put", "put_in","post_in"})
//   */
//  private $start_at;
//
//  /**
//   * @ORM\Column(type="string", length=255)
//   * @Groups({"get", "put", "put_in","post","post_in"})
//   */
//  private $working_place;
//
//  /**
//   * @ORM\OneToMany(targetEntity="Apply", mappedBy="offer")
//   * @Groups({"get", "put", "put_in","post"})
//   */
//
//  private $applies;
//
//  public function __construct() {
//      $this->applies = new ArrayCollection();
//  }
//
//
//  public function getId(): ?int
//  {
//      return $this->id;
//  }
//
//  public function getName(): ?string
//  {
//      return $this->name;
//  }
//
//  public function setName(string $name): self
//  {
//      $this->name = $name;
//
//      return $this;
//  }
//
//  public function getDescription(): ?string
//  {
//      return $this->description;
//  }
/*
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
*/

//  /**
//   * @return ArrayCollection
//    */
//   public function getApplies(): ArrayCollection
//   {
//       return $this->applies;
//   }

//  /**
//  * @param ArrayCollection $applies
//    */
/*
    public function setApplies(ArrayCollection $applies): void
    {
        $this->applies = $applies;
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
*/

//}
