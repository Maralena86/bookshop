<?php

namespace App\Repository;

use App\Entity\Book;
use App\DTO\SearchBookCriteria;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Book>
 *
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function add(Book $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Book $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findBooksDesc(): array
    {
        $pb= $this->createQueryBuilder('book');
        return $pb
        ->orderBy('book.title', 'ASC')
        ->setMaxResults(30)
        ->getQuery()
        ->getResult();

    }
    public function findBooksCategory(int $id): array
    {
        $pb= $this->createQueryBuilder('book');
        return $pb
        
        ->setParameter('id', $id)
        ->orderBy('book.price', 'DESC')
        ->leftJoin('book.categories', 'category')
        ->andWhere('category.id = :id')
        ->getQuery()
        ->getResult()
        ;

    }
    public function findByCriteria(SearchBookCriteria $search): array
    { 
        $qb= $this->createQueryBuilder('book');
        if($search->title){
            $qb
                ->andWhere('book.title LIKE :title')
                ->setParameter('title', "%$search->title%");
            
        }
        if(!empty($search->authors)){
            $qb
                ->leftJoin('book.author', 'author')
                ->andWhere('author.id IN (:authorIds)')
                ->setParameter('authorIds', $search->authors);
            
        }
        if(!empty($search->categories)){
            $qb
                ->leftJoin('book.categories',  'category')
                ->andWhere('category.id IN (:categoryIds)')
                ->setParameter('categoryIds', $search->categories);
        }
        if($search->minPrice){
            $qb
                ->andWhere('book.price >= :minPrice')
                ->setParameter('minPrice', $search->minPrice);
           
        }
        if($search->maxPrice){
             $qb
                ->andWhere('book.price <= :maxPrice')
                ->setParameter('maxPrice', $search->maxPrice);
          
        }

        if(!empty($search->publishingHouses)){
            $qb
                ->leftJoin('book.publishHouse',  'publishingHouse')
                ->andWhere('publishingHouse.id IN (:publishingHouseIds)')
                ->setParameter('publishingHouseIds', $search->publishingHouses);
        }

        
        return $qb
            ->orderBy('book.' . $search->orderBy, $search->direction)
            ->setMaxResults($search->limit)
            ->setFirstResult(($search->page - 1) * $search->limit)
            ->getQuery()
            ->getResult();
        
    }

//    /**
//     * @return Book[] Returns an array of Book objects
//     */
   public function findByExampleField($value): array
   {
       return $this->createQueryBuilder('b')
           ->andWhere('b.exampleField = :val')
           ->setParameter('val', $value)
           ->orderBy('b.id', 'ASC')
           ->setMaxResults(10)
           ->getQuery()
           ->getResult()
       ;
   }
//    public function findOneBySomeField($value): ?Book
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
