<?php
namespace app\index\controller;

class Query
{
    public function __construct(){
        ini_set("max_execution_time",1800);
        header("Content-Type: text/html;charset=utf-8"); 
        include '../extend/phpQuery/phpQuery.php';
    }
    public function getPolicy8btc(){
        for($i =0;$i<5;$i++){
            $eg1 = \phpQuery::newDocumentFile("https://www.8btc.com/news?cat_id=572");
            $time = json_encode(pq("#news>div:first>div:eq($i)>div>.article-item__body>.article-item__info>.article-item__author")->text());
            $pattern = '/^.*([0-9]{4}\-[0-9]{1,2}\-[0-9]{1,2}).*$/';
            preg_match($pattern,$time,$match);
            $time = $match[1];
            $url = pq("#news>div:first>div:eq($i)>div>.article-item__body>h3>a")->attr("href");
            $arr = explode('/',$url);
            $pattern = '/^.*' . end($arr) . '.*?image\":\"(.*?)\",\"images.*$/';
            $scriptContent = pq("script:first")->html();
            preg_match($pattern,$scriptContent,$match);
            $imageUrl = str_replace('\u002F','/',$match[1]);
            $introduce = pq("#news>div:first>div:eq($i)>div>.article-item__body>.article-item__content")->html();
            $url = 'https://www.8btc.com' . $url;
            $eg2 = \phpQuery::newDocumentFile($url);
            $title = pq("div[class='bbt-container']>h1")->text();
            $authorName = trim(pq("div[class='bbt-container']>.header__info>span:first>a")->text());
            $createTime = pq("div[class='bbt-container']>.header__info>span:first>time")->text();
            $hits = (int)pq("div[class='bbt-container']>.header__info>span:last")->text();
            $content = pq("div[class='bbt-html']")->html();
            echo $content;die;
        }
        
            
    }
}
