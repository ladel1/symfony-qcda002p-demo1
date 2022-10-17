<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {


    /**
     * @Route("/",name="app_home")
     */
    function home():Response{      
        return $this->render("pages/home.html.twig") ;
    }


    /**
     * @Route("/contact",name="app_contact")
     */
    function contact():Response{
        return new Response("<h1>Contact</h1>");
    }


}
