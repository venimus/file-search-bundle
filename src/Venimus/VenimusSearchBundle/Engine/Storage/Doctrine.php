<?php
namespace Venimus\VenimusSearchBundle\Engine\Storage;

use Doctrine\ORM\EntityRepository;
use Venimus\VenimusSearchBundle\Model\IndexableInterface;

/**
 * Class Doctrine
 * Implementation of Index storage based on Doctrine ORM Repository
 *
 * @package Venimus\VenimusSearchBundle\Entity
 */
class Doctrine extends EntityRepository implements StorageInterface
{
    /**
     * Indicates how many persists before automatic flush is performed.
     * If set to 0 will disable auto-flushing. If set to 1 will flush on every call of persist().
     *
     * @var int
     */
    private $flushEvery = 10;

    /**
     * Counts persists and flush when reached $flushEvery limit
     * @var int
     */
    private $flushCount = 0;

    /**
     * Holds the name of the Entity column that stores the index identifiers (e.g. returned by Entity::getIdentifier())
     * @var string
     */
    private $identifierName = 'identifier';

    /**
     * Creates or updates an entry
     * It searches the repository by identifier first instead of directly update it, because the provided Indexable
     * might not be a Doctrine managed entity
     *
     * @param IndexableInterface $indexable
     */
    public function persist(IndexableInterface $indexable)
    {
        $entity = $this->get($indexable->getIdentifier());
        $this->flushCount++;

        // new entity
        if (!$entity) {
            /* @var \Venimus\VenimusSearchBundle\Entity\Index $entity */
            $class = $this->getClassName();
            $entity = new $class();
            $entity->setIdentifier($indexable->getIdentifier());
        };

        $entity->setContent($indexable->getContent());

        $this->getEntityManager()->persist($entity);

        if ((int)$this->flushEvery === $this->flushCount) {
            $this->flush();
        }
    }

    public function get($identifier)
    {
        return $this->findOneBy([$this->getIdentifierName() => $identifier]);
    }

    /**
     * Returns the name of the property of the Entity that stores the index identifier data
     * @return string
     */
    public function getIdentifierName()
    {
        return $this->identifierName;
    }

    public function flush()
    {
        $this->getEntityManager()->flush();
        $this->flushCount = 0;
    }

    public function remove($identifier)
    {
        $this->getEntityManager()->remove($this->get($identifier));
        $this->getEntityManager()->flush();
    }

    public function getMatching($string)
    {
        $qb = $this->createQueryBuilder('a');
        $qb->select('a.' . $this->getIdentifierName());
        $qb->where('a.content like :partial');
        $qb->setParameter('partial', '%' . $string . '%');

        $result = $qb->getQuery()->getScalarResult();

        return array_column($result, null, $this->getIdentifierName());
    }

    /**
     * Sets the auto-flush threshold.
     * Set 0 to disable auto-flushing - flush will be performed only on implicit call of flush().
     * Set 1 to flush every persisted entity.
     * Default is 10
     *
     * @param int $flushEvery
     */
    public function setFlushEvery($flushEvery)
    {
        $this->flushEvery = (int)$flushEvery;
    }
}
