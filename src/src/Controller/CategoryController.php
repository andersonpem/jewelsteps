<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/api/v1', name: 'category_')]
class CategoryController extends AbstractController
{
    // PHP8's promoted properties
    public function __construct(private CategoryRepository $repository, private SerializerInterface $serializer)
    {}

    #[Route('/category/all', name: 'all')]
    public function index(): Response
    {
        return new Response($this->serializer->serialize($this->repository->findAll(), 'json'));
    }
}
