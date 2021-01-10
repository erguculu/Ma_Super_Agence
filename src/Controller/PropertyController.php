<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/property", name="property_")
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
        $property = new Property();
        $property->setTitle('Maison')
            ->setPrice(200000)
            ->setRooms(4)
            ->setBedrooms(2)
            ->setDescription('Très belle maison')
            ->setSurface(110)
            ->setFloor(0)
            ->setHeat(1)
            ->setCity('Tours')
            ->setAdress('10 Boulevard Beranger')
            ->setCodePostal('37000');
        $em = $this->getDoctrine()->getManager();
        $em->persist($property);
        $em->flush();

        return $this->render('property/index.html.twig', [
            'properties' => $propertyRepository->findAll(),
        ]);
    }
}
