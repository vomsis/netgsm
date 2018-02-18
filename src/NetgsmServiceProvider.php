<?php

namespace Vomsis\Netgsm;

use Illuminate\Support\ServiceProvider;

/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 18.02.2018
 * Time: 13:59
 */

class NetgsmServiceProvider extends ServiceProvider
{
    public function boot(){
        //ilk yüklendiğinde erişilir
        //tanımlamalar yapılır

        //paket config dosyasını uygulama içerisine aktarır
        $this->publishes([
            __DIR__.'/../config/netgsm.php'=>config_path('netgsm.php')
        ],'config'); //php artisan vendor:publish --tag='config'
    }

    public function register(){
        //kayıt işlemleri
        $this->mergeConfigFrom(__DIR__.'/../config/netgsm.php','netgsm');   //developer configleri ile default config dosyasını birleştirir
        $this->app->singleton('netgsm',function ($app){ //ana uygulamaya netgsm isminde bir uygulama ekle(singleton - tekil olmasını sayğlıyor) netgsm uygulaması istendiğinde bu function çalışır.
            $config=$app->make('config'); //laravel config uygulamasını getirir
            return new Netgsm($config);
        });
    }

    public function provides(){
        return ['netgsm'];
    }
}