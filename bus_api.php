<?php
/**
* bus_api.php
* Created: Tuesday, Feb 13, 2018
* 
* Juneyoung KANG <juneyoungdev@gmail.com>
* Gyoha High School
*
* Bus arrivial service API for GHHS Siri (specific bus)
* Github : https://github.com/Juneyoung-Kang/ghhs-siri-kakao/
*
* 버스도착정보 항목조회
*
* serviceKey(발급받은 키 값), stationId(정류소ID), routeId(노선ID)
*
* busArrivalItem(버스도착정보항목), stationId(정류소ID), routeId(노선ID), 
* locationNo1(첫번째 차량 위치 정보_WGS84 좌표), predictTime1(첫번째 차량 도착 예상시간),
* lowPlate1(첫번째 차량 저상버스 여부_0:일반버스_1:저상버스), plateNo1(첫번째 차량 차량번호), 
* remainSeatCnt1(첫번째 차량 빈자리 수_-1:정보없음_0~:빈자리 수), delayYn1(첫번째 차량 회차점 대기중 여부)
*
* 경기버스정보 http://www.gbis.go.kr, 공공데이터포털 https://www.data.go.kr 제공 API 사용
*
* Endpoint : http://openapi.gbis.go.kr/ws/rest/busarrivalservice
*
* 숲속길마을7단지(sm): 229000849 >> 1500 200 9030 9030-1 66 70 80 77-1 77-2 77-3 5600
* 트리플메디컬타운(tm): 229000856 >> 1500 200 9030 9030-1 66 70 80 77-1 77-2 77-3 5600
* 교하중앙공원(금촌방면)(cpp): 229000857 >> 200 70 77-1
* 교하중앙공원(일산방면)(cpi): 229000848 >> 200 70 77-1
* 책향기마을10-11단지(운정방면)(cmu): 229001342 >> 80
* 책향기마을10-11단지(교하/금촌방면)(cmg): 229001344 >> 80
* 
* 1500번: 218000010 / 200번: 229000028 / 9030번: 229000097 / 9030-1번: 229000083 / 66번: 229000018
* 70번: 229000034 / 80번: 229000020 / 77-1번: 229000116 / 77-2번: 229000117 / 77-3번: 229000118 / 5600번: 241006050
*
* 마을버스 미지원
*/
$route = $_GET['route'];          
$station =  $_GET['station'];         

$serviceKey="SERVICE_KEY";
$endpoint="http://openapi.gbis.go.kr/ws/rest/busarrivalservice";

switch($route){
    case "1500": $routeCode="218000010"; break;
    case "200": $routeCode="229000028"; break;
    case "9030": $routeCode="229000097"; break;
    case "9030_1": $routeCode="229000083"; break;
    case "66": $routeCode="229000018"; break;
    case "70": $routeCode="229000034"; break;
    case "80": $routeCode="229000020"; break;
    case "77_1": $routeCode="229000116"; break;
    case "77_2": $routeCode="229000117"; break;
    case "77_3": $routeCode="229000118"; break;
    case "5600": $routeCode="241006050"; break;
}

switch($station){
    case "sm": $stationCode="229000849"; break;
    case "tm": $stationCode="229000856"; break;
    case "cpp": $stationCode="229000857"; break;
    case "cpi": $stationCode="229000848"; break;
    case "cmu": $stationCode="229001342"; break;
    case "cmg": $stationCode="229001344"; break;
}

$url=$endpoint . "?serviceKey=" . $serviceKey . "&routeId=" . $routeCode . "&stationId=" . $stationCode;

$html=file_get_contents($url);
$xml=simplexml_load_string($html);

$json=json_encode($xml, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
$result=json_decode($json, true);

$first=$result['msgBody']['busArrivalItem']['predictTime1'];
$second=$result['msgBody']['busArrivalItem']['predictTime2'];

if($first > 1 && $first < 4){
    if($second != null){
        echo '잠시후 '.$route.'번 버스가 도착합니다. 다음 '.$route.'번 버스는 '.$second.'분 후에 도착합니다.';
    }else{
        echo '잠시후 '.$route.'번 버스가 도착합니다. 다음 '.$route.'번 버스의 정보는 없습니다.';
    }   
}

if($first == 1){
    if($second != null){
        echo '지금 '.$route.'번 버스가 도착합니다. 다음 '.$route.'번 버스는 '.$second.'분 후에 도착합니다.';
    }else{
        echo '지금 '.$route.'번 버스가 도착합니다. 다음 '.$route.'번 버스의 도착정보는 없습니다.';
    }   
}

if($first >= 4){
    if($second != null){
        echo $first.'분 후에 '.$route.'번 버스가 도착합니다. 다음 '.$route.'번 버스는 '.$second.'분 후에 도착합니다.';
    }else{
        echo $first.'분 후에 '.$route.'번 버스가 도착합니다. 다음 '.$route.'번 버스의 정보는 없습니다.';
    }
}

if($first == null){
    echo $route.'번 버스의 도착정보가 없습니다.';
}
?>