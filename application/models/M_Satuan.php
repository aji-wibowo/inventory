<?php

/**
 * 
 */
class M_Satuan extends CI_Model
{
	public function getAll(){
		$query = $this->db->get('units');

		return $query;
	}

	public function getById($id){
		return $this->db->where('id_unit', $id)->get('units');
	}

	public function save($data){
		return $this->db->insert("units", $data);
	}

	public function update($data, $where){
		return $this->db->update("units", $data, $where);
	}

	public function delete($where){
		return $this->db->delete("units", $where);
	}
}