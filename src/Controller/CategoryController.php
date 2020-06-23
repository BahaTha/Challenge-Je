<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CategoryController extends AbstractController
{
    /**
    * @Route("/C-{category}",name="article_show12")
    *
    *@return Response 
    */

    public function show($category ,ArticleRepository $repo)
    
    {
        $art = $repo->findOneByCategory($category);
        $articles = $repo->findAll();
        return $this->render('/courses/development.html.twig',[
            'list' => $articles,
            'articles' => $art
        ]);

    }}
