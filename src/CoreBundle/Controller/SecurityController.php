<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 27/03/17
 * Time: 22:22
 */

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    public function loginAction(Request $request){
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('@Core/security/login.html.twig', array( //rappel depuis le controller vers l'affichage de l'erreur si erreur il y a.
            'last_username' => $lastUsername, //key = nom de la variable dans le template twig
            'error'         => $error,// idem
        ));
    }

}