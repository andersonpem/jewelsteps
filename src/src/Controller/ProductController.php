<?php

namespace App\Controller;


use App\Entity\Category;
use App\Entity\Product;
use App\Entity\ProductPrice;
use App\Repository\ProductPriceRepository;
use App\Repository\ProductRepository;
use App\Requests\ProductRequest;
use App\Service\CategoryService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;

// Ideally, on a real project, this could be placed on the configuration for global pre-fixation.
#[Route('/api/v1', name: 'product_')]
class ProductController extends AbstractController
{
    // PHP8's promoted properties
    public function __construct(private EntityManagerInterface $manager, private CategoryService $categoryService, private ProductRepository $productRepository, private ProductPriceRepository $priceRepository)
    {
    }

    /**
     * @throws \Exception
     */
    #[Route('/product', name: 'new', methods: ['POST'])]
    public function new(Request $request): JsonResponse
    {
        // Laravel style validation
        $productRequest = ProductRequest::createFromGlobals();
        $productRequest->validate($this->categoryService);
        $data = $productRequest->request->all();
        $data = (object) $data;

        $product = $this->productRepository->findOneBy(['Name'=>$data->name]);

        // This product does not yet exist in the database
        if( !$product )
        {
            $product = new Product();
            $product->setName($data->name);
            $product->setCategory($this->categoryService->fetch($data->category));

            $price = new ProductPrice();
            $price->setPrice($data->price);
            $price->setCurrency($data->currency);
            $price->setSize($data->size);

            $product->addProductPrice($price);

            $this->manager->persist($price);
            $this->manager->persist($product);

            $this->manager->flush();

            return new JsonResponse('Resource created', 201);
        }
        else {
            // Product exists, let's check for variant's existence
            $price = $this->priceRepository->findOneBy(
            [
                'size'=>$data->size,
                'product'=>$product->getId()
            ]);

            if( $price )
            {
                // Resource exists, let's set the price.
                $price->setPrice($data->price);
                $this->manager->persist($price);
                $this->manager->flush();
                return new JsonResponse('Resource price\'s updated', 202);
            }
            // Variant does not exists, let's insert it.
            $price = new ProductPrice();
            // Stealing Laravel functionality
            $price->fill((array)$data);
            $price->setProduct($product);
            $this->manager->persist($price);
            $this->manager->flush();
            return new JsonResponse('Resource created', 201);
        }
    }
}
