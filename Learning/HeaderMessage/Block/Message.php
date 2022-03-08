<?php

declare(strict_types=1);

namespace Learning\HeaderMessage\Block;

use Magento\Framework\View\Element\Template;
use Magento\Store\Model\ScopeInterface;

class Message extends Template
{
    private const SHOW_MESSAGE = 'headermessage/message/show_message';
    private const MESSAGE_TEXT = 'headermessage/message/text';

    public function isEnable(): bool
    {
        return $this->_scopeConfig->isSetFlag(self::SHOW_MESSAGE, ScopeInterface::SCOPE_STORE);
    }

    public function getMessage(): string
    {
        return $this->_scopeConfig->getValue(self::MESSAGE_TEXT, ScopeInterface::SCOPE_STORE);
    }
}
