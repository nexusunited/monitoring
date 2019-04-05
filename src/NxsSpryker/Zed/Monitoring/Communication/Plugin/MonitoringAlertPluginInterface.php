<?php

namespace NxsSpryker\Zed\Monitoring\Communication\Plugin;

interface MonitoringAlertPluginInterface
{
    /**
     * @param string $criteriaName
     *
     * @return bool
     */
    public function isResponsibleForCriteria(string $criteriaName): bool;

    /**
     * @return void
     */
    public function triggerAlert(): void;
}
