<?php

declare(strict_types=1);

namespace Learning\HighlightedAttribute\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Catalog\Model\Product\Attribute\Source\Boolean;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

class HighlightItemBorder implements DataPatchInterface, PatchRevertableInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private ModuleDataSetupInterface $moduleDataSetup;

    /**
     * @var EavSetupFactory
     */
    private EavSetupFactory $eavSetupFactory;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Zend_Validate_Exception
     */
    public function apply(): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $eavSetup = $this->eavSetupFactory->create(['setup', $this->moduleDataSetup]);
        $eavSetup->addAttribute(Product::ENTITY, 'highlight_border', [
            'type' => 'int',
            'label' => 'Highlight border',
            'input' => 'boolean',
            'backend' => '',
            'frontend' => '',
            'source' => Boolean::class,
            'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible' => true,
            'required' => true,
            'user_defined' => false,
            'default' => false,
            'searchable' => false,
            'comparable' => false,
            'visible_on_front' => true,
            'used_in_product_listing' => true,
            'unique' => false
        ]);

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * @return void
     */
    public function revert(): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->removeAttribute(Product::ENTITY, 'highlight_border');

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * @return array|string[]
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * @return array|string[]
     */
    public function getAliases(): array
    {
        return [];
    }
}
