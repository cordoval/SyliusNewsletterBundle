<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\NewsletterBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * This class contains the configuration information for the bundle.
 *
 * This information is solely responsible for how the different configuration
 * sections are normalized, and merged.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree.
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sylius_newsletter');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('driver')->cannotBeOverwritten()->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('engine')->defaultValue('twig')->end()
            ->end();

        $this->addClassesSection($rootNode);
        $this->addExtensionsSection($rootNode);

        return $treeBuilder;
    }

    /**
     * Adds `classes` section.
     */
    private function addClassesSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('classes')
                    ->isRequired()
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('model')
                            ->isRequired()
                            ->children()
                                ->scalarNode('newsletter')->isRequired()->cannotBeEmpty()->end()
                                ->scalarNode('subscriber')->isRequired()->cannotBeEmpty()->end()
                            ->end()
                        ->end()
                        ->arrayNode('controller')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('backend')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('newsletter')->defaultValue('Sylius\Bundle\\NewsletterBundle\\Controller\Backend\\NewsletterController')->end()
                                        ->scalarNode('subscriber')->defaultValue('Sylius\Bundle\\NewsletterBundle\\Controller\Backend\\SubscriberController')->end()
                                    ->end()
                                ->end()
                                ->arrayNode('frontend')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('subscriber')->defaultValue('Sylius\Bundle\\NewsletterBundle\\Controller\Frontend\\SubscriberController')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('type')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('newsletter')->defaultValue('Sylius\Bundle\\NewsletterBundle\\Form\\Type\\NewsletterFormType')->end()
                                        ->scalarNode('subscriber')->defaultValue('Sylius\Bundle\\NewsletterBundle\\Form\\Type\\SubscriberFormType')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('manipulator')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('newsletter')->defaultValue('Sylius\\Bundle\\NewsletterBundle\\Manipulator\\NewsletterManipulator')->end()
                                ->scalarNode('subscriber')->defaultValue('Sylius\\Bundle\\NewsletterBundle\\Manipulator\\SubscriberManipulator')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
    
	/**
     * Adds `extensions` section.
     * 
     * @param ArrayNodeDefinition $node
     */
    private function addExtensionsSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('extensions')
                    ->children()
                        ->arrayNode('confirmation')
                            ->children()
                                ->booleanNode('enabled')->end()
                                ->arrayNode('options')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->arrayNode('email')
                                            ->children()
                                                ->scalarNode('from')->defaultValue('no-reply@example.com')->end()
                                                ->scalarNode('subject')->defaultValue('Confirm your newsletter subscription on example.com.')->end()
                                                ->scalarNode('template')->defaultValue('SyliusNewsletterBundle:Frontend/Confirmation:email.html.twig')->end()
                                            ->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
