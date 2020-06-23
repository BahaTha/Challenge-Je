<?php

namespace App\Controller;

use App\Entity\User5;




use App\Entity\PasswordUpdate;
use App\Form\PasswordUpdateType;
use App\Form\NewRegistrationType;



use App\Repository\ArticleRepository;
use Symfony\Component\Form\FormError;
use App\Form\AccountType as AccountType;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\NewRegistrationType as Form;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

 
class AccountController extends AbstractController
{ 
     /**
     * @Route("/login15", name="app_login15")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('index');
        }

      
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('account/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }
     private $entityManager;
     
    
    /**
     * @Route("/register1", name="account_register")
     * @route("/register")
     * 
     * @return Response
     */
    public function register(Request $request , EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder, SluggerInterface $slugger)
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('profile');
        }

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
                    $this->getParameter('avatars_directory'),
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

       $this->addFlash("success","Welcome ".$user->getName()." you can login now !");

       return $this->redirectToRoute("app_login");  
       
       }
  
        return $this->render('account/registration.html.twig',[
        'form' => $form->createView()
        ]);
            
        
    } 
    
    /**
     * @Route("/profil", name="account_profile")
     * 
     *
     * @return Response
     */
    public function profil(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger,SessionInterface $session , ArticleRepository $ArticleRepository) {
        if (!($this->getUser())) {
            return $this->redirectToRoute('/index');
        }
        $user = $this->getUser();
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
            } }

        $form = $this->createForm(AccountType::class, $user);

        $form->handleRequest($request);
        

        if($form->isSubmitted() && $form->isValid())
        {
            $avatarFile = $form->get('Avatar')->getData();
            if ($avatarFile) {
                $originalFilename = pathinfo($avatarFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$avatarFile->guessExtension();
    
                // Move the file to the directory where brochures are stored
                try {
                    $avatarFile->move(
                        $this->getParameter('avatars_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
    
                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $user->setAvatar($newFilename);
            }
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash("success", "Informations Updated !");
            return $this->redirectToRoute("profile");  
           
       
        }
        $articles = $ArticleRepository->findAll();
        return $this->render('account/profil.html.twig',[
            'form' => $form->createView(),
            'items' => $cartWithData,
            'total' => $total,
            'totalq' => $totalq,
            'articles' => $articles,

        ]);
    }

    /**
     * @route("/update-password",name="account_password")
     */
    public function updatePassword(Request $request , UserPasswordEncoderInterface $encoder, EntityManagerInterface $entityManager , SessionInterface $session , ArticleRepository $ArticleRepository)
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

        if (!($this->getUser())) {
            return $this->redirectToRoute('/index');
        }

        $passwordUpdate = new PasswordUpdate();
        $user = $this->getUser();
        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {  $this->addFlash("success", "Password updated :) ");
                
                
                return $this->redirectToRoute("account_password");  
            if(!password_verify($passwordUpdate->getOldpassword(),$user->getPassword()))
            {
                //Gérer l'erreur
                $form->get('OldPassword')->addError(new FormError("Le mot de passe que vous avez tapé n'est pas votre mot de passe actuel ! "));
            } else {
                $newPassword = $passwordUpdate->getNewPassword();
        
                 $hashed = $encoder->encodePassword($user, $newPassword);
         
                $user->setPassword($hashed); 
                 
                $entityManager->persist($user);
                $entityManager->flush();
               
                $this->addFlash("success", "Password updated :) ");
                
                
                return $this->redirectToRoute("profile");  
               
            }
            $this->addFlash("success", "Password updated :) ");
                
                
            return $this->redirectToRoute("profile");  
            }
        $articles = $ArticleRepository->findAll();
        return $this->render('account/password.html.twig',[
            'form' => $form->createView(),
            'items' => $cartWithData,
            'total' => $total,
            'totalq' => $totalq,
            'articles' => $articles,
        ]);
    }


  /**
   * @Route("/logout", name="logout_user")
   */


    public function logout () {}
  

}
