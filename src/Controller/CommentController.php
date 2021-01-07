<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Episode;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/comment", name="comment_")
 */
class CommentController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(CommentRepository $commentRepository): Response
    {
        return $this->render('comment/index.html.twig', [
            'comments' => $commentRepository->findAll(),
        ]);
    }

    /**
     * @Route ("/new", name="new", methods={"GET", "POST"})
     * @IsGranted ("ROLE_CONTRIBUTOR")
     */
    public function new (Request $request): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('comment_index');
        }
        return $this->render('comment/new.html.twig');
    }
    /**
     * @Route ("/{id}", name="show", methods={"GET", "POST"})
     */
    public function show(Comment $comment): Response
    {
     return $this->render('comment/show.html.twig',
     ['comment' => $comment]);
    }

    /**
     * @Route ("/{id}", name="delete", methods={"DELETE"})
     * @IsGranted ("ROLE_CONTRIBUTOR")
     */
    public function delete(Request $request, Comment $comment): Response
    {
        if($this->isCsrfTokenValid('delete' . $comment->getId(), $request->request->get('_token')))
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();
        }
        return $this->redirectToRoute('comment_index');
    }
}
