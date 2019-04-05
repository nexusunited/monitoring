<?php

namespace NxsSpryker\Zed\Monitoring\Business\Model;

use Generated\Shared\Transfer\MonitoringAlertTransfer;

interface AlertTriggerInterface
{
    /**
     * @param \Generated\Shared\Transfer\MonitoringAlertTransfer $monitoringAlert
     *
     * @return void
     */
    public function triggerCriteriaAlert(MonitoringAlertTransfer $monitoringAlert): void;
}
