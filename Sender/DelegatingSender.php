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

class DelegatingSender implements SenderInterface
{
    protected $senders;
    
    public function __construct()
    {
        $this->senders = array();
    }
    
    public function registerSender(SenderInterface $sender)
    {
        $this->senders[] = $sender;
    }
    
    public function unregisterSender(SenderInterface $sender)
    {
    }
    
    public function send(NewsletterInterface $newsletter)
    {
        foreach ($this->senders as $sender) {
            if ($sender->supports($newsletter)) {
                $sender->send($newsletter);
            }
        }
    }
    
    public function supports(NewsletterInterface $newsletter)
    {
        return true;
    }
}
