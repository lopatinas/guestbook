<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;

class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    /**
     * @param Message $message
     *
     * @return Message
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(Message $message): Message
    {
        $em = $this->getEntityManager();
        $em->persist($message);
        $em->flush();

        return $message;
    }

    /**
     * @param int $page
     * @param int $count
     *
     * @return array
     */
    public function listParents(int $page, int $count): array
    {
        return $this->createQueryBuilder('m')
            ->where('m.parent IS NULL')
            ->orderBy('m.createdAt', 'desc')
            ->setFirstResult(($page - 1) * $count)
            ->setMaxResults($count)
            ->getQuery()
            ->getResult();
    }
}
