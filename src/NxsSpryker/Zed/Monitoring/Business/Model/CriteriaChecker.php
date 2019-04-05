<?php

namespace NxsSpryker\Zed\Monitoring\Business\Model;

use Generated\Shared\Transfer\MonitoringAlertTransfer;
use Generated\Shared\Transfer\QueueSendMessageTransfer;
use NxsSpryker\Shared\Monitoring\MonitoringConstants;
use NxsSpryker\Zed\Monitoring\Dependency\Client\MonitoringToQueueClientBridgeInterface;

class CriteriaChecker implements CriteriaCheckerInterface
{
    /**
     * @var \NxsSpryker\Zed\Monitoring\Communication\Plugin\MonitoringCriteriaPluginInterface[]
     */
    private $monitoringCriteriaPlugins;

    /**
     * @var \NxsSpryker\Zed\Monitoring\Dependency\Client\MonitoringToQueueClientBridgeInterface
     */
    private $queueClient;

    /**
     * @param \NxsSpryker\Zed\Monitoring\Communication\Plugin\MonitoringCriteriaPluginInterface[] $monitoringCriteriaPlugins
     * @param \NxsSpryker\Zed\Monitoring\Dependency\Client\MonitoringToQueueClientBridgeInterface $queueClient
     */
    public function __construct(
        array $monitoringCriteriaPlugins,
        MonitoringToQueueClientBridgeInterface $queueClient
    ) {
        $this->monitoringCriteriaPlugins = $monitoringCriteriaPlugins;
        $this->queueClient = $queueClient;
    }

    /**
     * @return void
     */
    public function checkCriteria(): void
    {
        foreach ($this->monitoringCriteriaPlugins as $monitoringCriteriaPlugin) {
            if ($monitoringCriteriaPlugin->isCriteriaMet() === false) {
                $this->triggerAlertMessage($monitoringCriteriaPlugin->getCriteriaName());
            }
        }
    }

    /**
     * @param string $criteriaName
     *
     * @return void
     */
    protected function triggerAlertMessage(string $criteriaName): void
    {
        $monitoringAlert = new MonitoringAlertTransfer();
        $monitoringAlert->setCriteriaName($criteriaName);

        $messageTransfer = new QueueSendMessageTransfer();
        $messageTransfer->setBody($monitoringAlert->serialize());

        $this->queueClient->sendMessage(MonitoringConstants::MONITORING_ALERT_QUEUE, $messageTransfer);
    }
}
