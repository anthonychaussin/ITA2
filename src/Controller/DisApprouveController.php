<?php

namespace App\Controller;

use App\Entity\DisApprouve;
use App\Form\DisApprouve1Type;
use App\Repository\DisApprouveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dis/approuve")
 */
class DisApprouveController extends AbstractController
{
    /**
     * @Route("/", name="dis_approuve_index", methods={"GET"})
     */
    public function index(DisApprouveRepository $disApprouveRepository): Response
    {
        return $this->render('dis_approuve/index.html.twig', [
            'dis_approuves' => $disApprouveRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="dis_approuve_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $disApprouve = new DisApprouve();
        $form = $this->createForm(DisApprouve1Type::class, $disApprouve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($disApprouve);
            $entityManager->flush();

            return $this->redirectToRoute('dis_approuve_index');
        }

        return $this->render('dis_approuve/new.html.twig', [
            'dis_approuve' => $disApprouve,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="dis_approuve_show", methods={"GET"})
     */
    public function show(DisApprouve $disApprouve): Response
    {
        return $this->render('dis_approuve/show.html.twig', [
            'dis_approuve' => $disApprouve,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="dis_approuve_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DisApprouve $disApprouve): Response
    {
        $form = $this->createForm(DisApprouve1Type::class, $disApprouve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dis_approuve_index');
        }

        return $this->render('dis_approuve/edit.html.twig', [
            'dis_approuve' => $disApprouve,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="dis_approuve_delete", methods={"DELETE"})
     */
    public function delete(Request $request, DisApprouve $disApprouve): Response
    {
        if ($this->isCsrfTokenValid('delete' . $disApprouve->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($disApprouve);
            $entityManager->flush();
        }

        return $this->redirectToRoute('dis_approuve_index');
    }
}
