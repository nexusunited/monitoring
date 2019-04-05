<?php

namespace NxsSpryker\Zed\Monitoring\Dependency\Client;

use Generated\Shared\Transfer\QueueSendMessageTransfer;
use Spryker\Client\Queue\QueueClientInterface;

class MonitoringToQueueClientBridge implements MonitoringToQueueClientBridgeInterface
{
    /**
     * @var \Spryker\Client\Queue\QueueClientInterface
     */
    private $queueClient;

    /**
     * @param \Spryker\Client\Queue\QueueClientInterface $queueClient
     */
    public function __construct(QueueClientInterface $queueClient)
    {
        $this->queueClient = $queueClient;
    }

    /**
     * @api
     *
     * @param string $queueName
     * @param \Generated\Shared\Transfer\QueueSendMessageTransfer $queueSendMessageTransfer
     *
     * @return void
     */
    public function sendMessage(string $queueName, QueueSendMessageTransfer $queueSendMessageTransfer): void
    {
        $this->queueClient->sendMessage($queueName, $queueSendMessageTransfer);
    }
}
