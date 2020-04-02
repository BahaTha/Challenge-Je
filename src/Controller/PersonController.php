<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PersonController extends AbstractController
{
   /**
 *@route ("/new", name="bon")
 *
 *@Method({"GET", "HEAD"})
 *
 *@return Response
 */
public function create(Request $request, EntityManagerInterface $manager)
{

     $person = new Person();
     $form = $this->createForm(PersonType::class, $person);
     $form->handleRequest($request);
     if($form->isSubmitted() && $form->isValid())
     {
         // $manager = $this->getDoctrine()->getManager();
          $manager->persist($person);
          $manager->flush();
     }
     
     return $this->render('person/index.html.twig', [ 

          'form' => $form->createView()
     ]);
}

}
