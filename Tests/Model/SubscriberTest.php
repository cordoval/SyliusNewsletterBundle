<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\NewsletterBundle\Tests\Model;

use Sylius\Bundle\NewsletterBundle\Model\Newsletter;

class SubscriberTest extends \PHPUnit_Framework_TestCase
{
    public function testEmail()
    {
        $newsletter = $this->getSubscriber();
        $this->assertNull($newsletter->getEmail());

        $newsletter->setEmail('testing@email.com');
        $this->assertEquals('testing@email.com', $newsletter->getEmail());
        
        $newsletter->setEmail('TESTING@EMAIL.COM');
        $this->assertEquals('testing@email.com', $newsletter->getEmail());
    }
    
    public function testEnabled()
    {
        $newsletter = $this->getSubscriber();
        $this->assertFalse($newsletter->isEnabled());
        
        $newsletter->setEnabled(true);
        $this->assertTrue($newsletter->isEnabled());
    }

    protected function getSubscriber()
    {
        return $this->getMockForAbstractClass('Sylius\Bundle\NewsletterBundle\Model\Subscriber');
    }
}
