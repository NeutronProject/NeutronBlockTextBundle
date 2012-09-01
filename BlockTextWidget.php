<?php
namespace Neutron\Widget\BlockTextBundle;

use Neutron\LayoutBundle\Event\ConfigureWidgetEvent;

use Neutron\LayoutBundle\LayoutEvents;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Neutron\LayoutBundle\Widget\WidgetFactoryInterface;

use Neutron\LayoutBundle\Model\Widget\WidgetManagerInterface;

class BlockTextWidget
{
    protected $dispatcher;
    
    protected $factory; 
    
    protected $manager;

    public function __construct(EventDispatcherInterface $dispatcher, WidgetFactoryInterface $factory, 
        WidgetManagerInterface $manager)
    {
        $this->dispatcher = $dispatcher;
        $this->factory = $factory;
        $this->manager = $manager;
    }
    
    public function build()
    {
        $widget = $this->factory->createWidget('neutron.widget.block_text');
        $widget
            ->setLabel('widget.block_text.label')
            ->setDescription('widget.block_text.desc')
            ->setAdministrationRoute('neutron_block_text.administration')
            ->setFrontController('NeutronBlockTextBundle:Frontend\Default:index')
            ->setManager($this->manager)
            ->enablePluginAware(true)
            ->setAllowedPlugins(array('neutron.plugin.page'))
            ->enablePanelAware(true)
            ->setAllowedPanels(array('page_panel_footer_left'))
        ;
        
        $this->dispatcher->dispatch(
            LayoutEvents::onWidgetConfigure,
            new ConfigureWidgetEvent($this->factory, $widget)
        );
        
        return $widget;
    }
}