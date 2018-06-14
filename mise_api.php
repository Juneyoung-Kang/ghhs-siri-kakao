<?php
$numOfRows = $_GET['numOfRows'];          
$pageNo =  $_GET['pageNo'];         
$stationName = $_GET['stationName'];    
$dataTerm = $_GET['dataTerm'];        
$ver =  $_GET['ver'];   

$serviceKey="SERVICE_KEY";
$endpoint="http://openapi.airkorea.or.kr/openapi/services/rest/ArpltnInforInqireSvc/getMsrstnAcctoRltmMesureDnsty";

$url=$endpoint . "?numOfRows=" . $numOfRows . "&dataTerm=". $dataTerm . "&pageNo=" . $pageNo . "&stationName=" . $stationName . "&ver=" . $ver . "&ServiceKey=" . $serviceKey;

$html=file_get_contents($url);
$xml=simplexml_load_string($html);

$json=json_encode($xml, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
$result=json_decode($json, true);

$khai_value=$result['body']['items']['item']['0']['khaiValue'];
print_r($khai_value);
echo '/';

$khai_grade=$result['body']['items']['item']['0']['khaiGrade'];
$khai=print_r($khai_grade, true);

if($khai == '1')
    echo '좋음';
if($khai == '2')
    echo '보통';
if($khai == '3')
    echo '나쁨';
if($khai == '4')
    echo '매우나쁨';
?>