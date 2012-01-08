<?php

namespace Sylius\Sandbox\Bundle\InstallerBundle\Setup\Model;

class Parameters
{
    public $secret;

    public $databaseDriver;
    public $databaseHost = 'localhost';
    public $databasePort;
    public $databaseName = 'sylius_sandbox_database';
    public $databaseUser;
    public $databasePassword;

    public $locale = 'en';

    public $mailerTransport;
    public $mailerHost = 'localhost';
    public $mailerUser;
    public $mailerPassword;
}
