<?php

namespace App\Controller;

use Doctrine\Persistence\ObjectManager;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountController extends AbstractController
{
    /**
     * @Route("/login", name="account_login")
     */
    public function login()
    {
        return $this->render('account/ooo.html.twig');
    }
    /**
     * @Route("/Register1", name="account_register")
     * @return Response
     */
    public function register(Request $request, ObjectManager $manager)
    {

        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist(user);
            $manager->flush();
        }
        return $this->render('account/login.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
