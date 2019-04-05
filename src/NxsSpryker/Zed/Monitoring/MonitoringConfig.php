<?php

namespace NxsSpryker\Zed\Monitoring;

use Spryker\Zed\Kernel\AbstractBundleConfig;

class MonitoringConfig extends AbstractBundleConfig
{
    const DEFAULT_MONITORING_ALERT_CHUNK_SIZE = 500;

    /**
     * @return int
     */
    public function getMonitoringAlertChunkSize(): int
    {
        return static::DEFAULT_MONITORING_ALERT_CHUNK_SIZE;
    }
}
