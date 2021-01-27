<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require __DIR__.'/vendor/autoload.php';

use App\Controllers\MankindController;
use App\Models\Person;

echo 'Write 5*2 Objects Person in File' . '</br>';

for ($i=0; $i<6;$i++) {
    $person = new Person('Michael','Faster', Person::MALE['bool'],'2020.12.06');
    $person->save();

    $person = new Person('Inna','Slower', Person::FEMALE['bool'],'2019.11.05');
    $person->save();
};


//
echo '$makeKindController = MankindController::getInstance();' . '</br>';
$makeKindController = MankindController::getInstance();

//
echo 'Foreach $makeKindController instance' . '</br>';
foreach($makeKindController as $id) {
    echo $id . '</br>';
};

echo '</br></br></br>';

echo '$makeKindController->getPercentageOfMan();' . '</br>';
echo $makeKindController->getPercentageOfMan() . '% Percent';

echo '</br></br></br>';

//
echo '$personFindById = $makeKindController->findById(2);' . '</br>';
$personFindById = $makeKindController->findById(2);

print_r($personFindById);
