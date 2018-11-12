<?php
/**
 * Created by PhpStorm.
 * User: chaselaw
 * Date: 2018/5/28
 * Time: 下午2:07
 */

namespace ChaseLaw\OssWebUploader\Services;


use ChaseLaw\AliyunOpenApi\Services\AliyunOpenApi;
use live\Request\V20161101\DescribeLiveStreamsBlockListRequest;
use PHPUnit\Framework\TestCase;


class AliyunOpenApiTest extends TestCase
{
    public function testTest(){
        $api = AliyunOpenApi::create($GLOBALS['REGION_ID'],$GLOBALS['ACCESS_KEY_ID'],$GLOBALS['ACCESS_SECRET']);
        $request = new DescribeLiveStreamsBlockListRequest();
        $request->setMethod("GET");
        $request->setDomainName('live.masterloo.top');
        $response = $api->getAcsResponse($request);
        $this->assertInstanceOf(\stdClass::class,$response);
    }
}
