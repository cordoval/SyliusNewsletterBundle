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
 * Newsletter interface.
 * 
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
interface NewsletterInterface
{
    function getId();
    function getTitle();
    function setTitle($title);
    function getContent();
    function setContent($content);
    function isSent();
    function setSent($sent);
    function incrementCreatedAt();
    function getUpdatedAt();
    function incrementUpdatedAt();
}