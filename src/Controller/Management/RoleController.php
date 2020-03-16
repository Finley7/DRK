<?php


namespace App\Controller\Management;


use App\Entity\User;
use App\Entity\UserRole;
use App\Form\RoleType;
use App\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class RoleController
 * @package App\Controller\Management
 * @Route("/management/role", name="admin_role_")
 * @IsGranted("role_crud")
 */
class RoleController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {

        $roles = $this->getDoctrine()->getRepository(UserRole::class)->findAll();

        return $this->render('admin/role/index.html.twig', [
            'roles' => $roles
        ]);
    }

    /**
     * @Route("/create", name="create")
     * @Route("/{role}/edit", name="edit")
     * @param UserRole|null $role
     * @param Request $request
     * @return Response
     */
    public function addOrEdit(UserRole $role = null, Request $request): Response
    {

        $role = $role ?? new UserRole();

        $form = $this->createForm(RoleType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->persist($role);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash("success", "The role was saved successfully");

            return $this->redirectToRoute('admin_role_index');
        }

        return $this->render('admin/role/add-edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
