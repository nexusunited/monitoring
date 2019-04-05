NxsSpryker/Monitoring
===================

Spryker module to add Monitoring for some specific criteria with custom alert logic.



Installation
------------------
```
composer require nxsspryker/monitoring
```

For ***console command*** you need to register the console command in the ConsoleDependencyProvider.
Command validates each registered Criteria and issues monitoring alert if some Criteria is not met.
```php
<?php

namespace Pyz\Zed\Console;

use NxsSpryker\Zed\Monitoring\Communication\Console\MonitoringCriteriaValidationConsole;
use Spryker\Zed\Console\ConsoleDependencyProvider as SprykerConsoleDependencyProvider;
// ...

class ConsoleDependencyProvider extends SprykerConsoleDependencyProvider
{
    /**
         * @param \Spryker\Zed\Kernel\Container $container
         *
         * @return \Symfony\Component\Console\Command\Command[]
         */
        protected function getConsoleCommands(Container $container)
        {
            $commands = [
                // ...
                new MonitoringCriteriaValidationConsole()    
            ];

        }
```

For ***Alert handling*** you must register RabbitMQ queue in RabbitMqConfig
```php
<?php

namespace Pyz\Client\RabbitMq;

use ArrayObject;
use Spryker\Client\RabbitMq\RabbitMqConfig as SprykerRabbitMqConfig;
use NxsSpryker\Shared\Monitoring\MonitoringConstants;
// ...

class RabbitMqConfig extends SprykerRabbitMqConfig
{
    /**
     * @return \ArrayObject
     */
    protected function getQueueOptions()
    {
        $queueOptionCollection = new ArrayObject();
        // ...
        $queueOptionCollection->append(
            $this->createQueueOption(
                MonitoringConstants::MONITORING_ALERT_QUEUE,
                MonitoringConstants::MONITORING_ALERT_QUEUE_ERROR
                )
        );
        
        return $queueOptionCollection;
    }
}

```


Usage
------------------

You can create Criteria plugin that evaluates system's state:

```php
<?php

namespace Pyz\Zed\Example\Communication\Plugin;

use NxsSpryker\Zed\Monitoring\Communication\Plugin\MonitoringCriteriaPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

class ExampleCriteriaPlugin extends AbstractPlugin implements MonitoringCriteriaPluginInterface
{
    public const CRITERIA_NAME = 'Some unique criteria name';

    /**
     * @return string
     */
    public function getCriteriaName(): string
    {
        return self::CRITERIA_NAME;
    }

    /**
     * @return bool
     */
    public function isCriteriaMet(): bool
    {
        // Check if some system condition is met
    }
}

```

If Criteria is not met, RabbitMQ queue ***monitoring.alert*** is created with ***MonitoringAlertTransfer***.
It can be handeled manually or by creating Alert plugin:

```php
<?php

namespace Pyz\Zed\Example\Communication\Plugin;

use NxsSpryker\Zed\Monitoring\Communication\Plugin\MonitoringAlertPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

class ExampleAlertPlugin extends AbstractPlugin implements MonitoringAlertPluginInterface
{
    const EXCEPTION_CRITERIA = [ExampleCriteriaPlugin::CRITERIA_NAME];

    /**
     * @param string $criteriaName
     *
     * @return bool
     */
    public function isResponsibleForCriteria(string $criteriaName): bool
    {
        // Logic that decides if Criteria received is meant for this Alert
        return \in_array($criteriaName, self::EXCEPTION_CRITERIA);
    }

    /**
     * @return void
     */
    public function triggerAlert(): void
    {
        // Logic for alert if Criteria is not met
    }
}

```

Single Alert plugin can handle multiple Criterias and one Criteria can be handeled by multiple Alerts.

To ***register plugins*** extend MonitoringDependencyProvider:

```php
<?php

namespace Pyz\Zed\Monitoring;

use NxsSpryker\Zed\Monitoring\MonitoringDependencyProvider as NxsMonitoringDependencyProvider;
use Pyz\Zed\Example\Communication\Plugin\ExampleCriteriaPlugin;
use Pyz\Zed\Example\Communication\Plugin\ExampleAlertPlugin;

class MonitoringDependencyProvider extends NxsMonitoringDependencyProvider
{
    /**
     * @return array
     */
    protected function getAlertPluginCollection(): array
    {
        $exceptionPluginCollection = [
            // ...
            new ExampleAlertPlugin(),
        ];

        return $exceptionPluginCollection;
    }

    /**
     * @return array
     */
    protected function getCriteriaPluginCollection(): array
    {
        $criteriaPluginCollection = [
            // ...
            new ExampleCriteriaPlugin(),
        ];

        return $criteriaPluginCollection;
    }
}

```
