<?php


namespace App\Controller\Management;


use App\Controller\DRKBaseController;
use App\Entity\Category;
use App\Entity\Forum;
use App\Form\ForumType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ForumController
 * @package App\Controller\Management
 * @Route("/management/forum", name="admin_forum_")
 */
class ForumController extends DRKBaseController
{
    /**
     * @Route("/{category}/create", name="add")
     * @Route("/create", name="add_no_forum")
     * @Route("/{category}/{forum}/edit", name="edit")
     * @param $category
     * @param $forum
     * @param Request $request
     * @return Response
     */
    public function addOrEdit($category = null, $forum = null, Request $request) {

        $category = $category == null ? new Category() : $this->getDoctrine()->getRepository(Category::class)->find($category);
        $forum = $forum == null ? new Forum() : $this->getDoctrine()->getRepository(Forum::class)->find($forum);

        $form = $this->createForm(ForumType::class, $forum);

        if($category->getName() == null) {
            $form->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'selectize'
                ]
            ]);
        } else {
            $forum->setCategory($category);
        }

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $forum->setSlug($this->slugify($form->get('name')->getData()));

            $this->getDoctrine()->getManager()->persist($forum);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Forum has been saved');
            return $this->redirectToRoute('admin_category_index');
        }

        return $this->render('admin/forum/add.html.twig', [
            'form' => $form->createView(),
            'category' => $category
        ]);
    }
}
