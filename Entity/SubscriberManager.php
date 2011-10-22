<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\NewsletterBundle\Entity;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sylius\Bundle\NewsletterBundle\Model\SubscriberInterface;
use Sylius\Bundle\NewsletterBundle\Model\SubscriberManager as BaseSubscriberManager;

/**
 * ORM subscriber manager.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class SubscriberManager extends BaseSubscriberManager
{
    /**
     * Entity manager.
     * 
     * @var EntityManager
     */
    protected $entityManager;
    
    /**
     * Subscriber entity repository.
     * 
     * @var EntityRepository
     */
    protected $repository;
    
    /**
     * Constructor.
     * 
     * @param EntityManager $entityManager
     * @param string		$class
     */
    public function __construct(EntityManager $entityManager, $class)
    {
        parent::__construct($class);
        
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository($this->getClass());
    }
    
    /**
     * {@inheritdoc}
     */
    public function createSubscriber()
    {
        $class = $this->getClass();
        return new $class;
    }
    
    /**
     * {@inheritdoc}
     */
    public function persistSubscriber(SubscriberInterface $subscriber)
    {
        $this->entityManager->persist($subscriber);
        $this->entityManager->flush();
    }
    
    /**
     * {@inheritdoc}
     */
    public function removeSubscriber(SubscriberInterface $subscriber)
    {
        $this->entityManager->remove($subscriber);
        $this->entityManager->flush();
    }
    
    /**
     * {@inheritdoc}
     */
    public function findSubscriber($id)
    {
        return $this->repository->find($id);
    }
    
    /**
     * {@inheritdoc}
     */
    public function findSubscriberBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }
    
    /**
     * {@inheritdoc}
     */
    public function findSubscribers()
    {
        return $this->repository->findAll();
    }
    
    /**
     * {@inheritdoc}
     */
    public function findSubscribersBy(array $criteria)
    {
        return $this->repository->findBy($criteria);
    }
    
    /**
     * {@inheritdoc}
     */
    public function createPaginator()
    {
        $queryBuilder = $this->entityManager->createQueryBuilder()
            ->select('s')
            ->from($this->class, 's')
            ->orderBy('s.createdAt', 'DESC');
            
        return new Pagerfanta(new DoctrineORMAdapter($queryBuilder->getQuery()));
    }
}
