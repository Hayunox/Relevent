<?php

/*
This file will automatically be included before EACH run.

Use it to configure atoum or anything that needs to be done before EACH run.

More information on documentation:
[en] http://docs.atoum.org/en/latest/chapter3.html#configuration-files
[fr] http://docs.atoum.org/fr/latest/lancement_des_tests.html#fichier-de-configuration
*/

use \mageekguy\atoum;
use mageekguy\atoum\autoloader;
use mageekguy\atoum\reports;

$report = $script->addDefaultReport();

//TEST EXECUTION SETUP
$runner->addTestsFromDirectory('server/tests/units/database');
$runner->addTestsFromDirectory('server/tests/units/rest');

//CODE COVERAGE SETUP

/*
Publish code coverage report on coveralls.io
*/
$sources = '/path/to/sources/directory';
$token = 'qIapEkNDgw3Gjr4Z23S59PHXjUHONoZVy';
$coverallsReport = new reports\asynchronous\coveralls($sources, $token);

/*
If you are using Travis-CI (or any other CI tool), you should customize the report
* https://coveralls.io/docs/api
* http://about.travis-ci.org/docs/user/ci-environment/#Environment-variables
* https://wiki.jenkins-ci.org/display/JENKINS/Building+a+software+project#Buildingasoftwareproject-JenkinsSetEnvironmentVariables
*/
$defaultFinder = $coverallsReport->getBranchFinder();
$coverallsReport
    ->setBranchFinder(function () use ($defaultFinder) {
        if (($branch = getenv('TRAVIS_BRANCH')) === false) {
            $branch = $defaultFinder();
        }

        return $branch;
    })
    /*
    https://coveralls.zendesk.com/hc/en-us/articles/201774865-API-Introduction
    > Setting service_name to "travis-ci" and service_job_id to the Travis Job ID will automatically look up the appropriate build and repository, and assign the job correctly on Coveralls.
    */
    ->setServiceName(getenv('TRAVIS') ? 'travis-ci' : null)
    ->setServiceJobId(getenv('TRAVIS_JOB_ID') ?: null)
    ->addDefaultWriter()
;

$runner->addReport($coverallsReport);



/*
TEST GENERATOR SETUP

$testGenerator = new atoum\test\generator();

// Please replace in next line "/path/to/your/tests/units/classes/directory" by your unit test's directory.
$testGenerator->setTestClassesDirectory('path/to/your/tests/units/classes/directory');

// Please replace in next line "your\project\namespace\tests\units" by your unit test's namespace.
$testGenerator->setTestClassNamespace('your\project\namespace\tests\units');

// Please replace in next line "/path/to/your/classes/directory" by your classes directory.
$testGenerator->setTestedClassesDirectory('path/to/your/classes/directory');

// Please replace in next line "your\project\namespace" by your project namespace.
$testGenerator->setTestedClassNamespace('your\project\namespace');

// Please replace in next line "path/to/your/tests/units/runner.php" by path to your unit test's runner.
$testGenerator->setRunnerPath('path/to/your/tests/units/runner.php');

$script->getRunner()->setTestGenerator($testGenerator);
*/
