<?php
namespace Neutron\Widget\BlockTextBundle\Model;

use Neutron\MvcBundle\Model\Widget\WidgetManagerInterface;

interface BlockTextManagerInterface extends WidgetManagerInterface
{
    public function getQueryBuilderForBlockTextDataGrid();
}