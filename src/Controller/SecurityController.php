<?php

namespace App\Controller;

use App\Entity\User5;
use App\Form\NewRegistrationType;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(EntityManagerInterface $entityManager,UserPasswordEncoderInterface $encoder,SluggerInterface $slugger,Request $request ,AuthenticationUtils $authenticationUtils,SessionInterface $session , ArticleRepository $ArticleRepository): Response
    
    { $cart = $session->get('cart', []);
        $cartWithData = [];
        foreach($cart as $id => $quantity)
        {
            $cartWithData[] = [
                'article' => $ArticleRepository->find($id),
                'quantity' => $quantity
            ];
        }
        $total=0;
        foreach($cartWithData as $item){
            $totalItem = $item['article']->getPrice() * $item['quantity'];
            $total += $totalItem;
        }
        $totalq=0;
        foreach($cartWithData as $item)
        {
            $totalq+=$item['quantity'];
        }
       
    
        if ($this->getUser()) {
            return $this->redirectToRoute('/index');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = new User5();
        
        $form = $this->createForm(NewRegistrationType::class, $user);
        
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {
        $avatarFile = $form->get('Avatar')->getData();
        if ($avatarFile) {
            $originalFilename = pathinfo($avatarFile->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$avatarFile->guessExtension();

            // Move the file to the directory where brochures are stored
            try {
                $avatarFile->move(
                    $this->getParameter('upload_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            // updates the 'brochureFilename' property to store the PDF file name
            // instead of its contents
            $user->setAvatar($newFilename);
        }


           

        $hashed = $encoder->encodePassword($user, $user->getPassword());

       $user->setPassword($hashed);     
        
       $entityManager->persist($user);
       $entityManager->flush();

       $this->addFlash("success", "Welcome to our application");

       return $this->redirectToRoute("app_login");  
       
       }
  
      
            
       $articles = $ArticleRepository->findAll();
        return $this->render('log.html.twig', ['last_username' => $lastUsername, 'error' => $error,
        'items' => $cartWithData,
            'total' => $total,
            'articles' => $articles,
            'form' => $form->createView(),
            'totalq' => $totalq]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
    
}
