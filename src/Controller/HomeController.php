<?php
namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController{
    /**
     * @Route("/", name="homepage")
     * @Route("/index.html", name="homepage2")
     * @Route ("/index")
     * @route("/Index")
     */
    public function home() { 

       
       return $this->render('home.html.twig',
       
       
       ); 
        
    
    }
    /**
     * @route ("/Register.html", name="Registerpage2")
     * @route ("/Register", name="Registerpage1")
     */

    public function Register(){

         return $this->render ('log.html.twig',
    );
}

/**
     * @route("/Event", name="Registerpage")
     * 
     */

    public function event(){

        return $this->render ('event.html.twig',
   );
}

}

?>