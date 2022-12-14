<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController {


    /**
     * @Route("/",name="app_home")
     */
    function home(Request $request):Response{         
        $titre = "Home"; 
        $prenom = "Adel";   
        return $this->render("pages/home.html.twig",compact("titre","prenom")) ;
    }


    /**
     * @Route("/contact",name="app_contact")
     */
    function contact():Response{
        return $this->render("pages/contact.html.twig");
    }



}
