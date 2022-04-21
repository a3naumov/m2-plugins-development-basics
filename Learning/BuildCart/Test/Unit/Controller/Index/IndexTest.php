<?php

declare(strict_types=1);

namespace Learning\BuildCart\Test\Unit\Controller\Index;

use Learning\BuildCart\Controller\Index\Index;
use Magento\Framework\View\Page\Config;
use Magento\Framework\View\Page\Title;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class IndexTest extends TestCase
{
    /**
     * @var Index
     */
    private Index $object;

    /**
     * @var PageFactory|MockObject
     */
    private PageFactory $pageFactory;

    /**
     * @var Page|MockObject
     */
    private Page $page;

    /**
     * @var Config|MockObject
     */
    private Config $config;

    /**
     * @var Title|MockObject
     */
    private Title $title;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->pageFactory = $this->getMockBuilder(PageFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->page = $this->getMockBuilder(Page::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->config = $this->getMockBuilder(Config::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->title = $this->getMockBuilder(Title::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->object = new Index(
            $this->pageFactory
        );
    }

    /**
     * @return void
     */
    public function testExecute(): void
    {
        $this->pageFactory->expects($this->once())
            ->method('create')
            ->willReturn($this->page);

        $this->page->expects($this->once())
            ->method('getConfig')
            ->willReturn($this->config);

        $this->config->expects($this->once())
            ->method('getTitle')
            ->willReturn($this->title);

        $this->object->execute();
    }
}
