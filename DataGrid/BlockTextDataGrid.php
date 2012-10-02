<?php
namespace Neutron\Widget\BlockTextBundle\DataGrid;

use Neutron\Widget\BlockTextBundle\Model\BlockTextManagerInterface;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Doctrine\ORM\Query;

use Symfony\Bundle\FrameworkBundle\Routing\Router;

use Symfony\Bundle\FrameworkBundle\Translation\Translator;

use Doctrine\ORM\EntityManager;

use Neutron\Bundle\DataGridBundle\DataGrid\FactoryInterface;

class BlockTextDataGrid
{

    protected $factory;

    protected $manager;
    
    protected $translator;
    
    protected $router;
    
    protected $session;
    
    protected $defaultLocale;


    public function __construct (FactoryInterface $factory, BlockTextManagerInterface $manager, 
            Translator $translator, Router $router, SessionInterface $session, $defaultLocale)
    {
        $this->factory = $factory;
        $this->manager = $manager;
        $this->translator = $translator;
        $this->router = $router;
        $this->session = $session;
        $this->defaultLocale = $defaultLocale;
    }

    public function build ()
    {
        
        /**
         *
         * @var DataGrid $dataGrid
         */
        $dataGrid = $this->factory->createDataGrid('block_text_management');
        $dataGrid->setCaption(
            $this->translator->trans('grid.block_text_management.title',  array(), 'NeutronBlockTextBundle')
        )
            ->setAutoWidth(true)
            ->setColNames(array(
                $this->translator->trans('grid.block_text_management.column.title',  array(), 'NeutronBlockTextBundle'),
                $this->translator->trans('grid.block_text_management.column.enabled',  array(), 'NeutronBlockTextBundle'),
  

            ))
            ->setColModel(array(
                array(
                    'name' => 'b.title', 'index' => 'b.title', 'width' => 200, 
                    'align' => 'left', 'sortable' => true, 'search' => true,
                ), 
                array(
                    'name' => 'b.enabled', 'index' => 'b.enabled',  'width' => 40, 
                    'align' => 'left',  'sortable' => true, 
                    'formatter' => 'checkbox',  'search' => true, 'stype' => 'select',
                    'searchoptions' => array(
                        'value' => array(
                            1 => $this->translator->trans('grid.enabled', array(), 'NeutronBlockTextBundle'), 
                            0 => $this->translator->trans('grid.disabled', array(), 'NeutronBlockTextBundle')
                        )
                    )
                ),

            ))
            ->setQueryBuilder($this->manager->getQueryBuilderForBlockTextDataGrid())
            ->setSortName('b.title')
            ->setSortOrder('asc')
            ->enablePager(true)
            ->enableViewRecords(true)
            ->enableSearchButton(true)
            ->enableAddButton(true)
            ->setAddBtnUri($this->router->generate('neutron_block_text.update', array(), true))
            ->enableEditButton(true)
            ->setEditBtnUri($this->router->generate('neutron_block_text.update', array('id' => '{id}'), true))
            ->enableDeleteButton(true)
            ->setDeleteBtnUri($this->router->generate('neutron_block_text.delete', array('id' => '{id}'), true))
            ->setQueryHints(array(
                Query::HINT_CUSTOM_OUTPUT_WALKER 
                    => 'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker',
                \Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE 
                    => $this->session->get('frontend_language', $this->defaultLocale),
            ))

            ->setFetchJoinCollection(false)
        ;

        return $dataGrid;
    }


}