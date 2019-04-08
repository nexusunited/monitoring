<?php

namespace NxsSpryker\Zed\Monitoring\Communication\Plugin\Queue;

use Exception;
use Generated\Shared\Transfer\MonitoringAlertTransfer;
use Generated\Shared\Transfer\QueueReceiveMessageTransfer;
use Generated\Shared\Transfer\QueueSendMessageTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Queue\Dependency\Plugin\QueueMessageProcessorPluginInterface;

/**
 * @method \NxsSpryker\Zed\Monitoring\MonitoringConfig getConfig()
 * @method \NxsSpryker\Zed\Monitoring\Business\MonitoringFacade getFacade()
 */
class MonitoringAlertQueueMessageProcessorPlugin extends AbstractPlugin implements QueueMessageProcessorPluginInterface
{
    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\QueueReceiveMessageTransfer[] $queueMessageTransfers
     *
     * @return \Generated\Shared\Transfer\QueueReceiveMessageTransfer[]
     */
    public function processMessages(array $queueMessageTransfers)
    {
        foreach ($queueMessageTransfers as $queueMessage) {
            try {
                $monitoringAlert = $this->createMonitoringAlertTransfer($queueMessage);
                $this->getFacade()->triggerMonitoringAlert($monitoringAlert);
                $queueMessage->setAcknowledge(true);
            } catch (Exception $exception) {
                $queueMessage->setAcknowledge(false);
                $queueMessage->setHasError(true);
                $queueMessage->setQueueMessage((new QueueSendMessageTransfer())->setBody($exception->getMessage()));
            }
        }

        return $queueMessageTransfers;
    }

    /**
     * @api
     *
     * @return int
     */
    public function getChunkSize(): int
    {
        return $this->getConfig()->getMonitoringAlertChunkSize();
    }

    /**
     * @param \Generated\Shared\Transfer\QueueReceiveMessageTransfer $queueMessage
     *
     * @return \Generated\Shared\Transfer\MonitoringAlertTransfer
     */
    private function createMonitoringAlertTransfer(QueueReceiveMessageTransfer $queueMessage): MonitoringAlertTransfer
    {
        $monitoringAlert = new MonitoringAlertTransfer();
        $monitoringAlert->fromArray(\json_decode($queueMessage->getQueueMessage()->getBody(), true), true);
        $monitoringAlert->requireCriteriaName();

        return $monitoringAlert;
    }
}
