<?php
namespace ChaseLaw\AliyunOpenApi\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
class AliLiveServiceProvider extends LaravelServiceProvider {

    public function boot(){
        $this->publishes([
            __DIR__.'/../Config/ali-open-api.php' => config_path('ali-open-api.php'),
        ]);
    }
    public function register(){
        $this->app->singleton(AliLiveService::class,function($app){
            $config = config('ali-open-api');
            return new AliLiveService(
                $config['app_name']
                , $config['center_push_host']
                ,$config['vhost']
                ,$config['key']
                ,$config['trans_code_ids']
                ,$app->make(Collection::class)
            );
        });
    }
}
