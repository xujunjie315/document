<?php
namespace app\oss\controller;
use OSS\OssClient;
use OSS\Core\OssException;
use think\Log;
use think\Controller;

class Oss extends Controller
{
    private $ossClient;
    private $host;
    private $imagePath;
    public function __construct(){
        $this->host = 'a-static.finetech.top';
        $this->imagePath = '/wallet/oss/Oss/image';
        $accessKeyId = "xujunjieLTAI4Fp8dJg1AU9aGsbwz1AQ";
        $accessKeySecret = "xujunjieeOZyz0ABQ6lqLxkCPQL0ZRp1eJXDEm";
        $endpoint = "http://oss-cn-beijing.aliyuncs.com";
        
        try {
            $this->ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
        } catch (OssException $e) {
            Log::write('[' . __FILE__ . ':' . __LINE__ . '] ' . $e->getMessage(),'fatal');
            return json_encode(['data'=>false,'code'=>500,'message'=>$e->getMessage()]);
        }
    }
    public function test(){
        $bucket= "a-static";
        $object = "wallet/address/qr-code/2019/12/13/1576217180dbXWB.png";
        $filePath = "./static";
        $result = json_decode($this->download($bucket,$object,$filePath),true);
        print_r($result);die;
    }
    /**
     * 图片重定向
     * $data 图片加密地址
     */
    public function image(){
        $url = input('get.data');
        $url = $this->decode($url);
        header("content-type: image/png");
        $this->redirect($url,302);
    }
    /**
     * 创建oss空间
     * $bucket 空间名称
     */
    public function createBucket($bucket){
        try {
            if(!$this->ossClient->doesBucketExist($bucket)){
                $this->ossClient->createBucket($bucket);
                $acl = OssClient::OSS_ACL_TYPE_PRIVATE;
                $this->ossClient->putBucketAcl($bucket, $acl);
            }
        } catch (OssException $e) {
            Log::write('[' . __FILE__ . ':' . __LINE__ . '] ' . $e->getMessage(),'fatal');
            return json_encode(['data'=>false,'code'=>500,'message'=>$e->getMessage()]);
        }
        return json_encode(['data'=>true,'code'=>200,'message'=>'创建成功！']);
    }
    /**
     * 获取空间详情
     * $bucket 空间名称
     */
    public function getBucketInfo($bucket){
        try {
            //获取存储空间的访问权限
            $acls = $this->ossClient->getBucketAcl($bucket);
            //获取存储空间的地域
            $regions = $this->ossClient->getBucketLocation($bucket);
            //获取存储空间元信息
            $metas = $this->ossClient->getBucketMeta($bucket);
        } catch (OssException $e) {
            Log::write('[' . __FILE__ . ':' . __LINE__ . '] ' . $e->getMessage(),'fatal');
            return json_encode(['data'=>false,'code'=>500,'message'=>$e->getMessage()]);
        }
        return json_encode(['data'=>['acl'=>$acls,'region'=>$regions,'meta'=>$metas],'code'=>200,'message'=>'获取成功！']);
    }
    /**
     * 获取空间列表
     */
    public function getBucketList(){
        try {
            $bucketList = $this->ossClient->listBuckets()->getBucketList();
            $data = [];
            foreach($bucketList as $bucket) {
                $row['location'] = $bucket->getLocation();
                $row['name'] = $bucket->getName();
                $row['createdate'] = $bucket->getCreatedate();
                $data[] = $row;
            }
        } catch (OssException $e) {
            Log::write('[' . __FILE__ . ':' . __LINE__ . '] ' . $e->getMessage(),'fatal');
            return json_encode(['data'=>false,'code'=>500,'message'=>$e->getMessage()]);
        }
        return json_encode(['data'=>$data,'code'=>200,'message'=>'获取成功！']);
    }
    /**
     * 删除空间
     * $bucket 空间名称
     */
    public function deleteBucket($bucket){
        try {
            $this->ossClient->deleteBucket($bucket);
        } catch (OssException $e) {
            Log::write('[' . __FILE__ . ':' . __LINE__ . '] ' . $e->getMessage(),'fatal');
            return json_encode(['data'=>false,'code'=>500,'message'=>$e->getMessage()]);
        }
        return json_encode(['data'=>true,'code'=>200,'message'=>'删除成功！']);
    }
    /**
     * 字符串上传
     * $bucket 空间名称
     * $object oss存储path
     * $content 存储内容
     */
    public function stringUpload($bucket,$object,$content){
        try {
            $result = $this->ossClient->putObject($bucket, $object, $content);
        } catch (OssException $e) {
            Log::write('[' . __FILE__ . ':' . __LINE__ . '] ' . $e->getMessage(),'fatal');
            return json_encode(['data'=>false,'code'=>500,'message'=>$e->getMessage()]);
        }
        $urlInfo = parse_url($result['info']['url']);
        $url = 'http://' . $_SERVER['HTTP_HOST'] . $this->imagePath . '?data=' . $this->encode($urlInfo['scheme'] . '://' . $this->host . $urlInfo['path']);
        return json_encode(['data'=>['url'=>$url,'path'=>substr($urlInfo['path'],1)],'code'=>200,'message'=>'上传成功！']);
    }
    /**
     * 文件上传
     * $bucket 空间名称
     * $object oss存储path
     * $filePath 本地文件路径
     */
    public function fileUpload($bucket,$object,$filePath){
        try {
            $result = $this->ossClient->uploadFile($bucket, $object, $filePath);
        } catch (OssException $e) {
            Log::write('[' . __FILE__ . ':' . __LINE__ . '] ' . $e->getMessage(),'fatal');
            return json_encode(['data'=>false,'code'=>500,'message'=>$e->getMessage()]);
        }
        $urlInfo = parse_url($result['info']['url']);
        $url = 'http://' . $_SERVER['HTTP_HOST'] . $this->imagePath . '?data=' . $this->encode($urlInfo['scheme'] . '://' . $this->host . $urlInfo['path']);
        return json_encode(['data'=>['url'=>$url,'path'=>substr($urlInfo['path'],1)],'code'=>200,'message'=>'上传成功！']);
    }
    /**
     * 文件下载
     * $bucket 空间名称
     * $object oss存储path
     * $localfile 下载到本地存放路径
     */
    public function download($bucket,$object,$localfile){
        try {
            $options = array(
                OssClient::OSS_FILE_DOWNLOAD => $localfile
            );
            $this->ossClient->getObject($bucket, $object, $options);
        } catch (OssException $e) {
            Log::write('[' . __FILE__ . ':' . __LINE__ . '] ' . $e->getMessage(),'fatal');
            return json_encode(['data'=>false,'code'=>500,'message'=>$e->getMessage()]);
        }
        return json_encode(['data'=>true,'code'=>200,'message'=>'下载成功！']);
    }
    /**
     * 加密
     * $txt 被加密的内容
     */
    public function encode($txt){
        $key = 10;
        for($i=0;$i<strlen($txt);$i++){
            $txt[$i]=chr(ord($txt[$i])+$key);
        }
        return $txt=urlencode(base64_encode(urlencode($txt)));
    }
    /**
     * 解密
     * $txt 被解密的内容
     */
    public function decode($txt){
        $key = 10;
        $txt=urldecode(base64_decode($txt));
        for($i=0;$i<strlen($txt);$i++){
            $txt[$i]=chr(ord($txt[$i])-$key);
        }
        return $txt;
    }
}