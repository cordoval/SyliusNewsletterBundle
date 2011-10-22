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
use Sylius\Bundle\NewsletterBundle\Model\NewsletterInterface;
use Sylius\Bundle\NewsletterBundle\Model\NewsletterManager as BaseNewsletterManager;

/**
 * ORM newsletter manager.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class NewsletterManager extends BaseNewsletterManager
{
    /**
     * Entity manager.
     * 
     * @var EntityManager
     */
    protected $entityManager;
    
    /**
     * Newsletter entity repository.
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
    public function createNewsletter()
    {
        $class = $this->getClass();
        return new $class;
    }
    
    /**
     * {@inheritdoc}
     */
    public function persistNewsletter(NewsletterInterface $newsletter)
    {
        $this->entityManager->persist($newsletter);
        $this->entityManager->flush();
    }
    
    /**
     * {@inheritdoc}
     */
    public function removeNewsletter(NewsletterInterface $newsletter)
    {
        $this->entityManager->remove($newsletter);
        $this->entityManager->flush();
    }
    
    /**
     * {@inheritdoc}
     */
    public function findNewsletter($id)
    {
        return $this->repository->find($id);
    }
    
    /**
     * {@inheritdoc}
     */
    public function findNewsletterBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }
    
    /**
     * {@inheritdoc}
     */
    public function findNewsletters()
    {
        return $this->repository->findAll();
    }
    
    /**
     * {@inheritdoc}
     */
    public function findNewslettersBy(array $criteria)
    {
        return $this->repository->findBy($criteria);
    }
    
    /**
     * {@inheritdoc}
     */
    public function createPaginator()
    {
        $queryBuilder = $this->entityManager->createQueryBuilder()
            ->select('n')
            ->from($this->class, 'n')
            ->orderBy('n.createdAt', 'DESC');
            
        return new Pagerfanta(new DoctrineORMAdapter($queryBuilder->getQuery()));
    }
}
