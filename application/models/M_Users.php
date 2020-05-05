<?php

/**
 * 
 */
class M_Users extends CI_Model
{
	public function getAll(){
		$query = $this->db->get('users');

		return $query;
	}

	public function getByUsername($username){
		$query = $this->db->where('username', $username)->where('status', 1)->get('users');

		return $query;
	}

	public function getById($id){
		return $this->db->where('id_user', $id)->get('users');
	}
	
	public function getByCookie($cookie){
		$query = $this->db->where('cookie', $cookie)->get('users');

		return $query;
	}

	public function save($data){
		return $this->db->insert("users", $data);
	}

	public function update($data, $where){
		return $this->db->update("users", $data, $where);
	}

	public function delete($where){
		return $this->db->delete("users", $where);
	}
}