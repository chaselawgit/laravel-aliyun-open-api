<?php
/**
 * Created by PhpStorm.
 * User: chaselaw
 * Date: 2018/7/7
 * Time: 下午5:02
 */

namespace ChaseLaw\AliyunOpenApi\Services;


use PHPUnit\Framework\TestCase;

class AliLiveServiceTest extends TestCase {

    /** @var AliLiveService  */
    private $service;
    private $transCodeIds = [
        'lsd','lhd','lud'
    ];
    public function setUp()
    {
        parent::setUp();
        $this->service = new AliLiveService($GLOBALS['LIVE_APP_NAME'],$GLOBALS['LIVE_CENTER_PUSH_HOST'],$GLOBALS['LIVE_VHOST'],$GLOBALS['LIVE_KEY'],$this->transCodeIds);
    }

    public function testGetPushUrlWithAuth()
    {
        $streamName = 'whatever';
        $url = $this->service->getPushUrlWithAuth($streamName,time(),uniqid());
        $this->assertContains($streamName,$url);
    }

    public function testGetPushUrl()
    {
        $streamName = 'whatever';
        $url = $this->service->getPushUrl($streamName);
        $this->assertContains($streamName,$url);
    }

    public function testGetAuthKey()
    {
        $time = (string) time();
        $authKey = $this->service->getAuthKey('whatever',$time,uniqid());
        $this->assertContains($time,$authKey);
    }
    public function testGetPlays(){
        $streamName = 'whatever';
        $plays = $this->service->getPlays($streamName,time(),uniqid(),0);
        $keys = $this->transCodeIds;
        $keys[] = 'original';
        foreach ($keys as $key)
        {
            $this->assertArrayHasKey($key,$plays);
        }
    }
}
