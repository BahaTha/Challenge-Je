<?php

namespace App\Controller;
use App\Entity\Article;


use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Repository\User5Repository;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
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

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article")
     */
    public function index(ArticleRepository $repo)
    {
        $articles = $repo->findAll();

        return $this->render('development.html.twig', [
            'articles' => $articles
        ]);
    }
/**
 * 
 */

    /**
    * @Route("/A-{slug}",name="article_show")
    *
    *@return Response 
    */

    public function show($slug ,CommentRepository $repoc ,ArticleRepository $repo,SessionInterface $session ,ArticleRepository $ArticleRepository ,Request $request , EntityManagerInterface $entityManager)
    {
      
        $comment = new Comment();
        $comment->setAuthor($this->getUser());
        $comment->setArt($repo->findOneBySlug($slug));
        $form = $this->createForm(CommentType::class, $comment);
        
        
        $form->handleRequest($request);
        
      
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
        
            if($form->isSubmitted() && $form->isValid())
           { if ($this->getUser()) {
               
                $entityManager->persist($comment);
            $entityManager->flush(); }
           if (!($this->getUser())){ 
            $this->addFlash("warning", "you have to login to post a comment ");
            return $this->redirectToRoute("app_login"); 
        
        }  }
 
        $art = $repo->findOneBySlug($slug);
        $articles = $repo->findAll();
        $comments = $repoc->findAll();
        return $this->render('article.html.twig',[
            'list' => $articles,
            'articles' => $art,
            'items' => $cartWithData,
            'total' => $total,
            'totalq' => $totalq,
            'comments' => $comments,
            'slug' => $slug,
            'form' => $form->createView()
     
        ]);

    } 
    
      /**
     * @route("/shop", name="shop_user")
     * 
     */

    public function shop(ArticleRepository $repo,SessionInterface $session , ArticleRepository $ArticleRepository, User5Repository $userrepo)
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
{
    


        $articles = $repo->findAll();
        $users = $userrepo->findAll();
        $totalc=0;
        foreach($articles as $item)
        { foreach($users as $user)
            {
            if ($item->getAuthor()== $user->getName())
            $totalc+=1 ;
              } }
              $baha = $ArticleRepository->findAll();
        return $this->render('shop.html.twig',[
            'items' => $cartWithData,
            'total' => $total,
            'totalq' => $totalq,
            'users' => $users,
            'totalc' => $totalc,
            'articles' => $baha,
         
            'article' => $articles
        ]);

    }}

    /**
    * @Route("/B-{category}",name="article_dev")
    *
    *@return Response 
    */

    public function showdev($category,CommentRepository $repoc,ArticleRepository $repo,SessionInterface $session , ArticleRepository $ArticleRepository)
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
        $comments = $repoc->findAll();
        $avg=0;
       
        
    
    {    
      
        $art = $repo->findOneBycategory($category);
        $articles = $repo->findAll();
        
       
        return $this->render('/courses/development.html.twig',[
         
            'article' => $articles,
            'articles' => $art,
            'items' => $cartWithData,
            'total' => $total,
            'totalq' => $totalq,
            'category' => $category,
            'comments' => $comments
        ]);

    

    }}
    

    /**
     * @Route("/article-add", name="add_article")
     * @return Response
     */
    public function add(Request $request , EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
       

        $user = new Article();
        
        $form = $this->createForm(Article::class, $user);
        
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {
        $avatarFile = $form->get('Image')->getData();
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

       $this->addFlash("success", "Welcome to our application");

       return $this->redirectToRoute("app_login");  
       
       }

        

        
           
        return $this->render('article/index.html.twig',[
        'form' => $form->createView()
        ]);
            
        
    }
}
