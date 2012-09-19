<?php
namespace Neutron\Widget\BlockTextBundle\Model;

use Neutron\MvcBundle\Model\Widget\WidgetInstanceInterface;

interface BlockTextInterface extends WidgetInstanceInterface
{
    public function setTitle($title);
    
    public function getTitle();
    
    public function setContent($content);
    
    public function getContent();
    
    public function setTemplate($template);
    
    public function getTemplate();
}