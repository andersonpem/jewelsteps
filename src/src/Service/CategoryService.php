<?php

namespace App\Service;

use App\Entity\Category;
use App\Repository\CategoryRepository;

class CategoryService
{
    public function __construct(private CategoryRepository $repository)
    {}

    public function has(int $id): bool
    {
        $row = $this->repository->findOneBy(['id'=>$id]);
        return (bool)$row;
    }

    public function fetch(int $id) : ?Category
    {
        return $this->repository->findOneBy(['id'=>$id]);
    }

}