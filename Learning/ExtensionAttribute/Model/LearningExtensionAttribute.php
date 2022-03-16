<?php

declare(strict_types=1);

namespace Learning\ExtensionAttribute\Model;

use Magento\Catalog\Model\AbstractModel;
use Learning\ExtensionAttribute\Model\ResourceModel\LearningExtensionAttribute as ResourceModel;
use Learning\ExtensionAttribute\Api\Data\LearningExtensionAttributeInterface;


class LearningExtensionAttribute extends AbstractModel implements LearningExtensionAttributeInterface
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    public function getText(): string
    {
        return $this->_getData(self::TEXT);
    }

    public function setText(string $text): LearningExtensionAttribute
    {
        return $this->setData(self::TEXT, $text);
    }
}
