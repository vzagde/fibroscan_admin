<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('Grocery_CRUD');

		if(!$this->ion_auth->logged_in()){
			redirect('index.php/login');
			die();
		}

		$this->load->library('grocery_CRUD');
		$this->load->library('image_CRUD');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->library('session');
	}

	// public function login() {
	// 	echo "Login Page";
	// 	// $this->load->view('admin/login');
	// }

	public function index() {
		$user = $this->ion_auth->user()->row();
		print_r($user);
	}
}
