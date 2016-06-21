<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'common_func.php';
class Charge extends CI_Controller {
	var $CURRENT_PAGE = "充值记录";
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
		
		
		$date = date('Y-m-d H:i:s',time());
		$data["date"] = $date;
		
		$data['start_date_time'] = (isset($params["start_date_time"]) ? $params["start_date_time"] : $date);
		$data['end_date_time'] = (isset($params["end_date_time"]) ? $params["end_date_time"] : $date); 
		
		$data["result"] = (isset($params["result_struct"]) ? $params["result_struct"] : array());
		
		$data["cur_page"] = (isset($params["page"]) ? $params["page"] : 1);
		$data["order_id"] = (isset($params["order_id"]) ? $params["order_id"] : '');
		
		if (isset($params["player_charge_info"])) {
			$data["player_name"] = $params["player_charge_info"]["player_name"];
			$data["player_chongzhi_total_money"] = $params["player_charge_info"]["total_money"];
			$data["player_chongzhi_total_times"] = $params["player_charge_info"]["total_times"];
		} else {
			$data["player_name"] = '';
			$data["player_chongzhi_total_money"] = 0;	
			$data["player_chongzhi_total_times"] = 0;
		}
		
		$this->load->model('charge_model');
		
		$this->load->view("templates/header", $data);
		$this->load->view("charge/charge_show", $data);
		$this->load->view("templates/footer");
	}
	
	public function execute($area_id, $start_date_time, $end_date_time, $order_id, $player_name, $page = "_1_"){
		$player_name = urldecode($player_name);
		$order_id = urldecode($order_id);
		$area_id = $this->_getParam($area_id);
		
		$start_date_time = urldecode($this->_getParam($start_date_time));
		$end_date_time = urldecode($this->_getParam($end_date_time));

		$start_date_time_param = explode(" ", $start_date_time);
		$end_date_time_param = explode(" ", $end_date_time);
		
		if(!$this->common_model->check_string_date($start_date_time_param[0]) || !$this->common_model->check_string_time($start_date_time_param[1]) ||
			!$this->common_model->check_string_date($end_date_time_param[0]) || !$this->common_model->check_string_time($end_date_time_param[1])){
			echo "输入错误";
			return;
		}
		
		$page = $this->_getParam($page);
		$player_name = $this->_getParam($player_name);
		$order_id = $this->_getParam($order_id);
		
		$this->load->model("charge_model");
		if (!is_numeric($area_id) || !is_numeric($page)) {
			exit;	
		}
		$result = $this->charge_model->search($area_id, $start_date_time_param[0], $start_date_time_param[1], $end_date_time_param[0], $end_date_time_param[1], $order_id, $player_name, $page);
		$next_page_url = "";
		$previous_page_url = "";
		$count_per_page = $this->charge_model->get_count_per_page();
		if(count($result) > $count_per_page){
			$next_page_url = $this->charge_model->make_url($area_id, $start_date_time_param[0], $start_date_time_param[1], $end_date_time_param[0], $end_date_time_param[1], $player_name, $page + 1); 
		}
		if($page > 1){
			$previous_page_url = $this->charge_model->make_url($area_id, $start_date_time_param[0], $start_date_time_param[1], $end_date_time_param[0], $end_date_time_param[1], $player_name, $page - 1);
		}
	
		$player_charge_info = $this->charge_model->get_player_charge_info(($player_name),$area_id, $start_date_time_param[0], $start_date_time_param[1], $end_date_time_param[0], $end_date_time_param[1]);
		$result_show = array_slice($result, 0, $count_per_page);
		$result_struct = array(
			"result" => $result_show,
			"next_page_url" => $next_page_url,
			"previous_page_url" => $previous_page_url,
		);
		$this->show(array(
			"result_struct" => $result_struct,
			"start_date_time" => $start_date_time,
			"end_date_time" => $end_date_time,
			"page" => $page,
			"order_id" => $order_id,
			"player_charge_info" => $player_charge_info,
			"area_list" => $this->common_model->set_selected_flag_for_arealist($area_id,$this->common_model->get_arealist()),
		));
	}
	
	public function execute_reset($area_id, $start_date_time, $end_date_time, $player_name, $page = "_1_"){
		$this->show(array(
			"result_struct" => array(),
			"start_date_time" => date("Y-m-d H:i:s"),
			"end_date_time" => date("Y-m-d H:i:s"),
			"page" => 0,
			//"player_charge_info" => array(),
		));	
	}
	
	public function execute_export($area_id, $start_date_time, $end_date_time, $order_id, $player_name, $page = "_1_"){
		$player_name = urldecode($player_name);
		$order_id = urldecode($order_id);
		$area_id = $this->_getParam($area_id);
	
		$start_date_time = urldecode($this->_getParam($start_date_time));
		$end_date_time = urldecode($this->_getParam($end_date_time));

		$start_date_time_param = explode(" ", $start_date_time);
		$end_date_time_param = explode(" ", $end_date_time);
		
		if(!$this->common_model->check_string_date($start_date_time_param[0]) || !$this->common_model->check_string_time($start_date_time_param[1]) ||
			!$this->common_model->check_string_date($end_date_time_param[0]) || !$this->common_model->check_string_time($end_date_time_param[1])){
			echo "输入错误";
			return;
		}
		
		$page = $this->_getParam($page);
		$player_name = $this->_getParam($player_name);
		$order_id = $this->_getParam($order_id);
		
		$this->load->model("charge_model");
		if (!is_numeric($area_id) || !is_numeric($page)) {
			exit;	
		}
		$result = $this->charge_model->search($area_id, $start_date_time_param[0], $start_date_time_param[1], $end_date_time_param[0], $end_date_time_param[1], $order_id, $player_name, 0);
		$next_page_url = "";
		$previous_page_url = "";
		$count_per_page = $this->charge_model->get_count_per_page();
		if(count($result) > $count_per_page){
			$next_page_url = $this->charge_model->make_url($area_id, $start_date_time_param[0], $start_date_time_param[1], $end_date_time_param[0], $end_date_time_param[1], $player_name, $page + 1); 
		}
		if($page > 1){
			$previous_page_url = $this->charge_model->make_url($area_id, $start_date_time_param[0], $start_date_time_param[1], $end_date_time_param[0], $end_date_time_param[1], $player_name, $page - 1);
		}
	
		$player_charge_info = $this->charge_model->get_player_charge_info(($player_name),$area_id, $start_date_time_param[0], $start_date_time_param[1], $end_date_time_param[0], $end_date_time_param[1]);
		$result_show = array_slice($result, 0, $count_per_page);
		$result_struct = array(
			"result" => $result_show,
			"next_page_url" => $next_page_url,
			"previous_page_url" => $previous_page_url,
		);
		$this->show(array(
			"result_struct" => $result_struct,
			"start_date_time" => $start_date_time,
			"end_date_time" => $end_date_time,
			"page" => $page,
			"player_charge_info" => $player_charge_info,
		));	
		if (count($result) > 0) {
			//导出到文件
			/** Error reporting */
			error_reporting(E_ALL);
			
			$server_info = $this->common_model->get_server_info_areaid($area_id);
			
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
			$objPHPExcel->getActiveSheet()->SetCellValue('G1', LG_RECHARGE_LOG);
			$objPHPExcel->getActiveSheet()->SetCellValue('A2', LG_SERVER_NAME.':');
			$objPHPExcel->getActiveSheet()->SetCellValue('B2', $server_info->name);
			//$objPHPExcel->getActiveSheet()->SetCellValue('D2', '平台:');
			//$objPHPExcel->getActiveSheet()->SetCellValue('E2', $platform);
			$objPHPExcel->getActiveSheet()->SetCellValue('A3', LG_TIME_FROM);
			$objPHPExcel->getActiveSheet()->SetCellValue('B3', $start_date_time);
			$objPHPExcel->getActiveSheet()->SetCellValue('D3', LG_TIME_TO);
			$objPHPExcel->getActiveSheet()->SetCellValue('E3', $end_date_time);
			
			$objPHPExcel->getActiveSheet()->SetCellValue('B5', LG_AREA_NUMBER);
			$objPHPExcel->getActiveSheet()->SetCellValue('C5', LG_NAME);
			$objPHPExcel->getActiveSheet()->SetCellValue('D5', LG_MONEY);
			$objPHPExcel->getActiveSheet()->SetCellValue('E5', LG_GEMSTONE);
			$objPHPExcel->getActiveSheet()->SetCellValue('F5', LG_RECHARGE_TIME);
			$objPHPExcel->getActiveSheet()->SetCellValue('G5', LG_STATUS);
			$objPHPExcel->getActiveSheet()->SetCellValue('H5', LG_ADD_TO_GAME_TIME);
			$objPHPExcel->getActiveSheet()->SetCellValue('I5', LG_TRANSACTION_ID);
			if (defined('LANGUAGE_EN')) {
				$objPHPExcel->getActiveSheet()->SetCellValue('J5', LG_CHANNEL);	
			}
			
			$i = 6;
			foreach($result as $row){
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $row->area_no);
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $row->name);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $row->money);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, $row->yuanbao);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, $row->activetime);
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$i, $row->has_add_to_game);
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$i, $row->successtime);
				//防止订单字符串太长，导致订单号显示为科学计数
				$objPHPExcel->getActiveSheet()->setCellValueExplicit('I'.$i, $row->orderid,PHPExcel_Cell_DataType::TYPE_STRING);
				if ( defined('LANGUAGE_EN')) {
					$objPHPExcel->getActiveSheet()->SetCellValue('J'.$i, get_channel($row->app_id));	
				}
				++$i;
			}
			
			// Rename sheet
			//echo date('H:i:s') . " Rename sheet\n";
			$xls_name = "";
			if (strlen($player_name) > 0) {
				$xls_name = $server_info->name.$player_name.'_'.$start_date_time_param[0]." ".$start_date_time_param[1].'-'.$end_date_time_param[0]." ".$end_date_time_param[1].'_charge';		
			} else {
				$xls_name = $server_info->name.$start_date_time_param[0]." ".$start_date_time_param[1].'-'.$end_date_time_param[0]." ".$end_date_time_param[1].'_charge';	
			}
			$objPHPExcel->getActiveSheet()->setTitle('charge');
			
					
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
		    $xls_name = $xls_name.'.xls';
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
}
?>