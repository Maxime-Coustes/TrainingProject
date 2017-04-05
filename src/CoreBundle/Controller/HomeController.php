<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 29/03/17
 * Time: 21:12
 */

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class HomeController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $limit = 10;
        $offset = null;
        $articles = $em->getRepository('CoreBundle:Articles')->findBy(array(), null, $limit, $offset);//limite le l'affichage à 10 articles
        $typeArticles = $em->getRepository('CoreBundle:TypeArticle')->findAll();

        return $this->render('@Core/home.html.twig',array('articles' => $articles, 'typeArticles' => $typeArticles));
    }




}



/*return $this->render('@Core/forum/sport.html.twig', array(
    'nom' => $nom,
    'date' => $date,
    'contenu' => $contenu
));
*/