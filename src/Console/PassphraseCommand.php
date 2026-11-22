<?php

namespace PassGen\Console;

use PassGen\Passphrase;
use SigmaPHP\Console\Command;
use SigmaPHP\Console\DataType;
use SigmaPHP\Console\Option;

/**
 * Passphrase Command.
 */
class PassphraseCommand extends Command
{
    /**
     * Initialize the command.
     *
     * @return void
     */
    public function init()
    {
        $this->setName('passphrase');
        $this->setDescription('Create a new passphrase');

        $this->addOption(
            'capitalize',
            'z',
            'Capitalize words',
            Option::PARAMETER_NONE,
            DataType::BOOL
        );

        $this->addOption(
            'separator',
            'p',
            'Set separator between words',
            Option::PARAMETER_REQUIRED,
            DataType::STRING
        );

        $this->addOption(
            'numbers',
            'n',
            'Include numbers between words',
            Option::PARAMETER_NONE,
            DataType::BOOL
        );

        $this->addOption(
            'exclude',
            'e',
            'Exclude some words',
            Option::PARAMETER_REQUIRED,
            DataType::LIST
        );

        $this->addOption(
            'count',
            'c',
            'Number of words',
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
        $passphrase = new Passphrase();

        if ($this->hasOption('capitalize')) {
            $passphrase->capitalize();
        }

        if ($this->hasOption('separator')) {
            $passphrase->setSeparator($this->getOption('separator'));
        }

        if ($this->hasOption('numbers')) {
            $passphrase->withNumbers();
        }

        if ($this->hasOption('exclude')) {
            $passphrase->exclude($this->getOption('exclude'));
        }

        if ($this->hasOption('count')) {
            $passphrase->words($this->getOption('count'));
        }

        $this->writeln($passphrase->create());
    }
}
