<?php

namespace App\Controller;

use App\Entity\LikeP;
use App\Form\LikePType;
use App\Repository\LikePRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/like/p")
 */
class LikePController extends AbstractController
{
    /**
     * @Route("/", name="like_p_index", methods={"GET"})
     */
    public function index(LikePRepository $likePRepository): Response
    {
        return $this->render('like_p/index.html.twig', [
            'like_ps' => $likePRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="like_p_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $likeP = new LikeP();
        $form = $this->createForm(LikePType::class, $likeP);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($likeP);
            $entityManager->flush();

            return $this->redirectToRoute('like_p_index');
        }

        return $this->render('like_p/new.html.twig', [
            'like_p' => $likeP,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="like_p_show", methods={"GET"})
     */
    public function show(LikeP $likeP): Response
    {
        return $this->render('like_p/show.html.twig', [
            'like_p' => $likeP,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="like_p_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, LikeP $likeP): Response
    {
        $form = $this->createForm(LikePType::class, $likeP);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('like_p_index');
        }

        return $this->render('like_p/edit.html.twig', [
            'like_p' => $likeP,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="like_p_delete", methods={"DELETE"})
     */
    public function delete(Request $request, LikeP $likeP): Response
    {
        if ($this->isCsrfTokenValid('delete' . $likeP->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($likeP);
            $entityManager->flush();
        }

        return $this->redirectToRoute('like_p_index');
    }
}
