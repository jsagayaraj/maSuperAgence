<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class AdminPropertyController extends AbstractController
{

 
    /**
     * @Route("/admin", name="admin.property.index")
     * @return Response
     */
    public function index(PropertyRepository $repo):Response
    {
      
        $properties = $repo->findAll();
        //dump($result);
        return $this->render('Admin/index.html.twig', compact('properties'));
    }

    /**
     * @Route("/admin/property/new", name="admin.property.new")
     * @return Response
     */
    public function new(Request $request, ObjectManager $em)
    {
      $property = new Property();
      $form = $this->createForm(PropertyType::class, $property);
      $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid())
      {
        $em->persist($property);
        $em->flush();
        $this->addFlash('success', 'Bien creer avec succés');
        return $this->redirectToRoute('admin.property.index');     
        //dump($result);
      }
        else {
          return $this->render('Admin/new.html.twig',[
            //'property' => $property,
          'form'=> $form->createView()
        ]);
      }
    }



    /**
     * @Route("/admin/{id}", name="admin.property.edit", methods="GET|POST")
     * @return Response
     */

    public function edit(Property $property, Request $request, ObjectManager $em)
    {
      $form = $this->createForm(PropertyType::class, $property);
      $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid())
      {
        //$em->persist($property);
        $em->flush();
        $this->addFlash('success', 'Bien modifié avec succés');
        return $this->redirectToRoute('admin.property.index');
      }else{
        return $this->render('Admin/edit.html.twig',[
        'property'=> $property,
        'form'=> $form->createView()
      ]);
      }

      
    }

    /**
     * @Route("/admin/{id}", name="admin.property.delete", methods="DELETE")
     * @return Response
     */
    public function delete (Property $property, ObjectManager $em, Request $request)
    {
      
      if($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token')))
      {
        //dump('suppression');
        $em->remove($property);
        $em->flush();
        //return new Response('Suppression');
        $this->addFlash('success', 'Bien supprimé avec succés');
      }
      return $this->redirectToRoute('admin.property.index');
    }




}
