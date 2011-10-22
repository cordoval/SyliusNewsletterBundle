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
 * Newsletter manager interface.
 * 
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
interface NewsletterManagerInterface
{
    /**
     * Creates new newsletter object.
     * 
     * @return NewsletterInterface
     */
    function createNewsletter();

    /**
     * Persists newsletter.
     * 
     * @param NewsletterInterface $newsletter
     */
    function persistNewsletter(NewsletterInterface $newsletter);
    
    /**
     * Deletes newsletter.
     * 
     * @param NewsletterInterface $newsletter
     */
    function removeNewsletter(NewsletterInterface $newsletter);
    
    /**
     * Finds newsletter by id.
     * 
     * @param integer $id
     * @return NewsletterInterface
     */
    function findNewsletter($id);
    
    /**
     * Finds newsletter by criteria.
     * 
     * @param array $criteria
     * @return NewsletterInterface
     */
    function findNewsletterBy(array $criteria);
    
    /**
     * Finds all newsletters.
     * 
     * @return array
     */
    function findNewsletters();
    
    /**
     * Finds newsletters by criteria.
     * 
     * @param array $criteria
     * @return array
     */
    function findNewslettersBy(array $criteria);
    
    /**
     * Returns FQCN of newsletter.
     * 
     * @return string
     */
    function getClass();
    
    /**
     * Creates paginator.
     */
    function createPaginator();
}
