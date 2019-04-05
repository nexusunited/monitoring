<?php

namespace NxsSpryker\Zed\Monitoring\Business;

use Generated\Shared\Transfer\MonitoringAlertTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \NxsSpryker\Zed\Monitoring\Business\MonitoringBusinessFactory getFactory()
 */
class MonitoringFacade extends AbstractFacade implements MonitoringFacadeInterface
{
    /**
     * @api
     *
     * @return void
     */
    public function checkMonitoringCriteria(): void
    {
        $this->getFactory()->createCriteriaChecker()->checkCriteria();
    }

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\MonitoringAlertTransfer $monitoringAlert
     *
     * @return void
     */
    public function triggerMonitoringAlert(MonitoringAlertTransfer $monitoringAlert): void
    {
        $this->getFactory()->createAlertTrigger()->triggerCriteriaAlert($monitoringAlert);
    }
}
