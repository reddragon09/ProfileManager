<?php
require "vendor/autoload.php";
/*
include "Zend/Db.php";
include "Zend/Db/Table.php";
include "Zend/Registry.php";
include "Zend/Paginator.php";
include "Zend/Paginator/Adapter/Array.php";
include "Zend/Paginator/Adapter/DbTableSelect.php";
*/

$dbAdapter = Zend_Db::factory('PDO_MYSQL', array(
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'dbname' => 'employee'
));


Zend_Db_Table::setDefaultAdapter($dbAdapter);

$profileTable = new Zend_Db_Table('profile');

//$statement = $profileTable->getAdapter()->select();

$profiles = $profileTable->fetchAll();

foreach($profiles as $profile) {
 
    $id = $profile['id'];
    $fullname = $profile['fullname'];
    $address = $profile->address;

    echo $id.' '. $fullname.' '.$address.PHP_EOL;
}

//add new profile
$profileSaveData = array(
    'fullname' => 'Tung1234',
    'address' => 'Ha Noi',
);

$lastProfileId = (int)$profileTable->insert($profileSaveData);

//get profiles after insert profile
$profiles = $profileTable->fetchAll();

echo PHP_EOL;
foreach($profiles as $profile) {
 
    $id = $profile['id'];
    $fullname = $profile['fullname'];
    $address = $profile->address;

    echo $id.' '. $fullname.' '.$address.PHP_EOL;
}

if($lastProfileId <= 0){
    exit('Exit');
}

//update last insert profile
$profileUpdateData = array(
    'fullname' => 'Profile Update',
    'address' => 'Profile Update',
);
$statement = $profileTable->getAdapter()->quoteInto("id = ?",$lastProfileId);
$profiles = $profileTable->update($profileUpdateData,['id = ?' => $lastProfileId]);

//get profiles after update profile
$profiles = $profileTable->fetchAll();

echo PHP_EOL;
foreach($profiles as $profile) {
 
    $id = $profile['id'];
    $fullname = $profile['fullname'];
    $address = $profile->address;

    echo $id.' '. $fullname.' '.$address.PHP_EOL;
}
//delete last insert profile
$statement = $profileTable->getAdapter()->quoteInto("id = ?",$lastProfileId);
$profiles = $profileTable->delete($statement);

//get profiles after delete profile
$profiles = $profileTable->fetchAll();

echo PHP_EOL;
foreach($profiles as $profile) {
 
    $id = $profile['id'];
    $fullname = $profile['fullname'];
    $address = $profile->address;

    echo $id.' '. $fullname.' '.$address.PHP_EOL;
}

//Paginator
//$paginator = new Zend_Paginator(new Zend_Paginator_Adapter_Array($profiles->toArray()));
$profileSelect = $profileTable->select(); //Zend_Db_Table_Select  'select * from profile';

$profilePaginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbTableSelect($profileSelect));
$profilePaginator->setItemCountPerPage(2);    

echo PHP_EOL;
for($page = 1; $page <= $profilePaginator->count();$page++){
    echo "Page: $page";
    echo PHP_EOL;
    
    $profilePaginator->setCurrentPageNumber($page);
    foreach($profilePaginator as $profile){
        $id = $profile->id;
        $fullname = $profile->fullname;
        $address = $profile->address;

        echo $id.' '. $fullname.' '.$address.PHP_EOL;
    }
     echo PHP_EOL;
    
}
