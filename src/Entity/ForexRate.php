<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ForexRateRepository")
 * @ORM\Table(name="forex_rates",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="unique_index", columns={"currency", "rate", "published_at"}),
 *     }
 * )
 */
class ForexRate
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $currency;

    /**
     * @ORM\Column(type="decimal", precision=23, scale=8)
     */
    private $rate;

    /**
     * @ORM\Column(type="datetimetz")
     */
    private $published_at;

    public function __construct($rate)
    {
        $this->currency = $rate["currency"];
        $this->rate = $rate["rate"];
        $this->published_at = $rate["published_at"];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getRate(): ?string
    {
        return $this->rate;
    }

    public function setRate(string $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->published_at;
    }

    public function setPublishedAt(\DateTimeInterface $published_at): self
    {
        $this->published_at = $published_at;

        return $this;
    }
}
