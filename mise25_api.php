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

$pm25_value=$result['body']['items']['item']['0']['pm25Value'];
print_r($pm25_value);
echo '/';

$pm25_grade=$result['body']['items']['item']['0']['pm25Grade'];
$pm25=print_r($pm25_grade, true);

if($pm25 == '1')
    echo '좋음';
if($pm25 == '2')
    echo '보통';
if($pm25 == '3')
    echo '나쁨';
if($pm25 == '4')
    echo '매우나쁨';
?>