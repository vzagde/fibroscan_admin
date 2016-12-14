<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_other extends CI_Controller {

	public function __construct() {
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
	
	public function all_bookings(){
		$data = $this->user_data();
		// This will be accessed by ABM.
		// $user_ids = $this->db->query("select g.name, ug.user_id from groups g inner join users_groups ug on g.id = ug.group_id where g.name in ('TBM', 'FAM')")->result_array();
		$data["all_bookings"] = $this->db->query("SELECT mb.user_id, mb.machine_id, mb.start_time, mb.end_time, mb.location, mb.approved, mb.date, mb.cancel, mb.cancel_approved, mb.camp_type, mb.completed, u.username, u.email, u.first_name, u.last_name, g.name FROM machine_booking mb inner join users u on mb.user_id = u.id inner join users_groups ug on u.id = ug.user_id inner join groups g on ug.group_id = g.id where g.name in ('TBM', 'FAM')")->result();
		// print_r($all_bookings);
		$this->load->view("new_admin/abm", $data);
	}
	
	public function approve(){
		$id = $this->input->post("txt_id");
		$upd = array(
			"cancel_approved" => "true"
		);
		$this->db->where("id", $id);
		$this->db->update("machine_booking", $upd);
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

	public function index(){
		$user = $this->ion_auth->user()->row();
		$group = $this->ion_auth->get_users_groups($user->id)->row();
		$data = array(
			'user' => $user,
			'group' => $group,
		);
		// echo "<pre>";
		// print_r($data);exit();
		$this->load->view('new_admin/dashboard', $data);
	}

	public function add_user() {
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
		$this->load->view('new_admin/add_user', $data);
	}

	public function create_user() {
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

		$additional_data = array(
			'first_name' => $fname,
			'last_name' => $lname,
			'phone' => $phoneno,
			'senior_id' => $senior,
			'city' => $city,
			'area_id' => $area,
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
		// echo json_encode($json);
		// exit;
		$data = $this->user_data();
		$data['fam'] = json_encode($json);
		$this->load->view('new_admin/fam',$data);
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

	public function damn_good() {
		$data = $this->user_data();
		// echo('{id: 1, name: "Anas"}');
		// print_r($data);
		// echo(json_encode($data));
		// echo $data['user']->city;
		$sql = "SELECT * FROM `users` WHERE city=".$data['user']->city;
		$users = $this->db->query($sql)->result();
		// print_r($users);exit();
		$user_ids = "";
		foreach ($users as $key => $value) {
			$user_ids .= $value->id . ", ";
		}
		$user_ids = rtrim($user_ids, ", ");
		// echo($user_ids);exit();
		$sql = "SELECT * FROM `machine_booking` WHERE user_id IN ($user_ids)";
		// echo($sql);exit();
		$query = $this->db->query($sql)->result();
		$data['list'] = $query;
		// print_r($query);
		$this->load->view('new_admin/bm_camp_listing', $data);
	}

}
/* End of file welcome.php */
/* Location: ./application/controllers/Admin.php */
