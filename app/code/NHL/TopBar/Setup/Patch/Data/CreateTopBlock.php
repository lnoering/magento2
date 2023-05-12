<?php

declare(strict_types=1);

namespace NHL\TopBar\Setup\Patch\Data;

use Magento\Cms\Model\BlockFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Framework\App\State;
use Magento\Store\Model\Store;

class CreateTopBlock implements DataPatchInterface, PatchRevertableInterface
{
    const CMS_BLOCK_IDENTIFIER = 'custom-header-block';

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var BlockFactory
     */
    private $blockFactory;

    /**
     * @var \Magento\Framework\App\State
     */
    private $state;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param BlockFactory $blockFactory
     * @param State $state
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        BlockFactory $blockFactory,
        State $state
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->blockFactory = $blockFactory;
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

        $this->blockFactory->create()
            ->setTitle('Custom Header Block')
            ->setIdentifier(self::CMS_BLOCK_IDENTIFIER)
            ->setIsActive(true)
            ->setContent('<div class="main">
            <div class="'.self::CMS_BLOCK_IDENTIFIER.'" style="text-align: center; background: #d02e2e; padding: 10px; font-weight: bold; font-size: x-large;">Store to improve the Kwonledge about >>> <a class="discount" style="border: 1px solid black; cursor: pointer; background: #ff7900; padding: 8px; font-weight: bold;" href="https://github.com/lnoering/magento2#readme">Magento 2</a></div></div>')
            ->setStores([Store::DEFAULT_STORE_ID])
            ->save();

        $this->moduleDataSetup->endSetup();
    }

    /**
     * {@inheritdoc}
     */
    public function revert()
    {
        $sampleCmsBlock = $this->blockFactory
            ->create()
            ->load(self::CMS_BLOCK_IDENTIFIER, 'identifier');

        if ($sampleCmsBlock->getId()) {
            $sampleCmsBlock->delete();
        }
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