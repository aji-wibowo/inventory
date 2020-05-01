<?php

/**
 * 
 */
class M_Barang extends CI_Model
{
	
	public function getAll(){
		$query = $this->db->select('*')->from('items')->join('units', 'items.id_unit=units.id_unit')->get();

		return $query;
	}

	public function getById($id){
		return $this->db->select('*')->from('items')->join('units', 'items.id_unit=units.id_unit')->where('id_item', $id)->get();
	}

	public function save($data){
		return $this->db->insert("items", $data);
	}

	public function update($data, $where){
		return $this->db->update("items", $data, $where);
	}

	public function delete($where){
		return $this->db->delete("items", $where);
	}
}