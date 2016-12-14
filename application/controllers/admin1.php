<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin1 extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Grocery_CRUD');

		if(!$this->ion_auth->logged_in()){
			redirect('auth/login');
			die();
		}

		$this->load->library('grocery_CRUD');
		$this->load->library('image_CRUD');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->library('session');
	}

	public function index1(){
		$user = $this->ion_auth->user()->row();
		$group = $this->ion_auth->get_users_groups($user->id)->row();

		$month = date('m');
		$year = date('Y');

		$num_of_patient = $this->db->query("SELECT * FROM  `patients` WHERE `date_created` BETWEEN '$year-$month-01' AND '$year-$month-30';");

		$tbms = $this->db->query("SELECT max(count),name, area_name  FROM (SELECT COUNT(machine_booking.user_id) as count, machine_booking.user_id, users.first_name as name, area_master.name as area_name FROM machine_booking JOIN users ON machine_booking.user_id = users.id JOIN users_groups ON users.id = users_groups.user_id JOIN area_master ON users.area_id = area_master.id AND users_groups.group_id = 4 AND machine_booking.completed = 'true' AND machine_booking.created_date BETWEEN '$year-$month-01' AND '$year-$month-31' GROUP BY machine_booking.user_id) as demo")->row();

		$top_tbms = $this->db->query("SELECT count, name, area_name, id  FROM (SELECT COUNT(machine_booking.user_id) as count, machine_booking.user_id, users.first_name as name, users.id as id, area_master.name as area_name FROM machine_booking JOIN users ON machine_booking.user_id = users.id JOIN users_groups ON users.id = users_groups.user_id JOIN area_master ON users.area_id = area_master.id AND users_groups.group_id = 4 AND machine_booking.completed = 'true' AND machine_booking.created_date BETWEEN '$year-$month-01' AND '$year-$month-31' GROUP BY machine_booking.user_id) as demo ORDER BY count DESC LIMIT 5")->result();

		$fams = $this->db->query("SELECT SUM(count) as count, name, area_name FROM (SELECT * FROM (SELECT COUNT(machine_booking.user_id) as count, users.first_name as name, users.id as user_id, area_master.name as area_name FROM machine_booking JOIN users ON machine_booking.user_id = users.id JOIN users_groups ON users.id = users_groups.user_id JOIN area_master ON users.area_id = area_master.id AND users_groups.group_id = 2 AND machine_booking.completed = 'true' AND machine_booking.created_date BETWEEN '$year-$month-01' AND '$year-$month-31' GROUP BY machine_booking.user_id) as demo1
		UNION
		SELECT * FROM (SELECT COUNT(machine_booking.user_id) as count, users.first_name as name, users.senior_id as user_id, area_master.name as area_name FROM machine_booking JOIN users ON machine_booking.user_id = users.id JOIN users_groups ON users.id = users_groups.user_id JOIN area_master ON users.area_id = area_master.id AND users_groups.group_id = 4 AND machine_booking.completed = 'true' AND machine_booking.created_date BETWEEN '$year-$month-01' AND '$year-$month-31' GROUP BY machine_booking.user_id) AS demo2) as demo3 GROUP BY user_id")->row();

		$top_fams = $this->db->query("SELECT SUM(count) as count, name, area_name FROM (SELECT * FROM (SELECT COUNT(machine_booking.user_id) as count, users.first_name as name, users.id as user_id, area_master.name as area_name FROM machine_booking JOIN users ON machine_booking.user_id = users.id JOIN users_groups ON users.id = users_groups.user_id JOIN area_master ON users.area_id = area_master.id AND users_groups.group_id = 2 AND machine_booking.completed = 'true' AND machine_booking.created_date BETWEEN '$year-$month-01' AND '$year-$month-31' GROUP BY machine_booking.user_id ORDER BY count DESC LIMIT 5) as demo1
		UNION
		SELECT * FROM (SELECT COUNT(machine_booking.user_id) as count, users.first_name as name, users.senior_id as user_id, area_master.name as area_name FROM machine_booking JOIN users ON machine_booking.user_id = users.id JOIN users_groups ON users.id = users_groups.user_id JOIN area_master ON users.area_id = area_master.id AND users_groups.group_id = 4 AND machine_booking.completed = 'true' AND machine_booking.created_date BETWEEN '$year-$month-01' AND '$year-$month-31' GROUP BY machine_booking.user_id ) AS demo2) as demo3 GROUP BY user_id ")->result();

		$top_technician = $this->db->query("SELECT count,name, area_name, id  FROM (SELECT COUNT(machine_booking.user_id) as count, machine_booking.user_id, users.first_name as name, users.id as id, area_master.name as area_name FROM machine_booking JOIN machine ON machine_booking.machine_id  JOIN users ON machine.user_id = users.id JOIN users_groups ON users.id = users_groups.user_id JOIN area_master ON users.area_id = area_master.id AND users_groups.group_id = 3 AND machine_booking.completed = 'true'  AND machine_booking.created_date BETWEEN '$year-$month-01' AND '$year-$month-31' GROUP BY machine_booking.user_id) as demo ORDER BY count DESC LIMIT 5")->result();

		$total_num_camps = $this->db->query("SELECT * FROM machine_booking WHERE (date BETWEEN '$year-$month-01' AND '$year-$month-31') AND completed='true'")->num_rows();

		$total_num_planned_camps = $this->db->query("SELECT * FROM machine_booking WHERE (date BETWEEN '$year-$month-01' AND '$year-$month-31')")->num_rows();

		$sql = "SELECT * FROM (SELECT users.first_name, COUNT(users.id) AS count FROM machine_booking JOIN machine ON machine_booking.machine_id = machine.id JOIN users ON machine.user_id = users.id AND unlock_request != '' AND (machine_booking.date BETWEEN '$year-$month-01' AND '$year-$month-31') GROUP BY users.id) AS demo ORDER BY count LIMIT 5";
		$defaulter_list = $this->db->query($sql)->result();

		// $doc_engaged = $this->db->query("SELECT count(count) count, name, area_name  FROM (SELECT COUNT(machine_booking.user_id) as count, machine_booking.doctor_id, doctor_master.name as name, area_master.name as area_name FROM machine_booking JOIN doctor_master ON machine_booking.doctor_id = doctor_master.id  JOIN area_master ON doctor_master.area_id = area_master.id  AND machine_booking.completed = 'true' AND machine_booking.created_date BETWEEN '$year-$month-01' AND '$year-$month-31' GROUP BY machine_booking.user_id) as demo")->row();

		// print_r($top_fams);exit();

		$data = array(
			'user' => $user,
			'group' => $group,
			'num_of_patient' => $num_of_patient->num_rows(),
			'top_tbm' => $tbms,
			'top_tbms' => $top_tbms,
			'top_fam' => $fams,
			'top_fams' => $top_fams,
			'top_technician' => $top_technician,
			'total_num_camps' => $total_num_camps,
			'total_num_planned_camps' => $total_num_planned_camps,
			'defaulter_list' => $defaulter_list,
		);

		echo "<pre>";
		print_r($data);
		// $this->load->view('new_admin/dashboard', $data);
	}

	public function index(){
		$user = $this->ion_auth->user()->row();
		$group = $this->ion_auth->get_users_groups($user->id)->row();

		$month = date('m');
		$year = date('Y');

		if ($group->id == 1) {
			$patient_count = $this->db->query("SELECT COUNT(*) AS count FROM patients JOIN camp_details ON patients.camp_details_id = camp_details.id JOIN machine_booking ON camp_details.machine_booking_id = machine_booking.id AND machine_booking.date BETWEEN '".$year."-".$month."-01' AND '".$year."-".$month."-31'")->result();
			print_r($patient_count);
		} else if ($group->id == 7) {
			$query = "SELECT COUNT(DISTINCT(patients.id)) FROM patients
					JOIN camp_details
					ON patients.camp_details_id = camp_details.id
					JOIN machine_booking
					ON camp_details.machine_booking_id = machine_booking.id
					AND machine_booking.date BETWEEN '2016-11-01' AND '2016-11-31'
					JOIN (SELECT * FROM users
							WHERE senior_id
							IN (SELECT u.id FROM users_groups AS ug JOIN users AS u ON ug.user_id = u.id AND u.senior_id = 28)
						UNION
						SELECT * FROM users
							WHERE senior_id
							IN (SELECT id FROM users WHERE senior_id IN (SELECT u.id FROM users_groups AS ug JOIN users AS u ON ug.user_id = u.id AND u.senior_id = 28))) AS users
					ON machine_booking.user_id = users.id";
			$patient_count = $this->db->query($query);
		}
		exit();



		$data = array(
			'user' => $user,
			'group' => $group,
			'num_of_patient' => $num_of_patient->num_rows(),
			'top_tbm' => $tbms,
			'top_tbms' => $top_tbms,
			'top_fam' => $fams,
			'top_fams' => $top_fams,
			'top_technician' => $top_technician,
			'total_num_camps' => $total_num_camps,
			'total_num_planned_camps' => $total_num_planned_camps,
			'defaulter_list' => $defaulter_list,
		);

		$this->load->view('new_admin/dashboard', $data);
	}

	public function slot_stats()
	{
		$data = $this->user_data();

		$machine_booking_data = $this->db->get("machine_booking")->result();
		$ret_arr = array();
		$data["first_slot"] = 0;
		$data["last_slot"] = 0;
		$data["full_slot"] = 0;
		foreach($machine_booking_data as $machine_booking_data_val){
			$res = $this->ck_time($machine_booking_data_val->start_time, $machine_booking_data_val->end_time);
			if($res == "1"){
				$data["first_slot"]++;
			}
			if($res == "2"){
				$data["last_slot"]++;
			}
			if($res == "1,2"){
				$data["full_slot"]++;
			}
		}
		$this->load->view("new_admin/slot_stats", $data);
	}

	public function doctors_stats()
	{
		$data = $this->user_data();

		$machine_booking_data = $this->db->get("machine_booking")->result();
		$chart_arr = array();
		foreach($machine_booking_data as $machine_booking_data_val){
			$dt = strtotime($machine_booking_data_val->date);
			$this->db->where("id", $machine_booking_data_val->doctor_id);
			$doctor_name_arr = $this->db->get("doctor_master")->row();
			if(@$chart_arr[date("M", $dt)][$doctor_name_arr->name] == ""){
				$chart_arr[date("M", $dt)][$doctor_name_arr->name] = 1;
			}else{
				$chart_arr[date("M", $dt)][$doctor_name_arr->name]++;
			}
		}

		// Put 0s in other months.
		$arranged_array = array();
		$all_doctor_name = $this->db->get("doctor_master")->result();
		foreach($all_doctor_name as $all_doctor_name_val){
			for($month_num = 1; $month_num <= 12; $month_num++){
				if(@$chart_arr[date("M", strtotime("2016-".$month_num."-01"))][$all_doctor_name_val->name] == ""){
					$chart_arr[date("M", strtotime("2016-".$month_num."-01"))][$all_doctor_name_val->name] = 0;
				}
			}
		}

		for($month_num = 1; $month_num <= 12; $month_num++){
			array_push($arranged_array, $chart_arr[date("M", strtotime("2016-".$month_num."-01"))]);
		}

		$final_arr = array();
		$counter = 0;
		foreach($arranged_array[0] as $key => $arranged_array_val){
			$final_arr[$counter]["name"] = $key;
			$final_arr[$counter]["type"] = "bar";

			for($month_counter = 0; $month_counter < 12; $month_counter++){
				$final_arr[$counter]["data"][$month_counter] = $arranged_array[$month_counter][$key];
			}
			$counter++;
		}

		$data["doctors_stats"] = $final_arr;
		$this->load->view("new_admin/doctor_stats", $data);
	}

	public function machine_used()
	{
		$data = $this->user_data();

		$machine_booking_data = $this->db->get("machine_booking")->result();
		$chart_arr = array();
		foreach($machine_booking_data as $machine_booking_data_val){
			$dt = strtotime($machine_booking_data_val->date);
			$this->db->where("id", $machine_booking_data_val->machine_id);
			$machine_name_arr = $this->db->get("machine")->row();
			if(@$chart_arr[date("M", $dt)][$machine_name_arr->name] == ""){
				$chart_arr[date("M", $dt)][$machine_name_arr->name] = 1;
			}else{
				$chart_arr[date("M", $dt)][$machine_name_arr->name]++;
			}
		}

		// Put 0s in other months.
		$arranged_array = array();
		$all_machine_name = $this->db->get("machine")->result();
		foreach($all_machine_name as $all_machine_name_val){
			for($month_num = 1; $month_num <= 12; $month_num++){
				if(@$chart_arr[date("M", strtotime("2016-".$month_num."-01"))][$all_machine_name_val->name] == ""){
					$chart_arr[date("M", strtotime("2016-".$month_num."-01"))][$all_machine_name_val->name] = 0;
				}
			}
		}

		for($month_num = 1; $month_num <= 12; $month_num++){
			array_push($arranged_array, $chart_arr[date("M", strtotime("2016-".$month_num."-01"))]);
		}

		$final_arr = array();
		$counter = 0;
		foreach($arranged_array[0] as $key => $arranged_array_val){
			$final_arr[$counter]["name"] = $key;
			$final_arr[$counter]["type"] = "bar";

			for($month_counter = 0; $month_counter < 12; $month_counter++){
				$final_arr[$counter]["data"][$month_counter] = $arranged_array[$month_counter][$key];
			}
			$counter++;
		}

		$data["machine_used"] = $final_arr;
		$this->load->view("new_admin/machine_used", $data);
	}

	public function getLocation() {
		$city_id = $this->input->post('city');

		if ($city_id=='') {
			$data = $this->db->query('SELECT * FROM area_master')->result();
		} else {
			$data = $this->db->query('SELECT * FROM area_master WHERE city_id='.$city_id)->result();
		}

		$this->jsonify(array(
			'status' => 'success',
			'data' => $data
		));
	}

	public function logout()
	{
		$this->data['title'] = "Logout";

		//log the user out
		$logout = $this->ion_auth->logout();

		//redirect them to the login page
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect('auth/login', 'refresh');
	}

	public function doctors_speciality(){
		$speciality = $this->db->get("doctor_speciality_master")->result();
		$doctors = $this->db->get("doctor_master")->result();
		$speciality_arr = array();
		foreach($speciality as $speciality_val){
			foreach($doctors as $doctors_vals){
				$speciality_ids_arr = explode(",", $doctors_vals->speciality_ids);
				foreach($speciality_ids_arr as $speciality_ids_val){
					if($speciality_ids_val == $speciality_val->id){
						if(@$speciality_arr[$speciality_val->name] == ""){
							$speciality_arr[$speciality_val->name] = 1;
						}else{
							$speciality_arr[$speciality_val->name]++;
						}
					}
				}
			}
		}
		$data = $this->user_data();
		$data["speciality_arr"] = $speciality_arr;
		$this->load->view("new_admin/speciality_count", $data);
	}

	public function activation_live(){
		$data = $this->user_data();

		$this->db->where("completed", "true");
		$data["successful"] = count(@$this->db->get("machine_booking")->result());

		$this->db->where("cancel_approved", "true");
		$data["cancelled"] = count(@$this->db->get("machine_booking")->result());

		$this->db->where("completed", "");
		$this->db->where("cancel_approved", "");
		$data["booked"] = count(@$this->db->get("machine_booking")->result());

		$this->load->view("new_admin/activation_live_page", $data);
	}

	public function all_bookings(){
		$data = $this->user_data();
		// This will be accessed by ABM.
		// $user_ids = $this->db->query("select g.name, ug.user_id from groups g inner join users_groups ug on g.id = ug.group_id where g.name in ('TBM', 'FAM')")->result_array();
		$data["all_bookings"] = $this->db->query("SELECT mb.start_time, mb.end_time, mb.location, mb.approved, mb.date, mb.cancel, mb.cancel_approved, mb.camp_type, mb.completed, u.username, u.email, u.first_name, u.last_name, g.name FROM machine_booking mb inner join users u on mb.user_id = u.id inner join users_groups ug on u.id = ug.user_id inner join groups g on ug.group_id = g.id where g.name in ('TBM', 'FAM')")->result();
		// print_r($all_bookings);
		$this->load->view("new_admin/abm", $data);
	}

	public function ck_time($st_time_str, $end_time_str){
		$mid_time = strtotime("14:00:00");
		$st_time = strtotime($st_time_str);
		$end_time = strtotime($end_time_str);

		if($st_time > $mid_time){
			return "2";
		}else if($st_time < $mid_time && $end_time <= $mid_time){
			return "1";
		}else{
			return "1,2";
		}
	}

	public function ck_api(){
		$fields = array(
			"date"    => "1992-12-01",
			"slot"    => "1",
			"area_id" => "1",
			"msg"     => "Machine available on "
		);
		$fields_string = implode("&", $fields);
		echo $fields_string;
		echo "<br>";
		$url = "http://casaestilo.in/abbott_admin/api/api/Notify_availability/send_push_notification";
		$agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)";
		$fields_string = implode("&", $fields);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		$returned=curl_exec($ch);
		print_r($returned);
	}

	public function approve(){
		$id = $this->input->post("txt_id");
		$upd = array(
			"cancel_approved" => "true"
		);
		$this->db->where("id", $id);
		$this->db->update("machine_booking", $upd);

		// Hit DARPAN'S Link.
		$this->db->where("id", $id);
		$machine_booking_data = $this->db->get("machine_booking")->row();

		$this->db->where("id", $machine_booking_data->user_id);
		$area_id = $this->db->get("users")->row();

		$slot = $this->ck_time($machine_booking_data->start_time, $machine_booking_data->end_time);

		$fields = array(
			"date"    => $machine_booking_data->date,
			"slot"    => $slot,
			"area_id" => $area_id->area_id,
			"msg"     => "Machine available on ".$machine_booking_data->date." on slot ".$slot
		);
		$url = "http://casaestilo.in/abbott_admin/api/api/Notify_availability/send_push_notification";
		$agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)";
		$fields_string = implode("&", $fields);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		$returned=curl_exec($ch);

		print_r($returned);

		echo "Approved.";
	}

	public function disapprove(){
		$id = $this->input->post("txt_id");
		$upd = array(
			"cancel_approved" => "false"
		);
		$this->db->where("id", $id);
		$this->db->update("machine_booking", $upd);
		echo "DisApproved.";
	}

	public function all_cancellation() {
		$crud = new grocery_CRUD('default');
		$crud->set_theme('flexigrid');
	    $crud->set_table('machine_booking');
	    $crud->where('cancel', 'true');
	    $crud->where('cancel_approved', '');
		$crud->set_subject('Approve / Disapprove');
		$crud->unset_delete();
		$crud->unset_edit();
		$crud->unset_add();
		// $crud->add_action('Approve', 'http://dummyimage.com/16x16/1dde57/0011ff&text=A', 'admin/approve','');
		$crud->add_action('Approve', 'http://dummyimage.com/16x16/1dde57/0011ff&text=A', '','', array($this, '_approval'));
		$crud->add_action('Disapprove', 'http://dummyimage.com/16x16/ff0009/0011ff&text=D', '','', array($this, '_disapproval'));
		// $crud->add_action('Disapprove', 'http://dummyimage.com/16x16/ff0009/0011ff&text=D', 'admin/disapprove','');
		// $crud->add_action('Approve', '', 'demo/action_more', '', array($this, '_approval'));
		$data = $crud->render();

		$data = array_merge( (array) $data, $this->user_data());
		$this->load->view('new_admin/crud_view',$data);
	}

	function _approval($primary_key , $row){
		// print_r($row);
		return "javascript:app('".$primary_key."');";
	}

	function _disapproval($primary_key , $row){
		// print_r($row);
		return "javascript:disapp('".$primary_key."');";
	}

	function user_data() {
		$user = $this->ion_auth->user()->row();
		$group = $this->ion_auth->get_users_groups($user->id)->row();
		$data = array(
			'user' => $user,
			'group' => $group,
		);

		return $data;
	}



	public function add_user() {
		$user = $this->ion_auth->user()->row();
		$group = $this->ion_auth->get_users_groups($user->id)->row();
		$senior = $this->ion_auth->users(array(1, 2, 3, 5, 6, 7))->result();
		$city = $this->db->query("SELECT * FROM city_master")->result();
		$area = $this->db->query("SELECT * FROM area_master")->result();
		$groups = $this->db->query("SELECT * FROM groups")->result();

		$data = array(
			'user' => $user,
			'group' => $group,
			'senior' => $senior,
			'city' => $city,
			'area' => $area,
			'groups' => $groups,
		);
		$this->load->view('new_admin/add_user', $data);
	}

	public function create_user()
	{
		$username = $this->input->post('username');
		$email = $this->input->post('email');
		$fname = $this->input->post('fname');
		$lname = $this->input->post('lname');
		$password = $this->input->post('password');
		$repassword = $this->input->post('repassword');
		$phoneno = $this->input->post('phoneno');
		$group = $this->input->post('group');
		$senior = $this->input->post('senior');
		$city = $this->input->post('city');
		$area = $this->input->post('area');

		$target_file = '';
		$profile_image = $_FILES['profile_image'];
		// print_r($profile_image);exit();
		$check = getimagesize($profile_image["tmp_name"]);
		if ($check !== false) {
			$target_file = 'assets/uploads/profile_image/'.time().$profile_image['name'];
			if (!move_uploaded_file($profile_image["tmp_name"], $target_file)) {
				$target_file = '';
			}
		}

		$additional_data = array(
			'first_name' => $fname,
			'last_name' => $lname,
			'phone' => $phoneno,
			'senior_id' => $senior,
			'city' => $city,
			'area_id' => $area,
			'profile_image' => $target_file,
		);
		$groups = array($group);

		if ($this->ion_auth->register($username, $password, $email, $additional_data, $groups)) {
			echo(json_encode(array('status' => 'success', 'group' => $group, 'groups' => $groups)));
		} else {
			echo(json_encode(array('status' => 'fail')));
		}
	}

	public function all_users() {
		$crud = new grocery_CRUD('default');
		$crud->set_theme('flexigrid');
	    $crud->set_table('users');
		$crud->set_subject('User');
		$crud->columns('username', 'first_name', 'last_name', 'email', 'phone', 'country', 'city');
		$crud->fields('username', 'first_name', 'last_name', 'email', 'phone', 'country', 'city', 'Group');
		$crud->set_relation_n_n('Group', 'users_groups', 'groups', 'user_id', 'group_id', 'name');

		$crud->unset_edit();
		$crud->unset_add();
		$data = $crud->render();

		$data = array_merge( (array) $data, $this->user_data());
		$this->load->view('new_admin/crud_view',$data);
	}

	public function fam() {
		$json = $this->get_chart_json();

		$data = $this->user_data();
		$data['fam'] = json_encode($json);
		$this->load->view('new_admin/fam', $data);
	}

	public function get_chart_json(){
		$ret_arr = array();
		$city_arr = $this->db->get("city_master")->result();
		foreach ($city_arr as $city_value) {
			$this->db->where("city_id", $city_value->id);
			$area_arr = $this->db->get("area_master")->result();
			foreach($area_arr as $area_value){
				$failed = count($this->db->query("select mb.machine_id, mb.camp_type, mb.completed, tab1.user_id, tab1.username, tab1.email, tab1.first_name, tab1.last_name, tab1.area_id, tab1.group_name, tab1.area_name from (SELECT t1.user_id, t1.username, t1.email, t1.first_name, t1.last_name, t1.area_id, t1.group_name, am.name AS area_name FROM (SELECT u.id AS user_id, u.username, u.email, u.first_name, u.last_name, u.area_id, g.name AS group_name FROM users u INNER JOIN users_groups ug ON u.id = ug.user_id INNER JOIN groups g ON ug.group_id = g.id)t1 INNER JOIN area_master am ON t1.area_id = am.id)tab1 inner join machine_booking mb on tab1.user_id = mb.user_id where mb.completed = '' and tab1.area_id = ".$area_value->id)->result());

				$success = count($this->db->query("select mb.machine_id, mb.camp_type, mb.completed, tab1.user_id, tab1.username, tab1.email, tab1.first_name, tab1.last_name, tab1.area_id, tab1.group_name, tab1.area_name from (SELECT t1.user_id, t1.username, t1.email, t1.first_name, t1.last_name, t1.area_id, t1.group_name, am.name AS area_name FROM (SELECT u.id AS user_id, u.username, u.email, u.first_name, u.last_name, u.area_id, g.name AS group_name FROM users u INNER JOIN users_groups ug ON u.id = ug.user_id INNER JOIN groups g ON ug.group_id = g.id)t1 INNER JOIN area_master am ON t1.area_id = am.id)tab1 inner join machine_booking mb on tab1.user_id = mb.user_id where mb.completed = '1' and tab1.area_id = ".$area_value->id)->result());

				// $total = count($this->db->query("select mb.machine_id, mb.camp_type, mb.completed, tab1.user_id, tab1.username, tab1.email, tab1.first_name, tab1.last_name, tab1.area_id, tab1.group_name, tab1.area_name from (SELECT t1.user_id, t1.username, t1.email, t1.first_name, t1.last_name, t1.area_id, t1.group_name, am.name AS area_name FROM (SELECT u.id AS user_id, u.username, u.email, u.first_name, u.last_name, u.area_id, g.name AS group_name FROM users u INNER JOIN users_groups ug ON u.id = ug.user_id INNER JOIN groups g ON ug.group_id = g.id)t1 INNER JOIN area_master am ON t1.area_id = am.id)tab1 inner join machine_booking mb on tab1.user_id = mb.user_id and tab1.area_id = ".$area_value->id)->result());
				$ret_arr[$city_value->name][$area_value->name]["num_failed"] = $failed;
				$ret_arr[$city_value->name][$area_value->name]["num_success"] = $success;
				// $ret_arr[$city_value->name][$area_value->name]["num_total"] = $total;
			}
		}
		return $ret_arr;
	}

	public function camp_booking() {
		$user = $this->ion_auth->user()->row();
		$group = $this->ion_auth->get_users_groups($user->id)->row();
		$senior = $this->ion_auth->users(array(1, 2, 3, 5, 6, 7))->result();
		$city = $this->db->query("SELECT * FROM city_master")->result();
		$area = $this->db->query("SELECT * FROM area_master")->result();
		$groups = $this->db->query("SELECT * FROM groups")->result();
		// echo(json_encode($groups));exit();
		$data = array(
			'user' => $user,
			'group' => $group,
			'senior' => $senior,
			'city' => $city,
			'area' => $area,
			'groups' => $groups,
		);
		$this->load->view('new_admin/camp_booking', $data);
	}

	public function machine_usability() {
		$user = $this->ion_auth->user()->row();
		$group = $this->ion_auth->get_users_groups($user->id)->row();
		$senior = $this->ion_auth->users(array(1, 2, 3, 5, 6, 7))->result();
		$city = $this->db->query("SELECT * FROM city_master")->result();
		$area = $this->db->query("SELECT * FROM area_master")->result();
		$groups = $this->db->query("SELECT * FROM groups")->result();
		// echo(json_encode($groups));exit();
		//
		$cities = $this->db->query("SELECT * FROM `city_master` ")->result();
		$max_date = $this->db->query("SELECT max(date) date FROM `machine_booking` ")->row();
		$min_date = $this->db->query("SELECT min(date) date FROM `machine_booking` ")->row();

		$max_date = substr($max_date->date, 0, 4);
		$min_date = substr($min_date->date, 0, 4);

		$data = array(
			'user' => $user,
			'group' => $group,
			'senior' => $senior,
			'city' => $city,
			'area' => $area,
			'groups' => $groups,
			'max_date' => $max_date,
			'min_date' => $min_date,
			'cities' => $cities,
		);
		$this->load->view('new_admin/machine_usability', $data);
	}

	public function machine_utilization() {
		$user = $this->ion_auth->user()->row();
		$group = $this->ion_auth->get_users_groups($user->id)->row();
		$senior = $this->ion_auth->users(array(1, 2, 3, 5, 6, 7))->result();
		$city = $this->db->query("SELECT * FROM city_master")->result();
		$area = $this->db->query("SELECT * FROM area_master")->result();
		$groups = $this->db->query("SELECT * FROM groups")->result();

		$cities = $this->db->query("SELECT * FROM `city_master` ")->result();
		$max_date = $this->db->query("SELECT max(date) date FROM `machine_booking` ")->row();
		$min_date = $this->db->query("SELECT min(date) date FROM `machine_booking` ")->row();

		$max_date = substr($max_date->date, 0, 4);
		$min_date = substr($min_date->date, 0, 4);

		$data = array(
			'user' => $user,
			'group' => $group,
			'senior' => $senior,
			'city' => $city,
			'area' => $area,
			'groups' => $groups,
			'max_date' => $max_date,
			'min_date' => $min_date,
			'cities' => $cities,
		);
		$this->load->view('new_admin/machine_utilization', $data);
	}

	public function get_tbm_data() {
		$location = $this->input->post('location');
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		$user = $this->input->post('user');

		if ($location=='' || $year=='' || $month=='' || $user=='') {
			$this->jsonify(array(
				'status' => 'fail',
				'data' => 'unauthorized access',
			));
			return FALSE;
		}

		$data = array(
			'location' => $location,
			'year' => $year,
			'month' => $month,
			'user' => $user,
		);

		$data = $this->get_tbm_machine_data($user, $year, $month);
		$data3 = $this->db->query("SELECT COUNT(DISTINCT(machine_booking.doctor_id)) AS count FROM machine_booking JOIN users ON machine_booking.user_id = users.id JOIN users_groups ON users.id = users_groups.user_id AND users_groups.group_id = 4")->result();
		$data4 = $this->db->query("SELECT COUNT(patients.id) AS count FROM machine_booking JOIN camp_details ON machine_booking.id = camp_details.machine_booking_id JOIN patients ON camp_details.id = patients.camp_details_id JOIN users ON machine_booking.user_id = users.id JOIN users_groups ON users.id = users_groups.user_id AND users_groups.group_id = 4")->result();

		$this->jsonify(array(
			'status' => 'success',
			'data' => $data,
			'data3' => $data3,
			'data4' => $data4,
		));
	}

	public function patient_camps() {
		$user = $this->ion_auth->user()->row();
		$group = $this->ion_auth->get_users_groups($user->id)->row();
		$senior = $this->ion_auth->users(array(1, 2, 3, 5, 6, 7))->result();
		$city = $this->db->query("SELECT * FROM city_master")->result();
		$area = $this->db->query("SELECT * FROM area_master")->result();
		$groups = $this->db->query("SELECT * FROM groups")->result();

		$cities = $this->db->query("SELECT * FROM `city_master` ")->result();
		$max_date = $this->db->query("SELECT max(date) date FROM `machine_booking` ")->row();
		$min_date = $this->db->query("SELECT min(date) date FROM `machine_booking` ")->row();

		$max_date = substr($max_date->date, 0, 4);
		$min_date = substr($min_date->date, 0, 4);

		$data = array(
			'user' => $user,
			'group' => $group,
			'senior' => $senior,
			'city' => $city,
			'area' => $area,
			'groups' => $groups,
			'max_date' => $max_date,
			'min_date' => $min_date,
			'cities' => $cities,
		);
		$this->load->view('new_admin/get_patient_camps', $data);
	}

	public function getcamp_clinic_count(){
		echo json_encode(array('data' => $this->db->query("SELECT COUNT(camp_type) AS count, camp_type FROM machine_booking GROUP BY camp_type")->result(),));
	}

	public function getgove_count(){
		echo json_encode(array('data' => $this->db->query("SELECT COUNT(type) AS count, type FROM machine_booking GROUP BY type")->result(),));
	}

	public function get_patient_camps_by_month($year=2016, $month=8, $location=2) {
		$data = array();
		for ($i=1; $i < 32; $i++) {
			$data[$i] = array();
		}

		// $patients = $this->db->query("SELECT COUNT(mb.date) count, mb.date date FROM patients p JOIN camp_details cd ON p.camp_details_id=cd.id JOIN machine_booking mb ON cd.machine_booking_id=mb.id JOIN machine m ON m.id=mb.machine_id AND mb.date BETWEEN '$year-$month-01' AND '$year-$month-31' GROUP BY mb.date")->result();

		// $camps = $this->db->query("SELECT CD.id, MB.date  FROM camp_details CD JOIN machine_booking MB ON CD.machine_booking_id=MB.id AND MB.date BETWEEN '$year-$month-01' AND '$year-$month-31' GROUP BY MB.date")->result();

		// $camps = $this->db->query("SELECT count(machine_booking.date) as count, machine_booking.date FROM machine_booking JOIN users ON machine_booking.user_id = users.id JOIN area_master ON users.area_id = area_master.id AND area_master.id = 2 AND (machine_booking.date BETWEEN '$year-$month-01' AND '$year-$month-31') GROUP BY machine_booking.date ORDER BY machine_booking.date")->result();

		$sql = "SELECT mb.id id, DATE_FORMAT(mb.date, '%e') AS date FROM machine_booking mb JOIN users u ON mb.user_id=u.id JOIN area_master am ON u.area_id=am.id AND am.id = $location AND (mb.date BETWEEN '$year-$month-01' AND '$year-$month-31')";
		$camps = $this->db->query($sql)->result();

		foreach ($camps as $key => $value) {
			$sql1 = "SELECT count(p.id) count, cd.id FROM patients p JOIN camp_details cd ON p.camp_details_id=cd.id JOIN machine_booking mb ON mb.id=cd.machine_booking_id AND mb.id=$value->id";
			$id = $this->db->query($sql1)->row()->id;
			$count = $this->db->query($sql1)->row()->count;

			$data[$value->date][$value->id] = $count;
		}

		$data1 = $this->db->query("SELECT COUNT(patients.indication) as count, machine_booking.id, machine_booking.date, patients.indication FROM patients JOIN camp_details ON patients.camp_details_id = camp_details.id JOIN machine_booking ON camp_details.machine_booking_id = machine_booking.id AND (machine_booking.date BETWEEN '2016-08-01' AND '2016-08-31') GROUP BY machine_booking.date, patients.indication ORDER BY machine_booking.date")->result();

		$disease_count = $this->db->get("disease_master")->result();

		ksort($data);

		foreach ($data as $key => $value) {
			if (empty($data[$key]))
				$data[$key] = (object) $data[$key];
		}

		// echo "<pre>";
		// print_r($data);exit();
		$this->jsonify(array(
			'status' => 'success',
			'data' => $data,
			'data1' => $this->test_function(),
			'disease_count' => $disease_count,
		));
	}

	public function test_function(){
		$year = '2016';
		// $month = $this->input->post('month');
		$month = 8;

		$data1 = $this->db->query("SELECT COUNT(patients.indication) as count, machine_booking.id, machine_booking.date, patients.indication FROM patients JOIN camp_details ON patients.camp_details_id = camp_details.id JOIN machine_booking ON camp_details.machine_booking_id = machine_booking.id AND (machine_booking.date BETWEEN '2016-08-01' AND '2016-08-31') GROUP BY machine_booking.date, patients.indication ORDER BY machine_booking.date")->result();
		$disease_count = $this->db->get("disease_master")->result();
		$response = '';
		$count_string = ',';
		foreach ($disease_count as $value) {
			$count_string = ',';
			for ($i=1; $i < 32; $i++) {
				$date = $year.'-'.$month.'-'.$i;
				$data = $this->db->query("SELECT COUNT(patients.indication) as count, machine_booking.id, machine_booking.date, patients.indication FROM patients JOIN camp_details ON patients.camp_details_id = camp_details.id JOIN machine_booking ON camp_details.machine_booking_id = machine_booking.id AND (machine_booking.date BETWEEN '2016-08-01' AND '2016-08-31') AND patients.indication = '".$value->name."' AND machine_booking.date = '".$date."' GROUP BY machine_booking.date, patients.indication ORDER BY machine_booking.date")->result();

				if ($data) {
					$count_string .= ', '.$data[0]->count;
				} else {
					$count_string .= ', '.'0';
				}
			}

			$response[$value->id] = array(
					'disease' => $value->name,
					'count' => str_replace(',, ', '', $count_string),
				);
		}
		return json_encode($response);
		// for ($i=0; $i < 31; $i++) {
		// 	$date = $year.'-'.$month.'-'.($i+1);
		// 	$data = $this->db->query("SELECT COUNT(patients.indication) as count, machine_booking.id, machine_booking.date, patients.indication FROM patients JOIN camp_details ON patients.camp_details_id = camp_details.id JOIN machine_booking ON camp_details.machine_booking_id = machine_booking.id AND (machine_booking.date BETWEEN '2016-08-01' AND '2016-08-31') AND machine_booking.date = '$date' GROUP BY machine_booking.date, patients.indication ORDER BY machine_booking.date")->result();
		// 	if ($data) {
		// 		// print_r($data);
		// 		foreach ($data as $value) {
		// 			foreach ($disease_count as $val) {
		// 				if ($value->indication == $val->name) {
		// 					$response[$date][$val->name] = array(
		// 							'disease' => $value->indication,
		// 							'count' => $value->count,
		// 						);
		// 				}
		// 			}
		// 		}
		// 	} else {
		// 		$response[$date] = 0;
		// 	}
		// }
		// print_r($response);
	}

	function get_bm_machine_data($tbm_id=12, $year=2016, $month=8) {
		$data = array();
		$sql = "SELECT * FROM machine_booking WHERE user_id IN (SELECT id FROM users WHERE senior_id IN (SELECT id FROM users WHERE senior_id = $tbm_id)) AND (date BETWEEN '2016-8-01' AND '2016-8-31') AND (date BETWEEN '$year-$month-01' AND '$year-$month-31')";
		$machine_data = $this->db->query($sql)->result();

		$total = 0;
		$completed = 0;
		$cancelled = 0;
		$planned = 0;

		foreach ($machine_data as $mdk => $mdv) {

			if ($mdv->completed=='true')
				$completed += 1;
			if ($mdv->cancel_approved=='true')
				$cancelled += 1;
			$total += 1;
		}

		$planned = $total - $completed - $cancelled;

		$data = array(
			'completed' => ''.$completed.'.0',
			'canceled' => ''.$cancelled.'.0',
			'planned' => ''.$planned.'.0',
			'total' => ''.$total.'.0',
		);

		// $this->jsonify(array(
		// 	'status' => 'success',
		// 	'data' => $data,
		// ));

		return $data;
	}

	function get_tbm_machine_data($tbm_id=8, $year=2016, $month=8) {
		$data = array();
		$sql = "SELECT * FROM `machine_booking` WHERE `user_id`=$tbm_id AND (`date` BETWEEN '$year-$month-01' AND '$year-$month-31');";
		$machine_data = $this->db->query($sql)->result();

		$total = 0;
		$completed = 0;
		$cancelled = 0;
		$planned = 0;

		foreach ($machine_data as $mdk => $mdv) {

			if ($mdv->completed=='true')
				$completed += 1;
			if ($mdv->cancel_approved=='true')
				$cancelled += 1;
			$total += 1;
		}

		$planned = $total - $completed - $cancelled;

		$data = array(
			'completed' => ''.$completed.'.0',
			'canceled' => ''.$cancelled.'.0',
			'planned' => ''.$planned.'.0',
			'total' => ''.$total.'.0',
		);

		// $this->jsonify(array(
		// 	'status' => 'success',
		// 	'data' => $data,
		// ));

		return $data;
	}

	function get_fam_machine_data($fam_id=4, $year=2016, $month=8) {
		// $fam_id = 13;
		$data = array();

		$sql = "SELECT * FROM users WHERE senior_id=$fam_id";
		$users = $this->db->query($sql)->result();

		foreach ($users as $uk => $uv) {
			$sql = "SELECT * FROM `machine_booking` WHERE `user_id`=$uv->id AND (`date` BETWEEN '$year-$month-01' AND '$year-$month-31');";
			$machine_data[] = $this->db->query($sql)->result();
		}
		$sql = "SELECT * FROM `machine_booking` WHERE `user_id`=$fam_id AND (`date` BETWEEN '$year-$month-01' AND '$year-$month-31');";
		$machine_data[] = $this->db->query($sql)->result();

		// echo("<pre>");
		// print_r($machine_data);exit();

		$total = 0;
		$completed = 0;
		$cancelled = 0;
		$planned = 0;

		foreach ($machine_data as $mdk => $mdv) {

			foreach ($mdv as $key => $value) {
				if ($value->completed=='true')
					$completed += 1;
				if ($value->cancel_approved=='true')
					$cancelled += 1;
				$total += 1;
			}
		}

		$planned = $total - ($completed + $cancelled);

		$data = array(
			'completed' => ''.$completed.'.0',
			'canceled' => ''.$cancelled.'.0',
			'planned' => ''.$planned.'.0',
			'total' => ''.$total.'.0',
		);

		// $this->jsonify(array(
		// 	'status' => 'success',
		// 	'data' => $data,
		// ));

		return $data;
		// cursor
	}

	public function get_machine_utilization() {
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		$location = $this->input->post('location');

		$data = array();

		//
		$single_area = array();

		$sql = "SELECT m.*, am.id area_id FROM machine m JOIN users u ON m.user_id = u.id JOIN area_master am ON u.area_id = am.id  WHERE am.id=$location";

		$machines = $this->db->query($sql)->result();
		if (count($machines)>0) {
			foreach ($machines as $mk => $mv) {
				$total = 0;
				$completed = 0;
				$cancelled = 0;
				$planned = 0;

				$sql = "SELECT * FROM `machine_booking` WHERE `machine_id`=$mv->id AND (`date` BETWEEN '$year-$month-01' AND '$year-$month-30');";

				$booked_machines = $this->db->query($sql)->result();

				foreach ($booked_machines as $bmk => $bmv) {
					if ($bmv->completed=='true')
						$completed += 1;
					if ($bmv->cancel_approved=='true')
						$cancelled += 1;
					$total += 1;
				}

				$planned = $total - ($completed + $cancelled);

				$single_machine = array(
					'completed' => ''.$completed.'.0',
					'canceled' => ''.$cancelled.'.0',
					'planned' => ''.$planned.'.0',
					'total' => ''.$total.'.0',
				);
				$data[$mv->name] = $single_machine;
				// $single_area[$mv->name] = $single_machine;
			}
		}
		//
		//
		$this->jsonify(array(
			'status' => 'success',
			'data' => $data,
		));
		exit();

		$city_master = $this->db->query("SELECT * FROM city_master")->result();

		foreach ($city_master as $key => $value) {
			$single_city = array();
			$area_master = $this->db->query("SELECT * FROM area_master WHERE city_id=$value->id")->result();

			foreach ($area_master as $amk => $amv) {
				//
			}
			if ($single_city)
				$data[$value->name] = $single_city;
		}

		$this->jsonify(array(
			'status' => 'success',
			'data' => $data,
		));
	}

	public function get_camp_booking() {
		$year = $this->input->post('year');
		$month = $this->input->post('month');

		$data = array();
		$city_master = $this->db->query("SELECT * FROM city_master")->result();

		foreach ($city_master as $key => $value) {
			$single_city = array();
			$area_master = $this->db->query("SELECT * FROM area_master WHERE city_id=$value->id")->result();

			foreach ($area_master as $amk => $amv) {
				$single_area = array();

				$sql = "SELECT m.*, am.id area_id FROM machine m JOIN users u ON m.user_id = u.id JOIN area_master am ON u.area_id = am.id  WHERE am.id=$amv->id";

				$machines = $this->db->query($sql)->result();
				if (count($machines)>0) {
					foreach ($machines as $mk => $mv) {
						$total = 0;
						$completed = 0;
						$cancelled = 0;

						$sql = "SELECT * FROM `machine_booking` WHERE `machine_id`=$mv->id AND (`date` BETWEEN '$year-$month-01' AND '$year-$month-30');";

						$booked_machines = $this->db->query($sql)->result();

						foreach ($booked_machines as $bmk => $bmv) {
							if ($bmv->completed=='true')
								$completed += 1;
							if ($bmv->cancel_approved=='true')
								$cancelled += 1;
							$total += 1;
						}

						$cancelled=$cancelled+2;
						$single_machine = array(
							'completed' => ''.$completed.'.0',
							'canceled' => ''.$cancelled.'.0',
							'total' => ''.$total.'.0',
						);

						// $single_area[$mv->name] = $single_machine;
					}
					$single_city[$amv->name] = $single_machine;
				}
			}
			if ($single_city)
				$data[$value->name] = $single_city;
		}

		$this->jsonify(array(
			'status' => 'success',
			'data' => $data,
		));
	}

	public function get_machine_usability() {
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		$location = $this->input->post('location');

		$data = array();

		//
		$single_area = array();

		$sql = "SELECT m.*, am.id area_id FROM machine m JOIN users u ON m.user_id = u.id JOIN area_master am ON u.area_id = am.id  WHERE am.id=$location";

		$machines = $this->db->query($sql)->result();
		if (count($machines)>0) {
			foreach ($machines as $mk => $mv) {
				$total = 0;
				$completed = 0;
				$cancelled = 0;
				$planned = 0;

				$sql = "SELECT * FROM `machine_booking` WHERE `machine_id`=$mv->id AND (`date` BETWEEN '$year-$month-01' AND '$year-$month-30');";

				$booked_machines = $this->db->query($sql)->result();

				foreach ($booked_machines as $bmk => $bmv) {
					if ($bmv->completed=='true')
						$completed += 1;
					if ($bmv->cancel_approved=='true')
						$cancelled += 1;
					$total += 1;
				}

				$planned = $total - ($completed + $cancelled);

				$single_machine = array(
					'completed' => ''.$completed.'.0',
					'canceled' => ''.$cancelled.'.0',
					'planned' => ''.$planned.'.0',
					'total' => ''.$total.'.0',
				);
				$data[$mv->name] = $single_machine;
				// $single_area[$mv->name] = $single_machine;
			}
		}
		//
		//
		$this->jsonify(array(
			'status' => 'success',
			'data' => $data,
		));exit();
		//

		$city_master = $this->db->query("SELECT * FROM city_master")->result();

		foreach ($city_master as $key => $value) {
			$single_city = array();
			$area_master = $this->db->query("SELECT * FROM area_master WHERE city_id=$value->id")->result();

			foreach ($area_master as $amk => $amv) {
				//
			}
			if ($single_city)
				$data[$value->name] = $single_city;
		}

		$this->jsonify(array(
			'status' => 'success',
			'data' => $data,
		));
	}

	public function fam_data() {
		$user = $this->ion_auth->user()->row();
		$group = $this->ion_auth->get_users_groups($user->id)->row();
		$senior = $this->ion_auth->users(array(1, 2, 3, 5, 6, 7))->result();
		$city = $this->db->query("SELECT * FROM city_master")->result();
		$area = $this->db->query("SELECT * FROM area_master")->result();
		$groups = $this->db->query("SELECT * FROM groups")->result();

		$cities = $this->db->query("SELECT * FROM `city_master` ")->result();
		$max_date = $this->db->query("SELECT max(date) date FROM `machine_booking` ")->row();
		$min_date = $this->db->query("SELECT min(date) date FROM `machine_booking` ")->row();

		$max_date = substr($max_date->date, 0, 4);
		$min_date = substr($min_date->date, 0, 4);

		$data = array(
			'user' => $user,
			'group' => $group,
			'senior' => $senior,
			'city' => $city,
			'area' => $area,
			'groups' => $groups,
			'max_date' => $max_date,
			'min_date' => $min_date,
			'cities' => $cities,
		);
		$this->load->view('new_admin/fam_data', $data);
	}

	public function tbm_data() {
		$user = $this->ion_auth->user()->row();
		$group = $this->ion_auth->get_users_groups($user->id)->row();
		$senior = $this->ion_auth->users(array(1, 2, 3, 5, 6, 7))->result();
		$city = $this->db->query("SELECT * FROM city_master")->result();
		$area = $this->db->query("SELECT * FROM area_master")->result();
		$groups = $this->db->query("SELECT * FROM groups")->result();

		$cities = $this->db->query("SELECT * FROM `city_master` ")->result();
		$max_date = $this->db->query("SELECT max(date) date FROM `machine_booking` ")->row();
		$min_date = $this->db->query("SELECT min(date) date FROM `machine_booking` ")->row();

		$max_date = substr($max_date->date, 0, 4);
		$min_date = substr($min_date->date, 0, 4);

		$data = array(
			'user' => $user,
			'group' => $group,
			'senior' => $senior,
			'city' => $city,
			'area' => $area,
			'groups' => $groups,
			'max_date' => $max_date,
			'min_date' => $min_date,
			'cities' => $cities,
		);
		$this->load->view('new_admin/tbm_data', $data);
	}

	public function get_user_by_location() {
		$area_id = $this->input->post('location');
		$user_type = $this->input->post('user_type');
		if ($area_id=='') {
			$this->jsonify(array(
				'status' => 'fail',
				'data' => 'unauthorized access',
			));
			return FALSE;
		}

		$users = $this->db->query("SELECT u.id, u.first_name FROM users u JOIN users_groups ug ON u.id=ug.user_id JOIN groups g ON g.id=ug.group_id AND g.name='$user_type' WHERE area_id=$area_id")->result();

		$this->jsonify(array(
			'status' => 'success',
			'data' => $users,
		));
	}

	public function get_fam_data() {
		$location = $this->input->post('location');
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		$user = $this->input->post('user');

		if ($location=='' || $year=='' || $month=='' || $user=='') {
			$this->jsonify(array(
				'status' => 'fail',
				'data' => 'unauthorized access',
			));
			return FALSE;
		}

		$data = array(
			'location' => $location,
			'year' => $year,
			'month' => $month,
			'user' => $user,
		);

		$data = $this->get_fam_machine_data($user, $year, $month);
		$data1 = $this->db->query("SELECT COUNT(DISTINCT(machine_booking.doctor_id)) AS count FROM machine_booking JOIN users ON machine_booking.user_id = users.id JOIN users_groups ON users.id = users_groups.user_id AND users_groups.group_id = 2")->result();
		$data2 = $this->db->query("SELECT COUNT(patients.id) AS count FROM machine_booking JOIN camp_details ON machine_booking.id = camp_details.machine_booking_id JOIN patients ON camp_details.id = patients.camp_details_id JOIN users ON machine_booking.user_id = users.id JOIN users_groups ON users.id = users_groups.user_id AND users_groups.group_id = 2")->result();

		$this->jsonify(array(
			'status' => 'success',
			'data' => $data,
			'data1' => $data1,
			'data2' => $data2,
		));
	}

    public function patients(){
    	// echo "Working on it Bitches do not access this";
		$user = $this->ion_auth->user()->row();
		$group = $this->ion_auth->get_users_groups($user->id)->row();
		$senior = $this->ion_auth->users(array(1, 2, 3, 5, 6, 7))->result();
		$city = $this->db->query("SELECT * FROM city_master")->result();
		$area = $this->db->query("SELECT * FROM area_master")->result();
		$groups = $this->db->query("SELECT * FROM groups")->result();
		// echo(json_encode($groups));exit();
		//
		$cities = $this->db->query("SELECT * FROM `city_master` ")->result();
		$max_date = $this->db->query("SELECT max(date) date FROM `machine_booking` ")->row();
		$min_date = $this->db->query("SELECT min(date) date FROM `machine_booking` ")->row();

		$max_date = substr($max_date->date, 0, 4);
		$min_date = substr($min_date->date, 0, 4);

		$data = array(
			'user' => $user,
			'group' => $group,
			'senior' => $senior,
			'city' => $city,
			'area' => $area,
			'groups' => $groups,
			'max_date' => $max_date,
			'min_date' => $min_date,
			'cities' => $cities,
		);

    	$data['city'] = $this->db->get("city_master")->result_array();
    	$data['location'] = $this->db->get("area_master")->result_array();

    	$this->load->view("new_admin/patients", $data);
    }

    public function get_patients_age(){
    	$addquery = '';
    	if ($this->input->post('start_date')) {
    		$addquery += 'AND machine_booking.date >= "'.$this->input->post('start_date').'"';
    	} elseif ($this->input->post('end_date')) {
    		$addquery += 'AND machine_booking.date <= "'.$this->input->post('end_date').'"';
    	} elseif ($this->input->post('city') != 0) {
    		$addquery += 'AND city_master.id = "'.$this->input->post('city').'"';
    	} elseif ($this->input->post('location') != 0) {
    		$addquery += 'AND area_master.id = "'.$this->input->post('location').'"';
    	}
		$data = $this->db->query("SELECT patients.age as name, COUNT(patients.age) as count, patients.age as drilldown FROM patients JOIN machine_booking ON patients.camp_details_id = machine_booking.id JOIN users ON machine_booking.user_id = users.id JOIN area_master ON users.area_id = area_master.id JOIN city_master ON area_master.city_id = city_master.id GROUP BY patients.age")->result();

		$data1 = $this->db->query("SELECT patients.gender as name, COUNT(patients.gender) as count, patients.gender as drilldown FROM patients JOIN machine_booking ON patients.camp_details_id = machine_booking.id JOIN users ON machine_booking.user_id = users.id JOIN area_master ON users.area_id = area_master.id JOIN city_master ON area_master.city_id = city_master.id GROUP BY patients.gender")->result();

		$data2 = $this->db->query("SELECT patients.indication as name, COUNT(patients.indication) as count, patients.indication as drilldown FROM patients JOIN machine_booking ON patients.camp_details_id = machine_booking.id JOIN users ON machine_booking.user_id = users.id JOIN area_master ON users.area_id = area_master.id JOIN city_master ON area_master.city_id = city_master.id GROUP BY patients.indication")->result();

		$data3 = $this->db->query("SELECT * FROM (SELECT patients.indication as name, COUNT(patients.indication) as count, patients.indication as drilldown FROM patients JOIN machine_booking ON patients.camp_details_id = machine_booking.id JOIN users ON machine_booking.user_id = users.id JOIN area_master ON users.area_id = area_master.id JOIN city_master ON area_master.city_id = city_master.id JOIN disease_master ON patients.indication = disease_master.name AND patients.indication IN (SELECT indication FROM patients WHERE indication != 'None' AND indication != 'Other')) AS demo1 UNION SELECT * FROM (SELECT patients.indication as name, COUNT(patients.indication) as count, patients.indication as drilldown FROM patients JOIN machine_booking ON patients.camp_details_id = machine_booking.id JOIN users ON machine_booking.user_id = users.id JOIN area_master ON users.area_id = area_master.id JOIN city_master ON area_master.city_id = city_master.id JOIN disease_master ON patients.indication = disease_master.name AND patients.indication IN (SELECT indication FROM patients WHERE indication = 'None')) AS demo2 UNION SELECT * FROM (SELECT patients.indication as name, COUNT(patients.indication) as count, patients.indication as drilldown FROM patients JOIN machine_booking ON patients.camp_details_id = machine_booking.id JOIN users ON machine_booking.user_id = users.id JOIN area_master ON users.area_id = area_master.id JOIN city_master ON area_master.city_id = city_master.id JOIN disease_master ON patients.indication = disease_master.name AND patients.indication IN (SELECT indication FROM patients WHERE indication = 'Other')) AS demo3")->result();

		$data4 = '';
		$mnths = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec");

		$disease = $this->db->query("SELECT name FROM disease_master WHERE name != 'None'");
		foreach ($disease->result() as $value) {
			for ($i=1; $i < 13; $i++) {
				$res = $this->db->query("SELECT COUNT(patients.indication) AS count, patients.indication, ".$i." as month FROM machine_booking JOIN patients ON machine_booking.id = patients.camp_details_id AND patients.indication = '".$value->name."' AND MONTH(machine_booking.date) = ".$i." GROUP BY patients.indication")->result_array();
				// print_r($res);
				$data4[$value->name][$i] = array(
					"month" => $mnths[$i-1],
					"count" => $res,
					);
			}
		}

		$this->jsonify(array(
				'data' => $data,
				'data1' => $data1,
				'data2' => $data2,
				'data3' => $data3,
				'data4' => $data4,
			));
    }

    public function getListByUser(){
		$user = $this->ion_auth->user()->row();
		$group = $this->ion_auth->get_users_groups($user->id)->row();
		$senior = $this->ion_auth->users(array(1, 2, 3, 5, 6, 7))->result();
		$city = $this->db->query("SELECT * FROM city_master")->result();
		$area = $this->db->query("SELECT * FROM area_master")->result();
		$groups = $this->db->query("SELECT * FROM groups")->result();

		$data = array(
			'user' => $user,
			'group' => $group,
			'senior' => $senior,
			'city' => $city,
			'area' => $area,
			'groups' => $groups,
		);

    	$this->load->view("new_admin/listbyuser", $data);
    }

    public function getListHo(){
    	echo json_encode($this->db->query("SELECT users.first_name, users.last_name, users.id FROM users JOIN users_groups ON users.id = users_groups.user_id AND users_groups.group_id = 6")->result());
    }

    public function getListBM(){
    	echo json_encode($this->db->query("SELECT users.first_name, users.last_name, users.id, users.senior_id FROM users JOIN users_groups ON users.id = users_groups.user_id AND users_groups.group_id = 7 AND users.senior_id = ".$this->input->post('userID'))->result());
    }

    public function getListABM(){
    	echo json_encode($this->db->query("SELECT users.first_name, users.last_name, users.id, users.senior_id FROM users JOIN users_groups ON users.id = users_groups.user_id AND users_groups.group_id = 5 AND users.senior_id = ".$this->input->post('userID'))->result());
    }

    public function getListFAM(){
    	echo json_encode($this->db->query("SELECT users.first_name, users.last_name, users.id, users.senior_id FROM users JOIN users_groups ON users.id = users_groups.user_id AND users_groups.group_id = 2 AND users.senior_id = ".$this->input->post('userID'))->result());
    }

    public function getDataForList(){
    	$usertype = 6;
    	$userID = "";
    	$querystr = '';
    	$querystr2 = '';
    	if ($this->input->post("usertype") == "BM") {
    		$usertype = 7;
    		$userID = $this->input->post("userId");
    		$querystr = "SELECT COUNT(doctor_master.id) AS COUNT, doctor_master.name FROM patients LEFT JOIN camp_details ON patients.camp_details_id = camp_details.id JOIN machine_booking ON camp_details.machine_booking_id = machine_booking.id JOIN doctor_master ON machine_booking.doctor_id = doctor_master.id JOIN (SELECT id FROM users WHERE senior_id IN (SELECT id FROM users WHERE senior_id = ".$this->input->post("userID").")) AS users ON machine_booking.user_id = users.id GROUP BY doctor_master.id";
    		$querystr2 = "SELECT COUNT(disease_master.name) AS COUNT, disease_master.name FROM patients LEFT JOIN camp_details ON patients.camp_details_id = camp_details.id JOIN machine_booking ON camp_details.machine_booking_id = machine_booking.id JOIN disease_master ON patients.indication = disease_master.name JOIN (SELECT id FROM users WHERE senior_id IN (SELECT id FROM users WHERE senior_id = ".$this->input->post("userID").")) AS users ON machine_booking.user_id = users.id GROUP BY disease_master.name";
    	} elseif ($this->input->post("usertype") == "ABM") {
    		$usertype = 5;
    		$userID = $this->input->post("userId");
    		$querystr = "SELECT COUNT(doctor_master.id) AS COUNT, doctor_master.name FROM patients LEFT JOIN camp_details ON patients.camp_details_id = camp_details.id JOIN machine_booking ON camp_details.machine_booking_id = machine_booking.id JOIN doctor_master ON machine_booking.doctor_id = doctor_master.id JOIN (SELECT id FROM users WHERE senior_id = ".$this->input->post("userID").") AS users ON machine_booking.user_id = users.id GROUP BY doctor_master.id";
    		$querystr2 = "SELECT COUNT(disease_master.name) AS COUNT, disease_master.name FROM patients LEFT JOIN camp_details ON patients.camp_details_id = camp_details.id JOIN machine_booking ON camp_details.machine_booking_id = machine_booking.id JOIN disease_master ON patients.indication = disease_master.name JOIN (SELECT id FROM users WHERE senior_id = ".$this->input->post("userID").") AS users ON machine_booking.user_id = users.id GROUP BY disease_master.name";
    	} elseif ($this->input->post("usertype") == "FAM") {
    		$usertype = 2;
    		$userID = $this->input->post("userId");
    		$querystr = "SELECT COUNT(doctor_master.id) AS COUNT, doctor_master.name FROM patients LEFT JOIN camp_details ON patients.camp_details_id = camp_details.id JOIN machine_booking ON camp_details.machine_booking_id = machine_booking.id JOIN doctor_master ON machine_booking.doctor_id = doctor_master.id JOIN users ON machine_booking.user_id = users.id AND (users.senior_id = ".$this->input->post("userID")." OR users.id = ".$this->input->post("userID").") GROUP BY doctor_master.id";
    		$querystr2 = "SELECT COUNT(disease_master.name) AS COUNT, disease_master.name FROM patients LEFT JOIN camp_details ON patients.camp_details_id = camp_details.id JOIN machine_booking ON camp_details.machine_booking_id = machine_booking.id JOIN disease_master ON patients.indication = disease_master.name JOIN users ON machine_booking.user_id = users.id AND (users.senior_id = ".$this->input->post("userID")." OR users.id = ".$this->input->post("userID").") GROUP BY disease_master.name";
    	} elseif ($this->input->post("usertype") == "HO") {
    		if ($this->input->post("userID")) {
	    		$querystr = "SELECT COUNT(doctor_master.id) AS COUNT, doctor_master.name FROM patients LEFT JOIN camp_details ON patients.camp_details_id = camp_details.id JOIN machine_booking ON camp_details.machine_booking_id = machine_booking.id JOIN doctor_master ON machine_booking.doctor_id = doctor_master.id JOIN (SELECT id FROM users WHERE senior_id IN (SELECT id FROM users WHERE senior_id IN (SELECT id FROM users WHERE senior_id = ".$this->input->post("userID")."))) AS users ON machine_booking.user_id = users.id GROUP BY doctor_master.id";
	    		$querystr2 = "SELECT COUNT(disease_master.name) AS COUNT, disease_master.name FROM patients LEFT JOIN camp_details ON patients.camp_details_id = camp_details.id JOIN machine_booking ON camp_details.machine_booking_id = machine_booking.id JOIN disease_master ON patients.indication = disease_master.name JOIN (SELECT id FROM users WHERE senior_id IN (SELECT id FROM users WHERE senior_id IN (SELECT id FROM users WHERE senior_id = ".$this->input->post("userID")."))) AS users ON machine_booking.user_id = users.id GROUP BY disease_master.name";
    		} else {
	    		$querystr = "SELECT COUNT(doctor_master.id) AS COUNT, doctor_master.name FROM patients LEFT JOIN camp_details ON patients.camp_details_id = camp_details.id JOIN machine_booking ON camp_details.machine_booking_id = machine_booking.id JOIN doctor_master ON machine_booking.doctor_id = doctor_master.id GROUP BY doctor_master.id";
	    		$querystr2 = "SELECT COUNT(disease_master.name) AS COUNT, disease_master.name FROM patients LEFT JOIN camp_details ON patients.camp_details_id = camp_details.id JOIN machine_booking ON camp_details.machine_booking_id = machine_booking.id JOIN disease_master ON patients.indication = disease_master.name GROUP BY disease_master.name";
    		}
    	}

    	$res = $this->db->query($querystr);
    	$res1 = $this->db->query($querystr2);

		echo json_encode(array('data' => $res->result(), 'data1' => $res1->result(), 'status' => 'success', 'usertype' => $usertype));
    }

  //   public function load_chart(){
		// $user = $this->ion_auth->user()->row();
		// $group = $this->ion_auth->get_users_groups($user->id)->row();
		// $senior = $this->ion_auth->users(array(1, 2, 3, 5, 6, 7))->result();
		// $city = $this->db->query("SELECT * FROM city_master")->result();
		// $area = $this->db->query("SELECT * FROM area_master")->result();
		// $groups = $this->db->query("SELECT * FROM groups")->result();

		// $data = array(
		// 	'user' => $user,
		// 	'group' => $group,
		// 	'senior' => $senior,
		// 	'city' => $city,
		// 	'area' => $area,
		// 	'groups' => $groups,
		// );

  //   	$this->load->view("new_admin/addchart", $data);
  //   }

	public function load_chart() {
		$user = $this->ion_auth->user()->row();
		$group = $this->ion_auth->get_users_groups($user->id)->row();
		$senior = $this->ion_auth->users(array(1, 2, 3, 5, 6, 7))->result();
		$city = $this->db->query("SELECT * FROM city_master")->result();
		$area = $this->db->query("SELECT * FROM area_master")->result();
		$groups = $this->db->query("SELECT * FROM groups")->result();

		$cities = $this->db->query("SELECT * FROM `city_master` ")->result();
		$max_date = $this->db->query("SELECT max(date) date FROM `machine_booking` ")->row();
		$min_date = $this->db->query("SELECT min(date) date FROM `machine_booking` ")->row();

		$max_date = substr($max_date->date, 0, 4);
		$min_date = substr($min_date->date, 0, 4);

		$data = array(
			'user' => $user,
			'group' => $group,
			'senior' => $senior,
			'city' => $city,
			'area' => $area,
			'groups' => $groups,
			'max_date' => $max_date,
			'min_date' => $min_date,
			'cities' => $cities,
		);
		$this->load->view('new_admin/addchart', $data);
	}

	public function get_bm_data() {
		// $location = $this->input->post('location');
		// print_r(  );
		$location = $this->ion_auth->user()->row()->area_id;
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		$user = $this->input->post('user');

		if ($location=='' || $year=='' || $month=='' || $user=='') {
			$this->jsonify(array(
				'status' => 'fail',
				'data' => 'unauthorized access',
			));
			return FALSE;
		}

		$data = array(
			'location' => $location,
			'year' => $year,
			'month' => $month,
			'user' => $user,
		);

		$data = $this->get_tbm_machine_data($user, $year, $month);
		$data3 = $this->db->query("SELECT COUNT(DISTINCT(doctor_master.id)) AS count FROM machine_booking JOIN doctor_master ON machine_booking.doctor_id = doctor_master.id JOIN (SELECT * FROM users WHERE senior_id IN (SELECT id FROM users WHERE senior_id IN (SELECT users.id FROM users JOIN users_groups ON users.id = users_groups.user_id AND users_groups.group_id = 7))) AS users ON machine_booking.user_id = users.id")->result();
		$data4 = $this->db->query("SELECT COUNT(patients.id) AS count FROM machine_booking JOIN (SELECT * FROM users WHERE senior_id IN (SELECT id FROM users WHERE senior_id IN (SELECT users.id FROM users JOIN users_groups ON users.id = users_groups.user_id AND users_groups.group_id = 7))) AS users ON machine_booking.user_id = users.id JOIN camp_details ON machine_booking.id = camp_details.machine_booking_id RIGHT JOIN patients ON camp_details.id = patients.camp_details_id")->result();

		$this->jsonify(array(
			'status' => 'success',
			'data' => $data,
			'data3' => $data3,
			'data4' => $data4,
		));
	}

	public function dump($req = array()) {
		$data =
		'[
		        {
		            "hc-key": "in-5390",
		            "value": 0
		        },
		        {
		            "hc-key": "in-py",
		            "value": 1
		        },
		        {
		            "hc-key": "in-ld",
		            "value": 2
		        },
		        {
		            "hc-key": "in-an",
		            "value": 3
		        },
		        {
		            "hc-key": "in-wb",
		            "value": 4
		        },
		        {
		            "hc-key": "in-or",
		            "value": 5
		        },
		        {
		            "hc-key": "in-br",
		            "value": 6
		        },
		        {
		            "hc-key": "in-sk",
		            "value": 7
		        },
		        {
		            "hc-key": "in-ct",
		            "value": 8
		        },
		        {
		            "hc-key": "in-tn",
		            "value": 9
		        },
		        {
		            "hc-key": "in-mp",
		            "value": 10
		        },
		        {
		            "hc-key": "in-2984",
		            "value": 11
		        },
		        {
		            "hc-key": "in-ga",
		            "value": 12
		        },
		        {
		            "hc-key": "in-nl",
		            "value": 13
		        },
		        {
		            "hc-key": "in-mn",
		            "value": 14
		        },
		        {
		            "hc-key": "in-ar",
		            "value": 15
		        },
		        {
		            "hc-key": "in-mz",
		            "value": 16
		        },
		        {
		            "hc-key": "in-tr",
		            "value": 17
		        },
		        {
		            "hc-key": "in-3464",
		            "value": 18
		        },
		        {
		            "hc-key": "in-dl",
		            "value": 19
		        },
		        {
		            "hc-key": "in-hr",
		            "value": 20
		        },
		        {
		            "hc-key": "in-ch",
		            "value": 21
		        },
		        {
		            "hc-key": "in-hp",
		            "value": 22
		        },
		        {
		            "hc-key": "in-jk",
		            "value": 23
		        },
		        {
		            "hc-key": "in-kl",
		            "value": 24
		        },
		        {
		            "hc-key": "in-ka",
		            "value": 25
		        },
		        {
		            "hc-key": "in-dn",
		            "value": 26
		        },
		        {
		            "hc-key": "in-mh",
		            "value": 27
		        },
		        {
		            "hc-key": "in-as",
		            "value": 28
		        },
		        {
		            "hc-key": "in-ap",
		            "value": 29
		        },
		        {
		            "hc-key": "in-ml",
		            "value": 30
		        },
		        {
		            "hc-key": "in-pb",
		            "value": 31
		        },
		        {
		            "hc-key": "in-rj",
		            "value": 32
		        },
		        {
		            "hc-key": "in-up",
		            "value": 33
		        },
		        {
		            "hc-key": "in-ut",
		            "value": 34
		        },
		        {
		            "hc-key": "in-jh",
		            "value": 35
		        }
		    ]';

		    $arr = json_decode($data);
		    echo "<pre>";
		    print_r($arr);
		    echo "</pre>";

		    echo "<br><br><br><br>";

		    foreach ($arr as $key => $value) {
		    	$value = (array) $value;
		    	$sql = "INSERT INTO `state_master`(`name`, `hc-key`) VALUES ('".$value['hc-key']."', '".$value['hc-key']."');  <br>";
		    	echo $sql;
		    }
	}

	function jsonify($arr) {
		echo(json_encode((object) $arr));
	}

	public function list_data(){
		$user = $this->ion_auth->user()->row();
		$group = $this->ion_auth->get_users_groups($user->id)->row();

		$data = array(
			'user' => $user,
			'group' => $group,
			'city' => $this->db->get("city_master")->result_array(),
			'location' => $this->db->get("area_master")->result_array(),
		);
		$this->load->view('new_admin/datalistpage', $data);
	}

	public function get_datalist_data(){
		$month = date('m');
		$year = date('Y');

		$defaulter_list = $this->db->query("SELECT * FROM (SELECT users.first_name, COUNT(users.id) AS count FROM machine_booking JOIN machine ON machine_booking.machine_id = machine.id JOIN users ON machine.user_id = users.id AND unlock_request != '' AND (machine_booking.date BETWEEN '$year-$month-01' AND '$year-$month-31') GROUP BY users.id) AS demo ORDER BY count LIMIT 5")->result();

		// $defaulter_list = $this->db->query("SELECT * FROM (SELECT users.first_name, COUNT(users.id) AS count FROM machine_booking JOIN machine ON machine_booking.machine_id = machine.id JOIN users ON machine.user_id = users.id AND unlock_request != '' AND (machine_booking.date BETWEEN '2016-08-01' AND '2016-08-31') GROUP BY users.id) AS demo ORDER BY count LIMIT 5")->result();

    	// $data['city'] = $this->db->get("city_master")->result_array();
    	// $data['location'] = $this->db->get("area_master")->result_array();

		$data = array(
				'data1' => $defaulter_list,
			);
		echo json_encode($data);
	}

	public function get_filterdata_datalist(){
		$month = date('m');
		$year = date('Y');
		$addquery = '';

		if ($this->input->post('start_date') != '') {
			$addquery .= 'AND machine_booking.date >= "'.$this->input->post('start_date').'"';
		}

		if ($this->input->post('end_date')) {
    		$addquery .= 'AND machine_booking.date <= "'.$this->input->post('end_date').'"';
    	}
    	if ($this->input->post('city') != 0) {
    		$addquery .= 'AND city_master.id = "'.$this->input->post('city').'"';
    	}
    	if ($this->input->post('location') != 0) {
    		$addquery .= 'AND area_master.id = "'.$this->input->post('location').'"';
    	}

    	// $querystr = "SELECT * FROM (SELECT users.first_name, COUNT(users.id) AS count FROM machine_booking JOIN machine ON machine_booking.machine_id = machine.id JOIN users ON machine.user_id = users.id AND unlock_request != '' ".$addquery." AND (machine_booking.date BETWEEN '$year-$month-01' AND '$year-$month-31') GROUP BY users.id) AS demo ORDER BY count LIMIT 5";

		$defaulter_list = $this->db->query("SELECT * FROM (SELECT users.first_name, COUNT(users.id) AS count FROM machine_booking JOIN machine ON machine_booking.machine_id = machine.id JOIN users ON machine.user_id = users.id JOIN city_master ON city_master.id = users.city AND unlock_request != '' ".$addquery." GROUP BY users.id) AS demo ORDER BY count LIMIT 5")->result();

		// $defaulter_list = $this->db->query("SELECT * FROM (SELECT users.first_name, COUNT(users.id) AS count FROM machine_booking JOIN machine ON machine_booking.machine_id = machine.id JOIN users ON machine.user_id = users.id AND unlock_request != '' ".$addquery." AND (machine_booking.date BETWEEN '2016-08-01' AND '2016-08-31') GROUP BY users.id) AS demo ORDER BY count LIMIT 5")->result();

		$data = array(
				'data1' => $defaulter_list,
			);

		echo json_encode($data);
	}

	public function fam_list(){
		$user = $this->ion_auth->user()->row();
		$group = $this->ion_auth->get_users_groups($user->id)->row();

		$data = array(
			'user' => $user,
			'group' => $group,
			'city' => $this->db->get("city_master")->result_array(),
			'location' => $this->db->get("area_master")->result_array(),
		);
		$this->load->view('new_admin/fam_list', $data);
	}

	public function get_famlist_data(){
		echo json_encode($this->db->query("SELECT demo.*, COUNT(users.id) AS tbm_count FROM (SELECT users.id, users.first_name, users.last_name, users.email, area_master.name AS area, city_master.name AS city FROM users JOIN users_groups ON users.id = users_groups.user_id JOIN area_master ON users.area_id = area_master.id JOIN city_master ON area_master.city_id = city_master.id AND users_groups.group_id = 2) AS demo JOIN users ON demo.id = users.senior_id GROUP BY users.id")->result());
	}

	public function tbm_list_load($id){
		$user = $this->ion_auth->user()->row();
		$group = $this->ion_auth->get_users_groups($user->id)->row();

		$data = array(
			'user' => $user,
			'group' => $group,
			'city' => $this->db->get("city_master")->result_array(),
			'location' => $this->db->get("area_master")->result_array(),
			'user_id' => $id,
		);
		$this->load->view('new_admin/tbm_data_list', $data);
	}

	public function get_tbmlist_data(){
		echo json_encode($this->db->query("SELECT users.id, users.first_name, users.last_name, users.email, area_master.name AS area, city_master.name AS city FROM users JOIN users_groups ON users.id = users_groups.user_id JOIN area_master ON users.area_id = area_master.id JOIN city_master ON area_master.city_id = city_master.id AND users_groups.group_id = 4 AND users.senior_id = ".$this->input->post("user_id"))->result());
	}

	public function testadd(){
		$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address=Goregaon+West+Mumbai+Maharashtra&sensor=false');
		$output = json_decode($geocode);
		print_r($output);
	}

	public function test_finance_api(){
		$geocode=file_get_contents('http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.historicaldata%20where%20symbol%20%3D%20%22AAPL%22%20and%20startDate%20%3D%20%222012-09-11%22%20and%20endDate%20%3D%20%222014-02-11%22&format=json&diagnostics=true&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=');
		$output = json_decode($geocode);
		echo "<pre>";
		print_r($output);
	}

	public function getCampAddress(){
		$res = $this->db->get("machine_booking");
		foreach ($res->result() as $value) {
			$prepAddr = str_replace(' ','+',$value->location);
			$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
			$output = json_decode($geocode);
			print_r($output);
			$lat = $output->results[0]->geometry->location->lat;
			$long = $output->results[0]->geometry->location->lng;
			// echo $lat;
			// echo $long;
			echo "<hr>";
		}
	}

	public function getQuandlData1(){
		$geocode=file_get_contents('https://www.quandl.com/api/v3/databases.json');
		echo "<pre>";
		print_r(json_decode($geocode));
	}

	public function getQuandlData(){
		// QyS8adzJx5FMFqbXquxo
		$address = "Media Mart (T3), Indira Gandhi International Airport, Airport Rd, New Delhi, India";
		$url = "https://www.quandl.com/api/v3/databases/RB1/data?api_key=QyS8adzJx5FMFqbXquxo";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$response = curl_exec($ch);
		curl_close($ch);
		echo $response;

	}

	public function fam_patient_data() {
		$user = $this->ion_auth->user()->row();
		$group = $this->ion_auth->get_users_groups($user->id)->row();
		$senior = $this->ion_auth->users(array(1, 2, 3, 5, 6, 7))->result();
		$city = $this->db->query("SELECT * FROM city_master")->result();
		$area = $this->db->query("SELECT * FROM area_master")->result();
		$groups = $this->db->query("SELECT * FROM groups")->result();

		$cities = $this->db->query("SELECT * FROM `city_master` ")->result();
		$max_date = $this->db->query("SELECT max(date) date FROM `machine_booking` ")->row();
		$min_date = $this->db->query("SELECT min(date) date FROM `machine_booking` ")->row();

		$max_date = substr($max_date->date, 0, 4);
		$min_date = substr($min_date->date, 0, 4);

		$data = array(
			'user' => $user,
			'group' => $group,
			'senior' => $senior,
			'city' => $city,
			'area' => $area,
			'groups' => $groups,
			'max_date' => $max_date,
			'min_date' => $min_date,
			'cities' => $cities,
		);
		$this->load->view('new_admin/fam_patient_data', $data);
	}

	public function get_fam_patient_data() {
		$location = $this->input->post('location');
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		$user = $this->input->post('user');

		if ($location=='' || $year=='' || $month=='' || $user=='') {
			$this->jsonify(array(
				'status' => 'fail',
				'data' => 'unauthorized access',
			));
			return FALSE;
		}

		// $data = array(
		// 	'location' => $location,
		// 	'year' => $year,
		// 	'month' => $month,
		// 	'user' => $user,
		// );
		$sql = "SELECT * FROM users WHERE senior_id=$user";
		$tbms = $this->db->query($sql)->result();
		$all_user = "$user,";
		foreach ($tbms as $key => $value) {
			$all_user .= $value->id . ",";
		}
		$all_user = rtrim($all_user, ",");

		$sql = "SELECT p.* FROM machine_booking mb JOIN camp_details cd ON mb.id=cd.machine_booking_id JOIN patients p ON p.camp_details_id=cd.id AND user_id IN ($all_user)";
		$patients = $this->db->query($sql)->result_array();

		$patients_json = "[";
		foreach ($patients as $key => $value) {
			$patients_json .= "[";
			foreach ($value as $k => $v) {
				$patients_json .= "'" . $v . "',";
			}
			$patients_json = rtrim($patients_json, ",");
			$patients_json .= "],";
		}
		$patients_json = rtrim($patients_json, ",");
		$patients_json .= "]";

		$this->jsonify(array(
			'status' => 'success',
			'data' => $patients_json,
		));
	}
}
