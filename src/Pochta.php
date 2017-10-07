<?php
/**
 *    module: Ukrpochta 0.0.1
 *    author: Evgen Kitonin
 *    version: 1
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
     *    @param     string     $param         PARAMETERS
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
     *    PREPARE DATA
     *
     *    @param     array     $data     ARRAY DATA
     *
     *    @return JSON
     *
     **/
    private function prepare($data)
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    /**
     *    REQUEST DATA
     *
     *    @param     string     $method     METHOD REQUEST
     *    @param     array     $data         ARRAY DATA
     *    @param     string     $param         PARAMETERS
     *    @param     string     $type         TYPE REQUEST
     *
     *    @return data
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

            }

            return $response->getBody()->getContents();

        } catch (RequestException $e) {

            return $e->getResponse()->getBody()->getContents();

        }
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
     *    ПОКАЗАТЬ АДРЕС ПО ID
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
     *    @param string     $token     TOKEN COUNTERPARTY
     *    @param array     $data     ARRAY DATA
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
     *    @param     int     $id     ID CLIENT
     *    @param     string     $token     TOKEN COUNTERPARTY
     *    @param     array     $array     ARRAY DATA
     *
     *    @return string
     *
     **/
    public function changeClient($id, $token, $data = array())
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
     *    @param     boolean     $type     TYPE REQUEST     CLIENT ID || EXTERNAL ID
     *    @param     string         $token     TOKEN COUNTERPARTY
     *    @param     int         $extID     EXTERNAL ID CLIENT
     *
     *    @return string
     *
     **/
    public function getClient($type = true, $token, $id = 0, $extID = 0)
    {
        if ($type) {

            return $this->requestData('clients', '', $id . '/?token' . $token);

        } else {

            return $this->requestData('clients', '', '/external-id/' . $extID . '/?token=' . $token);

        }
    }
}
