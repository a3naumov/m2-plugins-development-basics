<?php

declare(strict_types=1);

namespace Learning\BuildCart\Controller\Index;

use Magento\Framework\View\Result\Page;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected PageFactory $_pageFactory;

    public function __construct(
        Context $context,
        PageFactory $pageFactory
    ) {
        $this->_pageFactory = $pageFactory;
        return parent::__construct($context);
    }

    public function execute(): Page
    {
        $resultPage = $this->_pageFactory->create();
        $resultPage->getConfig()->getTitle()->set('Build Cart');

        return $resultPage;
    }
}
