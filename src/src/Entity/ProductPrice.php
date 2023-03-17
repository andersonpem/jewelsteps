<?php

namespace App\Entity;

use App\EventListener\ProductPriceListener;
use App\Repository\ProductPriceRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\EntityListeners;

#[ORM\Entity(repositoryClass: ProductPriceRepository::class)]
#[EntityListeners([ProductPriceListener::class])]
class ProductPrice extends BaseEntity
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'productPrices')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\Column(length: 255)]
    private ?string $size = null;

    #[ORM\Column]
    private ?string $currency = null;

    #[ORM\Column]
    private ?float $price = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): self
    {
        $this->size = $size;

        return $this;
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    // Due to the autofill functionality, we do the conversion in the class
    public function setPrice(string $price): self
    {
        $price = floatval($price);

        if(!is_float($price)){
            throw new \Exception('Could not convert input to float');
        }

        $this->price = $price;

        return $this;
    }
}
