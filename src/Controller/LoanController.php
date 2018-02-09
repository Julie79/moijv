<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class LoanController extends Controller
{
    /**
     * @Route("/add/product", name="add_product")
     */
    public function addProduct(ObjectManager $manager, Request $request)
    {
//      $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez être connecté pour accéder à cette page');
        
        $product = new Product();
        
        // creation du formulaire
        $form = $this->createForm(ProductType::class, $product)
            // création du bouton submit)
            ->add('Envoyer', SubmitType::class);
        
        $form->handleRequest($request);
        
            // validation du formulaire
            if($form->isSubmitted() && $form->isValid()){
                // upload du fichier image
                $image = $product->getImage();
                // uniqid() génère une chaine de caractère aléatoire
                $fileName = md5(uniqid()).'.'.$image->guessExtension();
                $image->move('uploads/product', $fileName);
                $product->setImage($fileName);
                $product->setUser($this->getUser()); // notre image est liée à l'utilisateur courant

                // enregistrement du produit
                $manager->persist($product);
                $manager->flush();
        }
        
        return $this->render('add_product.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    /**
     * @Route("product", name="my_products")
     */
    public function myProducts() {
        return $this->render('my_products.html.twig');
    }
}
