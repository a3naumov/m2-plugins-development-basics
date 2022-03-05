<?php declare(strict_types=1);

namespace Learning\HeaderMessage\Block;

use Magento\Framework\View\Element\Template;
use Magento\Store\Model\ScopeInterface;

class Message extends Template
{
    public function isEnable(): bool
    {
        $status = $this->_scopeConfig->getValue('headermessage/message/show_message', ScopeInterface::SCOPE_STORE);
        return (boolean) $status;
    }

    public function getMessage()
    {
        return $this->_scopeConfig->getValue('headermessage/message/text', ScopeInterface::SCOPE_STORE);
    }
}
