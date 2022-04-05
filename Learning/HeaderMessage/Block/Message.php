<?php

declare(strict_types=1);

namespace Learning\HeaderMessage\Block;

use Magento\Framework\View\Element\Template;
use Magento\Store\Model\ScopeInterface;

class Message extends Template
{
    /**
     * Bool config value for show header message
     */
    private const SHOW_MESSAGE = 'headermessage/message/show_message';

    /**
     * Text config value for header message
     */
    private const MESSAGE_TEXT = 'headermessage/message/text';

    /**
     * @return bool
     */
    public function isEnable(): bool
    {
        return $this->_scopeConfig->isSetFlag(self::SHOW_MESSAGE, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->_scopeConfig->getValue(self::MESSAGE_TEXT, ScopeInterface::SCOPE_STORE);
    }
}
