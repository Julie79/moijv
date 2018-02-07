<?php
// Les fichiers du dossier Controller contiennent des actions (ou méthodes) qui répondent aux demandent faites dans l'URI

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    // Pour afficher la liste des utilisateurs
    /**
     * @Route("/admin/user", name="user_list")
     */
    public function getList(UserRepository $userRepo) { // $userRepo = new UserRepository()
        // $userRepo est une variable que l'on crée pour stocker les données de l'instanciation de la classe UserRepository.
        // Cette classe contient une méthode interne findAll() qui nous sert à récupérer notre liste d'utilisateurs.
        // On note donc que UserController est lié à UserRepository, elle-même liée à User.
        $users = $userRepo->findAll();
        
        // render() sert à faire apparaitre la vue de list_user.html.twig
        return $this->render('admin/list_user.html.twig', [
            // 'users' nous resservira dans list_user.html.twig
            // $users est la variable qu'on vient de créer plus haut
            'users' => $users
        ]);
    }
    
    // Pour afficher les détails d'un utilisateur
    /**
     * @Route("/admin/user/{id}", name="user_details")
     */
    public function details(User $user) { // $user = new UserRepository()
        
        return $this->render('admin/details_user.html.twig', [
            'user' => $user
        ]);
    }
}
