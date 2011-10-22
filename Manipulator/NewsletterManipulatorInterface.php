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

use Sylius\Bundle\NewsletterBundle\Model\NewsletterInterface;

/**
 * Newsletter manipulator interface.
 * 
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
interface NewsletterManipulatorInterface
{
    /**
     * Creates a newsletter.
     * 
     * @param NewsletterInterface $newsletter
     */
    function create(NewsletterInterface $newsletter);
    
    /**
     * Updates a newsletter.
     * 
     * @param NewsletterInterface $newsletter
     */
    function update(NewsletterInterface $newsletter);  
    
    /**
     * Deletes a newsletter.
     * 
     * @param NewsletterInterface $newsletter
     */
    function delete(NewsletterInterface $newsletter);
    
    /**
     * Sends a newsletter.
     * 
     * @param NewsletterInterface $newsletter
     */
    function send(NewsletterInterface $newsletter); 
}
