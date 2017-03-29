<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 22/03/17
 * Time: 21:04
 */

namespace CoreBundle\DataFixtures\ORM;

use CoreBundle\Entity\Articles;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class LoadArticlesData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{


    private $container;
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container ;
    }

    public function load(ObjectManager $manager)
    {
        //$date = new DateTime('now');  // == DateTime();   ou ligne 32 + 35,  ou ligne 36 only ^^
        $article = new Articles();
        $article->setNom('article');
        //$article->setDate($date);
        $article->setDate(new \DateTime());   // l'antislash permet de ne pas avoir à appeler la property directement.
        $article->setContenu('contenu');
        $article->setUsers($this->getReference('userAdmin'));
        $article->addTypeArticle($this->getReference('cinema'));

        $manager->persist($article);

        $manager->flush();

    }


    public function getOrder()
    {
        return 4; //comment savoir dans quel ordre définir le getOrder ?
    }
}