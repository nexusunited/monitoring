<?php

namespace NxsSpryker\Zed\Monitoring\Dependency\Client;

use Generated\Shared\Transfer\QueueSendMessageTransfer;

interface MonitoringToQueueClientBridgeInterface
{
    /**
     * @api
     *
     * @param string $queueName
     * @param \Generated\Shared\Transfer\QueueSendMessageTransfer $queueSendMessageTransfer
     *
     * @return void
     */
    public function sendMessage(string $queueName, QueueSendMessageTransfer $queueSendMessageTransfer): void;
}
