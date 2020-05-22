<?php

namespace App\Controller;

use App\Entity\DisLikeP;
use App\Form\DisLikePType;
use App\Repository\DisLikePRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dis/like/p")
 */
class DisLikePController extends AbstractController
{
    /**
     * @Route("/", name="dis_like_p_index", methods={"GET"})
     */
    public function index(DisLikePRepository $disLikePRepository): Response
    {
        return $this->render('dis_like_p/index.html.twig', [
            'dis_like_ps' => $disLikePRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="dis_like_p_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $disLikeP = new DisLikeP();
        $form = $this->createForm(DisLikePType::class, $disLikeP);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($disLikeP);
            $entityManager->flush();

            return $this->redirectToRoute('dis_like_p_index');
        }

        return $this->render('dis_like_p/new.html.twig', [
            'dis_like_p' => $disLikeP,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="dis_like_p_show", methods={"GET"})
     */
    public function show(DisLikeP $disLikeP): Response
    {
        return $this->render('dis_like_p/show.html.twig', [
            'dis_like_p' => $disLikeP,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="dis_like_p_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DisLikeP $disLikeP): Response
    {
        $form = $this->createForm(DisLikePType::class, $disLikeP);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dis_like_p_index');
        }

        return $this->render('dis_like_p/edit.html.twig', [
            'dis_like_p' => $disLikeP,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="dis_like_p_delete", methods={"DELETE"})
     */
    public function delete(Request $request, DisLikeP $disLikeP): Response
    {
        if ($this->isCsrfTokenValid('delete' . $disLikeP->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($disLikeP);
            $entityManager->flush();
        }

        return $this->redirectToRoute('dis_like_p_index');
    }
}
