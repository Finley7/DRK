<?php


namespace App\Controller;

use App\Entity\User;
use App\Entity\UserRole;
use App\Form\RegistrationFormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class SecurityController
 * @package App\Controller
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="security_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils) {

        if($this->getUser() != null) {
            $this->addFlash('warning', 'You are already logged in');
            return $this->redirectToRoute('home');
        }

        return $this->render('security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError()
        ]);
    }

    /**
     * @Route("/register", name="security_register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder) {

        if($this->getUser() != null) {
            $this->addFlash('warning', 'You are already logged in');
            return $this->redirectToRoute('home');
        }

        $user = new User();

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->add('submit', SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-success'
            ],
            'label' => 'Create my account'
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $userRole = $this->getDoctrine()->getRepository(UserRole::class)->findOneBy(['name' => 'User']);

            $user->setPrimaryRole($userRole);
            $user->addUserRole($userRole);
            $user->setLastIpAddress($_SERVER['REMOTE_ADDR']);

            $user->setPassword($passwordEncoder->encodePassword($user, $form->get('password')->get('first')->getData()));

            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Your account has been created! Please log in to continue');
            return $this->redirectToRoute('security_login');

        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout() {

    }
}
