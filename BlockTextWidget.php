<?php
namespace Neutron\Widget\BlockTextBundle;

use Symfony\Component\Translation\TranslatorInterface;

use Neutron\LayoutBundle\Event\ConfigureWidgetEvent;

use Neutron\LayoutBundle\LayoutEvents;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Neutron\LayoutBundle\Widget\WidgetFactoryInterface;

use Neutron\LayoutBundle\Model\Widget\WidgetManagerInterface;


class BlockTextWidget
{
    const IDENTIFIER = 'neutron.widget.block_text';
    
    protected $dispatcher;
    
    protected $factory; 
    
    protected $manager;
    
    protected $translator;
    
    protected $options;

    public function __construct(EventDispatcherInterface $dispatcher, WidgetFactoryInterface $factory, 
        WidgetManagerInterface $manager, TranslatorInterface $translator, array $options)
    {
        $this->dispatcher = $dispatcher;
        $this->factory = $factory;
        $this->manager = $manager;
        $this->translator = $translator;
        $this->options = $options;
    }
    
    public function build()
    {
        $widget = $this->factory->createWidget(self::IDENTIFIER);
        $widget
            ->setLabel($this->translator->trans('widget.block_text.label', array(), 'NeutronBlockTextBundle'))
            ->setDescription($this->translator->trans('widget.block_text.desc', array(), 'NeutronBlockTextBundle'))
            ->setAdministrationRoute('neutron_block_text.administration')
            ->setFrontController('NeutronBlockTextBundle:Frontend\Default:index')
            ->setManager($this->manager)
            ->enablePluginAware($this->options['plugin_aware'])
            ->setAllowedPlugins($this->options['allowed_plugins'])
            ->enablePanelAware($this->options['panel_aware'])
            ->setAllowedPanels($this->options['allowed_panels'])
        ;
        
        $this->dispatcher->dispatch(
            LayoutEvents::onWidgetConfigure,
            new ConfigureWidgetEvent($this->factory, $widget)
        );
        
        return $widget;
    }
}