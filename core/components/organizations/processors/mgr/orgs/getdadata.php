<?php
/**
 * Get a getDadata
 */

$query = $_POST['query'];
/* $test = array(
array('id'=>1,"value"=>"test1"),
array('id'=>2,"value"=>"test2"),	
array('id'=>3,"value"=>"test3"),
); */
$DaDataAPI = $modx->getOption('DaDataAPI');
/* curl -X POST \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Token e921277e7be62e99c07d6c0dd11561a5b686bfcc" \
  -d '{ "query": "сбербанк" }' \
  https://dadata.ru/api/v2/suggest/party */
$data = array(
    //"structure" => array("ADDRESS"),
    "query" => $query 
);
$options = array(
	'http' => array(
		'method'  => 'POST',
		'header'  => array(
			'Content-type: application/json',
			'Authorization: Token ' . $DaDataAPI,
			"Accept: application/json",
			//'X-Secret: ' . $this->secret
			),
		'content' => json_encode($data),
	),
);
$context = stream_context_create($options);
$suggest = $_POST['suggest'];
$url = "https://dadata.ru/api/v2/suggest/$suggest";  
$result = file_get_contents($url, false, $context);  
//echo $output;
$data = json_decode($result,true);
switch($suggest){
	case 'party':
		$firms = array();
		foreach($data['suggestions'] as $firm){
			$firm['search_value']= $firm['data']['inn'].' '.$firm['value'].' '.$firm['data']['address']['value'];
			$firms[] = $firm;
		}
		$data = $firms;
	break;
	case 'bank':
		//$firms = array();
		/* foreach($data['suggestions'] as $firm){
			$firm['search_value']= $firm['data']['inn'].' '.$firm['value'].' '.$firm['data']['address']['value'];
			$firms[] = $firm;
		} */
		$data = $data['suggestions'];
	break;
	case 'fio':
		$data = $data['suggestions'];
	break;
	case 'address':
		$data = $data['suggestions'];
	break;
	case 'email':
		$data = $data['suggestions'];
	break;
}
$count =count($data);
return '{"success":true,"message":"","total":"'.$count.'","results":'.$this->modx->toJSON($data).'}';
