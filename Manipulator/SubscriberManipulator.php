<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\NewsletterBundle\Manipulator;

use Sylius\Bundle\NewsletterBundle\Model\SubscriberManagerInterface;
use Sylius\Bundle\NewsletterBundle\Model\SubscriberInterface;

/**
 * Subscriber manipulator.
 * 
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class SubscriberManipulator implements SubscriberManipulatorInterface
{
    /**
     * Subscriber manager.
     * 
     * @var SubscriberManagerInterface
     */
    protected $subscriberManager;
    
    /**
     * Constructor.
     * 
     * @param SubscriberManagerInterface 	$subscriberManager
     */
    public function __construct(SubscriberManagerInterface $subscriberManager)
    {
        $this->subscriberManager = $subscriberManager;
    }
    
    /**
     * {@inheritdoc}
     */
    public function create(SubscriberInterface $subscriber)
    {
        $subscriber->incrementCreatedAt();
        $this->subscriberManager->persistSubscriber($subscriber);
    }
    
	/**
     * {@inheritdoc}
     */
    public function update(SubscriberInterface $subscriber)
    {
        $subscriber->incrementUpdatedAt();
        $this->subscriberManager->persistSubscriber($subscriber);
    }
    
	/**
     * {@inheritdoc}
     */
    public function delete(SubscriberInterface $subscriber)
    {     
        $this->subscriberManager->removeSubscriber($subscriber);
    }
    
	/**
     * {@inheritdoc}
     */
    public function subscribe(SubscriberInterface $subscriber)
    {
        $this->create($subscriber);
    }
    
	/**
     * {@inheritdoc}
     */
    public function unsubscribe(SubscriberInterface $subscriber)
    {
        $this->delete($subscriber);
    }
    
	/**
     * {@inheritdoc}
     */
    public function confirm(SubscriberInterface $subscriber)
    {
        $subscriber->setEnabled(true);
        $this->update($subscriber);
    }
}
