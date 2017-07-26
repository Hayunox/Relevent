<?php

use mageekguy\atoum\reports;

$report = $script->addDefaultReport();

//TEST EXECUTION SETUP
//$runner = new Runner;
$runner->addTest('tests/units/database/DBConnection.php');
$runner->addTest('tests/units/database/DBUser.php');
$runner->addTest('tests/units/database/DBEvent.php');
$runner->addTest('tests/units/rest/RestUser.php');
$runner->addTest('tests/units/rest/RestServer.php');
$runner->addTest('tests/units/rest/RestEvent.php');

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
