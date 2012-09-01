<?php
/*
 * This file is part of NeutronBlockTextBundle
 *
 * (c) Zender <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Neutron\Widget\BlockTextBundle\Entity\Translation;

use Gedmo\Translatable\Entity\MappedSuperclass\AbstractTranslation;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="neutron_widget_block_text_translations", indexes={
 *      @ORM\Index(name="neutron_widget_block_text_translation_idx", columns={"locale", "object_class", "field", "foreign_key"})
 * })
 * @ORM\Entity(repositoryClass="Gedmo\Translatable\Entity\Repository\TranslationRepository")
 */
class BlockTextTranslation extends AbstractTranslation
{}