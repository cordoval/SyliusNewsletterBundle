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
use Sylius\Bundle\NewsletterBundle\EventDispatcher\Event\FilterNewsletterEvent;
use Sylius\Bundle\NewsletterBundle\EventDispatcher\SyliusNewsletterEvents;

/**
 * Newsletter backend controller.
 * 
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class NewsletterController extends ContainerAware
{
    /**
     * Shows a newsletter.
     */
    public function showAction($id)
    {
        $newsletter = $this->container->get('sylius_newsletter.manager.newsletter')->findNewsletter($id);
        
        if (!$newsletter) {
            throw new NotFoundHttpException('Requested newsletter does not exist.');
        }
        
        return $this->container->get('templating')->renderResponse('SyliusNewsletterBundle:Backend/Newsletter:show.html.' . $this->getEngine(), array(
        	'newsletter' => $newsletter
        ));
    }
    
    /**
     * List paginated newsletters.
     */
    public function listAction()
    {
        $newsletterManager = $this->container->get('sylius_newsletter.manager.newsletter');
        
        $paginator = $newsletterManager->createPaginator();    
        $paginator->setCurrentPage($this->container->get('request')->query->get('page', 1), true, true);
        
        $newsletters = $paginator->getCurrentPageResults();
        
        return $this->container->get('templating')->renderResponse('SyliusNewsletterBundle:Backend/Newsletter:list.html.' . $this->getEngine(), array(
        	'newsletters' => $newsletters,
        	'paginator' => $paginator
        ));
    }
    
	/**
     * Sends a newsletter.
     */
    public function sendAction($id)
    {
        $newsletter = $this->container->get('sylius_newsletter.manager.newsletter')->findNewsletter($id);
        
        if (!$newsletter) {
            throw new NotFoundHttpException('Requested newsletter does not exist.');
        }
        
        $this->container->get('event_dispatcher')->dispatch(SyliusNewsletterEvents::NEWSLETTER_SEND, new FilterNewsletterEvent($newsletter));
        $this->container->get('sylius_newsletter.sender')->send($newsletter);
        $this->container->get('sylius_newsletter.manipulator.newsletter')->send($newsletter);
        
        return $this->container->get('templating')->renderResponse('SyliusNewsletterBundle:Backend/Newsletter:sent.html.' . $this->getEngine(), array(
        	'newsletter' => $newsletter
        ));
    }
    
    /**
     * Creating a new newsletter.
     */
    public function createAction()
    {     
        $request = $this->container->get('request');
        
        $newsletter = $this->container->get('sylius_newsletter.manager.newsletter')->createNewsletter();
        
        $form = $this->container->get('form.factory')->create($this->container->get('sylius_newsletter.form.type.newsletter'));
        $form->setData($newsletter);
        
        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);
            
            if ($form->isValid()) {
                $this->container->get('event_dispatcher')->dispatch(SyliusNewsletterEvents::NEWSLETTER_CREATE, new FilterNewsletterEvent($newsletter));
                $this->container->get('sylius_newsletter.manipulator.newsletter')->create($newsletter);
               
                return new RedirectResponse($this->container->get('router')->generate('sylius_newsletter_backend_newsletter_show', array(
                	'id' => $newsletter->getId()
                )));
            }
        }
        
        return $this->container->get('templating')->renderResponse('SyliusNewsletterBundle:Backend/Newsletter:create.html.' . $this->getEngine(), array(
        	'form' => $form->createView()
        ));
    }
    
    /**
     * Updating a newsletter.
     */
    public function updateAction($id)
    {
        $newsletter = $this->container->get('sylius_newsletter.manager.newsletter')->findNewsletter($id);
        
        if (!$newsletter) {
            throw new NotFoundHttpException('Requested newsletter does not exist.');
        }
        
        $request = $this->container->get('request');
        
        $form = $this->container->get('form.factory')->create($this->container->get('sylius_newsletter.form.type.newsletter'));
        $form->setData($newsletter);
        
        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);
            
            if ($form->isValid()) {
                $this->container->get('event_dispatcher')->dispatch(SyliusNewsletterEvents::NEWSLETTER_UPDATE, new FilterNewsletterEvent($newsletter));
                $this->container->get('sylius_newsletter.manipulator.newsletter')->update($newsletter);
               
                return new RedirectResponse($this->container->get('router')->generate('sylius_newsletter_backend_newsletter_show', array(
                	'id' => $newsletter->getId()
                )));
            }
        }
        
        return $this->container->get('templating')->renderResponse('SyliusNewsletterBundle:Backend/Newsletter:update.html.' . $this->getEngine(), array(
        	'form' => $form->createView(),
        	'newsletter' => $newsletter
        ));
    }
    
	/**
     * Deletes newsletters.
     */
    public function deleteAction($id)
    {
        $newsletter = $this->container->get('sylius_newsletter.manager.newsletter')->findNewsletter($id);
        
        if (!$newsletter) {
            throw new NotFoundHttpException('Requested newsletter does not exist.');
        }
        
        $this->container->get('event_dispatcher')->dispatch(SyliusNewsletterEvents::NEWSLETTER_DELETE, new FilterNewsletterEvent($newsletter));
        $this->container->get('sylius_newsletter.manipulator.newsletter')->delete($newsletter);
        
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
