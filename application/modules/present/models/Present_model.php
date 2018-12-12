<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Present_model extends CI_Model {

    function __construct() { 
        parent::__construct();
    }

    // Get From Databases
    function get($params = array()) {
        if (isset($params['id'])) {
            $this->db->where('presents.present_id', $params['id']);
        }

        if (isset($params['year'])) {
            $this->db->where('present_year', $params['year']);
        }

        if (isset($params['month'])) {
            $this->db->where('present_month', $params['month']);
        }

        if (isset($params['date'])) {
            $this->db->where('present_date', $params['date']);
        }

        if (isset($params['present1'])) {
            $this->db->where('present_out_time_1', $params['present1']);
        }

        if (isset($params['present2'])) {
            $this->db->where('present_out_time_2', $params['present2']);
        }

        if (isset($params['desc1'])) {
            $this->db->where('present_out_desc_1', $params['desc1']);
        }

        if (isset($params['desc2'])) {
            $this->db->where('present_out_desc_2', $params['desc2']);
        }

        if (isset($params['employee_id'])) {
            $this->db->where('employee_employee_id', $params['employee_id']);
        }

        if (isset($params['employee_nip'])) {
            $this->db->where('employee_employee_nip', $params['employee_nip']);
        }

        if (isset($params['ds']) AND isset($params['de'])) {
            $this->db->where('present_date >=', $params['ds'] . ' 00:00:00');
            $this->db->where('present_date <=', $params['de'] . ' 23:59:59');
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
            $this->db->order_by('present_date', 'desc');
        }

        $this->db->select('*');

        $this->db->join('employees', 'employees.employee_id = presents.employee_employee_id', 'left');

        $res = $this->db->get('presents'); 

        if (isset($params['id']) OR (isset($params['limit']) AND $params['limit'] == 1) OR (isset($params['date']) AND isset($params['employee_nip']))) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }

    // Add and uptgl to database
    function add($data = array()) {

        if (isset($data['present_id'])) {
            $this->db->set('present_id', $data['present_id']);
        }

        if (isset($data['present_year'])) {
            $this->db->set('present_year', $data['present_year']);
        }

        if (isset($data['present_month'])) {
            $this->db->set('present_month', $data['present_month']);
        }

        if (isset($data['present_date'])) {
            $this->db->set('present_date', $data['present_date']);
        }

        if (isset($data['present_entry_time_1'])) {
            $this->db->set('present_entry_time_1', $data['present_entry_time_1']);
        }

        if (isset($data['present_entry_time_2'])) {
            $this->db->set('present_entry_time_2', $data['present_entry_time_2']);
        }

        if (isset($data['present_out_time_1'])) {
            $this->db->set('present_out_time_1', $data['present_out_time_1']);
        }

        if (isset($data['present_out_time_2'])) {
            $this->db->set('present_out_time_2', $data['present_out_time_2']);
        }

        if (isset($data['present_out_desc_1'])) {
            $this->db->set('present_out_desc_1', $data['present_out_desc_1']);
        }

        if (isset($data['present_out_desc_2'])) {
            $this->db->set('present_out_desc_2', $data['present_out_desc_2']);
        }

        if (isset($data['present_is_late'])) {
            $this->db->set('present_is_late', $data['present_is_late']);
        }

        if (isset($data['present_is_before'])) {
            $this->db->set('present_is_before', $data['present_is_before']);
        }

        if (isset($data['employee_employee_id'])) {
            $this->db->set('employee_employee_id', $data['employee_employee_id']);
        }

        if (isset($data['employee_employee_nip'])) {
            $this->db->set('employee_employee_nip', $data['employee_employee_nip']);
        }

        if (isset($data['present_id'])) {
            $this->db->where('present_id', $data['present_id']);
            $this->db->update('presents');
            $id = $data['present_id'];
        } else {
            $this->db->insert('presents');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    // Delete to database
    function delete($id) {
        $this->db->where('present_id', $id);
        $this->db->delete('presents');
    }

}
