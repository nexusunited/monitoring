<?php

namespace NxsSpryker\Zed\Monitoring\Business\Model;

use Generated\Shared\Transfer\MonitoringAlertTransfer;

class AlertTrigger implements AlertTriggerInterface
{
    /**
     * @var \NxsSpryker\Zed\Monitoring\Communication\Plugin\MonitoringAlertPluginInterface[]
     */
    private $alertPlugins;

    /**
     * @param \NxsSpryker\Zed\Monitoring\Communication\Plugin\MonitoringAlertPluginInterface[] $alertPlugins
     */
    public function __construct(array $alertPlugins)
    {
        $this->alertPlugins = $alertPlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\MonitoringAlertTransfer $monitoringAlert
     *
     * @return void
     */
    public function triggerCriteriaAlert(MonitoringAlertTransfer $monitoringAlert): void
    {
        $criteriaName = $monitoringAlert->getCriteriaName();
        foreach ($this->alertPlugins as $alertPlugin) {
            if ($alertPlugin->isResponsibleForCriteria($criteriaName)) {
                $alertPlugin->triggerAlert();
            }
        }
    }
}
