<?php

declare(strict_types=1);

namespace NHL\TopBar\Setup\Patch\Data;

use Magento\Cms\Api\BlockRepositoryInterface;;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Widget\Model\Widget\InstanceFactory;
use Magento\Framework\App\State;
use Magento\Store\Model\Store;

class CreateWidgetToAddBlock implements DataPatchInterface, PatchRevertableInterface
{
    /**
     * @var \Magento\Cms\Api\BlockRepositoryInterface;
     */
    private $blockRepository;

    /**
     * @var \Magento\Widget\Model\Widget\InstanceFactory
     */
    private $widgetFactory;

    /**
     * @var \Magento\Framework\App\State
     */
    private $state;

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;


    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param BlockRepositoryInterface $blockRepository
     * @param InstanceFactory $widgetFactory
     * @param State $state
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        BlockRepositoryInterface $blockRepository,
        InstanceFactory $widgetFactory,
        State $state
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->blockRepository = $blockRepository;
        $this->widgetFactory = $widgetFactory;
        $this->state = $state;
    }

    /**
     * @inheritDoc
     */
    public function apply()
    {
        // Set Area code to prevent the Exception during setup:upgrade 
        $this->state->setAreaCode(\Magento\Framework\App\Area::AREA_ADMINHTML);

        $this->moduleDataSetup->startSetup();

        $blockIdentifier = \NHL\TopBar\Setup\Patch\Data\CreateTopBlock::CMS_BLOCK_IDENTIFIER;

        $cmsBlock = $this->blockRepository->getById($blockIdentifier);

        $widgetData = [
            'instance_type' => 'Magento\Cms\Block\Widget\Block',
            'instance_code' => 'cms_static_block',
            'theme_id' => 3,
            'title' => 'To add top bar',
            'store_ids' => [Store::DEFAULT_STORE_ID],
            'widget_parameters' => '{"block_id":"'.$cmsBlock->getId().'"}',
            'sort_order' => 0,
            'page_groups' => [[
                'page_id' => 1,
                'page_group' => 'all_pages',
                'layout_handle' => 'default',
                'for' => 'all',
                'all_pages' => [
                    'page_id' => null,
                    'layout_handle' => 'default',
                    'block' => 'after.body.start',
                    'for' => 'all',
                    'template' => 'widget/static_block/default.phtml'
                ]
            ]]
        ];    

        $this->widgetFactory->create()->setData($widgetData)->save();    

        $this->moduleDataSetup->endSetup();
    }

    /**
     * {@inheritdoc}
     */
    public function revert()
    {

    }

    /**
     * @inheritDoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getAliases()
    {
        return [];
    }
}