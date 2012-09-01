<?php
namespace Neutron\Widget\BlockTextBundle\Doctrine\ORM;

use Neutron\Widget\BlockTextBundle\Model\BlockTextManagerInterface;

use Doctrine\ORM\EntityManager;

use Neutron\Widget\BlockTextBundle\Model\BlockTextInterface;

use Neutron\LayoutBundle\Model\Widget\WidgetManagerInterface;

class Manager implements BlockTextManagerInterface
{
    protected $em;
    
    protected $repository;
    
    protected $meta;
     
    protected $className;
    
    public function __construct(EntityManager $em, $class)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository($class);
        $this->meta = $this->em->getClassMetadata($class);
        $this->className = $this->meta->name;
    }
    
    public function create()
    {
        $class = $this->className;
        $entity = new $class;
        
        return $entity;
    }
    
    public function update(BlockTextInterface $entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }
    
    public function delete(BlockTextInterface $entity)
    {
        $this->em->remove($entity);
        $this->em->flush();
    }
    
    public function findOneBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }
    
    public function get($identifier)
    {
        return $this->findOneBy(array('identifier' => $identifier));
    }
    
    public function getInstances($locale)
    {
        return $this->repository->getInstances($locale);
    }
    
    public function getQueryBuilderForBlockTextDataGrid()
    {
        return $this->repository->getQueryBuilderForBlockTextDataGrid();
    }
    
    public function getBlockText($identifier, $locale)
    {
        return $this->repository->getBlockText($identifier, $locale);
    }
}