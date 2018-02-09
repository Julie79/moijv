<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixture extends Fixture {
    
    // injection dépendance : le fait de passer un objet en paramètre d'une function
    public function load(ObjectManager $manager) {
        // On crée un admin pour accéder à notre backoffice
        $admin = new User();
        $admin->setRoles('ROLE_USER|ROLE_ADMIN');
        $admin->setUsername('root');
        $admin->setPassword(password_hash('root', PASSWORD_BCRYPT));
        $admin->setEmail('admin@noreply.com');
        $admin->setBirthdate(
            \DateTime::createFromFormat('Y/m/d h:i:s', '1979/07/23 10:50:00')
                );
        // persist () permet d'enregistrer les données passées en paramètre, ici : $admin
        $manager->persist($admin);
        
        // On crée une liste factice de 20 utilisateurs
        for ($i = 1; $i <= 20; $i++){
            $user = new User();
            $user->setUsername('user'.$i);
            $user->setEmail('user'.$i.'@mail.com');
            $user->setFirstname('User'.$i);
            $user->setLastname('Fake');
            $user->setRoles('ROLE_USER');
            $user->setPassword(password_hash('user'.$i, PASSWORD_BCRYPT));
            $user->setBirthdate(\DateTime::createFromFormat('Y/m/d h:i:s', (2000 - $i).'/01/01 00:00:00')
            );
            // Notre user sera référencé dans les autres fixtures sous la clé user0 puis user1 etc.
            $this->addReference('user'.$i, $user);
            //On demande au manager d'enregistrer l'utilisateur en BDD
            $manager->persist($user);
        }
               
        $manager->flush(); // Les insert into ne sont effectués qu'à ce moment là
    }
}
