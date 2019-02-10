<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Cocur\Slugify\Slugify;


class PropertyController extends AbstractController
{

 
    /**
     * @Route("/biens", name="property.index")
     * @return Response
     */
    public function index(PropertyRepository $repo):Response
    {
      
        $properties = $repo->findLatest();
        //dump($result);
        return $this->render('pages/home.html.twig',[
            'properties' => $properties
        ]);
    }


    /**
     * @Route("/biens/{slug}-{id}", name="property_show", requirements={"slug": "[a-z0-9\-]*"})
     */
    //when we use {slug} and {id} we should add requirements regular expresion[a-z0-9\-]*
     public function show(Property $property, PropertyRepository $repo)
     {
        //$property = $repo->find($id);
         return $this->render('property/show.html.twig',[
             'property' => $property
         ]);
     }
}
