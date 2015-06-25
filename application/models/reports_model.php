<?php
class reports_model extends CI_Model {

	function __construct(){
		$this->load->database();
	}
   
	public function get_report_activities($start_date, $end_date, $category_id, $audience, $focus, $model, $dealership_id, $currency_id){
		$filters = " ";
		$filter_audience = " ";
		$filter_focus = " ";
		$filter_model = " ";

		$filters.= " AND c.id = " . $currency_id;
		if($start_date!=""){
			$filters.= " AND a.start_date > str_to_date('" . $start_date . "','%m-%d-%Y') ";
		}

		if($end_date!=""){
			$filters.= " AND a.start_date < str_to_date('" . $end_date . "','%m-%d-%Y') ";
		}

		if($category_id!=0){
			$filters.= " AND a.category_id = ".  $category_id . " " ;
		}

		if($audience!=""){
			$filter_audience = " INNER JOIN activity_audiences X ON a.id = X.activity_id AND X.audience_id in ($audience) ";
		}

		if($focus!=""){
			$filter_focus = " INNER JOIN activity_focus Y ON a.id = Y.activity_id AND Y.focus_id in ($focus) ";
		}

		if($model!=""){
			$filter_model = " INNER JOIN activity_models Z ON a.id = Z.activity_id AND Z.model_id in ($model) ";
		}

		$result = $this->db->query("

				SELECT d.name as dealership, MONTHNAME(a.start_date) AS month_date, a.name, ca.description, DATE_FORMAT(a.start_date,'%d/%m/%Y') as start_date, a_c.audiences, a_f.focus, a.expense, a_m.models, metric, quantity
				FROM activities a 

					$filter_audience 
					$filter_focus 
					$filter_model 
					LEFT JOIN dealerships d ON a.dealership_id = d.id
					LEFT JOIN currencies c ON c.id = d.currency_id
					LEFT JOIN (SELECT ac.activity_id, GROUP_CONCAT(au.description SEPARATOR '|') as audiences 
								FROM activity_audiences ac 
									INNER JOIN audiences au ON ac.audience_id = au.id 
								WHERE au.status_id = 1 
								GROUP BY ac.activity_id) a_c ON a.id = a_c.activity_id 
					LEFT JOIN (SELECT af.activity_id, GROUP_CONCAT(fo.description SEPARATOR '|') as focus 
								FROM activity_focus af 
									INNER JOIN focus fo ON af.focus_id = fo.id 
								WHERE fo.status_id = 1 
								GROUP BY af.activity_id) a_f ON a.id = a_f.activity_id
					LEFT JOIN (SELECT am.activity_id, GROUP_CONCAT(mo.description SEPARATOR '|') as models
								FROM activity_models am 
									INNER JOIN models mo ON am.model_id = mo.id 
								WHERE mo.status_id = 1 
								GROUP BY am.activity_id) a_m ON a.id = a_m.activity_id
					INNER JOIN categories ca ON a.category_id = ca.id
					LEFT JOIN (SELECT activity_id, GROUP_CONCAT(met.description SEPARATOR '|') as 'metric', GROUP_CONCAT(quantity SEPARATOR '|') AS 'quantity'
								FROM activity_metrics ame
									INNER JOIN metrics met ON ame.metric_id = met.id
								GROUP BY activity_id) a_me ON a.id = a_me.activity_id 
			
				WHERE a.status_id = 1 
				AND (a.dealership_id = ".$dealership_id . " OR 0=".$dealership_id.")". $filters .
				" GROUP BY (a.start_date), a.name, ca.description, DATE_FORMAT(a.start_date, '%d/%m/%Y'), a_c.audiences,
    						a_f.focus, a.expense, a_m.models, metric,quantity 
    			ORDER BY d.id, a.start_date ASC 

    			"

				);

		//print $this->db->last_query();
		//exit();

		return $result->result_array(); 
	}

	public function get_report_currencies($start_date, $end_date, $category_id, $audience, $focus, $model, $dealership_id){
		$filters = " ";
		$filter_audience = " ";
		$filter_focus = " ";
		$filter_model = " ";

		if($start_date!=""){
			$filters.= " AND a.start_date > str_to_date('" . $start_date . "','%m-%d-%Y') ";
		}

		if($end_date!=""){
			$filters.= " AND a.start_date < str_to_date('" . $end_date . "','%m-%d-%Y') ";
		}

		if($category_id!=0){
			$filters.= " AND a.category_id = ".  $category_id . " " ;
		}

		if($audience!=""){
			$filter_audience = " INNER JOIN activity_audiences X ON a.id = X.activity_id AND X.audience_id in ($audience) ";
		}

		if($focus!=""){
			$filter_focus = " INNER JOIN activity_focus Y ON a.id = Y.activity_id AND Y.focus_id in ($focus) ";
		}

		if($model!=""){
			$filter_model = " INNER JOIN activity_models Z ON a.id = Z.activity_id AND Z.model_id in ($model) ";
		}

		$result = $this->db->query("
				SELECT distinct d.currency_id, c.description
				FROM activities a 

					$filter_audience 
					$filter_focus 
					$filter_model 
					LEFT JOIN dealerships d ON a.dealership_id = d.id
					LEFT JOIN currencies c ON c.id = d.currency_id
				WHERE a.status_id = 1 
				AND (a.dealership_id = ".$dealership_id . " OR 0=".$dealership_id.")". $filters . " AND c.id IS NOT NULL");

		//print $this->db->last_query();
		//exit();

		return $result->result_array(); 
	}
}
?>