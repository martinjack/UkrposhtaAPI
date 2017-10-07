# Описание 

PHP класс для работы с API Укрпочты

# Документация

[Google Disk](https://drive.google.com/file/d/0B-n0UjF7kxV_T253YU5nOHdCQlk/view?usp=sharing)

# Требование

* PHP не ниже 5.6
* Composer

# Методы API

1. Создать адрес
	* [createAddress](https://github.com/martinjack/UkrpochtaAPI#createaddressdata--array)
2. Редактировать адрес
	* [editAddress](https://github.com/martinjack/UkrpochtaAPI#editaddressid-data--array)
3. Показать адрес по ID
	* [getAddress](https://github.com/martinjack/UkrpochtaAPI#getaddressid) 
4. Создать нового клиента
	* [createClient](https://github.com/martinjack/UkrpochtaAPI#createclienttoken-data--array)
5. Редактировать клиента
    * [editClient](https://github.com/martinjack/UkrpochtaAPI#editclientid-token-data--array)

# Composer
```bash
composer require jackmartin/ukrpochta dev-master
```

# Библиотеки 

1. [Guzzle](https://github.com/guzzle/guzzle)

# Примеры

### createAddress($data = array()) ###

```php
<?php
use Ukrpochta\Pochta;

include __DIR__ . '/vendor/autoload.php';
$ukrpochta = new Pochta('API_KEY');

$result = $ukrpochta->editAddress(123130, array(
    'postcode'        => '02099',
    'region'          => 'Полтавська',
    'district'        => 'Полтавський',
    'city'            => 'Полтава',
    'street'          => 'Шевченка',
    'houseNumber'     => '25',
    'apartmentNumber' => '20',
));
print_r($result);
//{"id":123130,"postcode":"02099","region":"Полтавська","district":"Полтавський",
//"city":"Полтава","street":"Шевченка",
//"houseNumber":"51","apartmentNumber":"20","description":null,"countryside":false,
//"detailedInfo":"Україна, 02099, Полтавська, Полтавський, Полтава, Шевченка, 51, 20","country":"UA"}
```

### editAddress($id, $data = array()) ###
```php
<?php
use Ukrpochta\Pochta;

include __DIR__ . '/vendor/autoload.php';
$ukrpochta = new Pochta('API_KEY');

$result = $ukrpochta->editAddress(123130, array(
    'postcode'        => '02050',
    'region'          => 'Полтавська',
    'district'        => 'Полтавський',
    'city'            => 'Полтава',
    'street'          => 'Шевченка',
    'houseNumber'     => '50',
    'apartmentNumber' => '1',
));
print_r($result);
//{"id":123130,"postcode":"02099","region":"Полтавська","district":"Полтавський",
//"city":"Полтава","street":"Шевченка",
//"houseNumber":"51","apartmentNumber":"20","description":null,"countryside":false,
//"detailedInfo":"Україна, 02099, Полтавська, Полтавський, Полтава, Шевченка, 51, 20","country":"UA"}
```

### getAddress($id) ###
```php
<?php

use Ukrpochta\Pochta;

include __DIR__ . '/vendor/autoload.php';

$ukrpochta = new Pochta('API_KEY');

$result = $ukrpochta->getAddress(123130);
print_r($result);
```

### createClient($token, $data = array()) ###
```php
<?php

use Ukrpochta\Pochta;

include __DIR__ . '/vendor/autoload.php';

$ukrpochta = new Pochta('API_KEY');

$result = $ukrpochta->createClient('TOKEN COUNTERPARTY', array(
    'name'                     => 'ФОП «Діскорд',
    'uniqueRegistrationNumber' => '32855961',
    'externalId'               => '12345678',
    'addressId'                => 1245,
    'phoneNumber'              => '0954623442',
    'counterpartyUuid'         => 'COUNTERPARTY UUID',
    'bankCode'                 => '612456',
    'bankAccount'              => '12345684'
));
print_r($result);
``` 

### editClient($id, $token, $data = array()) ###
```php
<?php

use Ukrpochta\Pochta;

include __DIR__ . '/vendor/autoload.php';

$ukrpochta = new Pochta('API_KEY');

$result = $ukrpochta->editClient('UUID CLIENT', 'TOKEN COUNTERPARTY', array(
    'lastName'                 => 'Петрик',
    'firstName'                => 'Иван',
    'middleName'               => 'Васильович',
    'uniqueRegistrationNumber' => '73232855',
    'addressId'                => 1,
    'phoneNumber'              => '0954623442',
    'counterpartyUuid'         => 'UUID COUNTERPARTY',
    'discount'                 => 24,
    'bankCode'                 => 254,
));
print_r($result);
```

