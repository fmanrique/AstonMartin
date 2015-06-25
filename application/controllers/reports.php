<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reports extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html 
	 */

	public function __construct() {
		parent::__construct();
		if (!$this->session->userdata('user_data'))  redirect(base_url() . 'login/', 'location', 301); 
		$this->load->model('activities_model');
		$this->load->model('categories_model');
		$this->load->model('audiences_model');
		$this->load->model('models_model');
		$this->load->model('focus_model');
		$this->load->model('frequency_model');
		$this->load->model('metrics_model');
		$this->load->model('activity_audiences_model');
		$this->load->model('activity_models_model');
		$this->load->model('activity_focus_model');
		$this->load->model('activity_metrics_model');
		$this->load->model('reports_model');
		$this->load->library('functions');
	}

	public function index()
	{
		$vars['title'] = 'Reports';
		$vars['content_view'] = '/reports_activity';
		//$vars['data'] = $this->activities_model->get_all();
		$vars['option']  = "reports";
		
		$vars['audiences'] = $this->audiences_model->get_all();
		$vars['models'] = $this->models_model->get_all();
		$vars['focus'] = $this->focus_model->get_all();
		$vars['frequencies'] = $this->frequency_model->get_all();
		$vars['metrics'] = $this->metrics_model->get_all();
		//$vars['activity_metrics'] = $this->activity_metrics_model->get_all();

		
		
		$parents = $this->categories_model->get_parents();
		$childs = $this->categories_model->get_childs();
		$categories = array();

		foreach ($parents as $key => $parent) {
			$category = $parent;
			$category_childs = $this->functions->search($childs, 'parent_id', $parent['id']);

			$category['childs'] = $category_childs;

			$categories[] = $category;
		}

		$vars['categories'] = $categories;

		$this->load->view('template', $vars);
		
	}

	public function export(){
		$user = $this->session->userdata("user_data");

		$audience = "";
		$focus = "";
		$model = "";

		$start_date = $_POST["start_date"];
		$end_date = $_POST["end_date"];
		$category_id = $_POST["category_id"];
		$dealership_id = $user['dealership_id'];

		if(isset($_POST["audience"])){
			foreach ($_POST["audience"] as $item) {
				$audience.=$item.",";
			}
		}
  
		if(isset($_POST["focus"])){
			foreach ($_POST["focus"] as $item) {    
				$focus.=$item.",";
			}
		}
 
		if(isset($_POST["model"])){
			foreach ($_POST["model"] as $item) {
				$model.=$item.",";
			}
		}

		$currencies = $this->reports_model->get_report_currencies($start_date, $end_date, $category_id, rtrim($audience,','), rtrim($focus,','), rtrim($model,','),$dealership_id);

		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->removeSheetByIndex(0);


		foreach($currencies as $key => $currency) {
			$activities = $this->reports_model->get_report_activities($start_date, $end_date, $category_id, rtrim($audience,','), rtrim($focus,','), rtrim($model,','),$dealership_id, $currency['currency_id']);
			$objWorkSheet = $objPHPExcel->createSheet($key);


			$objWorkSheet->setCellValue('J' . 1, "Metrics");
			$objWorkSheet->mergeCells("J1:K1");
			$objWorkSheet->getStyle('J1')->getAlignment()->applyFromArray(
			    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
			);

			$objWorkSheet->getStyle('A1:K2')->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => '9cbbb3')
			        )
			    )
			);
			$objWorkSheet->getStyle('A1:K2')->getFont()->setBold(true);
			$objWorkSheet->getStyle('A1:K2')->getFont()->setSize(14);


			$objWorkSheet->setCellValue('A' . 2, "Dealership")
										  ->setCellValue('B' . 2, "Month")
			                              ->setCellValue('C' . 2, "Activity Type")
			                              ->setCellValue('D' . 2, "Activity Name")
			                              ->setCellValue('E' . 2, "Start Date")
			                              ->setCellValue('F' . 2, "Expense")
			                              ->setCellValue('G' . 2, "Audience")
			                              ->setCellValue('H' . 2, "Activity Focus")
			                              ->setCellValue('I' . 2, "Model Focus")
			                              ->setCellValue('J' . 2, "Metric")
			                              ->setCellValue('K' . 2, "Quantity");

			$objWorkSheet->getColumnDimension('A')->setWidth(15);
			$objWorkSheet->getColumnDimension('B')->setWidth(10);
			$objWorkSheet->getColumnDimension('C')->setWidth(60);
			$objWorkSheet->getColumnDimension('D')->setWidth(15);
			$objWorkSheet->getColumnDimension('E')->setWidth(15);
			$objWorkSheet->getColumnDimension('F')->setWidth(20);
			$objWorkSheet->getColumnDimension('G')->setWidth(20);
			$objWorkSheet->getColumnDimension('H')->setWidth(20);
			$objWorkSheet->getColumnDimension('I')->setWidth(20);
			$objWorkSheet->getColumnDimension('J')->setWidth(30);
			$objWorkSheet->getColumnDimension('K')->setWidth(20);
			
			$x = 0;

			for ($i = 3; $i <= count($activities)+2; $i++) {
				$objWorkSheet->setCellValue('A' . $i, $activities[$i-3]["dealership"])
											  ->setCellValue('B' . $i, $activities[$i-3]["month_date"])
											  ->setCellValue('C' . $i, $activities[$i-3]["description"])
				                              ->setCellValue('D' . $i, $activities[$i-3]["name"])
				                              ->setCellValue('E' . $i, $activities[$i-3]["start_date"])
				                              ->setCellValue('F' . $i, $activities[$i-3]["expense"])
				                              ->setCellValue('G' . $i, str_replace('|', "\n", $activities[$i-3]["audiences"]))
				                              ->setCellValue('H' . $i, str_replace('|', "\n", $activities[$i-3]["focus"]))
				                              ->setCellValue('I' . $i, str_replace('|', "\n", $activities[$i-3]["models"]))
				                              ->setCellValue('J' . $i, str_replace('|', "\n", $activities[$i-3]["metric"]))
				                              ->setCellValue('K' . $i, str_replace('|', "\n", $activities[$i-3]["quantity"]));

				$objWorkSheet->getStyle('G' . $i)->getAlignment()->setWrapText(true);
				$objWorkSheet->getStyle('H' . $i)->getAlignment()->setWrapText(true);
				$objWorkSheet->getStyle('I' . $i)->getAlignment()->setWrapText(true);
				$objWorkSheet->getStyle('J' . $i)->getAlignment()->setWrapText(true);
				$objWorkSheet->getStyle('K' . $i)->getAlignment()->setWrapText(true);

				$objWorkSheet->getStyle('K' . $i)->getAlignment()->applyFromArray(
				    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
				);

				$objWorkSheet->getStyle('F'.$i)->getNumberFormat()->setFormatCode("$ #,###,###.00");


				if($x <> 0){
					$objWorkSheet->getStyle('A'.$i.':K'.$i)->applyFromArray(
					    array(
					        'fill' => array(
					            'type' => PHPExcel_Style_Fill::FILL_SOLID,
					            'color' => array('rgb' => 'd3d3d3')
					        )
					    )
					);
					$x=0;
				}
				else{
					$x=1;	
				}

			}

			$objWorkSheet->setCellValue('F'.($i+2),'=SUM(F3:F'.($i+1).')');
			$objWorkSheet->setCellValue('E'.($i+2), "TOTAL:");
			$objWorkSheet->getStyle('E'.($i+2).':F'.($i+2))->getFont()->setBold(true);
			$objWorkSheet->getStyle('F'.($i+2))->getNumberFormat()->setFormatCode("$ #,###,###.00");

			$objWorkSheet->setTitle($currency['description']);

		}
		/*$objPHPExcel->setActiveSheetIndex(0);

		$objPHPExcel->getActiveSheet()->setCellValue('J' . 1, "Metrics");
		$objPHPExcel->getActiveSheet()->mergeCells("J1:K1");
		$objPHPExcel->getActiveSheet()->getStyle('J1')->getAlignment()->applyFromArray(
		    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
		);

		$objPHPExcel->getActiveSheet()->getStyle('A1:K2')->applyFromArray(
		    array(
		        'fill' => array(
		            'type' => PHPExcel_Style_Fill::FILL_SOLID,
		            'color' => array('rgb' => '9cbbb3')
		        )
		    )
		);
		$objPHPExcel->getActiveSheet()->getStyle('A1:K2')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1:K2')->getFont()->setSize(14);


		$objPHPExcel->getActiveSheet()->setCellValue('A' . 2, "Dealership")
									  ->setCellValue('B' . 2, "Month")
		                              ->setCellValue('C' . 2, "Activity Type")
		                              ->setCellValue('D' . 2, "Activity Name")
		                              ->setCellValue('E' . 2, "Start Date")
		                              ->setCellValue('F' . 2, "Expense")
		                              ->setCellValue('G' . 2, "Audience")
		                              ->setCellValue('H' . 2, "Activity Focus")
		                              ->setCellValue('I' . 2, "Model Focus")
		                              ->setCellValue('J' . 2, "Metric")
		                              ->setCellValue('K' . 2, "Quantity");

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(60);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
		
		$x = 0;

		for ($i = 3; $i <= count($activities)+2; $i++) {
			$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $activities[$i-3]["dealership"])
										  ->setCellValue('B' . $i, $activities[$i-3]["month_date"])
										  ->setCellValue('C' . $i, $activities[$i-3]["description"])
			                              ->setCellValue('D' . $i, $activities[$i-3]["name"])
			                              ->setCellValue('E' . $i, $activities[$i-3]["start_date"])
			                              ->setCellValue('F' . $i, $activities[$i-3]["expense"])
			                              ->setCellValue('G' . $i, str_replace('|', "\n", $activities[$i-3]["audiences"]))
			                              ->setCellValue('H' . $i, str_replace('|', "\n", $activities[$i-3]["focus"]))
			                              ->setCellValue('I' . $i, str_replace('|', "\n", $activities[$i-3]["models"]))
			                              ->setCellValue('J' . $i, str_replace('|', "\n", $activities[$i-3]["metric"]))
			                              ->setCellValue('K' . $i, str_replace('|', "\n", $activities[$i-3]["quantity"]));

			$objPHPExcel->getActiveSheet()->getStyle('G' . $i)->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle('H' . $i)->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle('I' . $i)->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle('J' . $i)->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle('K' . $i)->getAlignment()->setWrapText(true);

			$objPHPExcel->getActiveSheet()->getStyle('K' . $i)->getAlignment()->applyFromArray(
			    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
			);

			$objPHPExcel->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()->setFormatCode("$ #,###,###.00");


			if($x <> 0){
				$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':K'.$i)->applyFromArray(
				    array(
				        'fill' => array(
				            'type' => PHPExcel_Style_Fill::FILL_SOLID,
				            'color' => array('rgb' => 'd3d3d3')
				        )
				    )
				);
				$x=0;
			}
			else{
				$x=1;	
			}

		}

		$objPHPExcel->getActiveSheet()->setCellValue('F'.($i+2),'=SUM(F3:F'.($i+1).')');
		$objPHPExcel->getActiveSheet()->setCellValue('E'.($i+2), "TOTAL:");
		$objPHPExcel->getActiveSheet()->getStyle('E'.($i+2).':F'.($i+2))->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('F'.($i+2))->getNumberFormat()->setFormatCode("$ #,###,###.00");*/


		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="report_activity.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		//header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		//header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		//header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		//header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;


		


	}

	
}


