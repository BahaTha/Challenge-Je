<?php

namespace App\Controller;

use App\Repository\User5Repository;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart_index")
     */
    public function index(SessionInterface $session , ArticleRepository $ArticleRepository)
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
        return $this->render ('cart.html.twig',[
            'items' => $cartWithData,
            'total' => $total,
            'totalq' => $totalq,
            'articles' => $articles,
        ]);
    }



    /**
     * @Route("/cart/add/{id}", name="cart_add")
     */
    public function add($id, SessionInterface $session )
    {

        
        $cart = $session->get('cart', []);

        if (!empty($cart[$id]))
        
        {
            $cart[$id]++;
        } else {
            $cart[$id]= 1;
        }
        
        $session->set('cart', $cart);
        

        return $this->redirectToRoute("cart_index");

    }
    /**
     * @Route("/cart/remove/{id}", name="cart_remove")
     */
    public function remove ($id , SessionInterface $session ){

        $cart = $session->get('cart', []);
        if (!empty($cart[$id]))
        {
            unset($cart[$id]);
        }
        $session->set('cart', $cart);
        return $this->redirectToRoute("cart_index");
    
    }

    /**
     * @Route("/Checkout", name="check_out")
     */
    public function checkout (SessionInterface $session , ArticleRepository $ArticleRepository)
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
        return $this->render ('checkout.html.twig',[
            'items' => $cartWithData,
            'total' => $total,
            'articles' => $articles,
            'totalq' => $totalq
        ]);
    
}
  /**
     * @route("/shop", name="shop_userz")
     * 
     */

    public function shop(ArticleRepository $repo,SessionInterface $session , ArticleRepository $ArticleRepository)
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
        return $this->render('shop.html.twig',[
            'items' => $cartWithData,
            'total' => $total,
            'totalq' => $totalq,
         
            'articles' => $articles
        ]);

    }
    /**
     * @Route("/payment", name="payment")
     */
    public function payment (SessionInterface $session , ArticleRepository $ArticleRepository)
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
        return $this->render ('proc.html.twig',[
            'items' => $cartWithData,
            'total' => $total,
            'totalq' => $totalq,
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/list-{slug}", name="list")
     */
    public function list ($slug ,CommentRepository $repoc ,User5Repository $repo,SessionInterface $session ,ArticleRepository $ArticleRepository ,Request $request , EntityManagerInterface $entityManager)
    {
        $this->denyAccessUnlessGranted('ROLE_TEACHER');
      
        
       
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
     
        $users = $repo->findAll();
        $art = $ArticleRepository->findOneBySlug($slug);
        $articles = $ArticleRepository->findAll();
        $comments = $repoc->findAll();
        
        return $this->render('list.html.twig',[
            'list' => $articles,
            'articles' => $art,
            'items' => $cartWithData,
            'total' => $total,
            'totalq' => $totalq,
            'users' => $users,
        ]);
    }}

