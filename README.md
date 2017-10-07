# Описание 

PHP класс для работы с API Укрпочты

# Документация

[Google Disk](https://drive.google.com/file/d/0B-n0UjF7kxV_T253YU5nOHdCQlk/view?usp=sharing)

# Требование

* PHP не ниже 5.6
* Composer

# Методы API

1. Создание адреса
	* createAddress
2. Редактирование адреса
	* editAddress
3. Показать адрес по ID
	* getAddress
4. Создание клиента
	* createClient

# Composer
```bash
composer require jackmartin/ukrpochta
```
# Примеры

- createAddress($data = array())
```php
<?php
use Ukrpochta\Pochta;

include __DIR__ . '/vendor/autoload.php';
$ukrpochta = new Pochta('API_KEY');

$result = $ukrpochta->createAddress(array(
    'postcode' => '02099',
    'region' => 'Полтавська',
    'district' => 'Полтавський',
    'city' => 'Полтава',
    'street' => 'Шевченка',
    'houseNumber' => '51',
    'apartmentNumber' => '20'
));
print_r($result);
//{"id":123130,"postcode":"02099","region":"Полтавська","district":"Полтавський",
//"city":"Полтава","street":"Шевченка",
//"houseNumber":"51","apartmentNumber":"20","description":null,"countryside":false,
//"detailedInfo":"Україна, 02099, Полтавська, Полтавський, Полтава, Шевченка, 51, 20","country":"UA"}
```
- editAddress($id, $data = array())
```php
<?php
use Ukrpochta\Pochta;

include __DIR__ . '/vendor/autoload.php';
$ukrpochta = new Pochta('API_KEY');

$result = $ukrpochta->editAddress(123130, array(
    'postcode' => '02099',
    'region' => 'Полтавська',
    'district' => 'Полтавський',
    'city' => 'Полтава',
    'street' => 'Шевченка',
    'houseNumber' => '51',
    'apartmentNumber' => '20'
));
print_r($result);
//{"id":123130,"postcode":"02099","region":"Полтавська","district":"Полтавський",
//"city":"Полтава","street":"Шевченка",
//"houseNumber":"51","apartmentNumber":"20","description":null,"countryside":false,
//"detailedInfo":"Україна, 02099, Полтавська, Полтавський, Полтава, Шевченка, 51, 20","country":"UA"}
```

# Библиотеки 

1. [Guzzle](https://github.com/guzzle/guzzle)