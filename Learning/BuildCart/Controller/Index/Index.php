<?php

declare(strict_types=1);

namespace Learning\BuildCart\Controller\Index;

use Magento\Framework\View\Result\Page;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\View\Result\PageFactory;

class Index implements ActionInterface
{
    /**
     * @var PageFactory
     */
    protected PageFactory $_pageFactory;

    /**
     * @param PageFactory $pageFactory
     */
    public function __construct(
        PageFactory $pageFactory
    ) {
        $this->_pageFactory = $pageFactory;
    }

    /**
     * @return Page
     */
    public function execute(): Page
    {
        $resultPage = $this->_pageFactory->create();
        $resultPage->getConfig()->getTitle()->set('Build Cart');

        return $resultPage;
    }
}
