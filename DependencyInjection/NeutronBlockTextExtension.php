<?php

namespace Neutron\Widget\BlockTextBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class NeutronBlockTextExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        
        $container->setAlias('neutron_block_text.controller.administration', $config['controller_administration']);
        $container->setAlias('neutron_block_text.controller.front', $config['controller_front']);
        $container->setAlias('neutron_block_text.manager', $config['manager']);
        $container->setParameter('neutron_block_text.grid', $config['grid']);
        $container->setParameter('neutron_block_text.block_text_class', $config['block_text_class']);
        $container->setParameter('neutron_block_text.templates', $config['templates']);
        $container->setParameter('neutron_block_text.is_html', $config['is_html']);
        $container->setParameter('neutron_block_text.use_acl', $config['use_acl']);
        
        $container->setParameter('neutron_block_text.widget_options', $config['widget_options']);
        
        $container->setAlias('neutron_block_text.form.handler.block_text', $config['form']['handler']);
        $container->setParameter('neutron_block_text.form.type.block_text', $config['form']['type']);
        $container->setParameter('neutron_block_text.form.name.block_text', $config['form']['name']);
    }
}
