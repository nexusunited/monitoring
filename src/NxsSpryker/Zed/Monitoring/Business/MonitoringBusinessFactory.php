<?php

namespace NxsSpryker\Zed\Monitoring\Business;

use NxsSpryker\Zed\Monitoring\Business\Model\AlertTrigger;
use NxsSpryker\Zed\Monitoring\Business\Model\AlertTriggerInterface;
use NxsSpryker\Zed\Monitoring\Business\Model\CriteriaChecker;
use NxsSpryker\Zed\Monitoring\Business\Model\CriteriaCheckerInterface;
use NxsSpryker\Zed\Monitoring\Dependency\Client\MonitoringToQueueClientBridgeInterface;
use NxsSpryker\Zed\Monitoring\MonitoringDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

class MonitoringBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \NxsSpryker\Zed\Monitoring\Business\Model\CriteriaCheckerInterface
     */
    public function createCriteriaChecker(): CriteriaCheckerInterface
    {
        return new CriteriaChecker(
            $this->getMonitoringCriteriaPlugins(),
            $this->getQueueClient()
        );
    }

    /**
     * @return \NxsSpryker\Zed\Monitoring\Business\Model\AlertTriggerInterface
     */
    public function createAlertTrigger(): AlertTriggerInterface
    {
        return new AlertTrigger($this->getMonitoringAlertPlugins());
    }

    /**
     * @return \NxsSpryker\Zed\Monitoring\Communication\Plugin\MonitoringCriteriaPluginInterface[]
     */
    protected function getMonitoringCriteriaPlugins(): array
    {
        return $this->getProvidedDependency(MonitoringDependencyProvider::CRITERIA_PLUGIN_COLLECTION);
    }

    /**
     * @return \NxsSpryker\Zed\Monitoring\Communication\Plugin\MonitoringAlertPluginInterface[]
     */
    protected function getMonitoringAlertPlugins(): array
    {
        return $this->getProvidedDependency(MonitoringDependencyProvider::ALERT_PLUGIN_COLLECTION);
    }

    /**
     * @return \NxsSpryker\Zed\Monitoring\Dependency\Client\MonitoringToQueueClientBridgeInterface
     */
    protected function getQueueClient(): MonitoringToQueueClientBridgeInterface
    {
        return $this->getProvidedDependency(MonitoringDependencyProvider::QUEUE_CLIENT);
    }
}
