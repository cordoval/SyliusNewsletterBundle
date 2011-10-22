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
 * Model for newsletters.
 * 
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
abstract class Newsletter implements NewsletterInterface
{
    protected $id;
    protected $title;
    protected $content;
    protected $sent;
    protected $createdAt;
    protected $updatedAt;

    public function __construct()
    {
        $this->sent = false;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getTitle()
    {
        return $this->title;
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    public function getContent()
    {
        return $this->content;
    }
    
    public function setContent($content)
    {
        $this->content = $content;
    }
    
    public function isSent()
    {
        return $this->sent;
    }
    
    public function setSent($sent)
    {
        $this->sent = $sent;
    }
    
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
    public function incrementCreatedAt()
    {
        $this->createdAt = new \DateTime();
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function incrementUpdatedAt()
    {
        $this->updatedAt = new \DateTime();
    }
}
