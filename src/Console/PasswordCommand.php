<?php

namespace PassGen\Console;

use PassGen\Password;
use SigmaPHP\Console\Command;
use SigmaPHP\Console\DataType;
use SigmaPHP\Console\Option;

/**
 * Password Command.
 */
class PasswordCommand extends Command
{
    /**
     * Initialize the command.
     *
     * @return void
     */
    public function init()
    {
        $this->setName('password');
        $this->setDescription('Create a new password');

        $this->addOption(
            'length',
            'l',
            'The length of the password',
            Option::PARAMETER_OPTIONAL,
            DataType::NUMBER,
            16
        );
    }

    /**
     * Execute.
     *
     * @return void
     */
    public function execute()
    {
        $password = new Password();

        if ($this->hasOption('length')) {
            $password->length($this->getOption('length'));
        }

        $this->writeln($password->create());
    }
}
