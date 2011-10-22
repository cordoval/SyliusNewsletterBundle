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

use Sylius\Bundle\NewsletterBundle\Model\SubscriberInterface;

/**
 * Subscriber manipulator interface.
 * 
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
interface SubscriberManipulatorInterface
{
    /**
     * Creates a subscriber.
     * 
     * @param SubscriberInterface $subscriber
     */
    function create(SubscriberInterface $subscriber);
    
    /**
     * Updates a subscriber.
     * 
     * @param SubscriberInterface $subscriber
     */
    function update(SubscriberInterface $subscriber);  
    
    /**
     * Deletes a subscriber.
     * 
     * @param SubscriberInterface $subscriber
     */
    function delete(SubscriberInterface $subscriber);
    
    /**
     * Subscribes.
     * 
     * @param SubscriberInterface $subscriber
     */
    function subscribe(SubscriberInterface $subscriber);
    
    /**
     * Unsubscribes.
     * 
     * @param SubscriberInterface $subscriber
     */
    function unsubscribe(SubscriberInterface $subscriber);
    
    /**
     * Confirms subscribtion.
     * 
     * @param SubscriberInterface $subscriber
     */
    function confirm(SubscriberInterface $subscriber);
}
