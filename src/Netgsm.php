<?php

namespace Vomsis\Netgsm;

use GuzzleHttp\Client;
use Vomsis\Netgsm\Exception\AuthException;
use Vomsis\Netgsm\Exception\HeaderException;
use Vomsis\Netgsm\Exception\MessageException;
use Vomsis\Netgsm\Exception\ParameterException;

/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 18.02.2018
 * Time: 14:13
 */
class Netgsm
{

    protected $url;
    protected $username;
    protected $password;
    protected $header;
    protected $lang;
    protected $http;

    public function __construct($config)
    {
        $this->url = $config->get('netgsm.url');
        $this->username = $config->get('netgsm.username');
        $this->password = $config->get('netgsm.password');
        $this->header = $config->get('netgsm.header');
        $this->lang = $config->get('netgsm.language');
        $this->http = new Client([
            "base_uri" => $this->url,
            "timeout" => 10
        ]);
    }

    public function sendSms($number, $message, $header = null, $startDate = null, $endDate = null, $lang = null)
    {
        $numbers = [];
        if (is_array($number))
            foreach ($number as $num)
                $numbers[] = $num;
        else
            $numbers[] = $number;

        if (is_null($header))
            $header = $this->header;
        if (is_null($lang))
            $lang = $this->lang;

        $query = [
            'usercode' => $this->username,
            'password' => $this->password,
            'gsmno' => implode(',', $numbers),
            'message' => $message,
            'msgheader' => $header,
            'startdate' => $startDate,
            'stopdate' => $endDate,
            'dil' =>$lang
        ];

        $response = $this->http->request('GET', 'bulkhttppost.asp', [
            'query' => $query
        ]);

        if($response->getStatusCode() == 200){
            $content = $response->getBody()->getContents();

            if($content == '20')
                throw new MessageException('Mesaj metniniz hatalı veya standart maximum karakter sayısını geçiyor');
            elseif($content=='30')
                throw new AuthException('Geçersiz kullanıcı adı veya şifre yada Api erişiniz bulunmamakta');
            elseif($content=='40')
                throw new HeaderException('Mesaj başlığınız sistemde tanımlı değil');
            elseif($content=='70')
                throw new ParameterException('Gönderim parametreleri hatalı');

            $exp=explode(' ',$content);

            return $exp[1];
        } else {
            throw new ResponseException($response->getReasonPhrase());
        }

    }
}