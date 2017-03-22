<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 22/03/17
 * Time: 21:32
 */

namespace CoreBundle\DataFixtures\ORM;

use CoreBundle\Entity\TypeArticle;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class LoadTypeArticleData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

    private $container;
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container ;
    }

    public function load(ObjectManager $manager)
    {
        $typeArticle = new TypeArticle();
        $typeArticle->setKindof('sport');
        $manager->persist($typeArticle);
        $this->addReference('sport', $typeArticle);

        $typeArticle = new TypeArticle();
        $typeArticle->setKindof('musique');
        $manager->persist($typeArticle);
        $this->addReference('musique', $typeArticle);

        $typeArticle = new TypeArticle();
        $typeArticle->setKindof('cinema');
        $manager->persist($typeArticle);
        $this->addReference('cinema', $typeArticle);

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}