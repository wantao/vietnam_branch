<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'common_func.php';

ini_set('memory_limit','1024M');

class Detail extends CI_Controller {
	var $CURRENT_PAGE = "各服明细";
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
		$data['area_list'] = (isset($params["area_list"]) ? $params["area_list"] : $this->common_model->add_selected_key_for_arealist($this->common_model->get_arealist()));
		
		
		$date = date('Y-m-d',time());
		$data["date"] = $date;
		
		$data['start_date'] = (isset($params["start_date"]) ? $params["start_date"] : $date);
		$data['end_date'] = (isset($params["end_date"]) ? $params["end_date"] : $date); 
		$data['end_date'] = limit_end_date_and_start_date_in_the_same_month($data['start_date'],$data['end_date'],"");
		
		$data["result"] = (isset($params["result"]) ? $params["result"] : array());
		
		$this->load->view("templates/header", $data);
		$this->load->view("detail/detail_show", $data);
		$this->load->view("templates/footer");
	}
	
	public function execute($area_id, $start_date, $end_date){
		$area_id = $this->_getParam($area_id);
		$start_date = $this->_getParam($start_date);
		$end_date = $this->_getParam($end_date);
		if (!is_numeric($area_id)) {
			exit;
		}
		$end_date = limit_end_date_and_start_date_in_the_same_month($start_date,$end_date,"");
		 
		if(!$this->common_model->check_string_date($start_date) || !$this->common_model->check_string_date($end_date)){
			echo "输入错误";
			return;
		}
		$result = array();
		
		
		$start_timestamp = strtotime($start_date);
		$end_timestamp = strtotime($end_date);
		
		//遍历之间的每一天，包括选择的开始日期当天和结束日期当天
		for($timestamp = $start_timestamp; $timestamp <= $end_timestamp; $timestamp += 86400){
			$date = date('Y-m-d', $timestamp);
			$row = $this->_get_format_result($area_id, $date);
			array_push($result, $row);
		}
		$this->show(array(
			"result" => $result,
			"start_date" => $start_date,
			"end_date" => $end_date,
			"area_list" => $this->common_model->set_selected_flag_for_arealist($area_id,$this->common_model->get_arealist()),
		));
	}
	public function execute1($area_id, $start_date, $end_date){
		$area_id = $this->_getParam($area_id);
		$start_date = $this->_getParam($start_date);
		$end_date = $this->_getParam($end_date);
		if (!is_numeric($area_id)) {
			exit;
		}
		$end_date = limit_end_date_and_start_date_in_the_same_month($start_date,$end_date,"");
		 
		if(!$this->common_model->check_string_date($start_date) || !$this->common_model->check_string_date($end_date)){
			echo "输入错误";
			return;
		}
		$result = $this->_get_format_result_range($area_id, $start_date, $end_date);
		$this->show(array(
			"result" => $result,
			"start_date" => $start_date,
			"end_date" => $end_date,
			"area_list" => $this->common_model->set_selected_flag_for_arealist($area_id,$this->common_model->get_arealist()),
		));
	}
	
	public function execute_reset($area_id, $start_date, $end_date){
		$this->show(array(
			"result" => array(),
			"start_date" => '2014-10-01',
			"end_date" => date('Y-m-d'),
		));
	}
	
	public function execute_export($area_id, $start_date, $end_date){
		$area_id = $this->_getParam($area_id);
		$start_date = $this->_getParam($start_date);
		$end_date = $this->_getParam($end_date);
		if (!is_numeric($area_id)) {
			exit;
		}
		$end_date = limit_end_date_and_start_date_in_the_same_month($start_date,$end_date,"");
		 
		if(!$this->common_model->check_string_date($start_date) || !$this->common_model->check_string_date($end_date)){
			echo "输入错误";
			return;
		}
		$result = $this->_get_format_result_range($area_id, $start_date, $end_date);
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
			$objPHPExcel->getActiveSheet()->SetCellValue('G1', '各服明细');
			$objPHPExcel->getActiveSheet()->SetCellValue('A2', '区号：');
			$objPHPExcel->getActiveSheet()->SetCellValue('B2', $area_id);
			$objPHPExcel->getActiveSheet()->SetCellValue('A3', '时间从');
			$objPHPExcel->getActiveSheet()->SetCellValue('B3', $start_date);
			$objPHPExcel->getActiveSheet()->SetCellValue('C3', '到');
			$objPHPExcel->getActiveSheet()->SetCellValue('D3', $end_date);
			
			$objPHPExcel->getActiveSheet()->SetCellValue('B4', '日期');
			$objPHPExcel->getActiveSheet()->SetCellValue('C4', 'DNU');
			$objPHPExcel->getActiveSheet()->SetCellValue('D4', 'DAU');
			$objPHPExcel->getActiveSheet()->SetCellValue('E4', '最高同时在线人数');
			$objPHPExcel->getActiveSheet()->SetCellValue('F4', '充值人数');
			$objPHPExcel->getActiveSheet()->SetCellValue('G4', '充值次数');
			$objPHPExcel->getActiveSheet()->SetCellValue('H4', '充值总额');
			$objPHPExcel->getActiveSheet()->SetCellValue('I4', 'ARPRU');
			$objPHPExcel->getActiveSheet()->SetCellValue('J4', 'ARPPU');
			$objPHPExcel->getActiveSheet()->SetCellValue('K4', '新手无操作率');
			
			$objPHPExcel->getActiveSheet()->setTitle('detail');
			
			$i = 5;
			foreach($result as $row){
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $row["date"]);
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $row["DNU"]);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $row["DAU"]);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, $row["max_online"]);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, $row["charge_player_count"]);
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$i, $row["charge_times"]);
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$i, $row["charge_money"]);
				$objPHPExcel->getActiveSheet()->SetCellValue('I'.$i, $row["ARPRU"]);
				$objPHPExcel->getActiveSheet()->SetCellValue('J'.$i, $row["ARPPU"]);
				$objPHPExcel->getActiveSheet()->SetCellValue('K'.$i, $row["no_game_rate"]);
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
		    $xls_name = $area_id.'区_detail_'.$start_date.'-'.$end_date.'.xls';
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
	
	public function _getParam($param){
		$this->load->model("common_model");
		return $this->common_model->deprefix($param);
	}
	private function _get_format_result($area_id, $date){
		$this->load->model("detail_model");
		
		$dnu = $this->detail_model->get_dnu($area_id, $date);
		$dau = $this->detail_model->get_dau($area_id, $date);
		$max_online = $this->detail_model->get_max_player_count($area_id, $date);
		$_charge_info = $this->detail_model->get_charge_info($area_id, $date);
		$charge_player_count = $_charge_info->player;
		$charge_times = $_charge_info->times;
		$charge_money = (is_null($_charge_info->money) ? 0 : $_charge_info->money);
		$arpru = ($dau == 0 ? 0 : $charge_money / $dau);
		$arppu = ($charge_player_count == 0 ? 0 : $charge_money / $charge_player_count);
		$_playing_player = $this->detail_model->get_exp_changed_new_player_count($area_id, $date);
		$new_player_no_playing_rate = ($dnu == 0 ? 0 : $dnu - $_playing_player / $dnu);
		
		$charge_money_frt = number_format($charge_money,2,'.',',');
		return array(
			"date" => $date,
			"DNU" => $dnu,
			"DAU" => $dau,
			"max_online" => $max_online,
			"charge_player_count" => $charge_player_count,
			"charge_times" => $charge_times,
			"charge_money" => $charge_money_frt,
			"ARPRU" => $arpru,
			"ARPPU" => $arppu,
			"no_game_rate" => $new_player_no_playing_rate 
		);
	}
	private function _get_format_result_range($area_id, $start_date, $end_date){
		$this->load->model("detail_model");
		$_dnu_range = $this->detail_model->get_dnu_range($area_id, $start_date, $end_date);
		//result: (digitid, create_time)
		$_dnu_map = $this->detail_model->get_dnu_map($_dnu_range);
		
		$_dau_range = $this->detail_model->get_dau_range($area_id, $start_date, $end_date);
		//result: (digitid, today_first_login_time)
		$_dau_map = $this->detail_model->get_dau_map($_dau_range);
		
		$_max_online_range = $this->detail_model->get_max_player_range($area_id, $start_date, $end_date);
		//result: (playernumber, logtime)
		$_max_online_map = $this->detail_model->get_max_player_map($_max_online_range);
		
		$_charge_info_range = $this->detail_model->get_charge_info_range($area_id, $start_date, $end_date);
		//result: (playerid, money, activetime) sorted by playerid
		$_charge_player_map = $this->detail_model->get_charge_player_map($_charge_info_range);
		$_charge_times_map = $this->detail_model->get_charge_times_map($_charge_info_range);
		$_charge_money_map = $this->detail_model->get_charge_money_map($_charge_info_range);
		
		$_playing_player = $this->detail_model->get_exp_changed_new_player_range($area_id, $start_date, $end_date);
		//result: (digitid, activetime)
		$_real_player_map = $this->detail_model->get_real_new_player_map($_playing_player);
		
		
		$start_timestamp = strtotime($start_date);
		$end_timestamp = strtotime($end_date);
		
		$result = array();
		//遍历之间的每一天，包括选择的开始日期当天和结束日期当天
		for($timestamp = $end_timestamp; $timestamp >= $start_timestamp; $timestamp -= 86400){
			$date = date('Y-m-d', $timestamp);
			$dnu = isset($_dnu_map[$date]) ? $_dnu_map[$date] : 0;
			$dau = isset($_dau_map[$date]) ? $_dau_map[$date] : 0;
			$max_online = isset($_max_online_map[$date]) ? $_max_online_map[$date] : 0;
			$charge_player = isset($_charge_player_map[$date]) ? $_charge_player_map[$date] : 0;
			$charge_times = isset($_charge_times_map[$date]) ? $_charge_times_map[$date] : 0;
			$charge_money = isset($_charge_money_map[$date]) ? $_charge_money_map[$date] : 0;
			$arpru = ($dau == 0 ? 0 : $charge_money / $dau);
			$arppu = ($charge_player == 0 ? 0 : $charge_money / $charge_player);
			$new_player_no_playing_rate = ($dnu == 0 ? 0 : ($dnu - (isset($_real_player_map[$date]) ? $_real_player_map[$date] : 0)) / $dnu);
			
			$charge_money_frt = number_format($charge_money,2,'.',',');
			$result_oneday = array(
				"date" => $date,
				"DNU" => $dnu,
				"DAU" => $dau,
				"max_online" => $max_online,
				"charge_player_count" => $charge_player,
				"charge_times" => $charge_times,
				"charge_money" => $charge_money_frt,
				"ARPRU" => $arpru,
				"ARPPU" => $arppu,
				"no_game_rate" => $new_player_no_playing_rate 
			);
			array_push($result, $result_oneday);
		}
		return $result;
	}
}
?>