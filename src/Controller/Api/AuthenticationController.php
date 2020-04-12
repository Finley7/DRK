<?php


namespace App\Controller\Api;


use App\Controller\DRKBaseController;
use App\Entity\Session;
use App\Repository\SessionRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class AuthenticationController
 * @package App\Controller\Api
 * @Route("/authentication", name="authentication_")
 */
class AuthenticationController extends DRKBaseController
{
    /**
     * @Route("/login", name="login", methods={"POST"})
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
    public function login(Request $request, UserPasswordEncoderInterface $passwordEncoder, UserRepository $userRepository) {
        $body = json_decode($request->getContent(), false);

        $userCheck = $userRepository->findOneBy(['email' => $body->email]);

        if($passwordEncoder->isPasswordValid($userCheck, $body->password)) {
            $session = new Session();
            $session->setIpAddress($_SERVER['REMOTE_ADDR']);
            $session->setUserAgent($_SERVER['HTTP_USER_AGENT']);
            $session->setUser($userCheck);

            $this->getDoctrine()->getManager()->persist($session);
            $this->getDoctrine()->getManager()->flush();

            return $this->createApiResponse([
                'token' => $session->getToken(),
                'expires' => $session->getExpires(),
                'user'=> [
                    'name' => $userCheck->getName(),
                    'primaryRole' =>  [
                        'name' => $userCheck->getPrimaryRole()->getName(),
                        'description' => $userCheck->getPrimaryRole()->getDescription(),
                        'color' => $userCheck->getPrimaryRole()->getColorCode()
                    ],
                    'permissions' => $userCheck->getPermissions()
                ]
            ]);

        }


        return $this->createApiResponse([], 'authentication_ error', 403);
    }

    /**
     * @Route("/check/{token}", name="check", methods={"GET"})
     * @param string $token
     * @param SessionRepository $sessionRepository
     * @return JsonResponse
     * @throws \Exception
     */
    public function check(string $token, SessionRepository $sessionRepository) {

        $sessionCheck = $sessionRepository->findOneBy([
            'token' => $token
        ]);

        if($sessionCheck->getExpires() < new \DateTime()) {
            return $this->createApiResponse([], 'session_expired', 403);
        }

        return $this->createApiResponse([
            'token' => $sessionCheck->getToken(),
            'expires' => $sessionCheck->getExpires(),
            'user'=> [
                'name' => $sessionCheck->getUser()->getName(),
                'primaryRole' =>  [
                    'name' => $sessionCheck->getUser()->getPrimaryRole()->getName(),
                    'description' => $sessionCheck->getUser()->getPrimaryRole()->getDescription(),
                    'color' => $sessionCheck->getUser()->getPrimaryRole()->getColorCode()
                ],
                'permissions' => $sessionCheck->getUser()->getPermissions()
            ]
        ]);

    }
}