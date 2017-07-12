<?php
/*
 * Created by PhpStorm.
 * User: Paul
 * Date: 12/07/2017
 * Time: 18:45
 */

use mageekguy\atoum\reports;

$runner->addTestsFromDirectory(__DIR__ . '/Database');

$coveralls = new reports\asynchronous\coveralls('src', 'qIapEkNDgw3Gjr4Z23S59PHXjUHONoZVy');
$defaultFinder = $coveralls->getBranchFinder();
$coveralls
    ->setBranchFinder(function() use ($defaultFinder) {
        if (($branch = getenv('TRAVIS_BRANCH')) === false)
        {
            $branch = $defaultFinder();
        }

        return $branch;
    })
    ->setServiceName(getenv('TRAVIS') ? 'travis-ci' : null)
    ->setServiceJobId(getenv('TRAVIS_JOB_ID') ?: null)
    ->addWriter()
;
$runner->addReport($coveralls);

$script->addDefaultReport();