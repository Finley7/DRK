<?php


namespace App\Controller\Management;


use App\Entity\User;
use App\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserController
 * @package App\Controller\Management
 * @Route("/management/user", name="admin_user_")
 * @IsGranted("user_crud")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {

        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('admin/user/index.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/create", name="create")
     * @Route("/{user}/edit", name="edit")
     * @param User|null $user
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function addOrEdit(User $user = null, Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {

        $user = $user ?? new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get("password")->getData() != "") {

                $password = $passwordEncoder->encodePassword($user, $form->get("password")->getData());
                $user->setPassword($password);
            }

            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash("success", "The user profile was saved successfully");

            return $this->redirectToRoute('admin_user_index');
        }

        return $this->render('admin/user/add-edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
