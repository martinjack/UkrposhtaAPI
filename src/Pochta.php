<?php
/**
 *    module: Ukrpochta 0.0.1
 *    author: Evgen Kitonin
 *    version: 1.0
 *    create: 06.10.2017
 **/
namespace Ukrpochta;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Pochta
{
    /**
     *    VERSION API
     *
     *    @var string
     *
     **/
    private $version = '0.0.1';
    /**
     *    API LINK
     *
     *    @var string
     *
     **/
    private $api = 'https://www.ukrposhta.ua/ecom/';
    /**
     *    API KEY
     *
     *    @var string
     *
     **/
    private $key = null;
    /**
     *    INIT CLASS
     *
     *    @var function
     *
     **/
    public function __construct($key)
    {
        return $this->setKey($key);
    }
    public function __destruct()
    {
    }
    /**
     *
     *    @param SET KEY
     *    @return $this;
     *
     **/
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }
    /**
     *    CREATE LINK API
     *
     *    @param     string     $method     METHOD REQUEST
     *    @param     string     $param      PARAMETERS
     *
     *    @return $this->api
     *
     **/
    private function createLink($method, $param = '')
    {
        if ($param != '') {
            $param = '/' . $param;
        }

        $this->api = $this->api . $this->version . '/' . $method . $param;
    }
    /**
     *  ПІДГОТОВКА ДАННИХ
     *  ПОДГОТОВКА ДАННЫХ
     *
     *  @param  array   $data   ARRAY DATA
     *
     *  @return JSON
     *
     **/
    private function prepare($data)
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    /**
     *  ВИКОНУЄМО ЗАПРОС
     *  ВЫПОЛНЯЕМ ЗАПРОС
     *
     *  @param  string  $method     METHOD REQUEST
     *  @param  array   $data       ARRAY DATA
     *  @param  string  $param      PARAMETERS
     *  @param  string  $type       TYPE REQUEST
     *
     *  @return data
     *
     **/
    private function requestData($method, $data = '', $param = '', $type = 'post')
    {

        $this->createLink($method, $param);

        $client = new Client(array(
            'headers' => array(
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer ' . $this->key,
            ),
        ));

        try {

            switch ($type) {

                case 'post':
                    $response = $client->post($this->api, array(
                        'body' => $this->prepare($data),
                    ));
                    break;
                case 'get':
                    $response = $client->get($this->api);
                    break;
                case 'put':
                    $response = $client->put($this->api, array(
                        'body' => $this->prepare($data),
                    ));
                    break;
                case 'delete':
                    $response = $client->delete($this->api);
                    break;

            }

            return $response->getBody()->getContents();

        } catch (RequestException $e) {

            return $e->getResponse()->getBody()->getContents();

        }
    }
    /**
     *  ЗБЕРІГАЄМО PDF ФАЙЛ
     *  СОХРАНЯЕМ PDF ФАЙЛ
     *
     *  @param  stream   $pdf   STREAM CONTENT PDF
     *  @param  string   $path  PATH SAVE PDF FILE
     *
     *  @return pdf file
     **/
    private function savePDF($pdf, $path)
    {
        file_put_contents($path, $pdf);
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($path) . '"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($path));
        header('Accept-Ranges: bytes');
        readfile($path);
    }
    /**
     *  ПЕРЕВІРКА НА ПОМИЛКУ
     *  ПРОВЕРКА НА ОШИБКУ
     *
     *  @param  json    $content    JSON DATA RESPONSE
     *
     **/
    private function error($content)
    {
        $content = json_decode($content, true);
        if (isset($content['message'])) {
            print_r($content);
            return false;
        }
        return true;
    }
    /**
     *    СТВОРЕННЯ АДРЕСИ
     *    СОЗДАНИЕ АДРЕСА
     *
     *    @param array     $data     ARRAY DATA
     *
     *    @return string
     **/
    public function createAddress($data = array())
    {
        return $this->requestData('addresses', $data);
    }
    /**
     *    РЕДАГУВАННЯ АДРЕСИ
     *    РЕДАКТИРОВАНИЕ АДРЕСА
     *
     *    @param array     $data     ARRAY DATA
     *    @param int         $id     ID ADDRESS
     *
     *    @return string
     **/
    public function editAddress($id, $data = array())
    {
        return $this->requestData('addresses', $data, $id);
    }
    /**
     *    ПОКАЗАТИ АДРЕС ПО ID
     *    ПОКАЗАТЬ АДРЕС ПО ID
     *
     *     @param int     $id     ID ADDRESS
     *
     *    @return string
     *
     **/
    public function getAddress($id)
    {
        return $this->requestData('addresses', '', $id, 'get');
    }
    /**
     *    СТВОРЕННЯ КЛІЄНТА
     *    СОЗДАНИЕ КЛИЕНТА
     *
     *    @param string     $token   TOKEN COUNTERPARTY
     *    @param array      $data    ARRAY DATA
     *
     *    @return string
     *
     **/
    public function createClient($token, $data = array())
    {
        return $this->requestData('clients?token=' . $token, $data);
    }
    /**
     *    РЕДАГУВАННЯ КЛІЄНТУ
     *    РЕДАКТИРОВАНИЕ КЛИЕНТА
     *
     *    @param     int        $id       ID CLIENT
     *    @param     string     $token    TOKEN COUNTERPARTY
     *    @param     array      $array    ARRAY DATA
     *
     *    @return string
     *
     **/
    public function editClient($id, $token, $data = array())
    {
        return $this->requestData('clients', $data, $id . '/?token=' . $token);
    }
    /**
     *    ОТРИМАТИ СПИСОК КЛІЄНТІВ
     *    ПОЛУЧИТЬ СПИСОК КЛИЕНТОВ
     *
     *    @param     string     $token     TOKEN COUNTERPARTY
     *
     *    @return string
     *
     **/
    public function clientsList($token)
    {
        return $this->requestData('clients/token=' . $token);
    }
    /**
     *    ЗНАЙТИ КЛІЄНТА ПО ID
     *    НАЙТИ КЛИЕНТА ПО ID
     *
     *    @param     string      $token     TOKEN COUNTERPARTY
     *    @param     int         $extID     EXTERNAL ID CLIENT
     *    @param     boolean     $type      TYPE REQUEST CLIENT ID || EXTERNAL ID
     *
     *    @return string
     *
     **/
    public function getClient($token, $id = 0, $extID = 0, $type = true)
    {
        if ($type) {

            return $this->requestData('clients', '', $id . '/?token' . $token);

        } else {

            return $this->requestData('clients', '', 'external-id/' . $extID . '/?token=' . $token);

        }
    }
    /**
     *  СТВОРИТИ ГРУППУ ДЛЯ ВІДПРАВЛЕНЬ
     *  СОЗДАТЬ ГРУППУ ДЛЯ ОТПРАВЛЕНИЙ
     *
     *  @param  string  $token  TOKEN COUNTERPARTY
     *  @param  array   $data   DATA ARRAY
     *
     *  @return string
     *
     **/
    public function createGroup($token, $data = array())
    {
        return $this->requestData('shipment-groups?token=' . $token, $data);
    }
    /**
     *  РЕДАГУВАННЯ ГРУПИ ВІДПРАВЛЕНЬ
     *  РЕДАКТИРОВАНИЕ ГРУППЫ ОТПРАВЛЕНИЙ
     *
     *  @param  string  $token  TOKEN COUNTERPARTY
     *  @param  string  $id     UUID GROUP
     *  @param  array   $data   DATA ARRAY
     *
     *  @return string
     *
     **/
    public function editGroup($token, $id, $data = array())
    {
        return $this->requestData('shipment-groups', $data, $id . '?token=' . $token, 'put');
    }
    /**
     *  ОТРИМАТИ ПЕРЕЛІК ВІДПРАВЛЕНЬ
     *  ПОЛУЧИТЬ СПИСОК ОТПРАВЛЕНИЙ
     *
     *  @param  string  $token  TOKEN COUNTERPARTY
     *
     *  @return string
     *
     **/
    public function groupList($token)
    {
        return $this->requestData('shipment-groups?token=' . $token, '', '', 'get');
    }
    /**
     *  ПОКАЗАТИ ГРУППУ ВІДПРАВЛЕНЬ ПО ID
     *  ПОКАЗАТЬ ГРУППУ ОТПРАВЛЕНИЙ ПО ID
     *
     *  @param string   $id
     *  @param string   $token
     *
     *  @return string
     *
     **/
    public function getGroup($id, $token)
    {
        return $this->requestData('shipment-groups', '', $id . '?token=' . $token, 'get');
    }
    /**
     *  СТВОРИТИ НОВУ ПОСИЛКУ
     *  СОЗДАТЬ НОВУЮ ПОСЫЛКУ
     *
     *  @param string   $token  TOKEN COUNTERPARTY
     *
     *  @return string
     *
     **/
    public function createParcel($token, $data = array())
    {
        return $this->requestData('shipments?token=' . $token, $data);
    }
    /**
     *  РЕДАГУВАТИ ПОШТОВЕ ВІДПРАВЛЕННЯ
     *  РЕДАКТИРОВАНИЕ ПОЧТОВОЕ ОТПРАВЛЕНИЕ
     *
     *  @param  string  $id     UUID PARCEL
     *  @param  string  $token  TOKEN COUNTERPARTY
     *  @param  array   $data   DATA ARRAY
     *
     *  @return string
     *
     **/
    public function editParcel($id, $token, $data = array())
    {
        return $this->requestData('shipments', $data, $id . '?token=' . $token, 'put');
    }
    /**
     *  ПОКАЗАТИ ПЕРЕЛІК ПОШТОВИХ ВІДПРАВЛЕНЬ
     *  ПОКАЗАТЬ СПИСОК ПОЧТОВЫХ ОТПРАВЛЕННИЙ
     *
     *  @param  string  $token  TOKEN COUNTERPARTY
     *
     *  @return string
     *
     **/
    public function parcelList($token)
    {
        return $this->requestData('shipments?token=' . $token, '', '', 'get');
    }
    /**
     *  ПОКАЗАТИ ПОШТОВЕ ВІДПРАВЛЕННЯ ПО ID
     *  ПОКАЗАТЬ ПОЧТОВОЕ ОТПРАВЛЕНИЕ ПО ID
     *
     *  @param  string  $id     UUID PARCEL
     *  @param  string  $token  TOKEN COUNTERPARTY
     *  @param  boolean $type   TYPE REQUEST BY UUID PARCEL || SENDER UUID
     *
     *  @return string
     *
     **/
    public function getParcel($id, $token, $type = true)
    {
        if ($type) {

            return $this->requestData('shipments', '', $id . '?token=' . $token, 'get');

        } else {

            return $this->requestData('shipments', '', '?senderuuid=' . $id . '&token=' . $token, 'get');

        }

    }
    /**
     *  ВИДАЛЕННЯ ПОШТОВОГО ВІДПРАВЛЕННЯ З ГРУПИ
     *  УДАЛЕНИЯ ПОЧТОВОГО ОТПРАВЛЕНИЯ С ГРУППЫ
     *
     *  @param  string  $id     ID PARCEL
     *  @param  string  $token  TOKEN COUNTERPARTY
     *
     *  @return string
     *
     **/
    public function delParcelGroup($id, $token)
    {
        return $this->requestData('shipments', '', $id . '/shipment-group?token=' . $token, 'delete');
    }
    /**
     *  СТВОРИТИ ФОРМУ В PDF ФОРМАТІ
     *  СОЗДАТЬ ФОРМУ В PDF ФОРМАТЕ
     *
     *  @param string   $id     ID PARCEL || ID GROUP
     *  @param string   $token  TOKEN COUNTERPARTY
     *  @param string   $path   PATH SAVE PDS FORM
     *  @param boolean  $type   TYPE REQUEST ID PARCEL || ID GROUP
     *
     *  @return string
     **/
    public function createForm($id, $token, $path, $type = true)
    {
        if ($type) {

            $pdf = $this->requestData('shipments', '', $id . '/form?token=' . $token, 'get');

        } else {

            $pdf = $this->requestData('shipment-groups', '', $id . '/form?token=' . $token, 'get');

        }
        if ($this->error($pdf)) {
            $this->savePDF($pdf, $path);
        }
    }
    /**
     *  СТВОРИТИ ФОРМУ 103 В PDF ФОРМАТІ
     *  СОЗДАТЬ ФОРМУ 103 В PDF ФОРМАТЕ
     *
     *  @param string   $id     ID GROUP
     *  @param string   $token  TOKEN COUNTERPARTY
     *
     *  @return string
     **/
    public function createForm103($id, $token, $path)
    {
        $pdf = $this->requestData('shipment-groups', '', $id . '/form103?token=' . $token, 'get');

        if ($this->error($pdf)) {
            $this->savePDF($pdf, $path);
        }
    }
}
