<?php
/*
 * This file is part of NeutronBlockTextBundle
*
* (c) Zender <azazen09@gmail.com>
*
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/
namespace Neutron\Widget\BlockTextBundle\Entity;

use Neutron\Widget\BlockTextBundle\BlockTextWidget;

use Neutron\Widget\BlockTextBundle\Model\BlockTextInterface;

use Gedmo\Mapping\Annotation as Gedmo;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
abstract class BlockText implements BlockTextInterface
{
    /**
     * @var integer 
     *
     * @ORM\Id @ORM\Column(name="id", type="integer")
     * 
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string 
     * 
     * @Gedmo\Translatable
     * @ORM\Column(type="string", name="title", length=255, nullable=true, unique=false)
     */
    protected $title;
    
    /**
     * @var string 
     *
     * @Gedmo\Translatable
     * @ORM\Column(type="text", name="content", nullable=true)
     */
    protected $content;
    
    /**
     * @var string 
     *
     * @ORM\Column(type="string", name="template", length=255, nullable=false, unique=false)
     */
    protected $template;
    
    /**
     * @var boolean 
     *
     * @ORM\Column(type="boolean", name="enabled")
     */
    protected $enabled = false;
    
	/**
     * @return the $id
     */
    public function getId ()
    {
        return $this->id;
    }

	/**
     * @return the $title
     */
    public function getTitle ()
    {
        return $this->title;
    }

	/**
     * @param string $title
     */
    public function setTitle ($title)
    {
        $this->title = $title;
    }

	/**
     * @return the $content
     */
    public function getContent ()
    {
        return $this->content;
    }

	/**
     * @param string $content
     */
    public function setContent ($content)
    {
        $this->content = $content;
    }

	/**
     * @return the $template
     */
    public function getTemplate ()
    {
        return $this->template;
    }

	/**
     * @param string $template
     */
    public function setTemplate ($template)
    {
        $this->template = $template;
    }
    
    public function isEnabled()
    {
        return $this->enabled;
    }
    
    public function setEnabled($bool)
    {
        $this->enabled = (bool) $bool;
    }
    
    public function getLabel()
    {
        return $this->title;
    }
    
    public function getIdentifier()
    {
        return BlockTextWidget::IDENTIFIER;
    }

}