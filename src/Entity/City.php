<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CityRepository::class)
 */
class City
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=100 ,unique=true)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Country", inversedBy="city")
     */
    private $country;

    /**
     * @Orm\OneToMany(targetEntity="App\Entity\ZipCode", mappedBy="city")
     */
    private $zipCode;

    public function __construct()
    {
        $this->zipCode = new ArrayCollection();
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
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getCountryId(): ?int
    {
        return $this->country_id;
    }

    public function setCountryId(int $country_id): self
    {
        $this->country_id = $country_id;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection|ZipCode[]
     */
    public function getZipCode(): Collection
    {
        return $this->zipCode;
    }

    public function addZipCode(ZipCode $zipCode): self
    {
        if (!$this->zipCode->contains($zipCode)) {
            $this->zipCode[] = $zipCode;
            $zipCode->setCity($this);
        }

        return $this;
    }

    public function removeZipCode(ZipCode $zipCode): self
    {
        if ($this->zipCode->removeElement($zipCode)) {
            // set the owning side to null (unless already changed)
            if ($zipCode->getCity() === $this) {
                $zipCode->setCity(null);
            }
        }

        return $this;
    }
}
