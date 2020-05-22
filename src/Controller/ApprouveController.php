<?php

namespace App\Controller;

use App\Entity\Approuve;
use App\Form\Approuve1Type;
use App\Repository\ApprouveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/approuve")
 */
class ApprouveController extends AbstractController
{
    /**
     * @Route("/", name="approuve_index", methods={"GET"})
     */
    public function index(ApprouveRepository $approuveRepository): Response
    {
        return $this->render('approuve/index.html.twig', [
            'approuves' => $approuveRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="approuve_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $approuve = new Approuve();
        $form = $this->createForm(Approuve1Type::class, $approuve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($approuve);
            $entityManager->flush();

            return $this->redirectToRoute('approuve_index');
        }

        return $this->render('approuve/new.html.twig', [
            'approuve' => $approuve,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="approuve_show", methods={"GET"})
     */
    public function show(Approuve $approuve): Response
    {
        return $this->render('approuve/show.html.twig', [
            'approuve' => $approuve,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="approuve_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Approuve $approuve): Response
    {
        $form = $this->createForm(Approuve1Type::class, $approuve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('approuve_index');
        }

        return $this->render('approuve/edit.html.twig', [
            'approuve' => $approuve,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="approuve_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Approuve $approuve): Response
    {
        if ($this->isCsrfTokenValid('delete' . $approuve->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($approuve);
            $entityManager->flush();
        }

        return $this->redirectToRoute('approuve_index');
    }
}
