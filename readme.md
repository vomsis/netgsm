# Netgsm Laravel Package

## Installation

Install package with **composer**

```
composer require vomsis/netgsm
```

In Laravel 5.5+ package will auto discovery.

### Optional Steps for Laravel 5.4-

Add package provider to `config/app.php` file

```
'providers' => [
    Vomsis\Netgsm\NetgsmServiceProvider::class,
]
```

Add alias to `config/app.php` file

```
'aliases' => [
    'Netgsm' => Vomsis\Netgsm\NetgsmFacade::class,
]
```

## Configuration

Add Netgsm API information to `.env` file

```
NETGSM_URL=https://api.netgsm.com.tr
NETGSM_USERNAME=
NETGSM_PASSWORD=
NETGSM_HEADER=
```

`NETGSM_URL` is API base url of netgsm. `NETGSM_USERNAME` and `NETGSM_PASSWORD` is authentication information of netgsm. `NETGSM_HEADER` is default header of sms messages. 

You can also publish config file.

```
php artisan vendor:publish --provider="Vomsis\Netgsm\NetgsmServiceProvider"
```

## Usage

Send sms to one number

```
Netgsm::sendSms("50xxxxxxxx", "Message content");
```

You can also specify options. Like header and startDate

```
Netgsm::sendSms($number, $message, $header = null, $startDate = null, $endDate = null, $lang = null);
```

Send sms to multiple numbers

```
Netgsm::sendSms(["50xxxxxxxx", "50xxxxxxxx"], "Message Content");
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).