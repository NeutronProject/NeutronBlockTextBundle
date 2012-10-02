<?php
/*
 * This file is part of NeutronBlockTextBundle
 *
 * (c) Zender <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Neutron\Widget\BlockTextBundle\Form\Type\BlockText;

use Symfony\Component\Form\FormView;

use Symfony\Component\Form\FormInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\AbstractType;

/**
 * Short description
 *
 * @author Zender <azazen09@gmail.com>
 * @since 1.0
 */
class GeneralType extends AbstractType
{
    protected $subscriber;
    
    protected $dataClass;
    
    protected $isHtml;
    
    protected $templates;
    
    public function __construct($dataClass, array $templates)
    {
        $this->dataClass = $dataClass;
        $this->templates = $templates;
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'label' => 'form.title',
                'translation_domain' => 'NeutronBlockTextBundle'
            ))
            ->add('content', 'textarea', array(
                'label' => 'form.content',
                'attr' => array(
                    'rows' => 10
                ), 
                'required' => true,
                'translation_domain' => 'NeutronBlockTextBundle'
           ))
           ->add('template', 'choice', array(
                'choices' => $this->templates,
                'multiple' => false,
                'expanded' => false,
                'attr' => array('class' => 'uniform'),
                'label' => 'form.templates',
                'empty_value' => 'form.empty_value',
                'translation_domain' => 'NeutronBlockTextBundle'
            ))
            ->add('enabled', 'checkbox', array(
                'label' => 'form.enabled', 
                'value' => 1,
                'required' => false,
                'attr' => array('class' => 'uniform'),
                'translation_domain' => 'NeutronBlockTextBundle'
            ))
        ;
        
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::setDefaultOptions()
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->dataClass,
            'validation_groups' => function(FormInterface $form){
                if ($form->getData()->getId()){
                    return 'update';
                }
                
                return 'create';
            },
        ));
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'neutron_block_text_general';
    }
}