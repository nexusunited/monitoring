<?php

namespace NxsSpryker\Zed\Monitoring\Communication\Console;

use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \NxsSpryker\Zed\Monitoring\Business\MonitoringFacadeInterface getFacade()
 */
class MonitoringCriteriaValidationConsole extends Console
{
    const COMMAND_NAME = 'monitoring:criteria-validate';
    const COMMAND_DESCRIPTION = 'Run monitoring criteria checks and trigger alert if criteria is not met';
    const AFTERCOMMAND_MESSAGE = 'Command executed succesfully';

    /**
     * @return void
     */
    public function configure(): void
    {
        $this->setName(static::COMMAND_NAME);
        $this->setDescription(self::COMMAND_DESCRIPTION);

        parent::configure();
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return void
     */
    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->getFacade()->checkMonitoringCriteria();
        $this->printAfterCommandMessage();
    }

    /**
     * @return void
     */
    private function printAfterCommandMessage(): void
    {
        $this->info(
            self::AFTERCOMMAND_MESSAGE,
            true
        );
    }
}
