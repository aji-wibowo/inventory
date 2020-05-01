<?php

/**
 * 
 */
class M_Supplier extends CI_Model
{
	
	public function getAll(){
		$query = $this->db->get('supplier');

		return $query;
	}

	public function getById($id){
		return $this->db->where('id_supplier', $id)->get('supplier');
	}

	public function save($data){
		return $this->db->insert("supplier", $data);
	}

	public function update($data, $where){
		return $this->db->update("supplier", $data, $where);
	}

	public function delete($where){
		return $this->db->delete("supplier", $where);
	}
}