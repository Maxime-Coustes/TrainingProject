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

       for ($i = 0; $i <= 30; $i += 7){

           $article = new Articles();
           $date = new \DateTime('-'. $i .'days'); //now
           $article->setDate($date);
           $article->setNom('Resident Evil 1');
           $article->setContenu('Dans un somptueux manoir, une jeune femme nommée Alice (Milla Jovovich) 
           se réveille dans une salle de bains sans aucun souvenir. 
           Le temps de chercher des informations et des explications relatives à son amnésie, 
           Alice rencontre un homme du nom de Matt, un policier de la ville, (Eric Mabius) et tous deux se font 
           capturer par un commando d\'élite qui investit le manoir. Les soldats (James One Shade (Colin Salmon),
            Rain Ocampo (Michelle Rodríguez), Chad Kaplan (Martin Crewes), J. D. Salidas (Pasquale Aleardi), Olga (le médecin) 
            (Liz May Brice) et deux autres soldats) ont pour objectif de retrouver la véritable raison de cette mise en quarantaine, 
            qui a tourné, peut-on dire, au massacre. C\'est alors qu\'ils contraignent Alice, qui est une ancienne membre d\'escouade d\'Umbrella Corporation,
             et Matt, à monter à bord d\'un train situé sous le manoir les conduisant au HIVE, le laboratoire souterrain.
              Dans le train, le groupe découvre un autre homme qui comme Alice, n\'a aucun souvenir. 
              Il s\'agit d\'un autre membre d\'escouade et compagnon d\'Alice dénommé Spencer Parks (James Purefoy).');
           $article->setUsers($this->getReference('userEcrivain'));
           $article->addTypeArticle($this->getReference('cinema'));
           $manager->persist($article);
       }


        $manager->flush();

    }


    public function getOrder()
    {
        return 4; //comment savoir dans quel ordre définir le getOrder ?
    }
}