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

require './text.xml';