<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\NewsletterBundle\EventDispatcher;

/**
 * Events.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
final class SyliusNewsletterEvents
{
    const NEWSLETTER_CREATE = 'sylius_newsletter.event.newsletter.create';
    const NEWSLETTER_UPDATE = 'sylius_newsletter.event.newsletter.update';
    const NEWSLETTER_DELETE = 'sylius_newsletter.event.newsletter.delete';
    const NEWSLETTER_SEND   = 'sylius_newsletter.event.newsletter.send';
    
    const SUBSCRIBER_CREATE      = 'sylius_newsletter.event.subscriber.create';
    const SUBSCRIBER_UPDATE      = 'sylius_newsletter.event.subscriber.update';
    const SUBSCRIBER_DELETE      = 'sylius_newsletter.event.subscriber.delete';
    const SUBSCRIBER_SUBSCRIBE   = 'sylius_newsletter.event.subscriber.subscribe';
    const SUBSCRIBER_UNSUBSCRIBE = 'sylius_newsletter.event.subscriber.unsubscribe';
    const SUBSCRIBER_CONFIRM     = 'sylius_newsletter.event.subscriber.confirm';
}
