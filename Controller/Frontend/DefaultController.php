<?php
namespace Neutron\Widget\BlockTextBundle\Controller\Frontend;

use Neutron\Bundle\AsseticBundle\Controller\AsseticController;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\DependencyInjection\ContainerAware;

class DefaultController extends ContainerAware
{
    
    public function indexAction($widgetInstanceId)
    {         
        $manager = $this->container->get('neutron_block_text.manager');
        $aclManager = $this->container->get('neutron_admin.acl.manager');
        
        $block = $manager->getBlockText($widgetInstanceId);

        
        if (!$block || !$aclManager->isGranted($block, 'VIEW')){
            return new Response();
        }
        
        $template = $this->container->get('templating')
            ->render($block->getTemplate(), array(
                'block'   => $block,
            )
        );
    
        return  new Response($template);
    }
    
}
