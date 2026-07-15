#!/usr/local/bin/php
<?php

use Lagdo\DbAdmin\Support\Service\Query\QuerySplitter;
use Lagdo\DbAdmin\Tools\SplitterCommand;

(new SplitterCommand(new QuerySplitter()))->run();
