<?php

namespace App\Entity;

use App\Repository\ZipCodeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ZipCodeRepository::class)
 * @ORM\Table(
 *    name="zip_code",
 *    uniqueConstraints={
 *        @ORM\UniqueConstraint(name="unique_zipcode_city", columns={"code", "city_id"})
 *    }
 * )
 */
class ZipCode
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * * @Assert\Length(
     *      min = 4,
     *      max = 50,
     *      minMessage = "zip code must be at least {{ limit }} characters long",
     *      maxMessage = "zip code cannot be longer than {{ limit }} characters"
     * )
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=50)
     */
    private $code;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\City", inversedBy="zipCode")
     */
    private $city;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Address", mappedBy="zipCode")
     */
    private $address;

    public function __construct()
    {
        $this->address = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }
    

    /**
     * @return Collection|Address[]
     */
    public function getAddress(): Collection
    {
        return $this->address;
    }

    public function addAddress(Address $address): self
    {
        if (!$this->address->contains($address)) {
            $this->address[] = $address;
            $address->setZipCode($this);
        }

        return $this;
    }

    public function removeAddress(Address $address): self
    {
        if ($this->address->removeElement($address)) {
            // set the owning side to null (unless already changed)
            if ($address->getZipCode() === $this) {
                $address->setZipCode(null);
            }
        }

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function setAddress(?Address $address): self
    {
        // unset the owning side of the relation if necessary
        if ($address === null && $this->address !== null) {
            $this->address->setZipCode(null);
        }

        // set the owning side of the relation if necessary
        if ($address !== null && $address->getZipCode() !== $this) {
            $address->setZipCode($this);
        }

        $this->address = $address;

        return $this;
    }
}
