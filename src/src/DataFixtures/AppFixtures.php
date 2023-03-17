<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $cats = [
            ['name'=>'Shoes', 'variable_price'=>false],
            ['name'=>'Jewelry', 'variable_price'=>true],
        ];
        foreach ($cats as $cat) {
            $category = new Category();
            $category->setName($cat['name']);
            $category->setVariablePrice($cat['variable_price']);
            $manager->persist($category);
        }
        $manager->flush();
    }
}
