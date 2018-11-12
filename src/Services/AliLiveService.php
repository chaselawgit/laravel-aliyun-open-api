<?php
/**
 * Created by PhpStorm.
 * User: chaselaw
 * Date: 2018/7/7
 * Time: 下午4:06
 */

namespace ChaseLaw\AliyunOpenApi\Services;

use Illuminate\Support\Collection;

class AliLiveService {

    private $key;
    private $appName;
    private $centerPushHost;
    private $vhost;
    /**
     * @var array
     */
    private $transCodeIds;
    /**
     * @var Collection
     */
    private $collection;

    /**
     * AliLiveSigner constructor.
     * @param $appName
     * @param $centerPushHost
     * @param $vhost
     * @param $key
     * @param array $transCodeIds
     * @param Collection $collection
     */
    public function __construct($appName,$centerPushHost,$vhost,$key,$transCodeIds=[],Collection $collection)
    {
        $this->key = $key;
        $this->appName = $appName;
        $this->centerPushHost = $centerPushHost;
        $this->vhost = $vhost;
        $this->transCodeIds = $transCodeIds;
        $this->collection = $collection;
    }
    private function getUri($streamName){
        return '/'.$this->appName.'/'.$streamName;
    }
    public function getPushUrl($streamName){
        return $this->centerPushHost.$this->getUri($streamName).'?vhost='.$this->vhost;
    }
    public function getPushUrlWithAuth($streamName,$timestamp,$rand){
        return implode('',$this->getPushUrlArray($streamName,$timestamp,$rand));
    }
    public function getPushUrlArray($streamName,$timestamp,$rand){
        $url = $this->centerPushHost.'/'.$this->appName.'/';
        $streamKey = $streamName.'?vhost='.$this->vhost.'&auth_key='.$this->getAuthKey($this->getUri($streamName),$timestamp,$rand);
        return [
            'url' => $url,
            'stream_key' => $streamKey
        ];
    }
    public function getAuthKey($uri,$timestamp,$rand,$uid=0){
        $string = $uri.'-'.$timestamp.'-'.$rand.'-'.$uid.'-'.$this->key;
        return $timestamp.'-'.$rand.'-'.$uid.'-'.md5($string);
    }
    private function createPlayUrl($streamName){

    }
    public function createRtmpUrl($id=null,$streamName,$timestamp,$rand,$uid=0){
        $uri = $this->getUri($streamName);
        if( $id ){
            $uri .= '_'.$id;
        }
        return 'rtmp://'.$this->vhost.$uri.'?auth_key='.$this->getAuthKey($uri,$timestamp,$rand,$uid);
    }
    public function createFlvUrl($id=null,$streamName,$timestamp,$rand,$uid=0){
        $uri = $this->getUri($streamName);
        if( $id ){
            $uri .= '_'.$id;
        }
        $uri .= '.flv';
        return 'http://'.$this->vhost.$uri.'?auth_key='.$this->getAuthKey($uri,$timestamp,$rand,$uid);
    }
    public function createM3u8Url($id=null,$streamName,$timestamp,$rand,$uid=0){
        $uri = $this->getUri($streamName);
        $uri .= '.m3u8';
        return 'http://'.$this->vhost.$uri.'?auth_key='.$this->getAuthKey($uri,$timestamp,$rand,$uid);
    }
    public function getPlays($streamName,$timestamp,$rand,$uid=0){
        $ids = $this->transCodeIds;
        $playList = [];
        foreach ($ids as $id){
            $playList[] = [
                'PlayURL' => $this->createRtmpUrl($id,$streamName,$timestamp,$rand,$uid),
                'Format' => 'RTMP',
                'Definition' => $id
            ];
            $playList[] = [
                'PlayURL' => $this->createFlvUrl($id,$streamName,$timestamp,$rand,$uid),
                'Format' => 'FLV',
                'Definition' => $id
            ];
            $playList[] = [
                'PlayURL' => $this->createM3u8Url($id,$streamName,$timestamp,$rand,$uid),
                'Format' => 'M3U8',
                'Definition' => $id
            ];
        }
        $playList[] = [
            'PlayURL' => $this->createRtmpUrl(null,$streamName,$timestamp,$rand,$uid),
            'Format' => 'RTMP',
            'Definition' => 'original'
        ];
        $playList[] = [
            'PlayURL' => $this->createFlvUrl(null,$streamName,$timestamp,$rand,$uid),
            'Format' => 'FLV',
            'Definition' => 'original'
        ];
        $playList[] = [
            'PlayURL' => $this->createM3u8Url(null,$streamName,$timestamp,$rand,$uid),
            'Format' => 'M3U8',
            'Definition' => 'original'
        ];
        return $this->collection::make($playList);
    }
}