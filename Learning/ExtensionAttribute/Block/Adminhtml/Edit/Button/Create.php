<?php

declare(strict_types=1);

namespace Learning\ExtensionAttribute\Block\Adminhtml\Edit\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class Create implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData(): array
    {
        return [
            'label' => __('Create'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];

    }
}
