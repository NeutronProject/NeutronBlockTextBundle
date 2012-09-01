<?php

namespace Neutron\Widget\BlockTextBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('neutron_block_text');
        
        $this->addGeneralConfigurations($rootNode);
        $this->addFormSection($rootNode);

        return $treeBuilder;
    }
    
    private function addGeneralConfigurations(ArrayNodeDefinition $node)
    {
        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->booleanNode('enable')->defaultFalse()->end()
                ->booleanNode('is_html')->defaultFalse()->end()
                ->booleanNode('use_acl')->defaultFalse()->end()
                ->scalarNode('controller_administration')->defaultValue('neutron_block_text.controller.administration.default')->end()
                ->scalarNode('controller_front')->defaultValue('neutron_block_text.controller.front.default')->end()
                ->scalarNode('manager')->defaultValue('neutron_block_text.manager.default')->end()
                ->scalarNode('block_text_class')->defaultValue('Neutron\Widget\BlockTextBundle\Entity\BlockText')->end()
                ->arrayNode('templates')
                ->defaultValue(array(
                    'NeutronBlockTextBundle:Frontend\Template:standard.html.twig' => 'template.standard'
                ))
                ->validate()
                    ->ifTrue(function($v){
                        return empty($v);
                    })
                    ->thenInvalid('You should provide at least one template.')
                ->end()
                ->useAttributeAsKey('name')
                    ->prototype('scalar')
                ->end()
            ->end()
        ;
    }
    
    private function addFormSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('form')
                    ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('type')->defaultValue('neutron_block_text')->end()
                            ->scalarNode('handler')->defaultValue('neutron_block_text.form.handler.block_text.default')->end()
                            ->scalarNode('name')->defaultValue('neutron_block_text')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
