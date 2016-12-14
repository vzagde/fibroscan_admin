<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->library('Grocery_CRUD');
		$this->load->library('grocery_CRUD');
		$this->load->library('image_CRUD');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->library('session');
	}

	public function index() {
		$this->load->view('admin_theme/dashboard');
	}

	public function form_submit() {
		$user_data = $this->db->query("SELECT * FROM users WHERE email = '".$this->input->post('identity')."' AND '".md5(sha1($this->input->post('password')))."'");
		if ($user_data->num_rows() > 0) {
			$this->session->set_userdata($user_data->result()[0]);
			// print_r($this->session->all_userdata());
		} else {
			$this->session->set_flashdata('message', "Username / Password Doesn't Exists...");
			redirect('index.php/login', 'refresh');
		}
	}
}
