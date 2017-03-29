<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 29/03/17
 * Time: 21:12
 */

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ForumSportController extends Controller
{
    public function sportAction()
    {
        $em = $this->getDoctrine()->getManager();
        $limit = 10;
        $offset = null;
        $article = $em->getRepository('CoreBundle:Articles')->findBy(array(), null, $limit, $offset);//limite le l'affichage à 10 articles
        $news = $this->getDoctrine()
            ->getRepository('CoreBundle:Articles')
            ->findAll();
        if ($news != null){

            return $this->render('@Core/forum/sport.html.twig', array('article' => $article));
        }

        $categories = $em->getRepository('CoreBundle:Categories')->findAll();
        if ($categories != null){

            return $this->render('@Core/forum/sport.html.twig', array('categorie' => $categories));
        }
    }



    public function showAction($id)
    { }

}



/*return $this->render('@Core/forum/sport.html.twig', array(
    'nom' => $nom,
    'date' => $date,
    'contenu' => $contenu
));
*/