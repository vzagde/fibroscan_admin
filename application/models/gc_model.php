<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gc_model extends grocery_CRUD_Model {

    private  $query_str = ''; 
    function __construct() {
        parent::__construct();
    }
 
    function get_list() {
        $query=$this->db->query($this->query_str);
 
        $results_array=$query->result();
        return $results_array;      
    }
 
    public function set_query_str($query_str) {
        $this->query_str = $query_str;
    }


    public function get_advice_data(){
        $query = $this->db->query("SELECT ga.id,ga.investor_id,ga.type,pd.name, pd.email,pd.mobile,ga.created_date  FROM get_advice as ga LEFt JOIN PersonalDetails as pd ON ga.investor_id = pd.investor_id ");
        $r = $query->result_array();
        return $r;
    }

}

/* End of file gc_model.php */
/* Location: ./application/models/gc_model.php */