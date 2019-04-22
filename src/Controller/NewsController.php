<?php


namespace App\Controller;


use App\Entity\News;
use App\Entity\NewsComment;
use App\Form\NewsCommentType;
use App\Form\NewsType;
use App\Repository\NewsRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/news")
 */
class NewsController extends AbstractController
{

    /**
     * @var NewsRepository
     */
    private $newsRepository;

    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }


    /**
     * #@Route("/") - notice it's commented, this action is forwarded dynamically from IndexController, doing this so i can have /news prefix on whole NewsController
     * @return Response
     */
    public function list()
    {
        return $this->render('news/list.html.twig', [
            'newsList' => $this->newsRepository->findBy([], ['createdAt' => 'desc', 'id' => 'desc']) // @todo pagination
        ]);
    }

    /**
     * @Route("/{id}", methods={"GET", "POST"}, requirements={"id": "\d+"})
     * @param News $news
     * @param Request $request
     * @return Response
     */
    public function show(News $news, Request $request): Response
    {
        $comment = new NewsComment();
        $comment->setNews($news);

        $commentForm = $this->createForm(NewsCommentType::class, $comment);
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $this->getDoctrine()->getManager()->persist($comment);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_news_show', [
                'id' => $news->getId(),
            ]);
        }

        return $this->render('news/show.html.twig', [
            'news' => $news,
            'commentForm' => $commentForm->createView()
        ]);
    }

    /**
     * display news of currently logged user
     *
     * @Security(expression="is_granted('ROLE_USER')")
     *
     * @Route("/my")
     */
    public function my()
    {
        return $this->render('news/list.html.twig', [
            'newsList' => $this->newsRepository->findBy(['createdBy' => $this->getUser()], ['createdAt' => 'desc', 'id' => 'desc']),
            'belongingTo' => $this->getUser()
        ]);
    }

    /**
     * @Security(expression="is_granted('ROLE_USER')")
     *
     * @Route("/new",  methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $news = new News();
        $news->setCreatedBy($this->getUser()); // @todo there is some issue with Blameable when using codeception, need to investigate
        $news->setUpdatedBy($this->getUser());

        return $this->form($request, $news);
    }

    /**
     * @param Request $request
     * @param News $news
     * @return Response
     */
    private function form(Request $request, News $news)
    {
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($news);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_news_show', [
                'id' => $news->getId(),
            ]);
        }

        return $this->render('news/form.html.twig', [
            'news' => $news,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Security(expression="news.getCreatedBy() === user")
     *
     * @Route("/{id}/edit", methods={"GET","POST"})
     * @param Request $request
     * @param News $news
     * @return Response
     */
    public function edit(Request $request, News $news): Response
    {
        return $this->form($request, $news);
    }

    /**
     * @Security(expression="news.getCreatedBy() === user")
     *
     * @Route("/{id}", methods={"DELETE"})
     * @param Request $request
     * @param News $news
     * @return Response
     */
    public function delete(Request $request, News $news): Response
    {
        if ($this->isCsrfTokenValid('delete' . $news->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($news);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_news_my');
    }
}