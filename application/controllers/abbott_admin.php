<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Abbott_admin extends CI_Controller {

	public function __construct(){

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

	public function index(){

		$user = $this->ion_auth->user()->row();
		$group = $this->ion_auth->get_users_groups($user->id)->row();

		$month = date('m');
		$year = date('Y');
		echo "<pre>";
		print_r($user);
		print_r($group);

		// $this->load->view('abbott_admin/dashboard');

	}

	public function logout(){
		$this->ion_auth->logout();
	}

	public function update_state_code(){
		echo "<pre>";
		$res = $this->db->query("SELECT * FROM state_master")->result();
		foreach ($res as $value) {
			$data = array(
					'state_id' => $value->id, 
				);
			
			$this->db->where("state_id", $value->name);
			$this->db->update("city_master", $data);
		}
	}
}