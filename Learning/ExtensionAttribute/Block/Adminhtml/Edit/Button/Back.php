<?php

declare(strict_types=1);

namespace Learning\ExtensionAttribute\Block\Adminhtml\Edit\Button;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class Back implements ButtonProviderInterface
{
    private UrlInterface $urlBuilder;

    public function __construct(
        UrlInterface $urlBuilder
    ) {
        $this->urlBuilder = $urlBuilder;
    }

    public function getButtonData(): array
    {
        return [
            'label' => __('Back'),
            'class' => 'back',
            'on_click' => sprintf("location.href = '%s';", $this->urlBuilder->getUrl('learning_extension_attributes/attributes')),
            'sort_order' => 70,
        ];

    }
}
