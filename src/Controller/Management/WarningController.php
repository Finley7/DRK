<?php


namespace App\Controller\Management;


use App\Entity\Ban;
use App\Entity\Warning;
use App\Form\BanType;
use App\Form\UserType;
use App\Form\WarningType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class WarningController
 * @package App\Controller\Management
 * @Route("/management/warning", name="admin_warning_")
 * @IsGranted("warning_crud")
 */
class WarningController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {

        $warning = $this->getDoctrine()->getRepository(Warning::class)->findAll();

        return $this->render('admin/warning/index.html.twig', [
            'warnings' => $warning
        ]);
    }

    /**
     * @Route("/create", name="create")
     * @Route("/{warning}/edit", name="edit")
     * @param Warning|null $warning
     * @param Request $request
     * @return Response
     */
    public function addOrEdit(Warning $warning = null, Request $request): Response
    {

        $warning = $warning ?? new Warning();
        $warning->setAuthor($this->getUser());

        $form = $this->createForm(WarningType::class, $warning);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->persist($warning);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'The warning is saved successfully');

            return $this->redirectToRoute('admin_warning_index');
        }

        return $this->render('admin/warning/add-edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
