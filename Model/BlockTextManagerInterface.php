<?php
namespace Neutron\Widget\BlockTextBundle\Model;

use Neutron\LayoutBundle\Model\Widget\WidgetManagerInterface;

interface BlockTextManagerInterface extends WidgetManagerInterface
{
    public function getQueryBuilderForBlockTextDataGrid();
}