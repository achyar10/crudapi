<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Merchant_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	function get($params = array()) {

        if (isset($params['id'])) {
            $this->db->where('merchants.merchant_id', $params['id']);
        }

        if (isset($params['limit'])) {
            if (!isset($params['offset'])) {
                $params['offset'] = NULL;
            }

            $this->db->limit($params['limit'], $params['offset']);
        }

        if (isset($params['order_by'])) {
            $this->db->order_by($params['order_by'], 'desc');
        } else {
            $this->db->order_by('merchant_last_update', 'desc');
        }

        $this->db->select('merchants.merchant_id, merchant_code, merchant_name, merchant_input_date, merchant_last_update');

        $res = $this->db->get('merchants');

        if (isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }

    function add($data = array()) {

        if (isset($data['merchant_id'])) {
            $this->db->set('merchant_id', $data['merchant_id']);
        }

        if (isset($data['merchant_name'])) {
            $this->db->set('merchant_name', $data['merchant_name']);
        }

        if (isset($data['merchant_code'])) {
            $this->db->set('merchant_code', $data['merchant_code']);
        }

        if (isset($data['merchant_input_date'])) {
            $this->db->set('merchant_input_date', $data['merchant_input_date']);
        }

        if (isset($data['merchant_last_update'])) {
            $this->db->set('merchant_last_update', $data['merchant_last_update']);
        }

        if (isset($data['merchant_id'])) {
            $this->db->where('merchant_id', $data['merchant_id']);
            $this->db->update('merchants');
            $id = $data['merchant_id'];
        } else {
            $this->db->insert('merchants');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    function delete($id) {
        $this->db->where('merchant_id', $id);
        $this->db->delete('merchants');
    }

}

/* End of file Merchant_model.php */
/* Location: ./application/modules/merchant/models/Merchant_model.php */