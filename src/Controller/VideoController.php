<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\EventRepository;
use App\Repository\VideosRepository;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use App\Repository\CoursesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VideoController extends AbstractController
{
    /**
     * @route("/Vid-{slug}", name="video_page")
     * 
     */

    public function video($slug ,EntityManagerInterface $entityManager,SessionInterface $session , ArticleRepository $repo,CommentRepository $repoc,Request $request , VideosRepository $vid)
        { $comment = new Comment();
        
            $form = $this->createForm(CommentType::class, $comment);
            $form->handleRequest($request);
          
            
            $cart = $session->get('cart', []);
            $cartWithData = [];
            foreach($cart as $id => $quantity)
            {
                $cartWithData[] = [
                    'article' => $repo->find($id),
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
            { $entityManager->persist($comment);
             $entityManager->flush(); }
            $articles = $repo->findAll();
            $art = $repo->findOneByslug($slug);

            $comments = $repoc->findAll();
            $videos = $vid->findAll();
            $i=1;
            
            return $this->render ('/courses/video.html.twig',[
                'items' => $cartWithData,
                'total' => $total,
                'videos' => $videos,
                
                'totalq' => $totalq,
                'list' => $articles,
                'video' => $art,
                'comments' => $comments,
                'i'=> $i,
                'slug' =>$slug,
                'form' => $form->createView()
                

            ]);
        }
        /**
     * @route("/Live-{slug}", name="Live_page")
     * 
     */

    public function live($slug ,EntityManagerInterface $entityManager,SessionInterface $session , ArticleRepository $repo,CommentRepository $repoc,Request $request , VideosRepository $vid, EventRepository $event, CoursesRepository $cours )
    {          $this->denyAccessUnlessGranted('ROLE_STUDENT_'.$slug);
        $comment = new Comment();
    
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
      
        
        $cart = $session->get('cart', []);
        $cartWithData = [];
        foreach($cart as $id => $quantity)
        {
            $cartWithData[] = [
                'article' => $repo->find($id),
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
        { $entityManager->persist($comment);
         $entityManager->flush(); }
        $articles = $repo->findAll();
        $art = $repo->findOneByslug($slug);

        $comments = $repoc->findAll();
        $videos = $vid->findAll();
        $events = $event->findAll();
        $courses = $cours->findAll();
        
        return $this->render ('live.html.twig',[
            'items' => $cartWithData,
            'total' => $total,
            'videos' => $videos,
            'totalq' => $totalq,
            'list' => $articles,
            'video' => $art,
            'slug' => $slug,
            'comments' => $comments,
            'courses' => $courses,
            'form' => $form->createView()
            

        ]);
    }
}
