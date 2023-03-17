<?php

namespace App\EventListener;

use App\Entity\ProductPrice;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Psr\Log\LoggerInterface;

/**
 * This behavior is triggered when adding a price
 * For products with fixed prices, all the other existing should be updated
 * For products with variable price, just proceed
 */
class ProductPriceListener
{
    public function __construct(private LoggerInterface $logger, private EntityManagerInterface $em)
    {}

    public function postPersist(ProductPrice $productPrice, PostPersistEventArgs $event) : void
    {
        // Check if price is fixed for all entities
        if( !$productPrice->getProduct()->getCategory()->isVariablePrice() )
        {
            // If price is not variable, let's apply the new price to all
            $prices = $productPrice->getProduct()->getProductPrices();
            foreach ($prices as $price) {
                if( $price->getId() == $productPrice->getId() )
                {
                    continue;
                }
                $price->setPrice($productPrice->getPrice());
                $this->em->persist($price);
                $this->em->flush($price);
            }
        }
        $this->logger->info('This was activated on the ProductPriceListener right before ending.');
    }
}