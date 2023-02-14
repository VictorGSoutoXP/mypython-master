<?php

class Pacientes_exames_oit_model extends MY_Model {

    function __construct() {

        parent::__construct();

        $this->_tableName = "pacientes_exames_oit";

    }

    /**
     * Get only one Patient
     *
     * @param $where mixed
     */
    function get($where = NULL) {
        if (! is_array ( $where ) && ! is_null ( $where )) {
            $where = array ("oit.id" => $where );
        }
        $this->db->select("*");
        $query = $this->db->get_where ( $this->_tableName . " AS oit", $where, 1 );
        $row = $query->row_array();
        return $row;
    }

    public function insert(array $data){
        $id = $data['id'];
        parent::insert($data);
        parent::update($data, $id);
    }
}

?>

