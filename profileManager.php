<?php
include "Zend/Db.php";
include "Zend/Db/Table.php";
include "Zend/Registry.php";

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

$profileTable->insert($profileSaveData);

//get profiles after insert profile
$profiles = $profileTable->fetchAll();

echo PHP_EOL;
foreach($profiles as $profile) {
 
    $id = $profile['id'];
    $fullname = $profile['fullname'];
    $address = $profile->address;

    echo $id.' '. $fullname.' '.$address.PHP_EOL;
}

//get last insert profile
$statement = $profileTable->select()->order(array('id DESC'))->limit(1);
$profiles = $profileTable->fetchAll($statement);

$lastProfileId = 0;
foreach ($profiles as $profile) {
    $lastProfileId = (int)$profile->id;
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

