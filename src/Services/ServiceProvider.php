<?php
namespace ChaseLaw\AliyunOpenApi\Services;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
class ServiceProvider extends LaravelServiceProvider {

    public function boot(){
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('aliyun-open-api.php'),
        ]);
    }
    public function register(){
        // dd('register');
        $this->app->singleton(AliyunOpenApi::class,function($app){
            $config = config('aliyun-open-api');
            return AliyunOpenApi::create(
                $config['region_id'],
                $config['access_key_id'],
                $config['access_secret'],
                $config['security_token']
            );
        });
    }
}
