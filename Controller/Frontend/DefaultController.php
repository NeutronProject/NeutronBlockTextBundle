<?php
namespace Neutron\Widget\BlockTextBundle\Controller\Frontend;

use Neutron\UserBundle\Model\BackendRoles;

use Neutron\Bundle\AsseticBundle\Controller\AsseticController;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\DependencyInjection\ContainerAware;

class DefaultController extends ContainerAware
{
    
    public function indexAction($identifier)
    {         
        $manager = $this->container->get('neutron_block_text.manager');
        $aclManager = $this->container->get('neutron_admin.acl.manager');
        
        $block = $manager->getBlockText($identifier, $this->container->get('request')->getLocale());
        $useAcl = $this->container->getParameter('neutron_block_text.use_acl');
        $isHtml = $this->container->getParameter('neutron_block_text.is_html');
        
        if (!$block || !$aclManager->isGranted($block, 'VIEW')){
            return new Response();
        }
        
        $template = $this->container->get('templating')
            ->render($block->getTemplate(), array(
                'block'   => $block,
                'isHtml' => $isHtml,
            )
        );
    
        return  new Response($template);
    }
    
}
