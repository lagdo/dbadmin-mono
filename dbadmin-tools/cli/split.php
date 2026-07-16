#!/usr/local/bin/php
<?php

require __DIR__ . '/../../vendor/autoload.php';

use Lagdo\DbAdmin\Support\Service\Query\QuerySplitter;
use Lagdo\DbAdmin\Tools\SplitterCommand;

(new SplitterCommand(new QuerySplitter()))->run();
