<?php
/*
 * This file is part of NeutronBlockTextBundle
 *
 * (c) Zender <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Neutron\Widget\BlockTextBundle\Entity\Repository;

use Doctrine\ORM\Query;

use Gedmo\Translatable\Entity\Repository\TranslationRepository;

class BlockTextRepository extends TranslationRepository
{
    public function getQueryBuilderForBlockTextDataGrid()
    {
        $qb = $this->createQueryBuilder('b');
        $qb
            ->select('b.id, b.title, b.identifier, b.enabled')
        ;
        
        return $qb; 
    }
    
    public function getInstancesQueryBulder()
    {
        $qb = $this->createQueryBuilder('b');
        $qb
            ->select('b.identifier, b.title as label')
            ->where('b.enabled = ?1')
            ->orderBy('b.title', 'ASC')
            ->setParameters(array(
                1 => true        
           ))
        ;
        
        return $qb;
    }
    
    public function getInstancesQuery($locale)
    {
        $query = $this->getInstancesQueryBulder()->getQuery();
        
        $query->setHint(
            Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );
        $query->setHint(
            \Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE,
            $locale
        );      
        
        return $query;
    }
    
    public function getInstances($locale)
    {
        return $this->getInstancesQuery($locale)->getArrayResult();
    }
    
    public function getBlockTextQueryBuilder($identifier)
    {
        $qb = $this->createQueryBuilder('b');
        $qb
            ->select('b')
            ->where('b.identifier = ?1 AND b.enabled = ?2')
            ->setParameters(array(
                1 => $identifier,
                2 => true,
            ))
        ;
    
        return $qb;
    }
    
    public function getBlockTextQuery($identifier, $locale)
    {
        $query = $this->getBlockTextQueryBuilder($identifier)->getQuery();
        $query->setHint(
            Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );
        $query->setHint(
            \Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE,
            $locale
        );
    
        return $query;
    }
    
    public function getBlockText($identifier, $locale)
    {
        return $this->getBlockTextQuery($identifier, $locale)->getOneOrNullResult();
    }
}