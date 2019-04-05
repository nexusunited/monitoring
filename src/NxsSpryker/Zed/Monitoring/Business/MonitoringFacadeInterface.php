<?php

namespace NxsSpryker\Zed\Monitoring\Business;

use Generated\Shared\Transfer\MonitoringAlertTransfer;

interface MonitoringFacadeInterface
{
    /**
     * @api
     *
     * @return void
     */
    public function checkMonitoringCriteria(): void;

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\MonitoringAlertTransfer $monitoringAlert
     *
     * @return void
     */
    public function triggerMonitoringAlert(MonitoringAlertTransfer $monitoringAlert): void;
}
