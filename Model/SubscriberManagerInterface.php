<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\NewsletterBundle\Model;

/**
 * Subscriber manager interface.
 * 
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
interface SubscriberManagerInterface
{
    /**
     * Creates new subscriber object.
     * 
     * @return SubscriberInterface
     */
    function createSubscriber();

    /**
     * Persists subscriber.
     * 
     * @param SubscriberInterface $subscriber
     */
    function persistSubscriber(SubscriberInterface $subscriber);
    
    /**
     * Deletes subscriber.
     * 
     * @param SubscriberInterface $subscriber
     */
    function removeSubscriber(SubscriberInterface $subscriber);
    
    /**
     * Finds subscriber by id.
     * 
     * @param integer $id
     * @return SubscriberInterface
     */
    function findSubscriber($id);
    
    /**
     * Finds subscriber by criteria.
     * 
     * @param array $criteria
     * @return SubscriberInterface
     */
    function findSubscriberBy(array $criteria);
    
    /**
     * Finds all subscribers.
     * 
     * @return array
     */
    function findSubscribers();
    
    /**
     * Finds subscribers by criteria.
     * 
     * @param array $criteria
     * @return array
     */
    function findSubscribersBy(array $criteria);
    
    /**
     * Returns FQCN of subscriber.
     * 
     * @return string
     */
    function getClass();
    
    /**
     * Creates paginator.
     */
    function createPaginator();
}
