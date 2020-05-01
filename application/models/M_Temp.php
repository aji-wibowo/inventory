<?php 

/**
 * 
 */
class M_Temp extends CI_Model
{
	
	public function getAll(){
		$query = $this->db->get('buy_sell_item_temporary');

		return $query;
	}

	public function getById($id){
		return $this->db->where('id_buy_sell_item_temporary', $id)->get('buy_sell_item_temporary');
	}

	public function getByFK($id){
		return $this->db->where('id_buy_item', $id)->get('buy_sell_item_temporary');
	}

	public function getByIdItem($id){
		return $this->db->where('id_item', $id)->get('buy_sell_item_temporary');	
	}

	public function save($data){
		return $this->db->insert("buy_sell_item_temporary", $data);
	}

	public function update($data, $where){
		return $this->db->update("buy_sell_item_temporary", $data, $where);
	}

	public function delete($where){
		return $this->db->delete("buy_sell_item_temporary", $where);
	}

	public function removeAll(){
		return $this->db->truncate('buy_sell_item_temporary');
	}
}