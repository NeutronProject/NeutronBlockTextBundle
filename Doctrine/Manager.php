<?php
namespace Neutron\Widget\BlockTextBundle\Doctrine;

use Neutron\ComponentBundle\Doctrine\AbstractManager;

use Neutron\Widget\BlockTextBundle\Model\BlockTextManagerInterface;

use Neutron\Widget\BlockTextBundle\Model\BlockTextInterface;

use Neutron\LayoutBundle\Model\Widget\WidgetManagerInterface;

class Manager extends AbstractManager implements BlockTextManagerInterface
{
    protected $useTranslatable;
  
    public function __construct($useTranslatable)
    {
        $this->useTranslatable = $useTranslatable;
    }
    
    public function get($id)
    {
        return $this->findOneBy(array('id' => $id));
    }
    
    public function getInstances($locale)
    {
        return $this->repository->getInstances($locale, $this->useTranslatable);
    }
    
    public function getQueryBuilderForBlockTextDataGrid()
    {
        return $this->repository->getQueryBuilderForBlockTextDataGrid();
    }
    
    public function getBlockText($id)
    {
        return $this->findOneBy(array('id' => $id, 'enabled' => true));
    }
}