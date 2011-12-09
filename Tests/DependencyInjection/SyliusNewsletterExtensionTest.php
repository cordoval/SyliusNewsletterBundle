<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\NewsletterBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Sylius\Bundle\NewsletterBundle\DependencyInjection\SyliusNewsletterExtension;
use Symfony\Component\Yaml\Parser;

class SyliusNewsletterExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testUserLoadThrowsExceptionUnlessDriverSet()
    {
        $loader = new SyliusNewsletterExtension();
        $config = $this->getEmptyConfig();
        unset($config['driver']);
        $loader->load(array($config), new ContainerBuilder());
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testUserLoadThrowsExceptionUnlessDriverIsValid()
    {
        $loader = new SyliusNewsletterExtension();
        $config = $this->getEmptyConfig();
        $config['driver'] = 'foo';
        $loader->load(array($config), new ContainerBuilder());
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testUserLoadThrowsExceptionUnlessEngineIsValid()
    {
        $loader = new SyliusNewsletterExtension();
        $config = $this->getEmptyConfig();
        $config['engine'] = 'foo';
        $loader->load(array($config), new ContainerBuilder());
    }
    
    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testUserLoadThrowsExceptionUnlessSubscriberModelClassSet()
    {
        $loader = new SyliusNewsletterExtension();
        $config = $this->getEmptyConfig();
        unset($config['classes']['model']['subscriber']);
        $loader->load(array($config), new ContainerBuilder());
    }
    
    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testUserLoadThrowsExceptionUnlessNewsletterModelClassSet()
    {
        $loader = new SyliusNewsletterExtension();
        $config = $this->getEmptyConfig();
        unset($config['classes']['model']['newsletter']);
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * getEmptyConfig
     *
     * @return array
     */
    protected function getEmptyConfig()
    {
        $yaml = <<<EOF
driver: ORM
classes:
    model:
        newsletter: Sylius\Bundle\NewsletterBundle\Entity\DefaultNewsletter
        subscriber: Sylius\Bundle\NewsletterBundle\Entity\DefaultSubscriber
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }
}