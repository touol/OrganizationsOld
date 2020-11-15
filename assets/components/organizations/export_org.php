<?php
if (!defined('MODX_API_MODE')) {
    define('MODX_API_MODE', false);
}

include(dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php');
if (!defined('MODX_CORE_PATH')) define('MODX_CORE_PATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/core/');

include_once (MODX_CORE_PATH . "model/modx/modx.class.php");
$modx = new modX();
$modx->initialize('mgr');

//проверка доступа
$access = false;
if($modx->user->id){
	if($modx->user->isAuthenticated('mgr')){
		$access = true;
	}
}
if(!$access){
	header('Content-Type: text/html; charset=utf-8');
	echo "Нет доступа!"; exit;
}
$modx->addPackage('organizations', $modx->getOption('core_path') . 'components/organizations/model/');
//проверка пользователя
$query = $_GET['query'];

	$c = $modx->newQuery('Orgs');
	$c->leftJoin('modUser','modUser', '`Orgs`.`manager_id` = `modUser`.`id`');
	$Columns = $modx->getSelectColumns('Orgs', 'Orgs', '', array(), true);
	$c->select($Columns . ', `modUser`.`username` as `manager`');
	if ($query) {
		$c->where(array(
			'`Orgs`.`shortname`:LIKE' => "%{$query}%",
			'OR:`modUser`.`username`:LIKE' => "%{$query}%",
			'OR:`Orgs`.`inn`:LIKE' => "%{$query}%",
			'OR:`Orgs`.`discount`:LIKE' => "%{$query}%",
		));
	}
	$c->sortby('id','DESC');
	/* $c->prepare();
		echo $c->toSQL();
		exit; */
	$records = $modx->getIterator('Orgs',$c);
	$start_str = 2;
	require_once ('PHPExcel/IOFactory.php');
	// Открываем файл
	$xls = PHPExcel_IOFactory::load('org.xls');
	// Устанавливаем индекс активного листа
	$xls->setActiveSheetIndex(0);
	// Получаем активный лист
	$sheet = $xls->getActiveSheet();
	foreach ($records as $key => $row) {
		//print_r($row);exit;
		$str_num=$start_str+$key;
		
		$sheet->setCellValue('B'.$str_num, $row->urlico); //Юрлицо
		$sheet->setCellValue('C'.$str_num, $row->id); //id
		$sheet->setCellValue('D'.$str_num, $row->shortname); //shortname
		$sheet->setCellValue('E'.$str_num, $row->longname); //longname
		$sheet->setCellValue('F'.$str_num, $row->inn); //inn
		$sheet->setCellValue('G'.$str_num, $row->email); //email
		$sheet->setCellValue('H'.$str_num, $row->discount); //discount
		$sheet->setCellValue('I'.$str_num, $row->manager); //manager
	}
	$excel_name = "org";
	// Выводим HTTP-заголовки
	 header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT" );
	 header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
	 header ( "Cache-Control: no-cache, must-revalidate" );
	 header ( "Pragma: no-cache" );
	 header ( "Content-type: application/vnd.ms-excel;charset=utf-8;" );
	 header ( "Content-Disposition: attachment; filename=$excel_name.xls" );

	// Выводим содержимое файла
	 $objWriter = new PHPExcel_Writer_Excel5($xls);
	 $objWriter->save('php://output');
	 echo "<script>window.close;</script>";
?>