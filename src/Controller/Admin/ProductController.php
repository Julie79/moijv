<?php

// Les fichiers du dossier Controller contiennent des actions (ou méthodes) qui répondent aux demandent faites dans l'URI

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Entity\Tag;
use App\Repository\ProductRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller {

    // Pour afficher la liste des produits
    /**
     * @Route("/admin/product", name="product_list")
     */
    public function getList(ProductRepository $productRepo) { // $productRepo = new ProductRepository()
        // $productRepo est une variable que l'on crée pour stocker les données de l'instanciation de la classe ProductRepository.
        // Cette classe contient une méthode interne findAll() qui nous sert à récupérer notre liste de produits.
        // On note donc que ProductController est lié à ProductRepository, elle-même liée à Product.
        $products = $productRepo->findAllWithTags(); // fonction crée dans ProductRepository
        // render() sert à faire apparaitre la vue de list_product.html.twig
        return $this->render('admin/list_product.html.twig', [
            // 'products' nous resservira dans list_product.html.twig
            // $products est la variable qu'on vient de créer plus haut
            'products' => $products
        ]);
    }

    // Pour afficher la liste des produits par tag
    /**
     * @Route("/admin/product/tag/{name}", name="list_product_by_tag")
     */
    public function getListByTag(Tag $tag) {
        $products = $tag->getProducts();
        return $this->render('admin/list_product_by_tag.html.twig', [
            'products' => $products,
            'tag' => $tag
        ]);
    }

    // Pour afficher les détails d'un produit
    /**
     * @Route("/admin/product/{id}", name="product_details")
     */
    public function details(Product $product) { // $product = new ProductRepository()
        return $this->render('admin/details_product.html.twig', [
                    'product' => $product
        ]);
    }

}
