<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\NewsletterBundle\EventDispatcher\Event;

use Symfony\Component\EventDispatcher\Event;
use Sylius\Bundle\NewsletterBundle\Model\NewsletterInterface;

/**
 * Filter newsletter event.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class FilterNewsletterEvent extends Event
{
    private $newsletter;
    
    public function __construct(NewsletterInterface $newsletter)
    {
        $this->newsletter = $newsletter;
    }
    
    public function getNewsletter()
    {
        return $this->newsletter;
    }
}
