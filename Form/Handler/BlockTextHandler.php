<?php
namespace Neutron\Widget\BlockTextBundle\Form\Handler;

use Neutron\Widget\BlockTextBundle\Model\BlockTextManagerInterface;

use Symfony\Component\Translation\TranslatorInterface;

use Doctrine\ORM\EntityManager;

use Symfony\Component\Security\Acl\Domain\ObjectIdentity;

use Neutron\AdminBundle\Acl\AclManagerInterface;

use Neutron\ComponentBundle\Form\Handler\FormHandlerInterface;

use Neutron\ComponentBundle\Form\Helper\FormHelper;

use Symfony\Bundle\FrameworkBundle\Routing\Router;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Form\Form;

use Symfony\Component\HttpFoundation\Request;

class BlockTextHandler implements FormHandlerInterface
{
    
    protected $em;
    
    protected $request;
    
    protected $router;
    
    protected $translator;
    
    protected $form;
    
    protected $formHelper;
    
    protected $blockTextManager;
    
    protected $aclManager;
    
    protected $useAcl;
    
    protected $result;


    public function __construct(EntityManager $em, Form $form, FormHelper $formHelper, Request $request, Router $router, 
            TranslatorInterface $translator, BlockTextManagerInterface $blockTextManager, AclManagerInterface $aclManager, $useAcl)
    {
        $this->em = $em;
        $this->form = $form;
        $this->formHelper = $formHelper;
        $this->request = $request;
        $this->router = $router;
        $this->translator = $translator;
        $this->blockTextManager = $blockTextManager;
        $this->aclManager = $aclManager;
        $this->useAcl = $useAcl;

    }

    public function process()
    {
        if ($this->request->isXmlHttpRequest()) {
            
            $this->form->bind($this->request);
 
            if ($this->form->isValid()) {
                
                $this->onSucess();
                
                $this->request->getSession()
                    ->getFlashBag()->add('neutron.form.success', array(
                        'type' => 'success',
                        'body' => $this->translator->trans('form.success', array(), 'NeutronBlockTextBundle')
                    ));
                
                $this->result = array(
                    'success' => true,
                    'redirect_uri' => 
                        $this->router->generate('neutron_block_text.administration')
                );
                
                return true;
  
            } else {
                $this->result = array(
                    'success' => false,
                    'errors' => $this->formHelper->getErrorMessages($this->form, 'NeutronBlockTextkBundle')
                );
                
                return false;
            }
  
        }
    }
    
    protected function onSucess()
    {
        $blockTextManager = $this->blockTextManager;
        $block = $this->form->get('general')->getData();

        if ($this->useAcl){
            $aclManager = $this->aclManager;
            $acl = $this->form->get('acl')->getData();
            $this->em->transactional(function(EntityManager $em)
                    use ($blockTextManager, $aclManager, $block, $acl){
            
                $blockTextManager->update($block);
                $aclManager
                ->setObjectPermissions(ObjectIdentity::fromDomainObject($block), $acl);
            });
        } else {
            $blockTextManager->update($block);
        }      
    }
    
    public function getResult()
    {
        return $this->result;
    }

   
}
