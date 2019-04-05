<?php

namespace NxsSpryker\Zed\Monitoring;

use NxsSpryker\Zed\Monitoring\Dependency\Client\MonitoringToQueueClientBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class MonitoringDependencyProvider extends AbstractBundleDependencyProvider
{
    const CRITERIA_PLUGIN_COLLECTION = 'CRITERIA_PLUGIN_COLLECTION';
    const ALERT_PLUGIN_COLLECTION = 'ALERT_PLUGIN_COLLECTION';
    const UTIL_ENCODING_SERVICE = 'UTIL_ENCODING_SERVICE';
    const QUEUE_CLIENT = 'QUEUE_CLIENT';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $this->addCriteriaPluginCollection($container);
        $this->addAlertPluginCollection($container);
        $this->addQueueClient($container);

        return $container;
    }

    /**
     * @return \NxsSpryker\Zed\Monitoring\Communication\Plugin\MonitoringCriteriaPluginInterface[]
     */
    protected function getCriteriaPluginCollection(): array
    {
        return [];
    }

    /**
     * @return \NxsSpryker\Zed\Monitoring\Communication\Plugin\MonitoringCriteriaPluginInterface[]
     */
    protected function getAlertPluginCollection(): array
    {
        return [];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    private function addCriteriaPluginCollection(Container $container): void
    {
        $container[self::CRITERIA_PLUGIN_COLLECTION] = function () {
            return $this->getCriteriaPluginCollection();
        };
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    private function addAlertPluginCollection(Container $container): void
    {
        $container[self::ALERT_PLUGIN_COLLECTION] = function () {
            return $this->getAlertPluginCollection();
        };
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    private function addQueueClient(Container $container): void
    {
        $container[self::QUEUE_CLIENT] = function (Container $container) {
            return new MonitoringToQueueClientBridge(
                $container->getLocator()->queue()->client()
            );
        };
    }
}
