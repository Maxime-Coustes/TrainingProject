<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TodolistController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Core/todolist.html.twig');
    }
}
