<?php
namespace Neutron\Widget\BlockTextBundle\Model;

use Neutron\LayoutBundle\Model\Widget\WidgetManagerInterface;

interface BlockTextManagerInterface extends WidgetManagerInterface
{
    public function create();
    
    public function update(BlockTextInterface $entity);
    
    public function delete(BlockTextInterface $entity);
    
    public function findOneBy(array $criteria);
    
    public function getQueryBuilderForBlockTextDataGrid();
}