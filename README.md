# 阿里云开放api laravel 组件
### 说明
这件组件是对阿里云开放api官方sdk进行封装的laravel 组件，在laravel 中会自动注册服务，只需要配置即可。如果不是laravel 项目，需要自行构造 AliLiveService 实例。
### 安装 

* 安装组件
~~~
composer require chaselawgit/AliyunOpenApi
~~~

* 发布资源

~~~
php artisan vendor:publish --provider="ChaseLaw\AliyunOpenApi\Services\AliLiveServiceProvider"
~~~

这个命令会生成配置文件 config/ali-open-api.php ,只需要在配置文件中配置 app_name 及 key 。其它配置暂时不会用到。

### 使用 
* 示例
~~~
use ChaseLaw\AliyunOpenApi\Services\AliLiveService;
use live\Request\V20161101\DescribeLiveStreamsBlockListRequest;

public function blockList(AliLiveService $api){
    $request = new DescribeLiveStreamsBlockListRequest();
    $request->setMethod("GET");
    $request->setDomainName('your domain');
    $response = $api->getAcsResponse($request);
    //$response 为阿里云返回的数据对象
}
~~~

* 更多

更多用法请参考阿里云开放api sdk文档 。
