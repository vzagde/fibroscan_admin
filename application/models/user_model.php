<?php
defined('BASEPATH') OR exit('No direct script access allowed');

define('FINANCIAL_ACCURACY', 1.0e-6);
define('FINANCIAL_MAX_ITERATIONS', 100);

define('FINANCIAL_SECS_PER_DAY', 24 * 60 * 60);
define('FINANCIAL_HALF_SEC', 0.5 / FINANCIAL_SECS_PER_DAY);

class User_model extends CI_Model {

	public function get_all_investors(){
		// get all users from the database by grouping investor ids
		$this->db->select('investorId,InvestorName');
		$this->db->group_by('investorId,InvestorName');
		$qr = $this->db->get('TransactionsReport');

		return $qr->result_array();
	}


	public function generate_tx_data($investorId = null,$debug = null){

		$query = $this->db->query("SELECT folioNo,amfiSchemeCode,scheme_Name FROM TransactionsReport WHERE investorID = '{$investorId}' GROUP BY folioNo,amfiSchemeCode,scheme_Name ORDER BY amfiSchemeCode");

  //       $query = $this->db->query("SELECT MAX(scheme_Name),folioNo,amfiSchemeCode
  // FROM [NBuildDB].[dbo].[TransactionsReport]
  // group by scheme_Name,folioNo,amfiSchemeCode")
// echo $this->db->last_query();


		$schemes = $query->result();

        // var_dump($schemes);
        // die();

		$tx_data = array();

		foreach($schemes as $s){

			//transaction details for each scheme
			$this->db->where('investorId',$investorId);
			$this->db->where('folioNo',$s->folioNo);
			$this->db->where('amfiSchemeCode',$s->amfiSchemeCode);
			$this->db->order_by('t_cre_time');
			$tx_rep = $this->db->get('TransactionsReport');

			foreach($tx_rep->result() as $t){
                //print_r($t);
				$tx_data[$s->scheme_Name.'|'.trim($s->amfiSchemeCode).'|'.$s->folioNo][] = array(
						'amount' => ($t->transactionAmount) ? $t->transactionAmount : round($t->transactionQuantity*$t->transactionPrice,2),
						'units'  => $t->transactionQuantity,
						'nav'    => $t->transactionPrice,
						'type'   => $t->transactionType,
						'date'   => date("Y-m-d H:i:s", strtotime($t->t_cre_time))
					);

			}


			//dividend details
			$this->db->where('scheme_amfi_code', $s->amfiSchemeCode);
			$this->db->where('folio_no', $s->folioNo);
			$dd_rep = $this->db->get('DividendReport');

			foreach($dd_rep->result() as $t){
				$tx_data[$s->scheme_Name.'|'.trim($s->amfiSchemeCode).'|'.$s->folioNo][] = array(
						'amount' => $t->amount,
						'units'  => $t->units,
						'nav'    => $t->price,
						'type'   => $t->dividend_type,
						'date'   => date("Y-m-d H:i:s", strtotime($t->record_date))
					);
			}

			usort($tx_data[$s->scheme_Name.'|'.trim($s->amfiSchemeCode).'|'.$s->folioNo], function($a, $b) {
				if (strtotime($a['date']) == strtotime($b['date']))
					return 0;
				return (strtotime($a['date']) > strtotime($b['date'])) ? 1 : -1;
			});

		}

		if ($debug){
			foreach($tx_data as $key => $value){
				echo '<pre>';
				echo $key;
				$this->table->set_heading('amount','units','nav','type','date');
				echo "<style> table td, tr, th {border:1px solid #000} </style>";
				echo $this->table->generate($value);
			}

		}

            //         echo "<pre>";
            // print_r($tx_data);
            // exit;
		return $tx_data;

	}

	function XIRR($values, $dates, $guess = 0.1){ 
        if ((!is_array($values)) && (!is_array($dates))) return null; 
        if (count($values) != count($dates)) return null; 
        
        // create an initial bracket, with a root somewhere between bot and top 
        $x1 = 0.0; 
        $x2 = $guess; 
        $f1 = $this->XNPV($x1, $values, $dates); 
        $f2 = $this->XNPV($x2, $values, $dates); 
        for ($i = 0; $i < FINANCIAL_MAX_ITERATIONS; $i++) 
        { 
            if (($f1 * $f2) < 0.0) break; 
            if (abs($f1) < abs($f2)) { 
                $f1 = $this->XNPV($x1 += 1.6 * ($x1 - $x2), $values, $dates); 
            } else { 
                $f2 = $this->XNPV($x2 += 1.6 * ($x2 - $x1), $values, $dates); 
            } 
        } 
        if (($f1 * $f2) > 0.0) return null; 
        
        $f = $this->XNPV($x1, $values, $dates); 
        if ($f < 0.0) { 
            $rtb = $x1; 
            $dx = $x2 - $x1; 
        } else { 
            $rtb = $x2; 
            $dx = $x1 - $x2; 
        } 
        
        for ($i = 0; $i < FINANCIAL_MAX_ITERATIONS; $i++) 
        { 
            $dx *= 0.5; 
            $x_mid = $rtb + $dx; 
            $f_mid = $this->XNPV($x_mid, $values, $dates); 
            if ($f_mid <= 0.0) $rtb = $x_mid; 
            if ((abs($f_mid) < FINANCIAL_ACCURACY) || (abs($dx) < FINANCIAL_ACCURACY)) return $x_mid;
        }
        return null; 
    } 


	function XNPV($rate, $values, $dates) { 
        if ((!is_array($values)) || (!is_array($dates))) return null; 
        if (count($values) != count($dates)) return null; 
        
        $xnpv = 0.0; 
        for ($i = 0; $i < count($values); $i++) 
        { 
            @$xnpv += $values[$i] / pow(1 + $rate, $this->DATEDIFF('day', $dates[0], $dates[$i]) / 365); 
        } 
        return (is_finite($xnpv) ? $xnpv: null); 
    } 

	function DATEDIFF($datepart, $startdate, $enddate) { 
        switch (strtolower($datepart)) { 
            case 'yy': 
            case 'yyyy': 
            case 'year': 
                $di = getdate($startdate); 
                $df = getdate($enddate); 
                return $df['year'] - $di['year']; 
                break; 
            case 'q': 
            case 'qq': 
            case 'quarter': 
                die("Unsupported operation"); 
                break; 
            case 'n': 
            case 'mi': 
            case 'minute': 
                return ceil(($enddate - $startdate) / 60); 
                break; 
            case 'hh': 
            case 'hour': 
                return ceil(($enddate - $startdate) / 3600); 
                break; 
            case 'd': 
            case 'dd': 
            case 'day': 
                return ceil(($enddate - $startdate) / 86400); 
                break; 
            case 'wk': 
            case 'ww': 
            case 'week': 
                return ceil(($enddate - $startdate) / 604800); 
                break; 
            case 'm': 
            case 'mm': 
            case 'month': 
                $di = getdate($startdate); 
                $df = getdate($enddate); 
                return ($df['year'] - $di['year']) * 12 + ($df['mon'] - $di['mon']); 
                break; 
            default: 
                die("Unsupported operation"); 
        } 
    } 
}

/* End of file user_model.php */
/* Location: ./application/models/user_model.php */