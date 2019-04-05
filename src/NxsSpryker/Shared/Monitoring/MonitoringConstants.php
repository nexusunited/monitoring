<?php

namespace NxsSpryker\Shared\Monitoring;

interface MonitoringConstants
{
    /**
     * Specification:
     * - Queue name as used when with asynchronous monitoring alert handling
     *
     * @api
     */
    public const MONITORING_ALERT_QUEUE = 'monitoring.alert';

    /**
     * Specification:
     * - Error queue name as used when with asynchronous monitoring alert handling
     *
     * @api
     */
    public const MONITORING_ALERT_QUEUE_ERROR = 'monitoring.alert.error';
}
