<?php
namespace Neutron\Widget\BlockTextBundle\Form\EventSubscriber;

use Symfony\Component\Form\FormEvent;

use Symfony\Component\Form\FormEvents;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class GeneralTypeSubscriber implements EventSubscriberInterface
{
    
    public function preSetData(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();
        
        if (empty($data)) {
            return;
        }
        
        if ($data->getId()){
            $form->remove('identifier');
        }
    }
    
    /**
     * Subscription for Form Events
     */
    static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
        );
    }
}