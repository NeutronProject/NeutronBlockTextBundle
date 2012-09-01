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
        
        $block = $manager->getBlockText($identifier, $this->container->get('request')->getLocale());
        $useAcl = $this->container->getParameter('neutron_block_text.use_acl');
        $isHtml = $this->container->getParameter('neutron_block_text.is_html');
        
        if (!$block || ($useAcl && !$this->isAllowed($block))){
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
    
    // to be removed
    protected function isAllowed(PageBlockInterface $block)
    {
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        if ($user != 'anon.' && count(array_intersect($user->getRoles(), BackendRoles::getAdministrativeRoles())) > 0) {
            return true;
        }
    
        return $securityContext->isGranted('VIEW', $block);
    }
}
