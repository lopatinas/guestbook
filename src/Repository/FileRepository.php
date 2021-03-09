<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\File;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

class FileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, File::class);
    }

    /**
     * @param File $file
     *
     * @return File
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(File $file): File
    {
        $em = $this->getEntityManager();
        $em->persist($file);
        $em->flush();

        return $file;
    }
}
