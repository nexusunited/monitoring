<?php

namespace NxsSpryker\Zed\Monitoring\Communication\Plugin;

interface MonitoringCriteriaPluginInterface
{
    /**
     * @return string
     */
    public function getCriteriaName(): string;

    /**
     * @return bool
     */
    public function isCriteriaMet(): bool;
}
