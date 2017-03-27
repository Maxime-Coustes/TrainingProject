<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 20/03/17
 * Time: 23:03
 */

namespace CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CoreBundle\Entity\Categories;
use Doctrine\Common\DataFixtures\AbstractFixture;

class LoadCategoriesData extends AbstractFixture implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {
       $categorie = new Categories(); // je crer mon objet
       $categorie->setName('Utilisateur');
       $manager->persist($categorie);
       $this->addReference('utilisateur', $categorie); //je lui donne une référence propre à chaque categorie

       $categorie = new Categories();
       $categorie->setName('Administrateur');
       $manager->persist($categorie);
       $this->addReference('administrateur', $categorie);

       $categorie = new Categories();
       $categorie->setName('Ecrivain');
       $manager->persist($categorie);
       $this->addReference('ecrivain', $categorie);

       $manager->flush();

    }



    public function getOrder()
    {
        return 1;
    }
}