<?php

namespace PassGen\Console;

use PassGen\Passphrase;
use SigmaPHP\Console\Command;

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
    }

    /**
     * Execute.
     *
     * @return void
     */
    public function execute()
    {
        $passphrase = new Passphrase();

        $this->writeln($passphrase->create());
    }
}
