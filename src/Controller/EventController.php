<?php

namespace App\Controller;

use App\Repository\EventRepository;
use App\Repository\ArticleRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EventController extends AbstractController
{
    /**
     * @Route("/Events", name="event")
     */
    public function index(EventRepository $repon,ArticleRepository $repo,SessionInterface $session , ArticleRepository $ArticleRepository)
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
       
        $events= $repon->findAll();
        $articles = $ArticleRepository->findAll();

        return $this->render('event/index.html.twig', [
            'events' => $events,
            'items' => $cartWithData,
            'total' => $total,
            'articles' => $articles,
            'totalq' => $totalq,
         
        ]);
    }}
   
     /**
     * @Route("/oevents", name="old_events")
     */
    public function old(EventRepository $repo , SessionInterface $session , ArticleRepository $ArticleRepository)
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
        $events= $repo->findAll();
        $articles = $ArticleRepository->findAll();
        return $this->render('event/old.html.twig', [
            'events' => $events,
            'items' => $cartWithData,
            'total' => $total,
            'totalq' => $totalq,
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/good" , name="cbon")
     */
    public function flash(EventRepository $repo , SessionInterface $session , ArticleRepository $ArticleRepository)
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
        $events= $repo->findAll();
        $articles = $ArticleRepository->findAll();
    
        $this->addFlash("success", "Registered to event with sucess");
        return $this->render('home.html.twig', [
            'events' => $events,
            'items' => $cartWithData,
            'total' => $total,
            'totalq' => $totalq,
            'articles' => $articles,
        ]);

    }

   
}
