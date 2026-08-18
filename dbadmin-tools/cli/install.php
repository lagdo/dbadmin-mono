#!/usr/local/bin/php
<?php

require __DIR__ . '/../../vendor/autoload.php';

(new Lagdo\DbAdmin\Tools\InstallCommand())->run();
