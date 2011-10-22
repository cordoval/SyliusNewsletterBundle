<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\NewsletterBundle\Sender;

use Sylius\Bundle\NewsletterBundle\Model\NewsletterInterface;

/**
 * Interface for newsletter sender.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
interface SenderInterface
{
    function send(NewsletterInterface $newsletter);
    function supports(NewsletterInterface $newsletter);
}
