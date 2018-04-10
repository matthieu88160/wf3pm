<?php

namespace App\Repository;

use App\Entity\CommentFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CommentFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentFile[]    findAll()
 * @method CommentFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentFileRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CommentFile::class);
    }

//    /**
//     * @return CommentFile[] Returns an array of CommentFile objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CommentFile
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
