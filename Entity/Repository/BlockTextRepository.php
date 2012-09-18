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
    
    public function getInstancesQuery($locale, $useTranslatable)
    {
        $query = $this->getInstancesQueryBulder()->getQuery();
        
        if ($useTranslatable){
            $query->setHint(
                Query::HINT_CUSTOM_OUTPUT_WALKER,
                'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
            );
            $query->setHint(
                \Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE,
                $locale
            );
        }
             
        return $query;
    }
    
    public function getInstances($locale, $useTranslatable)
    {
        return $this->getInstancesQuery($locale, $useTranslatable)->getArrayResult();
    }
    
}