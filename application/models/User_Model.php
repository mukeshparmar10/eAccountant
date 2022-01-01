<?php 
class User_Model extends CI_Model {
	function __construct() {
        // load the parent constructor
        parent::__construct();
    }

    function select($table, $where) {
        return $this->db->select("*")
                        ->from($table)
                        ->where($where)
                        ->get("");
    }

    function select_order_by($table, $where, $field, $order, $limit) {
        return $this->db->select("*")
                        ->from($table)
                        ->where($where)
                        ->order_by("$field", "$order")
                        ->limit($limit)
                        ->get("");
    }

    function select_all($table) {
        return $this->db->select("*")
                        ->from($table)
                        ->get("");
    }

    function select_all_order_by($table, $field, $order, $limit) {
        return $this->db->select("*")
                        ->from($table)
                        ->order_by("$field", "$order")
                        ->limit($limit)
                        ->get("");
    }

    function record_count_where($table, $where) {
        $this->db->where($where);
        return $this->db->count_all_results($table);
    }

    function product_data_where($limit, $start, $table, $field, $order, $where) {
        $this->db->limit($limit, $start);
        $this->db->order_by($field, $order);
        $query = $this->db->select('*')
                ->from($table)
                ->where($where);
        return $query->get();
    }
    
    function insert($table, $data) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function update($table, $data, $where) {
        return $this->db->where($where)->update($table, $data);
    }

    function delete($table, $where) {
        return $this->db->where($where)->delete($table);
    }

    function exe_query($query) {
        return $this->db->query($query);
    }
}
?>