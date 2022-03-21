<?php

declare(strict_types=1);

namespace Learning\ExtensionAttribute\Api;

interface ExtensionAttributeManagementInterface
{
    /**
     * @return string
     */
    public function createAttributes(): string;

    /**
     * @return string
     */
    public function deleteAttributes(): string;
}
