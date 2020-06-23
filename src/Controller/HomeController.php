<?php
namespace App\Controller;

use App\Entity\User;
use App\Entity\User5;
use App\Form\ContactType;
use App\Form\NewRegistrationType;
use App\Repository\EventRepository;
use App\Repository\User5Repository;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use App\Repository\CoursesRepository;
use App\Form\RegistrationType as Form;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class HomeController extends AbstractController{
    /**
     * @Route("/", name="homepage")
     * @Route("/index.html", name="homepage2")
     * @Route ("/index")
     * @route("/Index")
     */
    public function home(SessionInterface $session ,ArticleRepository $ArticleRepository , User5Repository $users , EventRepository $event , CommentRepository $comment, ArticleRepository $article)
    {
        $users = $this->getDoctrine()->getRepository(User5::class)->findAll();
        $totalus=0;
        foreach($users as $i)
        { $totalus+=1;}
        $cart = $session->get('cart', []);
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
        $articles = $article->findAll();
  $events = $event->findAll();
  $comments = $comment->findAll();
        return $this->render('home.html.twig',[
            'items' => $cartWithData,
            'total' => $total,
            'totalq' => $totalq,
            'totalus' => $totalus,
            'events' => $events,
            'articles' => $articles,
            'comments' => $comments
        ]);
   
    }
    

    private $entityManager;
    
    /**
     * @Route("/registerzzzzz", name="account_registerz")
     * @route("/Registerzzzzz")
     * @return Response
     */
    public function register(Request $request , EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder,SessionInterface $session , ArticleRepository $ArticleRepository, SluggerInterface $slugger,AuthenticationUtils $authenticationUtils): Response
    { if ($this->getUser()) {
        return $this->redirectToRoute('profile');
    }
        
        $cart = $session->get('cart', []);
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

       $this->addFlash("success", "Welcome to our application");

       return $this->redirectToRoute("app_login");  
       
       }
       $error = $authenticationUtils->getLastAuthenticationError();
       // last username entered by the user
       $lastUsername = $authenticationUtils->getLastUsername();
      
       return $this->render('log.html.twig',[
        'form' => $form->createView(),
        'items' => $cartWithData,
            'total' => $total,
            'totalq' => $totalq,
            'last_username' => $lastUsername, 'error' => $error,
            
        ]);
            
        
    } 
/**
     * @route("/Event", name="Registerpage")
     * 
     */

    public function event (ArticleRepository $repo,SessionInterface $session , ArticleRepository $ArticleRepository)
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


        $articles = $repo->findAll();


        return $this->render ('event.html.twig'
        ,[
            'items' => $cartWithData,
            'total' => $total,
            'totalq' => $totalq,
         
            'articles' => $articles
        ]
   );
}
 /**
     * @Route("/list/remove/{id}", name="list_remove")
     */
    public function remove ($id , SessionInterface $session ){

        $cart = $session->get('list', []);
        if (!empty($cart[$id]))
        {
            unset($cart[$id]);
        }
        $session->set('list', $cart);
        return $this->redirectToRoute("index");
    
    }
/**
 * @Route("/sofiennebhim", name="sofiennehaha")
 */
public function sof()
{ return $this->render ('soon.html.twig',);}

/**
     * @route("/soon", name="soonpage")
     * 
     */

    public function soon(SessionInterface $session , ArticleRepository $ArticleRepository)
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
        $articles = $ArticleRepository->findAll();
        return $this->render ('soon.html.twig',[
            'items' => $cartWithData,
            'articles' => $articles,
            'total' => $total,
            'totalq' => $totalq
        ]);
    }

        
   



    

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        if (!($this->getUser())) {
            return $this->redirectToRoute('/index');
        }
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
    /**
     * @route("/profile", name="profile")
     * 
     */

    public function profile(ArticleRepository $repo,SessionInterface $session , ArticleRepository $ArticleRepository,CommentRepository $repoc , User5Repository $users)
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


        $articles = $repo->findAll();
        if (!($this->getUser())) {
            return $this->redirectToRoute('/index');
        }
        $comments = $repoc->findAll();
        $user = $users->findAll();

        return $this->render ('profile.html.twig',[
            'items' => $cartWithData,
            'total' => $total,
            'totalq' => $totalq,
            'comments' => $comments,
            'users' => $user,
         
            'articles' => $articles
        ]);

    }

   /**
    * @route("/Aboutus" ,name="About_us")
    */
    public function about(SessionInterface $session , ArticleRepository $ArticleRepository)
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
        $articles = $ArticleRepository->findAll();
        return $this->render ('aboutus.html.twig',[
            'items' => $cartWithData,
            'total' => $total,
            'totalq' => $totalq,
            'articles' => $articles,
        ]);
    }

/**
 * @Route("/Team",name="team")
 */
public function team(SessionInterface $session , ArticleRepository $ArticleRepository , User5Repository $repo)
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
    $users = $repo->findAll();
    $articles = $ArticleRepository->findAll();
    return $this->render ('team.html.twig',[
        'items' => $cartWithData,
        'total' => $total,
        'totalq' => $totalq,
        'users' => $users,
        'articles' => $articles,
    ]);
}

     /**
    * @route("/contactus" ,name="contact_us")
    */
    public function contact(SessionInterface $session , ArticleRepository $ArticleRepository , Request $request , \Swift_Mailer $mailer) 
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
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
           
            $contact = $form->getData();
           
        $message = (new \Swift_Message('Nouveau contact'))
        ->setFrom($contact['email'])
        ->setTo('baha.thabet1@gmail.com')
        ->setBody(
            $this->renderView(
                'third.html.twig',compact('contact') ), 'text/html'
            );
        $mailer->send($message);
        $this->addFlash("success","Email Sent ! Thanks We will check it soon".$contact['email']);
        return $this->redirectToRoute('homepage');
     
       
        }
        
        
        return $this->render ('contact.html.twig',[
            'items' => $cartWithData,
            'total' => $total,
            'totalq' => $totalq,
            'contactform' => $form->createView()
        ]);
    }
      /**
    * @route("/third" ,name="contact_us3")
    */
    public function third(SessionInterface $session , ArticleRepository $ArticleRepository , Request $request , \Swift_Mailer $mailer) 
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
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
           
            $contact = $form->getData();
           
        $message = (new \Swift_Message('Nouveau contact'))
        ->setFrom('baha.thabet1@gmail.com')
        ->setTo('baha.thabet1@gmail.com')
        ->setBody(
            $this->renderView(
                'third.html.twig',compact('contact') ), 'text/html'
            );
        $mailer->send($message);
        $this->addFlash("success","Email Sent ! Thanks We will check it soon");
        return $this->redirectToRoute('homepage');
     
       
        }
        
        
        return $this->render ('third.html.twig',[
            'items' => $cartWithData,
            'total' => $total,
            'totalq' => $totalq,
            'contactform' => $form->createView()
        ]);
    }
       
     
    /**
    * @route("/schedule" ,name="schedule")
    */
    public function schedule(SessionInterface $session , ArticleRepository $ArticleRepository , CoursesRepository $repo)
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
        $courses = $repo->findAll();
        $articles = $ArticleRepository->findAll();
        return $this->render ('schedule.html.twig',[
            'items' => $cartWithData,
            'total' => $total,
            'totalq' => $totalq,
            'courses' => $courses,
            'articles' => $articles,
        ]);
    }

       
      

   /**
     * @route("/Cart", name="cart_user")
     * 
     */

    public function cart(){


        return $this->render ('cart.html.twig',
   );
}

 /**
     * @route("/Courses/Development", name="development_page")
     * 
     */

    public function development(){
        $articles = $this->getDoctrine()->getRepository(User5::class)->findAll();


        return $this->render ('courses/development.html.twig',[ 'user5' => $articles]
   );
}
/**
     * @route("/Article", name="page_page")
     * 
     */

    public function article(){


        return $this->render ('article.html.twig',[]
   );
}

    

    }


?>