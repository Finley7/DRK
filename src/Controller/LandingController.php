<?php


namespace App\Controller;

use App\Entity\Category;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LandingController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home() {

        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

        return $this->render('home.html.twig', [
            'categories' => $categories
        ]);
    }
}
