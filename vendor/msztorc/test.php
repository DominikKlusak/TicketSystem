<?php

use DPD\Services\DPDService;

$sender = [
    'fid' => '1495',
    'name' => 'Janusz Biznesu',
    'company' => 'INCO',
    'address' => 'Chmielna 10',
    'city' => 'Warszawa',
    'postalCode' => '00999',
    'countryCode' => 'PL',
    'email'=> 'biuro@_inco.pl',
    'phone' => '+22123456',
];  

$dpd = new DPDService();
$dpd->setSender($sender);

$parcels = [
    0 => [
        'content' => 'antyramy',
        'customerData1' => 'Uwaga szkło!',
        'weight' => 8,
    ],
    1 => [
        'content' => 'ulotki',
        'weight' => 5,
    ],
];

$receiver = [
    'company' => 'ABC Sp. z o.o.',
    'name' => 'Jan Kowalski',
    'address' => 'Wielicka 10',
    'city' => 'Krakow',
    'postalCode' => '30552',
    'countryCode' => 'PL',
    'phone' => '+12 555221112',
    'email'=> 'biuro@a_b_c.pl',
];

//send a package
$result = $dpd->sendPackage($parcels, $receiver, 'SENDER');

$pickupAddress = [
    'fid' => '1495',
    /*'name' => 'Janusz Biznesu',
    'company' => 'INCO',
    'address' => 'Chmielna 10',
    'city' => 'Warszawa',
    'postalCode' => '00999',
    'countryCode' => 'PL',
    'email'=> 'biuro@_inco.pl',
    'phone' => '+22123456',*/
];
 
// generate speedlabel in default, pdf/a4 format
$speedlabel = $dpd->generateSpeedLabelsByPackageIds([$result->packageId], $pickupAddress);

// save speedlabel to pdf file
file_put_contents('pdf/slbl-pid' . $result->packageId . '.pdf', $speedlabel->filedata);

// generate protocol
$protocol = $dpd->generateProtocolByPackageIds([$result->packageId], $pickupAddress);

// save protocol to pdf file
file_put_contents('pdf/prot-pid' . $result->packageId . '.pdf', $protocol->filedata);


// pickup

$pickupDate = '2017-08-23';
$pickupTimeFrom = '13:00';
$pickupTimeTo = '16:00';

$contactInfo = [
    'name' => 'Janusz Biznesu',
    'company' => 'INCO',
    'phone' => '12 5555555',
    'email' => 'januszbiznesu@_inco.pl',
    'comments' => 'proszę dzownić domofonem'

];

// pickup call
$pickup = $dpd->pickupRequest([$protocol->documentId], $pickupDate, $pickupTimeFrom, $pickupTimeTo, $contactInfo, $pickupAddress);