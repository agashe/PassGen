<?php

namespace PassGen\Console;

use SigmaPHP\Console\App as ConsoleApp;
use PassGen\Console\PasswordCommand;
use PassGen\Console\PassphraseCommand;

/**
 * Console App Class.
 */
class App
{
    // define app version
    const VERSION = "v2.0.0";

    /**
     * Start console app.
     *
     * @return void
     */
    public static function start()
    {
        // initiate new console app
        $app = new ConsoleApp();

        $app->setAppName('passgen');
        $app->setAppDescription('Generate secure password/passphrase');
        $app->setAppVersion('PassGen ' . self::VERSION);

        $app->addCommand(PasswordCommand::class);
        $app->addCommand(PassphraseCommand::class);

        $app->run();
    }
}
