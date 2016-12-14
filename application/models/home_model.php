<?php 


class home_model extends CI_Model{

    public function portfolios(){

		 $portfoliyo_result = $this->db->select('id,image,title,sub_title,background,idea,solution')->from('portfoliyo')->get();
         return $portfoliyo_result->result();
	} 

	public function sliders(){
		 $query = $this->db->select('title,description')->from('slider')->get();
         return $query->result();
	} 
		

	public function data(){
		 $query = $this->db->select('name,description')->from('about_us')->get();
         return $query->result();
	} 

	public function services(){
		 $services = $this->db->select('name,description')->from('services')->get();
         return $services->result();
	} 

	public function teams(){
		 $team_result = $this->db->select('image,name,designation,facebook,twitter,linkedin')->from('team')->get();
         return $team_result->result();
	} 

	public function comaddress(){
		 $comaddress_result = $this->db->select('name,address,mobile, email')->from('company_add')->get();
         return $comaddress_result->result();
	} 

	public function counters(){
		 $counters_result = $this->db->select('name,count,icon')->from('counter')->get();
         return $counters_result->result();
	}	

	public function sub_portfolios($id){

		$this->db->where('portfolio_name',$id);
		$subportfolio_result = $this->db->select('image,portfolio_name')->from('sub_portfolio')->get();
        return $subportfolio_result->result();
	}

	public function sportfolios_idea_solution($id){

		$this->db->where('id',$id);
		$sportfolios_idea_solutions = $this->db->select('title,back_header,background,idea_header,idea,sol_header,solution,insight_header,insight,facebook,twitter,google,pinterest')->from('portfoliyo')->get();
        return $sportfolios_idea_solutions->result();
		//print_r($sportfolios_idea_solutions->result());exit;
	}


	

}