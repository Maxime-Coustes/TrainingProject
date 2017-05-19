<?php

namespace CoreBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use CoreBundle\Entity\Users;

trait UserCommandTrait
{
    public function checkUserConnexion(InputInterface $input, OutputInterface $output)
    {
        $questionType = 'ConfirmationQuestion';
        $label = 'Es tu un utilisateur inscrit sur le site ? ' ;
        $defaultValue = true;
        $isUserSubscribed = $this->generateQuestionWithAnswer($output, $input, $questionType, $label, $defaultValue);

        if ($isUserSubscribed == true){
            /**
             * C'est le cas de l'authentification
             */
            return $this->askUserLogin($input, $output);//asking user for informations
        }
        else {
            /**
             * C'est potentiellement le cas de l'inscription
             */
            return $this->doYouWantSubscribed($input, $output);//asking user for confirmation      boolean
        }

    }
    public function doYouWantSubscribed(InputInterface $input, OutputInterface $output)
    {
        $questionType = 'ConfirmationQuestion';
        $label = 'Voulez-vous vous inscrire sur le site ? ';
        $defaultValue = true;
        $isUserWantsSubscribed = $this->generateQuestionWithAnswer($output, $input, $questionType, $label, $defaultValue);

        if ($isUserWantsSubscribed == true){
            /**
             * C'est le cas de l'inscription
             */
            return $this->askUserLogin($input, $output, true);
        } else {
            /**
             * Fermeture de la commande
             */
            return $this->closeCommand($output);
        }
    }

    public function closeCommand(OutputInterface $output)
    {
        $text = 'Nous sommes désolé, mais la publication d\'article n\'est pas possible aux utilisateurs n\'étant pas inscrit sur le site. Au revoir et bonne journée';
        return $this->writeText($output, $text);
    }

    public function askUserLogin(InputInterface $input, OutputInterface $output, $subscribe = false)
    {
        $questionType = 'Question';
        $label ='Quel est ton pseudonyme ? ';
        $defaultValue = null;
        $userLogin = $this->generateQuestionWithAnswer($output, $input, $questionType, $label, $defaultValue);
        // userLogin est ce que rentre le user pour son username, il contient la valeur de retour de la function generateQuestionWithAnswer
        $isStringCorrect = $this->checkIfStringContainsSpecialChar($userLogin);

        if ($subscribe == true && $isStringCorrect == true) {
            /**
             * Mode inscription
             */
            return $this->askUserEmail($output, $input, $userLogin);
        } elseif ($subscribe == false && $isStringCorrect == true) {
            /**
             * Mode authentification
             */
            return $this->askUserPassword($output, $input, $userLogin);
        } else {
            $text = 'Attention !  Le pseudo ' .$userLogin. ' contient un ou plusieurs caractères interdits.';
            $this->writeText($output, $text);
            return $this->askUserLogin($input, $output);
        }
    }

    /**
     * @param OutputInterface $output
     * @param InputInterface $input
     * @param $userLogin
     * @return Users|null|object
     */
    public function askUserEmail(OutputInterface $output, InputInterface $input, $userLogin)
    {
        /**TODO regex email and condition if forbidden carac
         *
         * $questionType
         *
         */
        $questionType = 'Question';
        $label ='Quel est ton adresse e-mail ?';
        $defaultValue = null;
        $userEmail = $this->generateQuestionWithAnswer($output, $input, $questionType, $label, $defaultValue);

        return $this->askUserPassword($output, $input, $userLogin, true, $userEmail);
    }

    public function askUserPassword(OutputInterface $output,InputInterface $input, $userLogin, $subscribe = false, $userEmail = '')//asking user for informations
    {
        $questionType = 'Question';
        $label = 'Quel est ton mot de passe ? ';
        $defaultValue = null;
        $userPassword = $this->generateQuestionWithAnswer($output, $input, $questionType, $label, $defaultValue, true);

        if ($subscribe == true) {
            /**
             * Mode inscription
             */
            return $this->checkIfUserExists($userPassword, $userLogin, true, $userEmail, $output);
        } else {
            /**
             * Mode authentification
             */
            return $this->checkIfUserExists($userPassword, $userLogin);
        }
    }

    public function checkIfUserExists($userPassword, $userLogin, $subscribe = false, $userEmail = '', $output = null)
    {
        $user = $this->doctrine->getRepository('CoreBundle:Users')->findOneBy(
            [
                'username' => $userLogin ,
                'plainPassword' => $userPassword
            ]
        );

        if ($subscribe == true && $user == null) {
            $message = 'Création de l\'utilisateur en cours. Veuillez patienter ...';
            $this->writeText($output, $message);

            $category = $this->doctrine->getRepository('CoreBundle:Categories')->findOneBy(
                array(
                    'name' => 'Ecrivain'
                )
            );

            $passwordEncoder = $this->getContainer()->get('security.password_encoder');
            $user = new Users();
            $passwordEncoded = $passwordEncoder->encodePassword($user, $userPassword);

            $user->setMail($userEmail)
                ->setPlainPassword($userPassword)
                ->setUsername($userLogin)
                ->setIsActive(true)
                ->setCategories($category)
                ->setPassword($passwordEncoded);

            $this->doctrine->persist($user);
            $this->doctrine->flush();

            $message = 'Création de l\'utilisateur terminée.';
            $this->writeText($output, $message);
        }

        return $user;
    }

    public function checkIfStringContainsSpecialChar($string)
    {
        $isStringCorrect = false;
        $forbidden = '/[#$%^&*()+=\-\[\]\';,.\/{}|":<>@!?~\\\\]/';
        if(preg_match($forbidden,$string) == 0){
            $isStringCorrect = true;
        }
        return $isStringCorrect;
    }

}

