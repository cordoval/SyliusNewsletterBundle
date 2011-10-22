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

use Sylius\Bundle\NewsletterBundle\Model\NewsletterManagerInterface;
use Sylius\Bundle\NewsletterBundle\Model\NewsletterInterface;

/**
 * Newsletter manipulator.
 * 
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class NewsletterManipulator implements NewsletterManipulatorInterface
{
    /**
     * Newsletter manager.
     * 
     * @var NewsletterManagerInterface
     */
    protected $newsletterManager;
    
    /**
     * Constructor.
     * 
     * @param NewsletterManagerInterface 	$newsletterManager
     */
    public function __construct(NewsletterManagerInterface $newsletterManager)
    {
        $this->newsletterManager = $newsletterManager;
    }
    
    /**
     * {@inheritdoc}
     */
    public function create(NewsletterInterface $newsletter)
    {
        $newsletter->incrementCreatedAt();
        
        $this->newsletterManager->persistNewsletter($newsletter);
    }
    
	/**
     * {@inheritdoc}
     */
    public function update(NewsletterInterface $newsletter)
    {
        $newsletter->incrementUpdatedAt();
        
        $this->newsletterManager->persistNewsletter($newsletter);
    }
    
	/**
     * {@inheritdoc}
     */
    public function delete(NewsletterInterface $newsletter)
    {     
        $this->newsletterManager->removeNewsletter($newsletter);
    }
    
	/**
     * {@inheritdoc}
     */
    public function send(NewsletterInterface $newsletter)
    {
        $this->update($newsletter);
    }
}
