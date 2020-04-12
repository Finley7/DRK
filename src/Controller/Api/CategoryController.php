<?php


namespace App\Controller\Api;

use App\Controller\DRKBaseController;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class CategoryController
 * @package App\Controlle\Api
 * @Route("/category", name="category_")
 */
class CategoryController extends DRKBaseController
{
    /**
     * @Route("/{categoryName}", name="index")
     * @param string $categoryName
     * @return Response
     */
    public function index(string $categoryName) {

        $category = $this->getDoctrine()->getRepository(Category::class)
            ->findOneBy(['slug' => $categoryName]);

        return $this->createApiResponse($this->serialize($category, Category::class));
    }
}