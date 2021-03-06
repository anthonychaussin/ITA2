<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\Post1Type;
use App\Repository\PostRepository;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/index/{page}", name="post_index", methods={"GET"})
     * @param PostRepository $postRepository
     * @param int $page
     * @return Response
     */
    public function index(PostRepository $postRepository, int $page = 0): Response
    {
        return $this->render('post/index.html.twig', [
            'posts' => $postRepository->finMostLoved(20, $page),
        ]);
    }

    /**
     * @Route("/archive/{datetime}", name="post_archive", methods={"GET","POST"})
     * @param PostRepository $postRepository
     * @param DateTime|null $dateTime
     * @return Response
     */
    public function archive(PostRepository $postRepository, DateTime $dateTime = null): Response
    {
        return $this->render('post/archive.html.twig', [
            'posts' => $postRepository->findFromMonth($dateTime),
        ]);
    }

    /**
     * @Route("/api/archive/{dateTime}", name="api_post_archive", methods={"GET"})
     * @param PostRepository $postRepository
     * @param string $dateTime
     * @return JsonResponse
     */
    public function apiArchive(PostRepository $postRepository, string $dateTime): JsonResponse
    {
        return $this->json(($postRepository->findFromMonth(new DateTime($dateTime))));
    }

    /**
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @Route("/new", name="post_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(Post1Type::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('post_index');
        }

        return $this->render('post/new.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="post_show", methods={"GET"})
     * @param Post $post
     * @return Response
     */
    public function show(Post $post): Response
    {
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }

    /**
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @Route("/{id}/edit", name="post_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Post $post
     * @return Response
     */
    public function edit(Request $request, Post $post): Response
    {
        $form = $this->createForm(Post1Type::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('post_index');
        }

        return $this->render('post/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}", name="post_delete", methods={"DELETE"})
     * @param Request $request
     * @param Post $post
     * @return Response
     */
    public function delete(Request $request, Post $post): Response
    {
        if ($this->isCsrfTokenValid('delete' . $post->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('post_index');
    }
}
