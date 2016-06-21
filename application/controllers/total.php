<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'common_func.php';

ini_set('memory_limit','1024M');

class Total extends CI_Controller {
	var $CURRENT_PAGE = "各服汇总";
	var $GM_LEVEL = "-1";
	public function show($params = array()){
		$this->load->library('session');
		$logged_in = $this->session->userdata('logged_in');
		if($logged_in == false){
			$this->load->view("main/main_not_logged");
			return;
		}
		$gm_level = $this->session->userdata('gm_level');
		$this->load->model('main_model');
		$pages = $this->main_model->get_pages($gm_level);
		if(!isset($pages)){
			$this->load->view("main/main_not_enough_level");
			$this->load->view("templates/footer");
			return;
		}
		
		$data['current_page'] = $this->CURRENT_PAGE;
		$data['pages'] = $pages;
		
		$uri_string = $this->session->CI->uri->segments[1];
		if (!is_sub_url_string($data['pages'],$uri_string)) {
			$this->load->view("main/main_not_enough_level");
			$this->load->view("templates/footer");
			return;	
		}
		
		$this->load->model("common_model");
		$area_list = $this->common_model->get_arealist();
		$data['area_list'] = $area_list;
		
		
		$date = date('Y-m-d',time());
		
		$data['start_date'] = (isset($params["start_date"]) ? $params["start_date"] : $date);
		$data['end_date'] = (isset($params["end_date"]) ? $params["end_date"] : $date); 
		
		$data["result"] = (isset($params["result"]) ? $params["result"] : array());
		
		$this->load->view("templates/header", $data);
		$this->load->view("total/total_show", $data);
		$this->load->view("templates/footer");
	}
	
	public function execute($start_date, $end_date){
		
		$start_date = $this->_getParam($start_date);
		$end_date = $this->_getParam($end_date);
		 
		if(!$this->common_model->check_string_date($start_date) || !$this->common_model->check_string_date($end_date)){
			echo "输入错误";
			return;
		}
		$this->load->model("common_model");
		$area_list = $this->common_model->get_arealist();
		$total_days = $this->common_model->get_days($start_date, $end_date);
		if($total_days <= 0){
			echo "date input error";
			return;
		}
		$this->load->model("total_model");
		$result = array();
		foreach($area_list as $area){
			$row = array();
			$area_id = $area->id;
			$total_player = $this->total_model->get_total_player_number($area_id); 
			$max_online = $this->total_model->get_max_online_player_number($area_id, $start_date, $end_date);
			$_charge_info = $this->total_model->get_charge_info($area_id, $start_date, $end_date);
			$charge_player = $_charge_info->total_player;
			$charge_times = $_charge_info->total_times;
			$charge_money = $_charge_info->total_money;
			$charge_money_frt = number_format($charge_money,2,'.',',');
			$charge_money_per_day = $charge_money / $total_days;
			$charge_money_per_day_frt = number_format($charge_money_per_day,2,'.',',');
			$_info_per_day = $this->_get_info_per_day($area_id, $start_date, $end_date);
			$arpru_per_day = $_info_per_day["ARPRU"];
			$arppu_per_day = $_info_per_day["ARPPU"];
			$pr_per_day = $_info_per_day["PR"];
			$result_onearea = array(
				"area_id" => $area_id,
				"player_count" => $total_player,
				"max_online" => $max_online, 
				"charge_player" => $charge_player,
				"charge_times" => $charge_times,
				"charge_money" => $charge_money_frt,
				"charge_money_per_day" => $charge_money_per_day_frt,
				"arpru_per_day" => $arpru_per_day,
				"arppu_per_day" => $arppu_per_day,
				"pr_per_day" => $pr_per_day
			);
			array_push($result, $result_onearea);
		}
		$this->show(array(
			"result" => $result,
			"start_date" => $start_date,
			"end_date" => $end_date,
		));
		//$this->output->enable_profiler(TRUE);
	}
	
	public function execute_reset($start_date, $end_date){
		$this->show(array(
			"result" => array(),
			"start_date" => "2014-10-01",
			"end_date" => date("Y-m-d"),
		));	
	}
	
public function execute_export($start_date, $end_date){
		
		$start_date = $this->_getParam($start_date);
		$end_date = $this->_getParam($end_date);
		 
		if(!$this->common_model->check_string_date($start_date) || !$this->common_model->check_string_date($end_date)){
			echo "输入错误";
			return;
		}
		$this->load->model("common_model");
		$area_list = $this->common_model->get_arealist();
		$total_days = $this->common_model->get_days($start_date, $end_date);
		if($total_days <= 0){
			echo "日期错误";
			return;
		}
		$this->load->model("total_model");
		$result = array();
		foreach($area_list as $area){
			$row = array();
			$area_id = $area->id;
			$total_player = $this->total_model->get_total_player_number($area_id); 
			$max_online = $this->total_model->get_max_online_player_number($area_id, $start_date, $end_date);
			$_charge_info = $this->total_model->get_charge_info($area_id, $start_date, $end_date);
			$charge_player = $_charge_info->total_player;
			$charge_times = $_charge_info->total_times;
			$charge_money = $_charge_info->total_money;
			$charge_money_per_day = $charge_money / $total_days;
			$_info_per_day = $this->_get_info_per_day($area_id, $start_date, $end_date);
			$arpru_per_day = $_info_per_day["ARPRU"];
			$arppu_per_day = $_info_per_day["ARPPU"];
			$pr_per_day = $_info_per_day["PR"];;
			$result_onearea = array(
				"area_id" => $area_id,
				"player_count" => $total_player,
				"max_online" => $max_online, 
				"charge_player" => $charge_player,
				"charge_times" => $charge_times,
				"charge_money" => $charge_money,
				"charge_money_per_day" => $charge_money_per_day,
				"arpru_per_day" => $arpru_per_day,
				"arppu_per_day" => $arppu_per_day,
				"pr_per_day" => $pr_per_day
			);
			array_push($result, $result_onearea);
		}
		$this->show(array(
			"result" => $result,
			"start_date" => $start_date,
			"end_date" => $end_date,
		));
		
		if (count($result) > 0) {
		//导出到文件
			/** Error reporting */
			error_reporting(E_ALL);
			
			require_once 'PHPExcel_1.8.0_doc/Classes/PHPExcel.php';
			require_once 'PHPExcel_1.8.0_doc/Classes/PHPExcel/Writer/Excel2007.php';
			
			
			// Create new PHPExcel object
			//echo date('H:i:s') . " Create new PHPExcel object\n";
			$objPHPExcel = new PHPExcel();
			
			// Set properties
			//echo date('H:i:s') . " Set properties\n";
			$objPHPExcel->getProperties()->setCreator("Maarten Balliauw");
			$objPHPExcel->getProperties()->setLastModifiedBy("Maarten Balliauw");
			$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
			$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
			$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
			
			
			// Add some data
			//echo date('H:i:s') . " Add some data\n";
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->SetCellValue('G1', '各服汇总');
			$objPHPExcel->getActiveSheet()->SetCellValue('A2', '时间从');
			$objPHPExcel->getActiveSheet()->SetCellValue('B2', $start_date);
			$objPHPExcel->getActiveSheet()->SetCellValue('D2', '到');
			$objPHPExcel->getActiveSheet()->SetCellValue('E2', $end_date);
			
			$objPHPExcel->getActiveSheet()->SetCellValue('B3', '服务器');
			$objPHPExcel->getActiveSheet()->SetCellValue('C3', '角色总数');
			$objPHPExcel->getActiveSheet()->SetCellValue('D3', '最高同时在线');
			$objPHPExcel->getActiveSheet()->SetCellValue('E3', '充值人数');
			$objPHPExcel->getActiveSheet()->SetCellValue('F3', '充值次数');
			$objPHPExcel->getActiveSheet()->SetCellValue('G3', '充值总额');
			$objPHPExcel->getActiveSheet()->SetCellValue('H3', '平均日充值金额');
			$objPHPExcel->getActiveSheet()->SetCellValue('I3', '平均日ARPRU');
			$objPHPExcel->getActiveSheet()->SetCellValue('J3', '平均日ARPPU');
			$objPHPExcel->getActiveSheet()->SetCellValue('K3', '平均日PR');
			
			$objPHPExcel->getActiveSheet()->setTitle('total');
			
			$i = 4;
			foreach($result as $row){
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $row["area_id"]);
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $row["player_count"]);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $row["max_online"]);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, $row["charge_player"]);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, $row["charge_times"]);
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$i, $row["charge_money"]);
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$i, $row["charge_money_per_day"]);
				$objPHPExcel->getActiveSheet()->SetCellValue('I'.$i, $row["arpru_per_day"]);
				$objPHPExcel->getActiveSheet()->SetCellValue('J'.$i, $row["arppu_per_day"]);
				$objPHPExcel->getActiveSheet()->SetCellValue('K'.$i, $row["pr_per_day"]);
				++$i;
			}
					
			// Save Excel 2007 file
			//echo date('H:i:s') . " Write to Excel2007 format\n";
			$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			$file_name = str_replace('.php', '.xlsx', __FILE__);
			$objWriter->save($file_name);
			
			header("Pragma: public");
		    header("Expires: 0");
		    header("Cache-Control:must-revalidate,post-check=0,pre-check=0");
		    header("Content-Type:application/force-download");
		    header("Content-Type:application/vnd.ms-execl");
		    header("Content-Type:application/octet-stream");
		    header("Content-Type:application/download");
		    $xls_name = 'total_'.$start_date.'-'.$end_date.'.xls';
		    header("Content-Disposition:attachment;filename=".$xls_name);
		    header("Content-Transfer-Encoding:binary");
		    $filesize = filesize($file_name);
		    header( "Content-Length:   ".$filesize);
		    $data = file_get_contents($file_name);
		    echo $data;
	
		    if (file_exists($file_name)) {
			    if (unlink($file_name)) {
		      		echo "The file was deleted successfully.", "n";
		   		} else {
		      		echo "The specified file could not be deleted. Please try again.", "n";
		   		}	
		    }
		}	
	}
	
	private function _get_info_per_day($area_id, $start_date, $end_date){
		$this->load->model("common_model");
		$days = $this->common_model->get_days($start_date, $end_date);
		
		$this->load->model("detail_model");
		$_dau_range = $this->detail_model->get_dau_range($area_id, $start_date, $end_date);
		$_dau_map = $this->detail_model->get_dau_map($_dau_range);
		
		$_charge_info_range = $this->detail_model->get_charge_info_range($area_id, $start_date, $end_date);
		$_charge_player_map = $this->detail_model->get_charge_player_map($_charge_info_range);
		$_charge_money_map = $this->detail_model->get_charge_money_map($_charge_info_range);
		
		$start_timestamp = strtotime($start_date);
		$end_timestamp = strtotime($end_date);
		$total = array("ARPRU" => 0, "ARPPU" => 0, "PR" => 0);
		for($timestamp = $start_timestamp; $timestamp <= $end_timestamp; $timestamp += 86400){
			$_date = date('Y-m-d', $timestamp);
			$_dau = isset($_dau_map[$_date]) ? $_dau_map[$_date] : 0;
			$_charge_player = isset($_charge_player_map[$_date]) ? $_charge_player_map[$_date] : 0;
			$_charge_money = isset($_charge_money_map[$_date]) ? $_charge_money_map[$_date] : 0;
			$arpru = ($_dau == 0 ? 0 : $_charge_money / $_dau);
			$arppu = ($_charge_player == 0 ? 0 : $_charge_money / $_charge_player);
			
			$pr = ($_dau == 0 ? 0 : $_charge_player / $_dau);
			$total["ARPRU"] += $arpru;
			$total["ARPPU"] += $arppu;
			$total["PR"] += $pr;
		}
		return array(
			"ARPRU" => $total["ARPRU"]/$days,
			"ARPPU" => $total["ARPPU"]/$days, 
			"PR" => $total["PR"]/$days,
		);
		
	}
	
	private function _getParam($param){
		$this->load->model("common_model");
		return $this->common_model->deprefix($param);
	}
}
?>