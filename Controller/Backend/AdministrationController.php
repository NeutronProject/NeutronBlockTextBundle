<?php
/*
 * This file is part of NeutronBlockTextBundle
 *
 * (c) Zender <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Neutron\Widget\BlockTextBundle\Controller\Backend;

use Doctrine\ORM\EntityManager;

use Symfony\Component\HttpFoundation\RedirectResponse;

use Neutron\Widget\BlockTextBundle\Model\BlockTextInterface;

use Neutron\Widget\BlockTextBundle\Model\BlockTextManagerInterface;

use Symfony\Component\Security\Acl\Domain\ObjectIdentity;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Short description
 *
 * @author Zender <azazen09@gmail.com>
 * @since 1.0
 */
class AdministrationController extends ContainerAware
{
    /**
     * Short description
     * 
     * @return Response
     */
    public function indexAction()
    {    
        $grid = $this->container->get('neutron.datagrid')->get(
            $this->container->getParameter('neutron_block_text.grid')
        );
        
        $template = $this->container->get('templating')
            ->render('NeutronBlockTextBundle:Backend\Administration:index.html.twig', array(
                'grid' => $grid
            )
        );
    
        return  new Response($template);
    }
    
    public function updateAction($id)
    {
    
        $manager = $this->container->get('neutron_block_text.manager');
        $form = $this->container->get('neutron_block_text.form.block_text');
        $handler = $this->container->get('neutron_block_text.form.handler.block_text');
    
        if (!$id){
            $block = $manager->create(); 
        } else {
            $block = $manager->findOneBy(array('id' => $id));
        }
    
        if (!$block instanceof BlockTextInterface){
            throw new NotFoundHttpException();
        }
        
        $data = array(
            'general' => $block
        );
        
        if ($this->container->getParameter('neutron_block_text.use_acl')){
            $acl = $block->getId() ? $this->container->get('neutron_admin.acl.manager')
                ->getPermissions(ObjectIdentity::fromDomainObject($block)) : null;
            $data['acl'] = $acl;
        }
    
        $form->setData($data);
    
        if (null !== $handler->process()){
            return new Response(json_encode($handler->getResult()));
        }
    
        $template = $this->container->get('templating')
            ->render('NeutronBlockTextBundle:Backend\Administration:update.html.twig', array(
                'form' => $form->createView()
            )
        );
    
        return  new Response($template);
    }
    
    public function deleteAction($id)
    {
        $manager = $this->container->get('neutron_block_text.manager');
        $block = $manager->findOneBy(array('id' => $id));
    
        if (!$block instanceof BlockTextInterface){
            throw new NotFoundHttpException();
        }
    
        if ($this->container->get('request')->getMethod() == 'POST'){
            $this->doDelete($manager, $block);
    
            $this->container->get('session')
                ->getFlashBag()->add('neutron.form.success', array(
                    'type' => 'success',
                    'body' => $this->container->get('translator')
                        ->trans('flash.deleted', array(), 'NeutronBlockTextBundle')
                )
            );
    
            $redirectUrl = $this->container->get('router')->generate('neutron_block_text.administration');
            return new RedirectResponse($redirectUrl);
        }
    
        $template = $this->container->get('templating')
            ->render('NeutronBlockTextBundle:Backend\Administration:delete.html.twig', array(
                'record' => $block
            )
        );
    
        return  new Response($template);
    }
    
    protected function doDelete(BlockTextManagerInterface $blockTextManager, BlockTextInterface $block)
    {
        $aclManager = $this->container->get('neutron_admin.acl.manager');
        $em = $this->container->get('doctrine.orm.entity_manager');
    
        $em->transactional(function(EntityManager $em) use ($blockTextManager, $aclManager, $block){
            $aclManager->deleteObjectPermissions(ObjectIdentity::fromDomainObject($block));
            $blockTextManager->delete($block);
        });
    }
}