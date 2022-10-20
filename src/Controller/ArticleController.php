<?php 

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Form\ArticleType;
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

    private $em;
    private $articleRepository;

    function __construct(EntityManagerInterface $em,ArticleRepository $articleRepository)
    {
        $this->em=$em;
        $this->articleRepository=$articleRepository;
    }

    /**
     * @Route("/search",name="search")
     */
    function search(Request $request){
        //$articles=$this->articleRepository->search($request->query->get("s"));
        $articles=$this->articleRepository->searchBy($request->query->get("s"));
        $title = "Recherche";
        return $this->render("article/list.html.twig",compact("articles","title"));
    }


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
    function list():Response{
        $articles = $this->articleRepository->findAll();
        $title = "Acrticles";
        return $this->render("article/list.html.twig",compact("articles","title"));
    }     

    /**
     * @Route("/update/{id}",name="update",requirements={"id"="\d+"})
     */
    function update(Article $article,Request $request):Response{
        // verfier la méthode utilisé
        if($request->isMethod("POST")){
            //modifier de l'objet
            $article->setName($request->request->get("name"))
                    ->setDescription($request->request->get("description"))
                    ->setPrice($request->request->get("price"));
            // updater l'objet
            $this->em->flush();
        }        
        return $this->render("article/update.html.twig",compact("article"));
    }

    /**
     * @Route("/delete/{id}",name="delete",requirements={"id"="\d+"})
     */
    function delete($id):Response{
        $this->articleRepository->delete($id);
        return $this->redirectToRoute("app_article_list");
    }
    
    /**
     * @Route("/add",name="add")
     */
    function add(Request $request,EntityManagerInterface $em):Response{// injection de dependance
        // creation de l'objet article
        $article = new Article();
        // creation du formaulaire
        $articleForm = $this->createForm(ArticleType::class,$article);
        // fill article object
        $articleForm->handleRequest($request);
        if($articleForm->isSubmitted() && $articleForm->isValid() ){
            $category_name = $request->request->get("article")["category_name"];
            if(empty($category_name)){
                $this->articleRepository->add($article,true);
            }else{
                $category = new Category();
                $category->setName($category_name)
                         ->setSlug(urlencode($category_name));
                $article->setCategory($category);
                $em->persist($category);
                $em->persist($article);
                $em->flush();
            }
            // // sauvgarder le message dans la session
            $this->addFlash("success","Article a bien été ajouté!");
            return $this->redirectToRoute("app_article_list");
        }


        return $this->render("article/add.html.twig",
                            ["articleForm"=>$articleForm->createView()]);
    }

}
