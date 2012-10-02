<?php
namespace Neutron\Widget\BlockTextBundle\Form\Handler;

use Symfony\Component\Security\Acl\Domain\ObjectIdentity;

use Neutron\AdminBundle\Acl\AclManagerInterface;

use Neutron\Widget\BlockTextBundle\Doctrine\Manager;

use Neutron\ComponentBundle\Form\Handler\AbstractFormHandler;


class BlockTextHandler extends AbstractFormHandler
{

    protected $blockTextManager;
    
    protected $aclManager;

    public function __construct(Manager $blockTextManager, AclManagerInterface $aclManager)
    {
        $this->blockTextManager = $blockTextManager;
        $this->aclManager = $aclManager;
    }

    protected function onSuccess()
    {
        
        $block = $this->form->get('general')->getData();

        $this->blockTextManager->update($block, true);
        
        if ($this->aclManager->isAclEnabled()){
            $acl = $this->form->get('acl')->getData();
            $this->aclManager
                ->setObjectPermissions(ObjectIdentity::fromDomainObject($block), $acl);
        }     
    }
    
    public function getRedirectUrl()
    {
        return $this->router->generate('neutron_block_text.administration');
    }
}
