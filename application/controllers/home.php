<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller{
 	public function __construct(){
 		parent::__construct();
 		$this->load->model('home_model');
 	}


 	public function index(){

 		$portfolios=$this->home_model->portfolios();
 		$sliders=$this->home_model->sliders();
 		$about_us=$this->home_model->data();
 		$services=$this->home_model->services();
 		$teams=$this->home_model->teams();
 		$comaddress=$this->home_model->comaddress();
 		$counters=$this->home_model->counters();

 		$data['portfolio']=$portfolios;
 		$data['slider']=$sliders;
 		$data['about']=$about_us;
 		$data['service']=$services;
 		$data['team']=$teams;
 		$data['com_address']=$comaddress;
 		$data['counter']=$counters;

 		$this->load->view('index',$data);
 	}

 	public function sub_product($id){
 				$back_ideo_sol=$this->home_model->sportfolios_idea_solution($id);
 				$sub_portfolios=$this->home_model->sub_portfolios($id);
 				//$data['name']=$name;
 				$data['back_ideo_sol']=$back_ideo_sol;
 				$data['sub_portfolio']=$sub_portfolios;
 				$this->load->view('sub_product',$data);
 	}

 	 public function sendemail($email){
    	$config = Array(
		  'protocol' => 'smtp',
		  'smtp_host' => 'ssl://smtp.casaestilo.in',
		  'smtp_port' => '',
		  'smtp_user' => 'nightlybuilds',
		  'smtp_pass' => 'l0c@lh0st',
         );
        // $user = $this->ion_auth->user()->row();
		// $email=$user->email;
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->from('nh9967@gmail.com','Enquiry of owlworx.in');
		$this->email->to($email);
		$this->email->subject('send mail');
		$this->email->message('your designe has been approved by admin');
		if ($this->ion_auth->is_admin()){
		$this->email->message('your designe has been approved by admin');
	    } else {
	    	$this->email->message('your designe has been approved by moderator');
	    } if (!$this->email->send()) {
		    show_error($this->email->print_debugger());
		} else {
		  	return true;
        }
    }

    public function patients(){
    	echo "Working on it Bitches do not access this";
    	$resultset = '';
    	$resultset['city'] = $this->db->get("city_master")->result_array();
    	$resultset['location'] = $this->db->get("area_master")->result_array();
    	$this->load->view("new_admin/patients", $resultset);
    }

    public function get_patients_age(){
		// $location = $this->input->post('location');
		// $city = $this->input->post('city');
		// $start_date = $this->input->post('start_date');
		// $end_date = $this->input->post('end_date');

		$data = $this->db->query("SELECT patients.age, COUNT(patients.age) as count FROM patients JOIN machine_booking ON patients.camp_details_id = machine_booking.id JOIN users ON machine_booking.user_id = users.id JOIN area_master ON users.area_id = area_master.id JOIN city_master ON area_master.city_id = city_master.id GROUP BY patients.age")->result();
		$response = '';
		$i = 0;
		foreach ($data as $value) {
			$response[$i]['name'] = $value->age;
			$response[$i]['y'] = ''.$value->count.'.0';
			$response[$i]['drilldown'] = $value->age;
			$i += 1;
		}

		$final_data = array(
				'status' => 'success',
				'data' => $response,
			);
		echo json_encode($final_data);
    }

    public function testYahoo(){
        // set url
        $url = $this->api_url;
        $url .= '?q=select%20*%20from%20yahoo.finance.quotes%20where%20symbol%20in%20%28%22'.implode(',',$tickers).'%22%29&env=store://datatables.org/alltableswithkeys';
        // set fields
        if ($fields===true || empty($fields)) {
            $fields = array(
                    'Symbol','Name','Change','ChangeRealtime','PERatio',
                    'PERatioRealtime','Volume','PercentChange','DividendYield',
                    'LastTradeRealtimeWithTime','LastTradeWithTime','LastTradePriceOnly','LastTradeTime',
                    'LastTradeDate'
                    );
        }
        // make request
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $resp = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        // parse response
        if (!empty($fields)) {
            $xml = new SimpleXMLElement($resp);
            $data = array();
            $row = array();
            $time = time();
            if(is_object($xml)){
                foreach($xml->results->quote as $quote){
                    $row = array();
                    foreach ($fields as $field) {
                        $row[$field] = (string) $quote->$field;
                    }
                    $data[] = $row;
                }
            }
        } else {
            $data = $resp;
        }
        return $data;
    }

    public function testYahoo1(){
		$geocode = file_get_contents("http://finance.yahoo.com/q/hp?s=WU&a=01&b=19&c=2010&d=01&e=19&f=2010&g=d");
		echo $geocode;exit();
		$output = json_decode($geocode);
		echo "<pre>";
		print_r($output);
    }

    public function readNAV(){
        $content = file("http://portal.amfiindia.com/spages/NAV0.txt");
        echo "<pre>";
        print_r($content);
        // fclose($file);
    }

    public function reload_data(){
        // $fam_data = $this->db->query('SELECT * FROM users JOIN users_groups ON users.id = users_groups.user_id AND users_groups.group_id = 2')->result();
        // $tbm_data = $this->db->query('SELECT * FROM users JOIN users_groups ON users.id = users_groups.user_id AND users_groups.group_id = 4')->result();
        $dummy_table_fam = $this->db->query('SELECT * FROM dummy_table GROUP BY activation_manager_name')->result();
        // $dummy_table_tbm = $this->db->query('SELECT * FROM dummy_table GROUP BY tbm_name')->result();
        foreach ($dummy_table_fam as $value) {
            if ($value->activation_manager_name) {
                $getidtoupdatefam = $this->db->query("SELECT * FROM users WHERE first_name = '".$value->activation_manager_name."'")->row();
                $getidtoupdateabm = $this->db->query("SELECT * FROM users WHERE code = '".$value->abm_code."'")->row();
                echo "<pre>";
                print_r($getidtoupdatefam->id);
                echo "<br>";
                print_r($getidtoupdateabm->id);
                echo "<br>";
                $this->db->query("UPDATE users SET senior_id = ".$getidtoupdateabm->id." WHERE id = ".$getidtoupdatefam->id);
            }
        }
    }

    public function reload_data_location(){
        // $data = $this->db->query("SELECT * FROM users JOIN dummy_table ON users.code = dummy_table.bm_code GROUP BY dummy_table.bm_code")->result();
        // echo "<pre>";
        // print_r($data);
        // foreach ($data as $value) {
        //     $area_id = $this->db->query("SELECT * FROM area_master WHERE name = '".$value->hq."'")->row();
        //     if ($value->bm_code) {
        //         print_r($value->bm_code);
        //         echo "<br>";
        //         $this->db->query("UPDATE users SET area_id = '".$area_id->id."' WHERE code = '".$value->bm_code."'");
        //     }
        // }
        $machine_names = $this->db->query("SELECT * FROM dummy_table GROUP BY machine_name")->result();
        foreach ($machine_names as $value) {
            $data = $this->db->query("SELECT * FROM users WHERE first_name = '".$value->technician_name."'")->row();
            $this->db->query("UPDATE machine SET user_id = '".$data->id."' WHERE name = '".$value->machine_name."'");
        }
    }

    public function update_doctors(){
        $doctor_data = $this->db->query("SELECT * FROM dummy_table GROUP BY doctor_name")->result();
        foreach ($doctor_data as $value) {
            $area = $this->db->query("SELECT * FROM area_master WHERE name = '".$value->hq."'")->row();
            if ($value->doctor_name) {
                $data = array(
                        'name' => $value->doctor_name,
                        'area_id' => $area->id,
                    );
                $this->db->insert('doctor_master', $data);
            }
        }
    }

    public function update_location_data(){
        $joindata = $this->db->query("SELECT * FROM dummy_table JOIN area_master ON dummy_table.hq = area_master.name GROUP BY dummy_table.technician_name")->result();
        echo "<pre>";
        print_r($joindata);
        foreach ($joindata as $value) {
            $this->db->query("UPDATE users SET area_id = '".$value->id."' WHERE first_name = '".$value->technician_name."'");
        }
    }

    public function update_doctors_detail() {
        echo "Hola..! <br><pre>";
        // $sql = "SELECT * FROM dummy_table";

        $sql = "SELECT speciality_doctor FROM dummy_table GROUP BY speciality_doctor";
        $dum_doctor = $this->db->query($sql)->result();
        foreach ($dum_doctor as $key => $value) {
            // $this->db->insert('doctor_speciality_master', array('name' => $value->speciality_doctor));
        }
        print_r($dum_doctor);

        echo "<br>";

        $sql = "SELECT id, name FROM doctor_speciality_master";
        $dum_doctor = $this->db->query($sql)->result();
        print_r($dum_doctor);


    }

    public function get_data() {
      if(!$this->ion_auth->logged_in()){
  			redirect('auth/data_login');
  			die();
  		}
      $user = $this->user_data();
      // $disp['id'] = $user['user']->id;
      // $disp['username'] = $user['user']->username;
      // print_r($disp);

      if ($user['group']->name == 'FAM') {
        $data = [];
        $this->load->view('new_admin/get_data', $data);
      } else {
        echo "only FAM login.";
      }

      // print_r($user);
    }

    function user_data() {
  		$user = $this->ion_auth->user()->row();
      // $user = [$user->username, $user->email, $user->first_name, $user->last_name, $user->area_id];
  		$group = $this->ion_auth->get_users_groups($user->id)->row();
  		$data = array(
  			'user' => $user,
  			'group' => $group,
  		);

  		return $data;
  	}


    public function data_updation_senior_id(){
        // $data = $this->db->query("SELECT * FROM users JOIN users_groups ON users.id = users_groups.user_id JOIN groups ON users_groups.group_id = groups.id AND groups.id = 6")->result();
        $abm_records_from_data = $this->db->query("SELECT * FROM dummy_table GROUP BY abm_code")->result();

        foreach ($abm_records_from_data as $value) {
            $data_abm = '';
            $data_fam = '';
            // print_r($value);
            // print_r($value->abm_code);
            if ($value->abm_code) {
                $data_abm = $this->db->query("SELECT * FROM users WHERE bm_abm_code = '".$value->abm_code."'")->result();
                if ($data_abm) {
                    if ($value->activation_manager_name) {
                        $data_fam = $this->db->query("SELECT * FROM users WHERE first_name = '".$value->activation_manager_name."'")->result();
                    }
                }
            }

            // $data_abm = $this->db->query("SELECT * FROM users WHERE bm_abm_code = '".$value->abm_code."'");
            echo "<pre>";
            echo "ABM : ";
            print_r($data_abm);
            echo "<br>";
            echo "FAM : ";
            print_r($data_fam);
            // exit();
            // $data = array(
            //     'senior_id' =
            // );
            // $this->db->where("first_name", $value->)
        }
        // print_r($data);
    }

    public function assign_abm_to_bm() {
      $abms = $this->db->query("SELECT * FROM  `dummy_table` GROUP BY  `abm_name`")->result();
      // print_r($abms);
      // exit();
      foreach ($abms as $value) {
        $abm = $value->abm_name;
        $bm = $value->bm_name;
        echo "<br>" . $abm . "=>" . $bm;

        if ($abm=='' || $bm=='') {
          echo " #blank name <br>";
          continue;
        }
        $abm_id = $this->db->query("SELECT id FROM  `users` WHERE  `first_name` =  '$abm'");
        $bm_id = $this->db->query("SELECT id FROM  `users` WHERE  `first_name` =  '$bm'");

        if ( ! ($abm_id->num_rows()) > 0 || ! ($bm_id->num_rows() > 0) ) {
          echo " *no records<br>";
          continue;
        }

        $abm_id = $abm_id->row()->id;
        $bm_id = $bm_id->row()->id;

        echo " " . $abm_id . "=>" . $bm_id . "<br>";
        $this->db->where("id", $abm_id);
        $this->db->update("users", Array("senior_id" => $bm_id));
      }
    }
}
