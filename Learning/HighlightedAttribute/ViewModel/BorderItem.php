<?php

declare(strict_types=1);

namespace Learning\HighlightedAttribute\ViewModel;

use Magento\Catalog\Model\Product;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class BorderItem implements ArgumentInterface
{
    private const ATTRIBUTE_NAME = 'highlight_border';

    public function setBorder(Product $product): string
    {
        return $product->getData(self::ATTRIBUTE_NAME) ? 'highlight_border' : '';
    }
}
