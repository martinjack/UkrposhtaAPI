<?php

use Ukrpochta\Pochta;

include __DIR__ . '/vendor/autoload.php';

/**

Ключи ниже:

POST_ID : P170000659AGX

MY BEARER : f78f5c70-ea34-41d9-9078-d75bead82046

SANDBOX BEARER : f9027fbb-cf33-3e11-84bb-5484491e2c94


SAND_COUNTERPARTY TOKEN : ba5378df-985e-49c5-9cf3-d222fa60aa68


SAND_COUNTERPARTY UUID : 2304bbe5-015c-44f6-a5bf-3e750d753a17


 **/

$ukrpochta = new Pochta('f9027fbb-cf33-3e11-84bb-5484491e2c94');

$result = $ukrpochta->createAddress(
    array(
        'postcode'        => '02099',
        'region'          => 'Полтавська',
        'district'        => 'Полтавський',
        'city'            => 'Полтава',
        'street'          => 'Шевченка',
        'houseNumber'     => '51',
        'apartmentNumber' => '20',
    )
);

// print_r($result);
print_r($ukrpochta->getAddress(122576));
/**
{"uuid":"3a179d40-196f-49e7-899f-6969e9f3d53b","name":"Иванов Иван Иванович","firstName":null,"middleName":null,"lastName":null,"postId":null,"externalId":"1232342351623456","uniqueRegistrationNumber":"515151","counterpartyUuid":"2304bbe5-015c-44f6-a5bf-3e750d753a17","addressId":122576,"addresses":[{"uuid":"555d329a-f52f-41e8-bb4b-376868717d86","addressId":122576,"type":"PHYSICAL","main":true}],"phoneNumber":"+380974256152","phones":[{"uuid":"173e4a43-86bb-4964-be89-53bdfde1d569","phoneNumber":"+380974256152","type":"PERSONAL","main":true}],"email":"","emails":[],"individual":false,"edrpou":null,"bankCode":"123456","bankAccount":"123456","tin":null,"contactPersonName":null,"resident":true}
 **/
