<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="u_user")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     */
    protected $plainPassword;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $street;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $house;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $flat;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $floor;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $surname;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $phone;

	/**
	 * @ORM\Column(type="text", nullable=true, nullable=true)
	 */
	private $notes;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	private $payMethod;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	private $deliveryMethod;

    public function getId(): ?int
    {
        return $this->id;
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
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
         $this->plainPassword = null;
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

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;

        return $this;
    }

	public function getStreet()
	{
		return $this->street;
	}

	public function setStreet($street): void
	{
		$this->street = $street;
	}

	public function getHouse()
	{
		return $this->house;
	}

	public function setHouse($house): void
	{
		$this->house = $house;
	}

	public function getFlat()
	{
		return $this->flat;
	}

	public function setFlat($flat): void
	{
		$this->flat = $flat;
	}

	public function getFloor()
	{
		return $this->floor;
	}

	public function setFloor($floor): void
	{
		$this->floor = $floor;
	}

	public function getSurname()
	{
		return $this->surname;
	}

	public function setSurname($surname): void
	{
		$this->surname = $surname;
	}

	public function getPhone()
	{
		return $this->phone;
	}

	public function setPhone($phone): void
	{
		$this->phone = $phone;
	}

	public function getNotes()
	{
		return $this->notes;
	}

	public function setNotes($notes): void
	{
		$this->notes = $notes;
	}

	public function getPayMethod()
	{
		return $this->payMethod;
	}

	public function setPayMethod($payMethod): void
	{
		$this->payMethod = $payMethod;
	}

	public function getDeliveryMethod()
	{
		return $this->deliveryMethod;
	}

	public function setDeliveryMethod($deliveryMethod): void
	{
		$this->deliveryMethod = $deliveryMethod;
	}
}
