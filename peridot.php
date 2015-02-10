<?php

use Evenement\EventEmitterInterface;
use Peridot\Leo\HttpFoundation\LeoHttpFoundation;
use Peridot\Leo\Leo;
use Peridot\Plugin\Watcher\WatcherPlugin;
use Peridot\Reporter\CodeCoverageReporters;
use Peridot\Reporter\Dot\DotReporterPlugin;
use Peridot\Reporter\ListReporter\ListReporterPlugin;

return function(EventEmitterInterface $emitter) {
    $emitter->on('peridot.start', function (\Peridot\Console\Environment $environment) {
        $environment->getDefinition()->getArgument('path')->setDefault('specs');
    });

    $watcher = new WatcherPlugin($emitter);
    $dot = new DotReporterPlugin($emitter);
    $list = new ListReporterPlugin($emitter);

    $coverage = new CodeCoverageReporters($emitter);
    $coverage->register();

    Leo::assertion()->extend(new LeoHttpFoundation());
};
