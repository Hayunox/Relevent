<?php

/*
This file will automatically be included before EACH run.

Use it to configure atoum or anything that needs to be done before EACH run.

More information on documentation:
[en] http://docs.atoum.org/en/latest/chapter3.html#configuration-files
[fr] http://docs.atoum.org/fr/latest/lancement_des_tests.html#fichier-de-configuration
*/

use \mageekguy\atoum;
use mageekguy\atoum\reports;

$report = $script->addDefaultReport();

/*$coverallsReport = new reports\asynchronous\coveralls('classes', "qIapEkNDgw3Gjr4Z23S59PHXjUHONoZVy");
$defaultFinder = $coverallsReport->getBranchFinder();
$coverallsReport
    ->setBranchFinder(function() use ($defaultFinder) {
        if (($branch = getenv('TRAVIS_BRANCH')) === false)
        {
            $branch = $defaultFinder();
        }
        return $branch;
    }
    )
    ->setServiceName('travis-ci')
    ->setServiceJobId(getenv('TRAVIS_JOB_ID'))
    ->addDefaultWriter()
;
$runner->addReport($coverallsReport);*/


//CODE COVERAGE SETUP

$coverageField = new atoum\report\fields\runner\coverage\html('ProjetX', 'reports');

$coverageField->setRootUrl('https://coveralls.io/github/Herklos/ProjetX');

$report->addField($coverageField);



//TEST EXECUTION SETUP
$runner->addTestsFromDirectory('server/tests/units/database');


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
