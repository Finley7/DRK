<?php


namespace App\Controller;


use App\Entity\Forum;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends DRKBaseController
{
    /**
     * @Route("/{categoryName}/{forumName}", name="forum_index")
     * @param string $categoryName
     * @param string $forumName
     * @return Response
     */
    public function index(string $categoryName, string $forumName): Response
    {

        $forum = $this->getDoctrine()->getRepository(Forum::class)
            ->findOneBy(['slug' => $forumName]);

        return $this->render('forum/index.html.twig', [
            'forum' => $forum
        ]);
    }
}
