<?php

namespace App\Requests;

use App\Service\CategoryService;
use Psr\Container\ContainerInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

class ProductRequest extends \Symfony\Component\HttpFoundation\Request
{
    /**
     * Validates the product request. Requires a CategoryService instance.
     * @throws \Exception
     */
    public function validate(CategoryService $categoryService)
    {
        $validator = Validation::createValidator();

        $constraint = new Assert\Collection([
            'name' => [
                new Assert\NotBlank(),
                new Assert\Type('string'),
            ],
            'price' => [
                new Assert\NotBlank(),
                new Assert\GreaterThan(0),
            ],
            'currency' => [
                new Assert\NotBlank(),
                new Assert\Type('string'),
            ],
            'size' => [
                new Assert\NotBlank(),
                new Assert\Type('string'),
            ],
            'category' => [
                new Assert\NotBlank(),
                new Assert\GreaterThan(0),
            ],
            // add more constraints as necessary
        ]);

        $violations = $validator->validate($this->request->all(), $constraint);
        if( !$categoryService->has($this->request->get('category')) )
        {
            throw new \Exception('Validation error! You indicated a category which does not exist. List the categories in the /category/all endpoint.');
        }

        if (count($violations) > 0) {
            throw new \Exception('Validation failed: ' . $violations[0]->getMessage());
        }
    }

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }
}