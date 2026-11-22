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
            'capital',
            'c',
            'Use capital letters',
            Option::PARAMETER_NONE,
            DataType::BOOL
        );

        $this->addOption(
            'small',
            'm',
            'Use small letters',
            Option::PARAMETER_NONE,
            DataType::BOOL
        );

        $this->addOption(
            'digits',
            'd',
            'Use digits',
            Option::PARAMETER_NONE,
            DataType::BOOL
        );

        $this->addOption(
            'symbols',
            'y',
            'Use symbols',
            Option::PARAMETER_NONE,
            DataType::BOOL
        );

        $this->addOption(
            'pattern',
            'p',
            'Provide custom pattern',
            Option::PARAMETER_REQUIRED,
            DataType::STRING
        );

        $this->addOption(
            'exclude',
            'e',
            'Exclude some characters',
            Option::PARAMETER_REQUIRED,
            DataType::LIST
        );

        $this->addOption(
            'length',
            'l',
            'The length of the password',
            Option::PARAMETER_REQUIRED,
            DataType::NUMBER
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

        if ($this->hasOption('capital')) {
            $password->withCapital();
        }

        if ($this->hasOption('small')) {
            $password->withSmall();
        }

        if ($this->hasOption('digits')) {
            $password->withDigits();
        }

        if ($this->hasOption('symbols')) {
            $password->withSymbols();
        }

        if ($this->hasOption('pattern')) {
            $password->usePattern($this->getOption('pattern'));
        }

        if ($this->hasOption('exclude')) {
            $password->exclude($this->getOption('exclude'));
        }

        if ($this->hasOption('length')) {
            $password->length($this->getOption('length'));
        }

        $this->writeln($password->create());
    }
}
