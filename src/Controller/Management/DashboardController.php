<?php


namespace App\Controller\Management;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/management", name="admin_")
 * @IsGranted("view_acp_menu")
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index() {

        return $this->render('admin/home.html.twig');
    }
}
