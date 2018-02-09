<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        // lien avec l'entité Product
        parent::__construct($registry, Product::class);
    }
    
    // fonction pour trouver tous les tag
    public function findAllWithTags(){
        return $this->createQueryBuilder('p')
                // p.tags=join t=alias
                ->leftJoin('p.tags', 't')
                ->addSelect('t')
                ->getQuery()
                ->getResult();
    }

    // fonction pour trouver tous les produits associés à un tag
   public function findByTagWithTags($tag) {
       // SELECT p.*, t.* FROM product p
       // LEFT JOIN product_tag ON product_tag.product_id = product.id
       // LEFT JOIN tag t ON tag.id = product_tag.tag_id
       // WHERE tag.id = 25
       return $this->createQueryBuilder('p')
               ->lefJoin('p.tags', 't')
               ->leftJoin(Product::class, 'p2', Join::WITH, 'p2.id = p.id')
               ->leftJoin('p2.tags', 't2')
               ->addSelect('t')
               ->where('t.id = :id')
               ->setParameter(':id', $tag->getId())
               ->getQuery()
               ->getResult();
   }
    
}
