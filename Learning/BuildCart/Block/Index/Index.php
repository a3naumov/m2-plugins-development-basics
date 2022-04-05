<?php

declare(strict_types=1);

namespace Learning\BuildCart\Block\Index;

use Magento\Framework\View\Element\Template;

class Index extends Template
{
    /**
     * @return string
     */
    public function getUrlForForm(): string
    {
        return $this->getUrl('learning_buildcart/index/upload');
    }
}
