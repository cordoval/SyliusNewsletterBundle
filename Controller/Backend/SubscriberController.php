<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\NewsletterBundle\Controller\Backend;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sylius\Bundle\NewsletterBundle\EventDispatcher\Event\FilterSubscriberEvent;
use Sylius\Bundle\NewsletterBundle\EventDispatcher\SyliusNewsletterEvents;

/**
 * Subscriber backend controller.
 * 
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class SubscriberController extends ContainerAware
{
    /**
     * Shows a subscriber.
     */
    public function showAction($id)
    {
        $subscriber = $this->container->get('sylius_newsletter.manager.subscriber')->findSubscriber($id);
        
        if (!$subscriber) {
            throw new NotFoundHttpException('Requested subscriber does not exist.');
        }
        
        return $this->container->get('templating')->renderResponse('SyliusNewsletterBundle:Backend/Subscriber:show.html.' . $this->getEngine(), array(
        	'subscriber' => $subscriber
        ));
    }
    
    /**
     * List paginated subscribers.
     */
    public function listAction()
    {
        $subscriberManager = $this->container->get('sylius_newsletter.manager.subscriber');
        
        $paginator = $subscriberManager->createPaginator();    
        $paginator->setCurrentPage($this->container->get('request')->query->get('page', 1), true, true);
        
        $subscribers = $paginator->getCurrentPageResults();
        
        return $this->container->get('templating')->renderResponse('SyliusNewsletterBundle:Backend/Subscriber:list.html.' . $this->getEngine(), array(
        	'subscribers' => $subscribers,
        	'paginator' => $paginator
        ));
    }
    
    /**
     * Creating a new newsletter.
     */
    public function createAction()
    {     
        $request = $this->container->get('request');
        
        $subscriber = $this->container->get('sylius_newsletter.manager.subscriber')->createSubscriber();
        
        $form = $this->container->get('form.factory')->create($this->container->get('sylius_newsletter.form.type.subscriber'));
        $form->setData($subscriber);
        
        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);
            
            if ($form->isValid()) {
                $this->container->get('event_dispatcher')->dispatch(SyliusNewsletterEvents::NEWSLETTER_CREATE, new FilterSubscriberEvent($subscriber));
                $this->container->get('sylius_newsletter.manipulator.subscriber')->create($subscriber);
               
                return new RedirectResponse($this->container->get('router')->generate('sylius_newsletter_backend_subscriber_show', array(
                	'id' => $subscriber->getId()
                )));
            }
        }
        
        return $this->container->get('templating')->renderResponse('SyliusNewsletterBundle:Backend/Subscriber:create.html.' . $this->getEngine(), array(
        	'form' => $form->createView()
        ));
    }
    
    /**
     * Updating a newsletter.
     */
    public function updateAction($id)
    {
        $subscriber = $this->container->get('sylius_newsletter.manager.subscriber')->findSubscriber($id);
        
        if (!$subscriber) {
            throw new NotFoundHttpException('Requested newsletter does not exist.');
        }
        
        $request = $this->container->get('request');
        
        $form = $this->container->get('form.factory')->create($this->container->get('sylius_newsletter.form.type.subscriber'));
        $form->setData($subscriber);
        
        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);
            
            if ($form->isValid()) {
                $this->container->get('event_dispatcher')->dispatch(SyliusNewsletterEvents::NEWSLETTER_UPDATE, new FilterSubscriberEvent($subscriber));
                $this->container->get('sylius_newsletter.manipulator.subscriber')->update($subscriber);
               
                return new RedirectResponse($this->container->get('router')->generate('sylius_newsletter_backend_subscriber_show', array(
                	'id' => $subscriber->getId()
                )));
            }
        }
        
        return $this->container->get('templating')->renderResponse('SyliusNewsletterBundle:Backend/Subscriber:update.html.' . $this->getEngine(), array(
        	'form' => $form->createView(),
        	'subscriber' => $subscriber
        ));
    }
    
	/**
     * Deletes newsletters.
     */
    public function deleteAction($id)
    {
        $subscriber = $this->container->get('sylius_newsletter.manager.subscriber')->findSubscriber($id);
        
        if (!$subscriber) {
            throw new NotFoundHttpException('Requested newsletter does not exist.');
        }
        
        $this->container->get('event_dispatcher')->dispatch(SyliusNewsletterEvents::NEWSLETTER_DELETE, new FilterSubscriberEvent($subscriber));
        $this->container->get('sylius_newsletter.manipulator.subscriber')->delete($subscriber);
        
        return new RedirectResponse($this->container->get('request')->headers->get('referer'));
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
