<?php
namespace App\Controller;

use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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

/**
     * @route("/soon", name="soonpage")
     * 
     */

    public function soon(){

     return $this->render ('soon.html.twig',
);
}


}


?>