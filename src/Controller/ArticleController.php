<?php 

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
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
        $repo = $this->getDoctrine()->getRepository(Article::class);
        return new Response($repo->find($id)->getName());
    } 


    /**
     * @Route("/list",name="list")
     */
    function list(ArticleRepository $repo):Response{
        $articles = $repo->findAll();
        return $this->render("article/list.html.twig",compact("articles"));
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
    function delete(ArticleRepository $repo,$id):Response{
        $repo->delete($id);
        return $this->redirectToRoute("app_article_list");
    }
    
    /**
     * @Route("/add",name="add")
     */
    function add(Request $request,ArticleRepository $repo):Response{// injection de dependance
        // verfier la méthode utilisé
        if($request->isMethod("POST")){
            //la création de l'objet
            $article = new Article();
            $article->setName($request->request->get("name"))
                    ->setDescription($request->request->get("description"))
                    ->setPrice($request->request->get("price"));
            // persister l'objet
            $repo->add($article,true);
        }
        
        return $this->render("article/add.html.twig");
    }

}
