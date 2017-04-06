<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ForumController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $typeArticles = $em->getRepository('CoreBundle:TypeArticle')->findAll(); //typeArticles (pluriel) peut contenir plusieurs 'typeArticle'
        return $this->render('@Core/forum/index.html.twig', array('typeArticles' => $typeArticles));
    }
}
