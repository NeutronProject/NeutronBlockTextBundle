<?php 
namespace Neutron\Widget\BlockTextBundle\EventListener;

use Neutron\LayoutBundle\Widget\WidgetInterface;

use Neutron\AdminBundle\Menu\Main;

use Knp\Menu\FactoryInterface;

use Neutron\AdminBundle\Event\ConfigureMenuEvent;

class MainMenuListener
{
   
    protected $widget;
    
    public function __construct(WidgetInterface $widget)
    {
        $this->widget = $widget;
    }
    
    public function onMenuConfigure(ConfigureMenuEvent $event)
    {
        
        if ($event->getIdentifier() !== Main::IDENTIFIER){
            return;
        }
        
        $menu = $event->getMenu();
        $factory = $event->getFactory();
        
        
        $widgets = $menu->getRoot()->getChild('widgets');
        
        $widgets->addChild($this->widget->getName(), array(
            'label' => $this->widget->getLabel(),
            'route' => $this->widget->getAdministrationRoute(),
            'extras' => array(
                'breadcrumbs' => true,
                'translation_domain' => 'NeutronBlockTextBundle'
            ),
        ));
        

    }

    
}