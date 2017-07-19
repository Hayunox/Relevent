<?php

use mageekguy\atoum\reports;

$report = $script->addDefaultReport();

//TEST EXECUTION SETUP
$runner->addTestsFromDirectory('tests/units/database');
$runner->addTestsFromDirectory('tests/units/rest');

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
