<?php 

/**
 * 
 */
class M_Jual extends CI_Model
{
	
	public function getAll(){
		$query = $this->db->get('sell_item');

		return $query;
	}

	public function getAllJoined(){
		return $query = $this->db->select('*')->from('sell_item')->get();
	}

	public function getAllDetail(){
		$query = $this->db->get('sell_item_detail');

		return $query;
	}

	public function getById($id){
		return $this->db->where('id_sell_item', $id)->get('sell_item');
	}

	public function getAllDetails($id_sell){
		return $query = $this->db->select('*')->from('sell_item_detail')->join('sell_item', 'sell_item_detail.id_sell_item=sell_item.id_sell_item')->join('items', 'sell_item_detail.id_item=items.id_item')->join('units', 'units.id_unit=items.id_unit')->join('users', 'users.id_user=sell_item.id_user')->where('sell_item_detail.id_sell_item', $id_sell)->get();
	}

	public function getDetailById($id){
		return $this->db->where('id_sell_item_detail', $id)->get('sell_item_detail');
	}

	public function save($data){
		return $this->db->insert("sell_item", $data);
	}

	public function saveDetail($data){
		return $this->db->insert_batch("sell_item_detail", $data);
	}

	public function update($data, $where){
		return $this->db->update("sell_item", $data, $where);
	}

	public function updateDetail($data, $where){
		return $this->db->update("sell_item_detail", $data, $where);
	}

	public function delete($where){
		return $this->db->delete("sell_item", $where);
	}

	public function deleteDetail($where){
		return $this->db->delete("sell_item_detail", $where);
	}

	public function getLastID(){
		return $this->db->select_max('id_sell_item')->where('year(sell_date)', date('Y'))->where('month(sell_date)', date('m'))->get('sell_item');
	}

	public function getReport(){
		return $this->db->query("SELECT DISTINCT b.id_item, (SELECT item_name FROM items c WHERE c.id_item = b.id_item) item_name, SUM(subtotal) jual, count(b.id_item) qty FROM sell_item a JOIN sell_item_detail b ON a.id_sell_item=b.id_sell_item WHERE YEAR(a.sell_date) = '".date('Y')."' GROUP by b.id_item");
	}

	public function getSummary(){
		return $this->db->query("SELECT SUM(subtotal) jual, count(b.id_item) qty FROM sell_item a JOIN sell_item_detail b ON a.id_sell_item=b.id_sell_item WHERE YEAR(a.sell_date) = '".date('Y')."'");
	}
}