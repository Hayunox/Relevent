<?php

use mageekguy\atoum\reports;

$report = $script->addDefaultReport();

//TEST EXECUTION SETUP
$runner->addTestsFromDirectory('tests/units/database');
$runner->addTestsFromDirectory('tests/units/rest');

/*
Publish errors on sentry.io
*/
$client = new Raven_Client('https://97d0881376544234aa54b3d4157e2a44:daa853fe91a2457bafb3783f11a16a49@sentry.io/193436');
$error_handler = new Raven_ErrorHandler($client);
$error_handler->registerExceptionHandler();
$error_handler->registerErrorHandler();
$error_handler->registerShutdownFunction();

/*
Publish code coverage report on coveralls.io
*/
$sources = '';
$token = 'qIapEkNDgw3Gjr4Z23S59PHXjUHONoZVy';
$coverallsReport = new reports\asynchronous\coveralls($sources, $token);

/**
 * Converalls report
 */
$defaultFinder = $coverallsReport->getBranchFinder();
$coverallsReport
    ->setBranchFinder(function () use ($defaultFinder) {
        if (($branch = getenv('TRAVIS_BRANCH')) === false) {
            $branch = $defaultFinder();
        }

        return $branch;
    })
    ->setServiceName(getenv('TRAVIS') ? 'travis-ci' : null)
    ->setServiceJobId(getenv('TRAVIS_JOB_ID') ?: null)
    ->addDefaultWriter()
;

$runner->addReport($coverallsReport);
