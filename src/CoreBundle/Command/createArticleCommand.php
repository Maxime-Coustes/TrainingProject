<?php

namespace CoreBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;



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

    public function writeText(OutputInterface $output, $text)
    {
        return $output->writeln($text);
    }

    public function checkUserConnexion(InputInterface $input, OutputInterface $output)
    {
        $questionType = 'ConfirmationQuestion';
        $label = 'Es tu un utilisateur inscrit sur le site ? ' ;
        $defaultValue = true;
        $isUserSubscribed = $this->generateQuestionWithAnswer($output, $input, $questionType, $label, $defaultValue);
        var_dump($isUserSubscribed);
    }

    public function generateQuestionWithAnswer(OutputInterface $output, InputInterface $input, $questionType, $label, $defaultValue)
    {
        $question = null;
        $helper = $this->getHelper('question');
        $questionClass = '\Symfony\Component\Console\Question\\'.$questionType;
        if ($questionType == 'ConfirmationQuestion') {
            $question = new $questionClass($label,$defaultValue,'/^(y|true|yes)/i');
        }
        return $helper->ask($input,$output,$question);
    }
}
