<?php

namespace CoreBundle\Command;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use CoreBundle\Entity\Users;

class createArticleCommand extends ContainerAwareCommand
{

    private $doctrine;

    public function __construct(EntityManager $doctrine) // contient la valeur de l'argument passer lors de la déclaration du service.
    {
        parent::__construct();
        $this->doctrine = $doctrine; // this->doctrine = instance de private $doctrine dans cette class
    }


    protected function configure()
    {
        $this->setName('myblog:create:article')
            ->setDescription('Ici vous pourrez créer votre article si vous êtes inscrit sur le site ;) ')
            ->setHelp('null');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->displayHomeMessage($output);
        /**
         * @var null|Users $userConnected
         * Je vérifie la connexion de l'utilisateur
         */
        $userConnected = $this->checkUserConnexion($input, $output);

        if ($userConnected){
            $text = 'Bienvenue ' . $userConnected->getUsername() . ', nous allons passer à la génération de l\'article :).';
            $this->writeText($output,$text);
        } else {
            $text = 'Désolé, nous n\'avons pas trouvé d\'utilisateur avec ce pseudonyme.';
            $this->writeText($output,$text);
            return $this->execute($input, $output);
        }
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
            $question = new $questionClass($label,$defaultValue,'/^(y|true|yes|oui)/i');
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

