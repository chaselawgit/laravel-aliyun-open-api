<?php
/**
 * Created by PhpStorm.
 * User: chaselaw
 * Date: 2018/7/6
 * Time: 下午3:07
 */
namespace ChaseLaw\AliyunOpenApi\Services;


use DefaultAcsClient;
use DefaultProfile;

/**
 * Class AliyunOpenApi
 * @package ChaseLaw\AliyunOpenApi\Services
 * @method \stdClass getAcsResponse($request)
 */
class AliyunOpenApi {

    private $client;
    private $regionId;
    private $accessKeyId;
    private $accessSecret;
    /**
     * @var null
     */
    private $securityToken;

    /**
     * AliyunOpenApi constructor.
     * @param $regionId
     * @param $accessKeyId
     * @param $accessSecret
     * @param null $securityToken
     */
    public function __construct($regionId, $accessKeyId, $accessSecret, $securityToken = null)
    {

        $this->regionId = $regionId;
        $this->accessKeyId = $accessKeyId;
        $this->accessSecret = $accessSecret;
        $this->securityToken = $securityToken;
        $profile = DefaultProfile::getProfile($regionId, $accessKeyId, $accessSecret, $securityToken = null);
        $this->client = new DefaultAcsClient($profile);
    }
    public static function create($regionId, $accessKeyId, $accessSecret, $securityToken = null){
        return new self($regionId, $accessKeyId, $accessSecret, $securityToken = null);
    }
    public function __call($name, $arguments)
    {
        $client = $this->client;
        return call_user_func_array([$client,$name],$arguments);
    }


}