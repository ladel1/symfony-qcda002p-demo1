<?php 

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    function add(Request $request):Response{

        if($request->isMethod("POST")){
            //la création de l'objet
            $article = new Article();
            $article->setName($request->request->get("name"))
                    ->setDescription($request->request->get("description"))
                    ->setPrice($request->request->get("price"));
    
            // recup entity manager
            $em = $this->getDoctrine()->getManager();
            // persister l'objet
            $em->persist($article);
            $em->flush();
        }
        
        return $this->render("article/add.html.twig");
    }

}
