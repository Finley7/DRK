<?php


namespace App\Controller;

use App\Entity\Category;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CategoryController
 * @package App\Controller
 */
class CategoryController extends DRKBaseController
{
    /**
     * @Route("/{categoryName}", name="category_index")
     * @param string $categoryName
     * @return Response
     */
    public function index(string $categoryName) {

        $category = $this->getDoctrine()->getRepository(Category::class)
            ->findOneBy(['slug' => $categoryName]);

        return $this->render('category/index.html.twig', [
            'category' => $category
        ]);
    }
}
