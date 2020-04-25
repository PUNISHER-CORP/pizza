<?php

namespace App\Controller\Admin;

use App\Entity\Admin\Dimension;
use App\Form\Admin\DimensionTranslationType;
use App\Repository\Admin\DimensionRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/dimension")
 */
class DimensionController extends AbstractController
{
    const LIMIT_PER_PAGE = 20;

    /**
     * @Route("/", name="admin_dimension_index", methods={"GET"})
     */
    public function index(Request $request, DimensionRepository $dimensionRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $dimensionRepository->findAll(),
            $request->query->getInt('page', 1),
            self::LIMIT_PER_PAGE
        );

        return $this->render('admin/dimension/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/new", name="admin_dimension_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $dimension = new Dimension();
        $form = $this->createForm(DimensionTranslationType::class, $dimension);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($dimension);
            $entityManager->flush();

            return $this->redirectToRoute('admin_dimension_index');
        }

        return $this->render('admin/dimension/new.html.twig', [
            'dimension' => $dimension,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_dimension_show", methods={"GET"})
     */
    public function show(Dimension $dimension): Response
    {
        return $this->render('admin/dimension/show.html.twig', [
            'dimension' => $dimension,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_dimension_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Dimension $dimension): Response
    {
        $form = $this->createForm(DimensionTranslationType::class, $dimension);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_dimension_index');
        }

        return $this->render('admin/dimension/edit.html.twig', [
            'dimension' => $dimension,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_dimension_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Dimension $dimension): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dimension->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($dimension);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_dimension_index');
    }
}
