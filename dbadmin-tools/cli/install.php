#!/usr/local/bin/php
<?php

require __DIR__ . '/../../vendor/autoload.php';

use Lagdo\DbAdmin\Tools\InstallCommand;

(new InstallCommand())->run();
