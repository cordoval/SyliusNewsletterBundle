<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\NewsletterBundle\Controller\Frontend;

use Sylius\Bundle\NewsletterBundle\EventDispatcher\Event\FilterSubscriberEvent;
use Sylius\Bundle\NewsletterBundle\EventDispatcher\SyliusNewsletterEvents;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Subscriber controller.
 * 
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class SubscriberController extends ContainerAware
{
    /**
     * Subscribe.
     */
    public function subscribeAction()
    {     
        $request = $this->container->get('request');
        
        $subscriber = $this->container->get('sylius_newsletter.manager.subscriber')->createSubscriber();
        
        $form = $this->container->get('form.factory')->create($this->container->get('sylius_newsletter.form.type.subscriber'));
        $form->setData($subscriber);
        
        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);
            
            if ($form->isValid()) {
                $this->container->get('event_dispatcher')->dispatch(SyliusNewsletterEvents::SUBSCRIBER_SUBSCRIBE, new FilterSubscriberEvent($subscriber));
                $this->container->get('sylius_newsletter.manipulator.subscriber')->create($subscriber);
               
                return $this->container->get('templating')->renderResponse('SyliusNewsletterBundle:Frontend/Subscriber:subscribed.html.' . $this->getEngine(), array(
                	'subscriber' => $subscriber
                ));
            }
        }
        
        return $this->container->get('templating')->renderResponse('SyliusNewsletterBundle:Frontend/Subscriber:subscribe.html.' . $this->getEngine(), array(
        	'form' => $form->createView()
        ));
    }
    
    /**
     * Unsubscribe.
     */
    public function unsubscribeAction($token)
    {
    }
    
    /**
     * Confirm subscriber action.
     */
    public function confirmAction($token)
    {
        $subscriber = $this->container->get('sylius_newsletter.manager.subscriber')->findSubscriberBy(array('confirmationToken' => $token));
        
        if (!$subscriber) {
            throw new NotFoundHttpException('Requested subscriber does not exist.');
        }
        
        if (!$subscriber->isEnabled()) {
            $this->container->get('event_dispatcher')->dispatch(SyliusNewsletterEvents::SUBSCRIBER_CONFIRM, new FilterSubscriberEvent($subscriber)); 
            $this->container->get('sylius_newsletter.manipulator.subscriber')->confirm($subscriber);
        }

        return $this->container->get('templating')->renderResponse('SyliusNewsletterBundle:Frontend/Subscriber:confirmed.html.' . $this->getEngine(), array(
        	'subscriber' => $subscriber
        ));
    } 
    
    /**
     * Returns templating engine name.
     * 
     * @return string
     */
    protected function getEngine()
    {
        return $this->container->getParameter('sylius_newsletter.engine');
    }
}
