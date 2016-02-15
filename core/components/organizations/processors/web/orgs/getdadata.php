<?php
/**
 * Get a getDadata
 */

$query = $_POST['query'];
$DaDataAPI = $modx->getOption('DaDataAPI');
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
