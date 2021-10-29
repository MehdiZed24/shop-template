<?php

namespace App\Repository;

use App\Classe\Search;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, Product::class);
  }

  /**
   * Requete qui me permet de récupérer les produits en fonction de la recherche de l'utilisateur
   * @return Product[]
   */

  public function findWithSearch(Search $search)
  {
    $query = $this
      ->createQueryBuilder('p') //Avec quelle table on veut faire le mapping, avec laquelle on va créer notre "query","p" pour "products
      ->select('c', 'p') //Qu'est ce qu'on veut selectionner à l'interieur de notre query?->'c' pour category et 'p' pour products
      ->join('p.category','c'); //On veut faire la jointure entre les catégories de mon produit et la table category

    if (!empty($search->categories)) {
      //Lorsque et uniquement lorsque les catégories ont été cochés, on veut rajouter un 'where' qui me permet de filtrer mes catégories sur ce qu'on a ecrit ensemble 
      $query = $query->andWhere('c.id IN (:categories)')
        //Rajout à la query qu'on vient de créer plus haut et que dedans; ajout des id de mes catégories soientt dans la liste categorie qu'on envoie en paramètre dans l'objet Search
        //Equivaut à WHERE dans SQL
        ->setParameter('categories', $search->categories);
      //donner un paramètre categories et sa valeur sera ce qu'il y a dans 'search categorie'
    }

    //Est ce que SearchString a été renseigné par l'utilisataeur
    if (!empty($search->string)) { //Est ce qu'une recherche textuelle a été renseigné dans mon champs par l'utulisateur?

      $query = $query
        ->andWhere('p.name LIKE :string')
        //Est ce que le nom de mon produit me permet d'acceder au name du produit,est ce que cela ressemble à la recheche 
        ->setParameter('string', "%{$search->string}%");
        //Est ce que le string passé en paramètre équivaut à mon search, les pourcentages representent une recherche partielle. On utilise les %
    }

    return $query->getQuery()->getResult();
    //On veut retourner la query créee, l'éxecuter et retourner le résultat
  }

  // /**
  //  * @return Product[] Returns an array of Product objects
  //  */
  /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

  /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
