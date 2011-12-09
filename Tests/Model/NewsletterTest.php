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

class NewsletterTest extends \PHPUnit_Framework_TestCase
{
    public function testTitle()
    {
        $newsletter = $this->getNewsletter();
        $this->assertNull($newsletter->getTitle());

        $newsletter->setTitle('testing newsletter');
        $this->assertEquals('testing newsletter', $newsletter->getTitle());
    }
    
    public function testContent()
    {
        $newsletter = $this->getNewsletter();
        $this->assertNull($newsletter->getContent());
    
        $newsletter->setContent('testing newsletter...');
        $this->assertEquals('testing newsletter...', $newsletter->getContent());
    }
    
    public function testSent()
    {
        $newsletter = $this->getNewsletter();
        $this->assertFalse($newsletter->isSent());
        
        $newsletter->setSent(true);
        $this->assertTrue($newsletter->isSent());
    }

    protected function getNewsletter()
    {
        return $this->getMockForAbstractClass('Sylius\Bundle\NewsletterBundle\Model\Newsletter');
    }
}
