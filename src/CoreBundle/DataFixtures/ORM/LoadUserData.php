<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 20/03/17
 * Time: 21:20
 */

namespace CoreBundle\DataFixtures\ORM;

use CoreBundle\Entity\Users;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }


    public function load(ObjectManager $manager) //il s'agit de la function load, qui prend comme paramêtre $manager
        // qui doit être une instance de la classe ObjectManager

    {
        $user = new Users();
        $user->setUsername('admin');

        $user->setMail('maxime.coustes@fidesio.com');
        $user->setCategories($this->getReference('administrateur'));
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user, 'admin');
        $user->setPassword($password);//md5 encode et hache le code entre '' plus simple mais moins sûr qu'avec (md5(uniqid()))
// the 'security.password_encoder' service requires Symfony 2.6 or higher
        $user->setPlainPassword('admin');

        $manager->persist($user);
        $this->addReference('userAdmin',$user);


        $user = new Users();
        $user->setUsername('utilisateur');
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user, 'utilisateur');
        $user->setPassword($password);
        $user->setMail('maxime.coustes@fidesio.com');
        $user->setCategories($this->getReference('utilisateur'));
        $user->setPlainPassword('utilisateur');

        $manager->persist($user);
        $this->addReference('userUtilisateur',$user);

        $user = new Users();
        $user->setUsername('ecrivain');
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user, 'ecrivain');
        $user->setPassword($password);
        $user->setMail('maxime.coustes@fidesio.com');
        $user->setCategories($this->getReference('ecrivain'));
        $user->setPlainPassword('ecrivain');
        $manager->persist($user);
        $this->addReference('userEcrivain',$user);


        $manager->flush();

    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 2;
    }

}