<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	function get_user($where=null, $limit=null, $offset=null) {
		return $this->db->get_where('users', $where, $limit, $offset);
	}

	function update($data, $condition){
		return $this->db->update('users', $data, $condition);
	}

	function insert($data){
		$this->db->insert('users', $data);
		return $this->db->insert_id();
	}

}

/* End of file User_model.php */
/* Location: ./application/models/api/User_model.php */