<?php
//接收微信发送的数据
$postXml=file_get_contents('php://input');
//把消息生成xml文件
file_put_contents('postXML.xml',$postXml);
//解析xml数据
$xml=simplexml_load_string($postXml);
$data=[];
foreach ($xml as $key=>$value){
    $data[$key]=(string)$value;
}
extract($data);
//加载天气
$tq=simplexml_load_file('./tq.xml');
//var_dump($tq);exit;
//获取所有城市天气节点
$weathers=$tq->city;
$ss=$Content;
$Content='城市名输入错误,查询失败';
foreach ($weathers as $city){
//            var_dump($city);exit;
    if ($city['centername']==$ss){
        $Content=$city['centername'].'-----'.$city['stateDetailed'];
        break;
    }
}
require './text.xml';