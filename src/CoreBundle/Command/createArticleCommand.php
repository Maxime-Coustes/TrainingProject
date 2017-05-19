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
    use UserCommandTrait;

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

    /**
     * all functions have to be private
     */
    public function displayHomeMessage(OutputInterface $output)
    {
        $text = 'Bienvenue sur le générateur d\'articles version 3.45 !';
        return $this->writeText($output, $text);
    }

    public function writeText(OutputInterface $output, $text) //enable us to display text
    {
        return $output->writeln($text);
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
            $question = new $questionClass($label,$defaultValue,'/^(y|true|yes|oui|o)/i');
        } elseif ($questionType == 'Question') {
            $question = new $questionClass($label, $defaultValue);
            if ($isHidden == true) {
                $question->setHidden(true);
                $question->setHiddenFallback(false);
            }
        }

        return $helper->ask($input,$output,$question);
    }
    /**
     * @var Question ChoiceQuestion
     * @param OutputInterface $output
     * @param InputInterface $input
     */
    public function generateTitle(InputInterface $input, OutputInterface $output)
    {
        $questionType = 'Question';
        $label ='Quel sera le titre de l\'article ?';
        $defaultValue = null;
        $output->generateQuestionWithAnswer($output, $input, $questionType, $label, $defaultValue);

        if ($output!== null){

            $message = 'Création du titre terminée.' ;
            $this->writeText($output, $message);

            return $this->generateArticleContent();
        }
    }

    /**
     * @var Question ChoiceQuestion
     * @param OutputInterface $output
     * @param InputInterface $input
     */
    public function generateArticleContent(InputInterface $input, OutputInterface $output)
    {
        $questionType = 'Question';
        $label ='Quel sera le contenu de l\'article ?';
        $defaultValue = null;
        $content = $this->generateQuestionWithAnswer($output, $input, $questionType, $label, $defaultValue);

        if ($content!== null){

            $message = 'Création de l\'article terminée!';
            $this->writeText($output, $message);

            $text = 'Le titre de ton artile est : ' . $this->generateTitle($output) ', et le contenu de ton article est : ' . $content ;
            return $this->displayHomeMessage($output, $text);
        }
    }
}

