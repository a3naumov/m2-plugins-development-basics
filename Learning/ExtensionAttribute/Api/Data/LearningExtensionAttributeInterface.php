<?php

declare(strict_types=1);

namespace Learning\ExtensionAttribute\Api\Data;

use Learning\ExtensionAttribute\Model\LearningExtensionAttribute;

interface LearningExtensionAttributeInterface
{
    const TEXT = 'text';

    public function getText(): string;

    public function setText(string $text): LearningExtensionAttribute;
}
