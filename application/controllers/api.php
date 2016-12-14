<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('Grocery_CRUD');
		header("Access-Control-Allow-Origin: *");
		header('Content-Type: application/json');
	}

	public function index(){
		echo $this->jsonify(array('error' => 'Unauthorised Access'));
	}

	/* Login API accepts two parameters 
		email : username / email id
		password : password - which will further be encoded using md5 and sha1 and cross verified

		API will return following parameters 
		user data - data
		message - message relevant to api response
		status - SUCCESS / FALSE
	*/

	public function login(){
		$email = $this->input->post('email');
		$password = md5(sha1($this->input->post('password')));

		$user_data = $this->db->query("SELECT * FROM users WHERE email = '".$email."' AND password = '".$password."'");

		if ($user_data->num_rows() > 0) {
			$data = array(
					'id' => $user_data->result()[0]->id,
					'email' => $user_data->result()[0]->email,
					'first_name'=> $user_data->result()[0]->name,
					'group_name' => $this->db->query("SELECT * FROM groups WHERE id = '".$user_data->result()[0]->group_id."'")->result()[0]->name,
					'area_name' =>  $user_data->result()[0]->location,
					'mobile' => $user_data->result()[0]->contact_number,
				);
			$this->response([
				'status' => "SUCCESS",
				'message' => "Logged In Successfully",
				'data' => $data,
			]);
		} else {
			$this->response([
				'status' => "FALSE",
				'message' => "Invalid Authentication Details",
			]);
		}
	}

	/* Machine Listing API accepts four parameters 
		user data : user id, name, group name, contact number, email id
		day : date user have selected
		month : month user have selected
		year : year

		API will return following parameters 
		machine list - all the machines which comes under the user (fam / tbm)
		message - message relevant to api response
		status - SUCCESS / FALSE
		num_machines - total number of machines which will be passed through api
		prev details - camp details previous date of selected date
		current details -  camp details of selected date
		next details - camp details of next date of selected date
		contact number - fam cantact number incase user is TBM
		sample data
		$group_id = 'TBM';
		$user_id = '108';
		$user_id = '374';
		$date = '2016-11-27';
	*/

	public function machine_listing(){
		$machine_data = '';
		$response_data = '';
		$counter = 0;
		$prev_camp = '';
		$next_camp = '';
		$current_camp = '';


		$data = $this->input->post('user_data');
		$group_id = $data['group_name'];
		$user_id = $data['id'];
		$date = $this->input->post('year').'-'.$this->input->post('month').'-'.$this->input->post('day');

		if($group_id == 'FAM') {
			$machine_data = $this->db->query("SELECT * FROM machine WHERE fam_id = '".$user_id."'");
		} else {
			$machine_data = $this->db->query("SELECT machine.* 
												FROM machine 
												JOIN user_relations 
												ON machine.fam_id = user_relations.fam_id 
												AND user_relations.tbm_id = '".$user_id."' 
												GROUP BY machine.id"
											);
		}

		if ($machine_data->num_rows() > 0) {
			$response_data = array('message' => 'SUCCESS', 'status' => 'SUCCESS','num_machine' => $machine_data->num_rows());

			foreach ($machine_data->result() as $value) {
				$prev_camp = '';
				$next_camp = '';
				$current_camp = '';

				$prev_camp = $this->db->query("SELECT 
												camp_clinic_booking.id, 
												users.name, 
												camp_clinic_booking.date, 
												camp_clinic_booking.start_time, 
												camp_clinic_booking.end_time, 
												camp_clinic_booking.address 
												FROM camp_clinic_booking 
												JOIN users 
												ON camp_clinic_booking.user_id = users.id 
												WHERE camp_clinic_booking.machine_name = '".$value->machine_name."' 
												AND camp_clinic_booking.date < '".$date."' 
												AND ( camp_clinic_booking.camp_status = 'complete' OR camp_clinic_booking.camp_status = 'incomplete' ) 
												ORDER BY camp_clinic_booking.date DESC LIMIT 1"
											);

				$next_camp = $this->db->query("SELECT 
												camp_clinic_booking.id, 
												users.name, 
												camp_clinic_booking.date, 
												camp_clinic_booking.start_time, 
												camp_clinic_booking.end_time, 
												camp_clinic_booking.address 
												FROM camp_clinic_booking 
												JOIN users 
												ON camp_clinic_booking.user_id = users.id 
												AND camp_clinic_booking.machine_name = '".$value->machine_name."' 
												AND camp_clinic_booking.date > '".$date."' 
												AND ( camp_clinic_booking.camp_status = 'complete' OR camp_clinic_booking.camp_status = 'incomplete' ) 
												ORDER BY camp_clinic_booking.date ASC LIMIT 1"
											);

				$current_camp = $this->db->query("SELECT 
													camp_clinic_booking.id, 
													users.name, 
													camp_clinic_booking.date, 
													camp_clinic_booking.start_time, 
													camp_clinic_booking.end_time, 
													camp_clinic_booking.address, 
													camp_clinic_booking.slot_type, 
													COUNT(*) AS count 
													FROM camp_clinic_booking 
													JOIN users 
													ON camp_clinic_booking.user_id = users.id 
													AND camp_clinic_booking.machine_name = '".$value->machine_name."' 
													AND camp_clinic_booking.date = '".$date."' 
													AND ( camp_clinic_booking.camp_status = 'complete' OR camp_clinic_booking.camp_status = 'incomplete' ) 
													ORDER BY camp_clinic_booking.date"
												);

				if ($prev_camp->num_rows() > 0) { $prev_camp = $prev_camp->result()[0]; } else { $prev_camp = ''; }

				if ($next_camp->num_rows() > 0) { $next_camp = $next_camp->result()[0]; } else { $next_camp = ''; }

				if ($current_camp->num_rows() > 0) { $current_camp = $current_camp->result()[0]; } else { $current_camp = ''; }

				$response_data['machine_name'][$counter] = $machine_data->result()[$counter];
				$response_data['prev_details'][$counter] = $prev_camp;
				$response_data['current_details'][$counter] = $current_camp;
				$response_data['next_details'][$counter] = $next_camp;
				$counter += 1;
			}
		} else {
			$response_data = array('message' => 'No Machines are assigned to this user', 'status' => 'failed');
		}
		$this->response($response_data);
	}

	/* load form API accepts four parameters 
		user data : user id, name, group name, contact number, email id

		API will return following parameters 
		doctors list - all the doctors which comes under the user (fam / tbm)
		message - message relevant to api response
		status - SUCCESS / FALSE
		$group_id = 'TBM';
		$user_id = '119';
	*/

	public function load_form_data(){
		$doctors_data = '';

		$data = $this->input->post('user_data');
		$group_id = $data['group_name'];
		$user_id = $data['id'];

		if ($group_id == 'FAM') {
			$doctors_data = $this->db->query("SELECT 
												doctors.id, 
												doctors.name 
												FROM doctors 
												JOIN user_relations 
												ON doctors.id = user_relations.doctor_id 
												AND user_relations.fam_id = '".$user_id."' 
												GROUP BY user_relations.doctor_id"
											);
		} else {
			$doctors_data = $this->db->query("SELECT 
												doctors.id, 
												doctors.name 
												FROM doctors 
												JOIN user_relations 
												ON doctors.id = user_relations.doctor_id 
												AND user_relations.tbm_id = '".$user_id."' 
												GROUP BY user_relations.doctor_id"
											);
		}

		if ($doctors_data->num_rows() > 0) {
			$response_data = array('message' => 'SUCCESS', 'status' => 'SUCCESS', 'doctors_data' => $doctors_data->result());
		} else {
			$response_data = array('message' => 'Doctors are not assigned for user', 'status' => 'failed');
		}

		$this->response($response_data);
	}

	/* Doctors data API accepts four parameters 
		doctor_id : doctor id which user will select

		API will return following parameters 
		doctors details - all doctors related details
		address - address from previously booked camps for which same doctor was assigned
		message - message relevant to api response
		status - SUCCESS / FALSE
		$user_id = '116';
	*/

	public function doctor_data(){
		$response_data = '';
		$address = '';

		$user_id = $this->input->post('doctor_id');

		$doctors_data = $this->db->query("SELECT * FROM doctors WHERE doctors.id = '".$user_id."'");

		if ($doctors_data->num_rows() > 0) {
			$address_data = $this->db->query("SELECT * FROM camp_clinic_booking WHERE id = '".$doctors_data->result()[0]->id."' ORDER BY id LIMIT 1");

			if ($address_data->num_rows() > 0) {
				$address = $address_data->result()[0]->address;
			}

			$response_data = array('message' => 'SUCCESS', 'status' => 'SUCCESS', 'doctors_data' => $doctors_data->result(), 'address' => $address);
		} else {
			$response_data = array('message' => 'Doctor Selection Invalid', 'status' => 'failed');
		}

		$this->response($response_data);
	}

	public function forgot_password(){
		$password = '';

		$input_data = $this->db->post('email_id');
		$data = $this->db->query("SELECT * FROM users WHERE email = '".$input_data."'");

		if ($data->num_rows() > 0) {
		    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		    $charactersLength = strlen($characters);
		    $randomString = '';

		    for ($i = 0; $i < 7; $i++) {
		        $randomString .= $characters[rand(0, $charactersLength - 1)];
		    }

		    $password = $this->generate_password($randomString);

		    $this->db->where('id', $data->result()[0]->id);
		    $this->db->update('users', array('password' => $password));
		    $this->db->where('email_id', $data->result()[0]->email);
		    $this->db->update('users_password', array('password' => $randomString));

			$response_data = array('message' => 'Your password has been updated and sent to your Email ID', 'status' => 'SUCCESS');
		} else {
			$response_data = array('message' => 'Email Id is not Registered with Fibroscan - Abbott', 'status' => 'failed');
		}

		$this->response($response_data);
	}

	/* Doctors data API accepts four parameters 
		doctor_id : doctor id which user will select
		camp / clinic : camp or clinic
		start time : start time
		end time : end time
		date : date which is selected by user
		no of registrations
		block machine - status
		i will be available at camp - status
		address
		user data : user id, name, group name, contact number, email id

		API will return following parameters 
		doctors details - all doctors related details
		address - address from previously booked camps for which same doctor was assigned
		message - message relevant to api response
		status - SUCCESS / FALSE
	*/

	public function camp_clinic_form_submit(){
		$response_data = '';
		$insert_arr = '';
		$clinic_more_date = '';
		$parent_id = '';

		$data = $this->input->post('user_data');
		$doctor_id = $this->input->post('doctor_id');
		$camp_clinic = $this->input->post('camp_clinic');
		$start_time = $this->input->post('start_time');
		$end_time = $this->input->post('end_time');
		$block_machine = $this->input->post('block_machine');
		$availability_check = $this->input->post('available_at_camp');
		$group_id = $data['group_name'];
		$user_id = $data['id'];
		$address = $this->input->post('address');
		$expected_registrations = $this->input->post('expected_registrations');
		$date = $this->input->post('date');
		$machine_name = $this->input->post('machine_name');
		$user_group = $this->db->query("SELECT * FROM users WHERE id = '".$user_id."'")->result()[0]->group_id;

		if (!$doctor_id) {
			$response_data = array('message' => 'Please specify Doctor details', 'status' => 'failed');
		} else if (!$start_time) {
			$response_data = array('message' => 'Please specify Camp / Clinic start time', 'status' => 'failed');
		} else if (!$end_time) {
			$response_data = array('message' => 'Please specify Camp / Clinic end time', 'status' => 'failed');
		} else if (!$block_machine) {
			$response_data = array('message' => 'Please BLOCK machine before proceeding', 'status' => 'failed');
		} else if (!$address) {
			$response_data = array('message' => 'Please enter address where you wish to held the Camp / Clinic', 'status' => 'failed');
		} else if (!$expected_registrations) {
			$response_data = array('message' => 'Please specify expected number of registration', 'status' => 'failed');
		} else if (!$date) {
			$response_data = array('message' => 'Please specify date for Camp / Clinic', 'status' => 'failed');
		} else if (!$machine_name) {
			$response_data = array('message' => 'Please specify Machine for booking', 'status' => 'failed');
		} else if ($camp_clinic != 'camp') {
			if ($camp_clinic != 'clinic') {
				$response_data = array('message' => 'Please specify Type - Camp / Clinic', 'status' => 'failed');
			} else {

				$insert_arr['slot_type'] = $this->check_camp_slot($start_time, $end_time);

				if ($insert_arr['slot_type'] == 'Invalid Slot Time' || $insert_arr['slot_type'] == 'Entered special case') {
					$response_data = array('message' => 'Please select valid time slots', 'status' => 'failed');
					$this->response($response_data);
					exit();
				}

				$camp_validity_check = $this->camp_validity_check($machine_name, $date, $start_time, $end_time);

				if ($camp_validity_check == 'Exists') {
					$response_data = array('message' => 'Sorry you can not create any more camps with this date and timeslot', 'status' => 'failed');
					$this->response($response_data);
					exit();
				}

				$clinic_more_dates = $this->input->post('clinic_more_date');

				if (!$clinic_more_dates) {
					$response_data = array('message' => 'You have choosed clinic as option, You have to select more dates for Clinic creation', 'status' => 'failed');
					$this->response($response_data);
					exit();
				}

				for ($i=0; $i < count($clinic_more_dates); $i++) { 

					$insert_arr['slot_type'] = $this->check_camp_slot($start_time, $end_time);

					if ($insert_arr['slot_type'] == 'Invalid Slot Time' || $insert_arr['slot_type'] == 'Entered special case') {
						$response_data = array(
								'message' => 'Please select valid time slots', 
								'status' => 'failed', 
							);
						$this->response($response_data);
						exit();
					}

					$camp_validity_check = $this->camp_validity_check($machine_name, $clinic_more_dates[$i], $start_time, $end_time);

					if ($camp_validity_check == 'Exists') {
						$response_data = array(
								'message' => 'Sorry you can not create any more clinic with date -  '.$clinic_more_dates[$i].' and timeslot', 
								'status' => 'failed', 
							);
						$this->response($response_data);
						exit();
					}

					if ($user_group == 2) {
						$response_data['message'] = 'Your camp has been booked successfully';
						$response_data['status'] = 'SUCCESS';
						$insert_arr['camp_status'] = 'complete';
					} else {
						$response_data['message'] = 'Your camp creation request has been sent for an approval to your respective FAM';
						$response_data['status'] = 'SUCCESS';
						$insert_arr['camp_status'] = 'incomplete';
					}

					if ($i == 0) {
						$insert_arr = array(
								'doctor_id' => $doctor_id, 
								'address' => $address, 
								'clinic_camp' => 'clinic', 
								'expected_registrations' => $expected_registrations, 
								'start_time' => $start_time, 
								'end_time' => $end_time, 
								'date' => $date, 
								'lock_unlock' => 'unlock', 
								'block_machine' => 'yes', 
								'available_at_camp' => $availability_check, 
								'machine_name' => $machine_name, 
								'user_id' => $user_id, 
							);


						$this->db->insert("camp_clinic_booking", $insert_arr);

						$parent_id = $this->db->insert_id();
					}

					$insert_arr = array(
							'doctor_id' => $doctor_id, 
							'address' => $address, 
							'clinic_camp' => 'clinic', 
							'expected_registrations' => $expected_registrations, 
							'start_time' => $start_time, 
							'end_time' => $end_time, 
							'date' => $clinic_more_dates[$i], 
							'lock_unlock' => 'unlock', 
							'block_machine' => 'yes', 
							'available_at_camp' => $availability_check, 
							'machine_name' => $machine_name, 
							'clinic_parent_id' => $parent_id, 
							'user_id' => $user_id, 
						);

					$this->db->insert("camp_clinic_booking", $insert_arr);
				}
			}
		} else {
			$insert_arr = array(
					'doctor_id' => $doctor_id, 
					'address' => $address, 
					'clinic_camp' => 'camp', 
					'expected_registrations' => $expected_registrations, 
					'start_time' => $start_time, 
					'end_time' => $end_time, 
					'date' => $date, 
					'lock_unlock' => 'unlock', 
					'block_machine' => 'yes', 
					'available_at_camp' => $availability_check, 
					'machine_name' => $machine_name, 
					'user_id' => $user_id, 
				);

			$insert_arr['slot_type'] = $this->check_camp_slot($start_time, $end_time);

			if ($insert_arr['slot_type'] == 'Invalid Slot Time' || $insert_arr['slot_type'] == 'Entered special case') {
				$response_data = array('message' => 'Please select valid time slots', 'status' => 'failed');
				$this->response($response_data);
				exit();
			}

			$camp_validity_check = $this->camp_validity_check($machine_name, $date, $start_time, $end_time);

			if ($camp_validity_check == 'Exists') {
				$response_data = array('message' => 'Sorry you can not create any more camps with this date and timeslot', 'status' => 'failed');
				$this->response($response_data);
				exit();
			}

			if ($user_group == 2) {
				$response_data['message'] = 'Your camp has been booked successfully';
				$response_data['status'] = 'SUCCESS';
				$insert_arr['camp_status'] = 'complete';
			} else {
				$response_data['message'] = 'Your camp creation request has been sent for an approval to your respective FAM';
				$response_data['status'] = 'SUCCESS';
				$insert_arr['camp_status'] = 'incomplete';
			}

			$this->db->insert("camp_clinic_booking", $insert_arr);
		}

		$this->response($response_data);
	}

	public function validate_camp_clinic(){
		$response = '';

		$machine_name = $this->input->post('machine_name');
		$date = $this->input->post('date');
		$start_time = $this->input->post('start_time');
		$end_time = $this->input->post('end_time');
		$res = $this->camp_validity_check($machine_name, $date, $start_time, $end_time);

		if ($res == 'Exists') {
			$response_data = array('message' => 'Sorry you can not create any more camps with this date and timeslot', 'status' => 'failed');
		} else {
			$response_data = array('message' => 'Date added for Clinic', 'status' => 'SUCCESS');
		}

		$this->response($response_data);
	}

	public function pull_calendar_data(){
		$response = '';
		$machine_data_query = '';
		$machine_data = '';
		$camp_data = '';
		$counter = 0;

		$dashboard_data = '';

		$cur_month = Date('m');
		$cur_year = Date('Y');

		if ($this->input->post('mnthtopass')) {
			$cur_month = $this->input->post('mnthtopass');
			if (strlen($this->input->post('mnthtopass')) == 1) {
				$cur_month = '0'.$this->input->post('mnthtopass');
			}
		}

		if ($this->input->post('yeartopass')) {
			$cur_year = $this->input->post('yeartopass');
		}

		$data = $this->input->post('user_data');
		$group_id = $data['group_name'];
		$user_id = $data['id'];

		if($group_id == 'FAM') {
			$machine_data_query = "SELECT machine_name FROM machine WHERE fam_id = '".$user_id."'";
			$machine_data = $this->db->query("SELECT * FROM machine WHERE fam_id = '".$user_id."'");

			$dashboard_data = $this->pull_dashboard_data($user_id, 'FAM', $cur_month, $cur_year);
		} else {
			$machine_data_query = "SELECT 
									machine.machine_name 
									FROM machine 
									JOIN user_relations 
									ON machine.fam_id = user_relations.fam_id 
									AND user_relations.tbm_id = '".$user_id."' 
									GROUP BY machine.id";

			$machine_data = $this->db->query("SELECT 
												machine.* 
												FROM machine 
												JOIN user_relations 
												ON machine.fam_id = user_relations.fam_id 
												AND user_relations.tbm_id = '".$user_id."' 
												GROUP BY machine.id"
											);

			$dashboard_data = $this->pull_dashboard_data($user_id, 'TBM', $cur_month, $cur_year);
		}

		if ($machine_data->num_rows() > 0) {
			$query = "SELECT * FROM (
										( 
											SELECT * FROM ( 
												SELECT 
													count(date) AS first_slot, 
													date AS fs_date 
													FROM camp_clinic_booking 
													WHERE date 
													BETWEEN '".$cur_year."-".$cur_month."-01' 
														AND '".$cur_year."-".$cur_month."-31' 
													AND ( 
														slot_type = 'First Slot' 
														OR slot_type = 'Both Slot' 
													) 
													AND machine_name IN (".$machine_data_query.") 
													AND ( camp_clinic_booking.camp_status = 'complete' OR camp_clinic_booking.camp_status = 'incomplete' ) 
													GROUP BY date 
											) AS first_slot_table 
											LEFT JOIN ( 
											SELECT 
												count(date) AS second_slot, 
												date AS ss_date 
												FROM camp_clinic_booking 
												WHERE date 
												BETWEEN '".$cur_year."-".$cur_month."-01' 
													AND '".$cur_year."-".$cur_month."-31' 
												AND ( 
													slot_type = 'Second Slot' 
													OR slot_type = 'Both Slot' 
												) 
												AND machine_name IN (".$machine_data_query.") 
												AND ( camp_clinic_booking.camp_status = 'complete' OR camp_clinic_booking.camp_status = 'incomplete' ) 
												GROUP BY date 
											) AS second_slot_table 
											ON first_slot_table.fs_date = second_slot_table.ss_date 
										) 
										UNION ALL ( 
											SELECT * FROM ( 
												SELECT 
													count(date) AS first_slot, 
													date AS fs_date 
													FROM camp_clinic_booking 
													WHERE date 
													BETWEEN '".$cur_year."-".$cur_month."-01' 
														AND '".$cur_year."-".$cur_month."-31' 
													AND ( 
														slot_type = 'First Slot' 
														OR slot_type = 'Both Slot' 
													) 
													AND machine_name IN (".$machine_data_query.") 
													AND ( camp_clinic_booking.camp_status = 'complete' OR camp_clinic_booking.camp_status = 'incomplete' ) 
													GROUP BY date 
												) AS first_slot_table 
											RIGHT JOIN ( 
												SELECT 
													count(date) AS second_slot, 
													date AS ss_date 
													FROM camp_clinic_booking 
													WHERE date 
													BETWEEN '".$cur_year."-".$cur_month."-01' 
														AND '".$cur_year."-".$cur_month."-31' 
													AND ( 
														slot_type = 'Second Slot' 
														OR slot_type = 'Both Slot' 
													) 
													AND machine_name IN (".$machine_data_query.") 
													AND ( camp_clinic_booking.camp_status = 'complete' OR camp_clinic_booking.camp_status = 'incomplete' ) 
													GROUP BY date 
												) AS second_slot_table 
											ON first_slot_table.fs_date = second_slot_table.ss_date
										)
									) AS table1 
									GROUP BY ss_date, fs_date";

			$camp_listing = $this->db->query($query);

			if ($camp_listing->num_rows() > 0) {
				foreach ($camp_listing->result() as $value) {
					$first_color = 'green';
					$second_color = 'green';
					$date = '';

					if ($value->fs_date) {
						$date = $value->fs_date;
						if ($value->first_slot == $machine_data->num_rows()) {
							$first_color = 'red';
						}
						if ($value->ss_date) {
							if ($value->second_slot == $machine_data->num_rows()) {
								$second_color = 'red';
							}
						}
					} else {
						$date = $value->ss_date;
						if ($value->second_slot == $machine_data->num_rows()) {
							$second_color = 'red';
						}
					}

					$camp_data[$counter] = array('date' => $date, 'first_color' => $first_color, 'second_color' => $second_color);
					$counter += 1;
				}

				$response_data = array('message' => 'Fetching data', 'status' => 'GOTDATA', 'data' => $camp_data, 'dashboard_data' => $dashboard_data);
			} else {
				$response_data = array('message' => 'No Data Present for this Month', 'status' => 'NODATA', 'dashboard_data' => $dashboard_data);
			}
		} else {
			$response_data = array('message' => 'No Machines are assigned to this user', 'status' => 'failed', 'dashboard_data' => $dashboard_data);
		}

		$this->response($response_data);
	}

	public function technician_dashboard(){
		$response_data = '';

		$data = $this->input->post('user_data');
		$group_id = $data['group_name'];
		$user_id = $data['id'];

		// $user_id = 396;
		// $date = '2016-12-25';
		$date = new DateTime('7 days ago');
		$date = $date->format('Y-m-d');

		$cur_month = Date('m');
		$cur_year = Date('Y');

		$camp_data = $this->db->query("SELECT * FROM (
										(
											SELECT 
												camp_clinic_booking.id, 
												doctors.name, 
												camp_clinic_booking.date, 
												camp_clinic_booking.start_time, 
												camp_clinic_booking.end_time, 
												camp_clinic_booking.address, 
												'Start' AS status 
												FROM camp_clinic_booking 
												JOIN doctors 
												ON camp_clinic_booking.doctor_id = doctors.id 
												JOIN machine 
												ON camp_clinic_booking.machine_name = machine.machine_name 
												AND machine.technician_id = ".$user_id." 
												AND camp_clinic_booking.camp_status = 'complete' 
												AND camp_clinic_booking.date > '".$date."'
												AND camp_clinic_booking.lock_unlock = 'unlock' 
										) UNION (
											SELECT 
												camp_clinic_booking.id, 
												doctors.name, 
												camp_clinic_booking.date, 
												camp_clinic_booking.start_time, 
												camp_clinic_booking.end_time, 
												camp_clinic_booking.address, 
												'Locked' AS status 
												FROM camp_clinic_booking 
												JOIN doctors 
												ON camp_clinic_booking.doctor_id = doctors.id 
												JOIN machine 
												ON camp_clinic_booking.machine_name = machine.machine_name 
												AND machine.technician_id = ".$user_id." 
												AND camp_clinic_booking.camp_status = 'complete' 
												AND camp_clinic_booking.date < '".$date."' 
												AND camp_clinic_booking.lock_unlock = 'unlock' 
										) UNION (
											SELECT 
												camp_clinic_booking.id, 
												doctors.name, 
												camp_clinic_booking.date, 
												camp_clinic_booking.start_time, 
												camp_clinic_booking.end_time, 
												camp_clinic_booking.address, 
												'Request In Process' AS status 
												FROM camp_clinic_booking 
												JOIN doctors 
												ON camp_clinic_booking.doctor_id = doctors.id 
												JOIN machine 
												ON camp_clinic_booking.machine_name = machine.machine_name 
												AND machine.technician_id = ".$user_id." 
												AND camp_clinic_booking.camp_status = 'complete' 
												AND camp_clinic_booking.date < '".$date."' 
												AND camp_clinic_booking.lock_unlock = 'lock' 
										) UNION (
											SELECT 
												camp_clinic_booking.id, 
												doctors.name, 
												camp_clinic_booking.date, 
												camp_clinic_booking.start_time, 
												camp_clinic_booking.end_time, 
												camp_clinic_booking.address, 
												'Start' AS status 
												FROM camp_clinic_booking 
												JOIN doctors 
												ON camp_clinic_booking.doctor_id = doctors.id 
												JOIN machine 
												ON camp_clinic_booking.machine_name = machine.machine_name 
												AND machine.technician_id = ".$user_id." 
												AND camp_clinic_booking.camp_status = 'complete' 
												AND camp_clinic_booking.date < '".$date."' 
												AND camp_clinic_booking.lock_unlock = 'requested' 
										)
									) 
									AS camp_details 
									ORDER BY date ASC 
									LIMIT 15");

		if ($camp_data->num_rows() > 0) {
			$dashboard_data = array(
					'num_of_camps' => $this->db->query("SELECT COUNT(*) AS count FROM camp_clinic_booking JOIN machine ON camp_clinic_booking.machine_name = machine.machine_name AND machine.technician_id = '".$user_id."' AND ( camp_clinic_booking.camp_status = 'complete' OR camp_clinic_booking.camp_status = 'executed' ) AND camp_clinic_booking.date BETWEEN '".$cur_year."-".$cur_month."-01' AND '".$cur_year."-".$cur_month."-31'")->result()[0]->count, 
					'num_of_patients' => $this->db->query("SELECT COUNT(*) as count FROM camp_clinic_booking JOIN machine ON camp_clinic_booking.machine_name = machine.machine_name JOIN patients ON camp_clinic_booking.id = patients.camp_clinic_id AND machine.technician_id = 396 AND camp_clinic_booking.camp_status = 'executed' AND camp_clinic_booking.date BETWEEN '".$cur_year."-".$cur_month."-01' AND '".$cur_year."-".$cur_month."-31'")->result()[0]->count, 
					'num_of_camps_to_be_executed' => $this->db->query("SELECT COUNT(*) AS count FROM camp_clinic_booking JOIN machine ON camp_clinic_booking.machine_name = machine.machine_name AND machine.technician_id = '".$user_id."' AND camp_clinic_booking.camp_status = 'complete' AND camp_clinic_booking.date BETWEEN '".$cur_year."-".$cur_month."-01' AND '".$cur_year."-".$cur_month."-31'")->result()[0]->count, 
					'completed_reports' => $this->db->query("SELECT COUNT(*) AS count FROM camp_clinic_booking JOIN machine ON camp_clinic_booking.machine_name = machine.machine_name AND machine.technician_id = '".$user_id."' AND camp_clinic_booking.camp_status = 'executed' AND camp_clinic_booking.date BETWEEN '".$cur_year."-".$cur_month."-01' AND '".$cur_year."-".$cur_month."-31'")->result()[0]->count, 
					'pending_reports' => 0, 
				);
			$response_data = array('message' => 'SUCCESS', 'status' => 'SUCCESS', 'data' => $camp_data->result(), 'dashboard_data' => $dashboard_data);
		} else {
			$dashboard_data = array(
					'num_of_camps' => 0, 
					'num_of_patients' => 0, 
					'num_of_camps_to_be_executed' => 0, 
					'completed_reports' => 0, 
					'pending_reports' => 0, 
				);
			$response_data = array('message' => 'No Camps are assigned to this user yet', 'status' => 'failed');
		}

		$this->response($response_data);
	}

	public function camp_listing_details(){
		$data = $this->input->post('user_data');
		$group_id = $data['group_name'];
		$user_id = $data['id'];

		$user_id = 108;
		$cur_year = date("Y");
		$cur_month = date("m");

		$executed_camps = $this->db->query("SELECT 
											camp_clinic_booking.id, 
											camp_clinic_booking.date, 
											camp_clinic_booking.start_time, 
											camp_clinic_booking.end_time, 
											camp_clinic_booking.address, 
											doctors.name, 
											camp_clinic_booking.camp_status 
											FROM camp_clinic_booking 
											JOIN doctors 
											ON camp_clinic_booking.doctor_id = doctors.id 
											AND camp_clinic_booking.date 
											BETWEEN '".$cur_year."-".$cur_month."-01' AND '".$cur_year."-".$cur_month."-31' 
											AND camp_clinic_booking.camp_status = 'executed' 
											AND camp_clinic_booking.user_id = '".$user_id."'"
										);

		$in_complete_camps = $this->db->query("SELECT 
												camp_clinic_booking.id, 
												camp_clinic_booking.date, 
												camp_clinic_booking.start_time, 
												camp_clinic_booking.end_time, 
												camp_clinic_booking.address, 
												doctors.name, 
												camp_clinic_booking.camp_status 
												FROM camp_clinic_booking 
												JOIN doctors 
												ON camp_clinic_booking.doctor_id = doctors.id 
												AND camp_clinic_booking.date 
												BETWEEN '".$cur_year."-".$cur_month."-01' AND '".$cur_year."-".$cur_month."-31' 
												AND ( 
													camp_clinic_booking.camp_status = 'complete' 
													OR camp_clinic_booking.camp_status = 'incomplete' 
												) 
												AND camp_clinic_booking.user_id = '".$user_id."'"
											);

		$response_data = array('message' => 'SUCCESS', 'status' => 'SUCCESS');

		if ($executed_camps->num_rows() > 0) {
			$response_data['executed_camps'] = $executed_camps->result();
		} else {
			$response_data['executed_camps'] = '';
		}

		if ($in_complete_camps->num_rows() > 0) {
			$response_data['in_complete_camps'] = $in_complete_camps->result();
		} else {
			$response_data['in_complete_camps'] = '';
		}

		$this->response($response_data);
	}

	public function fam_approval_list(){
		$data = $this->input->post('user_data');
		$group_id = $data['group_name'];
		$user_id = $data['id'];
		$user_id = 374;

		$pending_approvals = $this->db->query("SELECT 
												camp_clinic_booking.id, 
												users.name AS fam_name, 
												camp_clinic_booking.machine_name, 
												camp_clinic_booking.date, 
												camp_clinic_booking.start_time, 
												camp_clinic_booking.end_time, 
												doctors.name AS doctor_name, 
												camp_clinic_booking.address 
												FROM user_relations 
												JOIN camp_clinic_booking 
												ON user_relations.tbm_id = camp_clinic_booking.user_id 
												JOIN doctors 
												ON camp_clinic_booking.doctor_id = doctors.id 
												JOIN users 
												ON camp_clinic_booking.user_id = users.id 
												AND user_relations.fam_id = '".$user_id."' 
												AND camp_clinic_booking.camp_status = 'incomplete' 
												GROUP BY camp_clinic_booking.id"
											);

		$response_data = array('message' => 'SUCCESS', 'status' => 'SUCCESS');

		if ($pending_approvals->num_rows() > 0) {
			$response_data['pending_approvals'] = $pending_approvals->result();
		} else {
			$response_data['pending_approvals'] = '';
		}

		$this->response($response_data);
	}

	public function patients_record_submit(){
		$patients_records = $this->input->post('patients_records');
		$start_time = $this->input->post('start_time');
		$camp_clinic_id = $this->input->post('camp_id');
		$end_time = $this->input->post('end_time');
		$image = $this->input->post('image');

		$technician_records = array(
				'technician_start_time' => $start_time,
				'technician_end_time' => $end_time,
				'camp_status' => 'executed',
			);

		$this->db->where('id', $camp_clinic_id);
		$this->db->update('camp_clinic_booking', $technician_records);

		for ($i=0; $i < count($patients_records); $i++) {
			$records = array(
					'camp_clinic_id' => $camp_clinic_id,
					'gender' => $patients_records[$i][0],
					'age' => $patients_records[$i][1],
					'disease_id' => $patients_records[$i][2],
					'fibroscan_value' => $patients_records[$i][3],
				);
			$this->db->insert('patients', $records);
		}

		for ($i=0; $i < count($image); $i++) {
			$records = array(
					'camp_clinic_id' => $camp_clinic_id,
					'image' => $image[$i],
				);

			$this->db->insert('camp_images', $records);
		}

		$this->response(array('message' => 'Your camp details has been uploaded successfully', 'status' => 'SUCCESS'));
	}

	public function approve_camp(){
		$this->db->where('id', $this->input->post('camp_id'));
		if ($this->db->update("camp_clinic_booking", array('camp_status' => 'complete'))) {
			$this->response(array('message' => 'SUCCESS', 'status' => 'SUCCESS'));
		} else {
			$this->response(array('message' => 'There is some issue from server, Please try again later', 'status' => 'failed'));
		}
	}

	public function delete_camp(){
		$this->db->where('id', $this->input->post('camp_id'));
		if ($this->db->update("camp_clinic_booking", array('camp_status' => 'canceled'))) {
			$this->response(array('message' => 'Your camp has been canceled successfully', 'status' => 'SUCCESS'));
		} else {
			$this->response(array('message' => 'There is some issue from server, Please try again later', 'status' => 'failed'));
		}
	}

	public function unlock_request(){
		$this->db->where('id', $this->input->post('camp_id'));
		if ($this->db->update("camp_clinic_booking", array('lock_unlock' => 'lock'))) {
			$this->response(array('message' => 'SUCCESS', 'status' => 'SUCCESS'));
		} else {
			$this->response(array('message' => 'There is some issue from server, Please try again later', 'status' => 'failed'));
		}
	}

	public function disease_data(){
		$this->response(array('message' => 'SUCCESS', 'status' => 'SUCCESS', 'disease' => $this->db->get('disease')->result()));
	}

	public function create_notification(){
		$data = $this->input->post('user_data');
		$user_id = $data['id'];
		$slot_type = '';
		if ($this->input->post('slot_type') == 'Morning') { $slot_type = 'First Slot'; } else if ($this->input->post('slot_type') == 'Evening') { $slot_type = 'Second Slot'; } else { $slot_type = 'Both Slot'; }

		$this->db->insert('notify_me', array('user_id' => $user_id, 'date' => $this->input->post('date'), 'slot_type' => $slot_type));
		$this->response(array('message' => 'SUCCESS', 'status' => 'SUCCESS'));
	}

	public function leaderboard(){
		$response_data = '';
		$counter = 0;

		$cur_month = Date('m');
		$cur_year = Date('Y');

		$fam_data = $this->db->query("SELECT * FROM users WHERE group_id = 2");

		foreach ($fam_data->result() as $value) {
			$num_of_proposed_camps = 0;
			$num_of_completed_camps = 0;
			$num_of_patients_per_camps = 0;
			$high_risk = 0;
			$counter = 1;
			$fam_name = $value->name;


			$fam_id = $value->id;
			$num_of_proposed_camps_array = $this->db->query("SELECT COUNT(*) AS count FROM camp_clinic_booking WHERE user_id = '".$fam_id."' AND (camp_status = 'complete' OR camp_status = 'executed') AND date BETWEEN '".$cur_year."-".$cur_month."-01' AND '".$cur_year."-".$cur_month."-31'");
			if ($num_of_proposed_camps_array->num_rows() > 0) {
				$num_of_proposed_camps += intval($num_of_proposed_camps_array->result()[0]->count);
			}
			$num_of_completed_camps_array = $this->db->query("SELECT COUNT(*) AS count FROM camp_clinic_booking WHERE user_id = '".$fam_id."' AND camp_status = 'executed' AND date BETWEEN '".$cur_year."-".$cur_month."-01' AND '".$cur_year."-".$cur_month."-31'");
			if ($num_of_completed_camps_array->num_rows() > 0) {
				$num_of_completed_camps += intval($num_of_completed_camps_array->result()[0]->count);
			}
			$num_of_patients_per_camps_array = $this->db->query("SELECT AVG(count) AS average FROM (SELECT COUNT(patients.camp_clinic_id) AS count FROM camp_clinic_booking JOIN patients ON camp_clinic_booking.id = patients.camp_clinic_id AND camp_clinic_booking.user_id = '".$fam_id."' AND camp_clinic_booking.camp_status = 'executed' AND camp_clinic_booking.date BETWEEN '".$cur_year."-".$cur_month."-01' AND '".$cur_year."-".$cur_month."-31' GROUP BY patients.camp_clinic_id) AS count_table");
			if ($num_of_patients_per_camps_array->num_rows() > 0) {
				$num_of_patients_per_camps += round($num_of_patients_per_camps_array->result()[0]->average);
				if ($num_of_patients_per_camps_array->result()[0]->average > 0 || $num_of_patients_per_camps_array->result()[0]->average != NULL) {
					$num_of_patients_per_camps += round($num_of_patients_per_camps_array->result()[0]->average);
				}
			}
			$high_risk_array = $this->db->query("SELECT COUNT(*) AS count FROM camp_clinic_booking JOIN patients ON camp_clinic_booking.id = patients.camp_clinic_id AND camp_clinic_booking.user_id = '".$fam_id."' AND camp_clinic_booking.camp_status = 'executed' AND camp_clinic_booking.date BETWEEN '".$cur_year."-".$cur_month."-01' AND '".$cur_year."-".$cur_month."-31' AND patients.fibroscan_value > 40 GROUP BY patients.camp_clinic_id");
			if ($high_risk_array->num_rows() > 0) {
				$high_risk += intval($high_risk_array->result()[0]->count);
			}

			$tbm_id = $this->db->query("SELECT * FROM user_relations WHERE fam_id = '".$fam_id."' GROUP BY tbm_id");
			if ($tbm_id->num_rows()) {
				foreach ($tbm_id->result() as $value) {
					$num_of_proposed_camps_array = $this->db->query("SELECT COUNT(*) AS count FROM camp_clinic_booking WHERE user_id = '".$value->tbm_id."' AND (camp_status = 'complete' OR camp_status = 'executed') AND date BETWEEN '".$cur_year."-".$cur_month."-01' AND '".$cur_year."-".$cur_month."-31'");
					if ($num_of_proposed_camps_array->num_rows() > 0) {
						$num_of_proposed_camps += intval($num_of_proposed_camps_array->result()[0]->count);
					}
					$num_of_completed_camps_array = $this->db->query("SELECT COUNT(*) AS count FROM camp_clinic_booking WHERE user_id = '".$value->tbm_id."' AND camp_status = 'executed' AND date BETWEEN '".$cur_year."-".$cur_month."-01' AND '".$cur_year."-".$cur_month."-31'");
					if ($num_of_completed_camps_array->num_rows() > 0) {
						$num_of_completed_camps += intval($num_of_completed_camps_array->result()[0]->count);
					}
					$num_of_patients_per_camps_array = $this->db->query("SELECT AVG(count) AS average FROM (SELECT COUNT(patients.camp_clinic_id) AS count FROM camp_clinic_booking JOIN patients ON camp_clinic_booking.id = patients.camp_clinic_id AND camp_clinic_booking.user_id = '".$value->tbm_id."' AND camp_clinic_booking.camp_status = 'executed' AND camp_clinic_booking.date BETWEEN '".$cur_year."-".$cur_month."-01' AND '".$cur_year."-".$cur_month."-31' GROUP BY patients.camp_clinic_id) AS count_table");
					if ($num_of_patients_per_camps_array->num_rows() > 0) {
						$num_of_patients_per_camps += round($num_of_patients_per_camps_array->result()[0]->average);
						if ($num_of_patients_per_camps_array->result()[0]->average > 0 || $num_of_patients_per_camps_array->result()[0]->average != NULL) {
							$counter += 1;
						}
					}
					$high_risk_array = $this->db->query("SELECT COUNT(*) AS count FROM camp_clinic_booking JOIN patients ON camp_clinic_booking.id = patients.camp_clinic_id AND camp_clinic_booking.user_id = '".$value->tbm_id."' AND camp_clinic_booking.camp_status = 'executed' AND camp_clinic_booking.date BETWEEN '".$cur_year."-".$cur_month."-01' AND '".$cur_year."-".$cur_month."-31' AND patients.fibroscan_value > 40 GROUP BY patients.camp_clinic_id");
					if ($high_risk_array->num_rows() > 0) {
						$high_risk += intval($high_risk_array->result()[0]->count);
					}
				}
			}
			if ($num_of_proposed_camps > 0) {
				$machine_utilization = ($num_of_completed_camps/$num_of_proposed_camps) * 100;
			} else {
				$machine_utilization = 0;
			}

			$response_data[$fam_id] = array(
					'num_of_proposed_camps' => $num_of_proposed_camps, 
					'num_of_completed_camps' => $num_of_completed_camps, 
					'num_of_patients_per_camps' => $num_of_patients_per_camps/$counter, 
					'high_risk' => $high_risk, 
					'machine_utilization' => $machine_utilization, 
					'fam_name' => $fam_name, 
				);


			usort($response_data, function ($a, $b){
			    return strcmp($b["machine_utilization"], $a["machine_utilization"]);
			});
		}

		$this->response(array('message' => 'SUCCESS', 'status' => 'SUCCESS', 'leaderboard_data' => $response_data));
	}

	public function get_camp_details(){
		// $camp_id = 27;
		$camp_id = $this->input->post('camp_id');
		$fam_name = '';
		$camp_details = $this->db->query("SELECT camp_clinic_booking.address, camp_clinic_booking.expected_registrations, camp_clinic_booking.user_id, camp_clinic_booking.date, doctors.name AS doctor_name, users.name, users.group_id FROM camp_clinic_booking JOIN users on camp_clinic_booking.user_id = users.id JOIN doctors ON camp_clinic_booking.doctor_id = doctors.id AND camp_clinic_booking.id = '".$camp_id."'")->result()[0];
		if ($camp_details->group_id == 4) {
			$fam_name = $this->db->query("SELECT * FROM users JOIN user_relations ON users.id = user_relations.tbm_id AND user_relations.tbm_id = '".$camp_details->user_id."'")->result()[0]->name;
		} else {
			$fam_name = $camp_details->name;
		}

		$response_data = array(
				'doctor_name' => $camp_details->doctor_name, 
				'fam_name' => $fam_name, 
				'location' => $camp_details->address, 
				'camp_date' => $camp_details->date, 
				'total_patients' => $this->db->query("SELECT COUNT(*) AS count FROM patients WHERE camp_clinic_id = '".$camp_id."'")->result()[0]->count, 
				'high_risk' => $this->db->query("SELECT COUNT(*) AS count FROM patients WHERE camp_clinic_id = '".$camp_id."' AND fibroscan_value > 40")->result()[0]->count, 
				'male_percentage' => $this->db->query("SELECT COUNT(*) AS count FROM patients WHERE camp_clinic_id = '".$camp_id."' AND gender = 'male'")->result()[0]->count, 
				'expected_registrations' => $camp_details->expected_registrations, 
				'camp_images' => $this->db->query("SELECT * FROM camp_images WHERE camp_clinic_id = '".$camp_id."'")->result(),
			);

		$response_data['positive'] = (($response_data['total_patients'] - $response_data['high_risk']) / $response_data['total_patients']) * 100;

		$this->response(array('message' => 'SUCCESS', 'status' => 'SUCCESS', 'leaderboard_data' => $response_data));
	}


	function camp_validity_check($machine_name, $date, $start_time, $end_time){
		$response = '';
		$slot_type = $this->check_camp_slot($start_time, $end_time);

		$camp_data = $this->db->query("SELECT * 
										FROM camp_clinic_booking 
										WHERE machine_name = '".$machine_name."' 
										AND date = '".$date."' 
										AND ( slot_type = '".$slot_type."' OR slot_type = 'Both Slot' ) 
										AND ( camp_status = 'complete' OR camp_status = 'incomplete' )"
									);

		if ($camp_data->num_rows() > 0) {
			return  'Exists';
		} else {
			return  'Create';
		}
	}

	function check_camp_slot($start_time, $end_time){
		$response = '';

		$slot_time_start = strtotime('08:00');
		$slot_time_mid = strtotime('14:00');
		$slot_time_end = strtotime('20:00');
		$slot_start_time = strtotime($start_time);
		$slot_end_time = strtotime($end_time);

		if ($slot_time_start <= $slot_start_time && $slot_start_time <= $slot_end_time && $slot_time_start <= $slot_end_time && $slot_end_time <= $slot_end_time) {
			if ($slot_start_time >= $slot_time_start && $slot_end_time <= $slot_time_mid && $slot_end_time >= $slot_time_start) {
				return 'First Slot';
			} elseif ($slot_start_time >= $slot_time_mid && $slot_end_time <= $slot_time_end && $slot_end_time >= $slot_time_mid) {
				return 'Second Slot';
			} elseif ($slot_start_time >= $slot_time_start && $slot_end_time <= $slot_time_end && $slot_end_time >= $slot_time_start) {
				return 'Both Slot';
			}
 		} else {
			return 'Entered special case';
		}
	}

	function response($res) {
		echo json_encode($res);
	}

	function generate_password($randomString){
		return md5(sha1($randomString));
	}

	function upload_user() {
		$res = array("status" => "fail");

		$response = md5(date('ydmhis'));
		$file_name = $_FILES["file"]["name"];
		$ext = strtolower(substr(strrchr($file_name, "."), 1));
		$upload_img = $response.".jpg";
		move_uploaded_file($_FILES["file"]["tmp_name"], "assets/uploads/".$upload_img);
		$res["status"] = "success";
		$res["data"] = $upload_img;
		echo(json_encode($upload_img));
	}

	function pull_dashboard_data($user_id, $user_group, $month, $year){
		$num_of_proposed_camps = 0;
		$num_of_completed_camps = 0;
		$num_of_patients_per_camps = 0;
		$high_risk = 0;
		$counter = 1;
		$machine_utilization = 0;

		$cur_month = $month;
		$cur_year = $year;

		if ($user_group == 'FAM') {

			$fam_id = $user_id;

			$num_of_proposed_camps_array = $this->db->query("SELECT COUNT(*) AS count FROM camp_clinic_booking WHERE user_id = '".$fam_id."' AND (camp_status = 'complete' OR camp_status = 'executed') AND date BETWEEN '".$cur_year."-".$cur_month."-01' AND '".$cur_year."-".$cur_month."-31'");
			if ($num_of_proposed_camps_array->num_rows() > 0) {
				$num_of_proposed_camps += intval($num_of_proposed_camps_array->result()[0]->count);
			}
			$num_of_completed_camps_array = $this->db->query("SELECT COUNT(*) AS count FROM camp_clinic_booking WHERE user_id = '".$fam_id."' AND camp_status = 'executed' AND date BETWEEN '".$cur_year."-".$cur_month."-01' AND '".$cur_year."-".$cur_month."-31'");
			if ($num_of_completed_camps_array->num_rows() > 0) {
				$num_of_completed_camps += intval($num_of_completed_camps_array->result()[0]->count);
			}
			$num_of_patients_per_camps_array = $this->db->query("SELECT COUNT(patients.camp_clinic_id) AS count FROM camp_clinic_booking JOIN patients ON camp_clinic_booking.id = patients.camp_clinic_id AND camp_clinic_booking.user_id = '".$fam_id."' AND camp_clinic_booking.camp_status = 'executed' AND camp_clinic_booking.date BETWEEN '".$cur_year."-".$cur_month."-01' AND '".$cur_year."-".$cur_month."-31' GROUP BY patients.camp_clinic_id");
			if ($num_of_patients_per_camps_array->num_rows() > 0) {
				$num_of_patients_per_camps += round($num_of_patients_per_camps_array->result()[0]->count);
				if ($num_of_patients_per_camps_array->result()[0]->count > 0 || $num_of_patients_per_camps_array->result()[0]->count != NULL) {
					$num_of_patients_per_camps += round($num_of_patients_per_camps_array->result()[0]->count);
				}
			}
			$high_risk_array = $this->db->query("SELECT COUNT(*) AS count FROM camp_clinic_booking JOIN patients ON camp_clinic_booking.id = patients.camp_clinic_id AND camp_clinic_booking.user_id = '".$fam_id."' AND camp_clinic_booking.camp_status = 'executed' AND camp_clinic_booking.date BETWEEN '".$cur_year."-".$cur_month."-01' AND '".$cur_year."-".$cur_month."-31' AND patients.fibroscan_value > 40 GROUP BY patients.camp_clinic_id");
			if ($high_risk_array->num_rows() > 0) {
				$high_risk += intval($high_risk_array->result()[0]->count);
			}

			$tbm_id = $this->db->query("SELECT * FROM user_relations WHERE fam_id = '".$fam_id."' GROUP BY tbm_id");
			if ($tbm_id->num_rows()) {
				foreach ($tbm_id->result() as $value) {
					$num_of_proposed_camps_array = $this->db->query("SELECT COUNT(*) AS count FROM camp_clinic_booking WHERE user_id = '".$value->tbm_id."' AND (camp_status = 'complete' OR camp_status = 'executed') AND date BETWEEN '".$cur_year."-".$cur_month."-01' AND '".$cur_year."-".$cur_month."-31'");
					if ($num_of_proposed_camps_array->num_rows() > 0) {
						$num_of_proposed_camps += intval($num_of_proposed_camps_array->result()[0]->count);
					}
					$num_of_completed_camps_array = $this->db->query("SELECT COUNT(*) AS count FROM camp_clinic_booking WHERE user_id = '".$value->tbm_id."' AND camp_status = 'executed' AND date BETWEEN '".$cur_year."-".$cur_month."-01' AND '".$cur_year."-".$cur_month."-31'");
					if ($num_of_completed_camps_array->num_rows() > 0) {
						$num_of_completed_camps += intval($num_of_completed_camps_array->result()[0]->count);
					}
					$num_of_patients_per_camps_array = $this->db->query("SELECT AVG(count) AS average FROM (SELECT COUNT(patients.camp_clinic_id) AS count FROM camp_clinic_booking JOIN patients ON camp_clinic_booking.id = patients.camp_clinic_id AND camp_clinic_booking.user_id = '".$value->tbm_id."' AND camp_clinic_booking.camp_status = 'executed' AND camp_clinic_booking.date BETWEEN '".$cur_year."-".$cur_month."-01' AND '".$cur_year."-".$cur_month."-31' GROUP BY patients.camp_clinic_id) AS count_table");
					if ($num_of_patients_per_camps_array->num_rows() > 0) {
						$num_of_patients_per_camps += round($num_of_patients_per_camps_array->result()[0]->average);
						if ($num_of_patients_per_camps_array->result()[0]->average > 0) {
							$counter += 1;
						}
					}
					$high_risk_array = $this->db->query("SELECT COUNT(*) AS count FROM camp_clinic_booking JOIN patients ON camp_clinic_booking.id = patients.camp_clinic_id AND camp_clinic_booking.user_id = '".$value->tbm_id."' AND camp_clinic_booking.camp_status = 'executed' AND camp_clinic_booking.date BETWEEN '".$cur_year."-".$cur_month."-01' AND '".$cur_year."-".$cur_month."-31' AND patients.fibroscan_value > 40 GROUP BY patients.camp_clinic_id");
					if ($high_risk_array->num_rows() > 0) {
						$high_risk += intval($high_risk_array->result()[0]->count);
					}
				}
			}

			if ($num_of_proposed_camps > 0) {
				$machine_utilization = ($num_of_completed_camps/$num_of_proposed_camps) * 100;
			} else {
				$machine_utilization = 0;
			}

			return $response_data = array( 'num_of_proposed_camps' => $num_of_proposed_camps,  'num_of_completed_camps' => $num_of_completed_camps,  'num_of_patients_per_camps' => $num_of_patients_per_camps/$counter,  'high_risk' => $high_risk,  'machine_utilization' => round($machine_utilization) );
		} else {

			$tbm_id = $user_id;

			$num_of_proposed_camps_array = $this->db->query("SELECT COUNT(*) AS count FROM camp_clinic_booking WHERE user_id = '".$tbm_id."' AND (camp_status = 'complete' OR camp_status = 'executed') AND date BETWEEN '".$cur_year."-".$cur_month."-01' AND '".$cur_year."-".$cur_month."-31'");
			if ($num_of_proposed_camps_array->num_rows() > 0) {
				$num_of_proposed_camps += intval($num_of_proposed_camps_array->result()[0]->count);
			}
			$num_of_completed_camps_array = $this->db->query("SELECT COUNT(*) AS count FROM camp_clinic_booking WHERE user_id = '".$tbm_id."' AND camp_status = 'executed' AND date BETWEEN '".$cur_year."-".$cur_month."-01' AND '".$cur_year."-".$cur_month."-31'");
			if ($num_of_completed_camps_array->num_rows() > 0) {
				$num_of_completed_camps += intval($num_of_completed_camps_array->result()[0]->count);
			}
			$num_of_patients_per_camps_array = $this->db->query("SELECT COUNT(patients.camp_clinic_id) AS count FROM camp_clinic_booking JOIN patients ON camp_clinic_booking.id = patients.camp_clinic_id AND camp_clinic_booking.user_id = '".$tbm_id."' AND camp_clinic_booking.camp_status = 'executed' AND camp_clinic_booking.date BETWEEN '".$cur_year."-".$cur_month."-01' AND '".$cur_year."-".$cur_month."-31' GROUP BY patients.camp_clinic_id");
			if ($num_of_patients_per_camps_array->num_rows() > 0) {
				$num_of_patients_per_camps += round($num_of_patients_per_camps_array->result()[0]->count);
				if ($num_of_patients_per_camps_array->result()[0]->count > 0) {
					$counter += 1;
				}
			}
			$high_risk_array = $this->db->query("SELECT COUNT(*) AS count FROM camp_clinic_booking JOIN patients ON camp_clinic_booking.id = patients.camp_clinic_id AND camp_clinic_booking.user_id = '".$tbm_id."' AND camp_clinic_booking.camp_status = 'executed' AND camp_clinic_booking.date BETWEEN '".$cur_year."-".$cur_month."-01' AND '".$cur_year."-".$cur_month."-31' AND patients.fibroscan_value > 40 GROUP BY patients.camp_clinic_id");
			if ($high_risk_array->num_rows() > 0) {
				$high_risk += intval($high_risk_array->result()[0]->count);
			}

			if ($num_of_proposed_camps > 0) {
				$machine_utilization = ($num_of_completed_camps/$num_of_proposed_camps) * 100;
			} else {
				$machine_utilization = 0;
			}

			return $response_data = array( 'num_of_proposed_camps' => $num_of_proposed_camps,  'num_of_completed_camps' => $num_of_completed_camps,  'num_of_patients_per_camps' => $num_of_patients_per_camps/$counter,  'high_risk' => $high_risk,  'machine_utilization' => round($machine_utilization) );
		}
	}

	function calendar(){
		echo '{  "events": [{    "month": "2",    "day": "12",    "year": "2016",    "title": "Lorem ipsum",    "description": "Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentumnibh, ut fermentum massa justo sit amet risus. Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatisdapibus posuere velit aliquet. Cras justo odio, dapibus ac facilisis in, egestas eget quam."  },  {    "month": "2",    "day": "9",    "year": "2016",    "title": "Lorem ipsum",    "description": "Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentumnibh, ut fermentum massa justo sit amet risus. Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatisdapibus posuere velit aliquet. Cras justo odio, dapibus ac facilisis in, egestas eget quam."  },  {    "month": "2",    "day": "10",    "year": "2016",    "title": "Lorem ipsum",    "description": "Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentumnibh, ut fermentum massa justo sit amet risus. Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatisdapibus posuere velit aliquet. Cras justo odio, dapibus ac facilisis in, egestas eget quam."  }]}';
	}
}