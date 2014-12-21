<?php

use Evenement\EventEmitterInterface;
use Peridot\Leo\HttpFoundation\LeoHttpFoundation;
use Peridot\Leo\Leo;
use Peridot\Plugin\Watcher\WatcherPlugin;
use Peridot\Reporter\CodeCoverageReporters;
use Peridot\Reporter\Dot\DotReporterPlugin;
use Peridot\Reporter\ListReporter\ListReporterPlugin;

return function(EventEmitterInterface $emitter) {
    $watcher = new WatcherPlugin($emitter);
    $dot = new DotReporterPlugin($emitter);
    $list = new ListReporterPlugin($emitter);

    $coverage = new CodeCoverageReporters($emitter);
    $coverage->register();

    $assertion = Leo::instance()->getAssertion();
    $assertion->extend(new LeoHttpFoundation());
};
