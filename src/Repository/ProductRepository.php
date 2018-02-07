<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
        
        return $this->createQueryBuilder('p')
                // p.tags=join t=alias
                ->leftJoin('p.tags', 't')
                ->addSelect('t')
                ->where('t.id = :id')
                ->setParameter(':id', $tag->getId())
                ->getQuery()
                ->getResult();
    }
    
}
