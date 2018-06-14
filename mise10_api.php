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

$pm10_value=$result['body']['items']['item']['0']['pm10Value'];
print_r($pm10_value);
echo '/';

$pm10_grade=$result['body']['items']['item']['0']['pm10Grade'];
$pm10=print_r($pm10_grade, true);

if($pm10 == '1')
    echo '좋음';
if($pm10 == '2')
    echo '보통';
if($pm10 == '3')
    echo '나쁨';
if($pm10 == '4')
    echo '매우나쁨';
?>