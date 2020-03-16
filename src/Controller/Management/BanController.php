<?php


namespace App\Controller\Management;


use App\Entity\Ban;
use App\Form\BanType;
use App\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class BanController
 * @package App\Controller\Management
 * @Route("/management/ban", name="admin_ban_")
 * @IsGranted("ban_crud")
 */
class BanController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {

        $bans = $this->getDoctrine()->getRepository(Ban::class)->findAll();

        return $this->render('admin/ban/index.html.twig', [
            'bans' => $bans
        ]);
    }

    /**
     * @Route("/create", name="create")
     * @Route("/{ban}/edit", name="edit")
     * @param Ban|null $ban
     * @param Request $request
     * @return Response
     */
    public function addOrEdit(Ban $ban = null, Request $request): Response
    {

        $ban = $ban ?? new Ban();
        $ban->setAuthor($this->getUser());

        $form = $this->createForm(BanType::class, $ban);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->persist($ban);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'The ban was saved successfully');

            return $this->redirectToRoute('admin_ban_index');
        }

        return $this->render('admin/ban/add-edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
