<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use ContainerG93yvNH\getResponseService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/biens", name="property_")
 */
class PropertyController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param PropertyRepository $propertyRepository
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function index(PropertyRepository $propertyRepository, EntityManagerInterface $em): Response
    {
        return $this->render('property/index.html.twig', [
            'properties' => $propertyRepository->findAllVisible(),
        ]);
    }

    /**
     * @Route("/{id}", name="show")
     * @param Property $property
     * @return Response
     */
    public function show(Property $property): Response
    {
        return $this->render('property/show.html.twig',[
            'property' => $property
        ]);
    }
}
