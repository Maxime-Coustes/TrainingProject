<?php

namespace CoreBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

class createArticleCommand extends Command
{
    protected function configure()
    {
        $this->setName('myblog:create:article')
            ->setDescription('Ici vous pourrez créer votre article si vous êtes inscrit sur le site ;) ')
            ->setHelp('null');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->displayHomeMessage($output);
        $this->checkUserConnexion($input, $output);

    }

    public function displayHomeMessage(OutputInterface $output)
    {
        $text = 'Bienvenue sur le générateur d\'articles version 3.45 !';
        return $this->writeText($output, $text);
    }

    public function writeText(OutputInterface $output, $text) //enable us to display text
    {
        return $output->writeln($text);
    }

    public function checkUserConnexion(InputInterface $input, OutputInterface $output)
    {
        $questionType = 'ConfirmationQuestion';
        $label = 'Es tu un utilisateur inscrit sur le site ? ' ;
        $defaultValue = true;
        $isUserSubscribed = $this->generateQuestionWithAnswer($output, $input, $questionType, $label, $defaultValue);
        //var_dump($isUserSubscribed);

        /******************************* mon code d'aujourd'hui************************************/

        // Si $isUserSUbscribed vaut true
            // On demande ses identifiants: function login
        // Sinon
            // On demande à l'utilisateur s'il souhaite s'inscrire: function doYouWantSubscribed

        if ($isUserSubscribed == true){
            $this->askUserLogin($input, $output);//asking user for informations
        }
        else {
            $this->doYouWantSubscribed($input, $output);//asking user for confirmation      boolean
        }

    }
    public function askUserLogin(InputInterface $input, OutputInterface $output)
    {
        $questionType = 'Question';
        $label ='Quel est ton pseudonyme ? ';
        $defaultValue = null;
        $userLogin = $this->generateQuestionWithAnswer($output, $input, $questionType, $label, $defaultValue);
        // userLogin est ce que rentre le user pour son username, ilcontient la valeur de retour le la function generateQuestionWithAnswer
        $isStringCorrect = $this->checkIfStringContainsSpecialChar($userLogin);

        if ($isStringCorrect == true){
            $this->askUserPassword($output, $input, $userLogin);
        } else {
            $text = 'Attention !  Le pseudo ' .$userLogin. ' contient un ou plusieurs caractères interdits.';
            $this->writeText($output, $text);
            return $this->askUserLogin($input, $output);
        }
    }

    public function askUserPassword(OutputInterface $output,InputInterface $input,  $userLogin)//asking user for informations
    {
        $questionType = 'Question';
        $label = 'Quel est ton mot de passe ? ';
        $defaultValue = null;
        $userPassword = $this->generateQuestionWithAnswer($output, $input, $questionType, $label, $defaultValue, true);


        var_dump($userPassword);die;

        //si on trouve un user pour le couple utilisateur/Mdp
            // on affiche Bienvenue... blablabla
        //sinon
            // "nous n'avons pas trouvé d'user pour cet id" et retour à quel est ton pseudonyme?

    }

    public function checkIfStringContainsSpecialChar($string)
    {
        $isStringCorrect = false;
        $forbidden = '/[#$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]/';
        if(preg_match($forbidden,$string) == 0){
            $isStringCorrect = true;
        }
        return $isStringCorrect;
    }
    /******************************* Fin de mon code d'aujourd'hui************************************/
// le dernier parametre est optionnel et a une valeur par defaut, quand j'appel cette function, je ne met le parametre optionnel seulement si je ne veux pas la valeur par defaut.
    public function generateQuestionWithAnswer(OutputInterface $output, InputInterface $input, $questionType, $label, $defaultValue, $isHidden = false)
    {
        /**
         * @var Question|ConfirmationQuestion|ChoiceQuestion|null $question
         * ici on dit ce que peut être $question et par conséquent les méthodes qui y sont affiliées
         */
        $question = null;
        $helper = $this->getHelper('question');
        $questionClass = '\Symfony\Component\Console\Question\\'.$questionType; //ici on concatène questionType pour que ça soit dynamique car il en existe 3 types.
        if ($questionType == 'ConfirmationQuestion') {
            $question = new $questionClass($label,$defaultValue,'/^(y|true|yes)/i');
        } elseif ($questionType == 'Question') {
            $question = new $questionClass($label, $defaultValue);
            if ($isHidden == true) {
                $question->setHidden(true);
                $question->setHiddenFallback(false);
            }
        }

        return $helper->ask($input,$output,$question);
    }
}
