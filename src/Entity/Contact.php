<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 17, nullable: true)]
    #[Assert\Regex(pattern: "^(\+)?((\d{2,3}) ?\d|\d)(([ -]?\d)|( ?(\d{2,3}) ?)){5,12}\d$^", message: "Введите номер телефона правильно!")]
    private ?string $number1 = null;

    #[ORM\Column(length: 17, nullable: true)]
    #[Assert\Regex(pattern: "^(\+)?((\d{2,3}) ?\d|\d)(([ -]?\d)|( ?(\d{2,3}) ?)){5,12}\d$^", message: "Введите номер телефона правильно!")]
    private ?string $number2 = null;

    #[ORM\Column(length: 180, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tg = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $wa = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $workTime = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber1(): ?string
    {
        return $this->number1;
    }

    public function setNumber1(?string $number1): self
    {
        $this->number1 = $number1;

        return $this;
    }

    public function getNumber2(): ?string
    {
        return $this->number2;
    }

    public function setNumber2(?string $number2): self
    {
        $this->number2 = $number2;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTg(): ?string
    {
        return $this->tg;
    }

    public function setTg(?string $tg): self
    {
        $this->tg = $tg;

        return $this;
    }

    public function getWa(): ?string
    {
        return $this->wa;
    }

    public function setWa(?string $wa): self
    {
        $this->wa = $wa;

        return $this;
    }

    public function getWorkTime(): ?string
    {
        return $this->workTime;
    }

    public function setWorkTime(?string $workTime): self
    {
        $this->workTime = $workTime;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }
}
