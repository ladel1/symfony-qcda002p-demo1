<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article",name="app_article_")
 */
class ArticleController extends AbstractController {

    /**
     * @Route("/{id}",name="detail",requirements={"id"="\d+"})
     */
    function detail($id):Response{
        return new Response("<h1> id = $id</h1>");
    } 

    /**
     * @Route("/update/{id}",name="update",requirements={"id"="\d+"})
     */
    function update($id):Response{
        return new Response("Modifier un article");
    }

    /**
     * @Route("/delete/{id}",name="delete",requirements={"id"="\d+"})
     */
    function delete($id):Response{
        return new Response("Supprimer un article");
    }

    /**
     * @Route("/add",name="add")
     */
    function add():Response{
        return new Response("Ajouter un article");
    }

}
