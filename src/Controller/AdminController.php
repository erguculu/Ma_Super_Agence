<?php

namespace App\Controller;

use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Property;

/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="property_index", methods={"GET"})
     * @param PropertyRepository $propertyRepository
     * @return Response
     */
    public function index(PropertyRepository $propertyRepository): Response
    {
        return $this->render('admin/index.html.twig', [
            'properties' => $propertyRepository->findAll(),
        ]);
    }


    /**
     * @Route ("/new", name="property_new")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface $em):Response
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($property);
            $em->flush();

            $this->addFlash('success', 'Le bien a été bien ajouté');

            return $this->redirectToRoute('admin_property_index');
        };
        return $this->render('admin/new.html.twig', [
            'property' => $property,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="property_edit", methods={"GET", "POST"})
     * @param Request $request
     * @param Property $property
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function edit(Request $request, Property $property, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($property);
            $em->flush();

            $this->addFlash('success', 'Le bien a été bien édité');


            return $this->redirectToRoute('admin_property_index');
        }

        return $this->render('admin/edit.html.twig', [
            'property' => $property,
            'form' =>$form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="property_delete", methods="DELETE")
     * @param Request $request
     * @param Property $property
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function delete(Request $request, Property $property, EntityManagerInterface $em ):Response
    {
        if ($this->isCsrfTokenValid('delete'.$property->getId(), $request->request->get('_token'))){
        $em->remove($property);
        $em->flush();

            $this->addFlash('danger', 'Le bien a été bien supprimé');
        }
        return $this->redirectToRoute('admin_property_index');

    }
}
