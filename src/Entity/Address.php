<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 */
class Address
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * * @Assert\Length(
     *      min = 3,
     *      max = 100,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     * @ORM\Column(type="string", length=100)
     */
    private $firstname;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 3,
     *      max = 100,
     *      minMessage = "Your last name must be at least {{ limit }} characters long",
     *      maxMessage = "Your last name cannot be longer than {{ limit }} characters"
     * )
     * @ORM\Column(type="string", length=100)
     */
    private $lastName;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    private $fullAddress;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ZipCode", inversedBy="address" , cascade={"persist", "remove" })
     */
    private $zipCode;


    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=15)
     */
    private $phoneNumber;

    /**
     * @Assert\NotBlank()
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $birthDay;

    /**
     * @Assert\NotBlank()
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     * @ORM\Column(type="string", length=150)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $pic;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFullAddress(): ?string
    {
        return $this->fullAddress;
    }

    public function setFullAddress(string $fullAddress): self
    {
        $this->fullAddress = $fullAddress;

        return $this;
    }

    

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getBirthDay(): ?\DateTimeInterface
    {
        return $this->birthDay;
    }

    public function setBirthDay(\DateTimeInterface $birthDay): self
    {
        $this->birthDay = $birthDay;

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

    public function getPic(): ?string
    {
        return $this->pic;
    }

    public function setPic(?string $pic): self
    {
        $this->pic = $pic;

        return $this;
    }

    public function getZipCodeId(): ?string
    {
        return $this->zipCodeId;
    }

    public function setZipCodeId(string $zipCodeId): self
    {
        $this->zipCodeId = $zipCodeId;

        return $this;
    }

    public function getZipCode(): ?ZipCode
    {
        return $this->zipCode;
    }

    public function setZipCode(?ZipCode $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }
    public function bindParam(Address  $request): self
    {
        $this->firstname = $request->getFirstname();
        $this->lastName = $request->getLastName();
        $this->fullAddress = $request->getFullAddress();
        $this->phoneNumber = $request->getPhoneNumber();
        $this->birthDay = $request->getBirthDay();
        $this->email = $request->getEmail();
        $this->getZipCode()->setCode($request->getZipCode()->getCode());

        return $this;
    }
}
