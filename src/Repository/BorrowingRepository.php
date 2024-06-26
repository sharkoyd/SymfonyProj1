<?php
// src/Repository/BookRepository.php
namespace App\Repository;

use App\Entity\Borrowing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BorrowingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Borrowing::class);
    }

    // Add your custom queries here
    public function findMostPopularBooks()
    {
        $sql = "SELECT b2.title, COUNT(*) AS howMany
                FROM borrowing b1
                INNER JOIN book b2 ON b2.id=b1.book_id
                GROUP BY b2.title
                ORDER BY howMany DESC";
        $statement = $this->getEntityManager()->getConnection()->prepare($sql);
        $result = $statement->executeQuery()->fetchAllAssociative();
        return $result;
    }
    public function findMostPopularBooksQb()
    {
        return $this->createQueryBuilder('b')
            ->addSelect('bk.title, COUNT(b) AS howMany')
            ->join('b.book', 'bk')
            ->groupBy('bk.title')
            ->orderBy('howMany', 'DESC')
            ->getQuery()
            ->getResult();
    }
    public function findMostPopularBooksDql()
    {
        $query = $this->_em->createQuery('SELECT bk.title, COUNT(b) AS howMany
                                            FROM App\Entity\Borrowing b
                                            JOIN b.book bk
                                            GROUP BY bk.title
                                            ORDER BY howMany DESC');
        $borrowings = $query->getResult();
        return $borrowings;
    }
}
