<?php

/*
 * This file is part of the Sylius package.
 *
 * (c); Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\NewsletterBundle\Model;

/**
 * Subscriber interface.
 * 
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
interface SubscriberInterface
{
    function getId();
    function getEmail();
    function setEmail($email);
    function isEnabled();
    function setEnabled($enabled);
    function getConfirmationToken();
    function setConfirmationToken($confirmationToken);
    function getCreatedAt();
    function incrementCreatedAt();
    function getUpdatedAt();
    function incrementUpdatedAt();
}