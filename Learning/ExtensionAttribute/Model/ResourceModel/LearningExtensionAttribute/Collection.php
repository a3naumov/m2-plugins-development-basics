<?php

declare(strict_types=1);

namespace Learning\ExtensionAttribute\Model\ResourceModel\LearningExtensionAttribute;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Learning\ExtensionAttribute\Model\LearningExtensionAttribute as Model;
use Learning\ExtensionAttribute\Model\ResourceModel\LearningExtensionAttribute as ResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
