<?php 

/**
 * 
 */
class M_Beli extends CI_Model
{
	
	public function getAll(){
		$query = $this->db->get('buy_item');

		return $query;
	}

	public function getAllJoined(){
		return $query = $this->db->select('*')->from('buy_item')->join('supplier', 'buy_item.id_supplier=supplier.id_supplier')->get();
	}

	public function getAllDetails($id_buy){
		return $query = $this->db->select('*')->from('buy_item_detail')->join('buy_item', 'buy_item_detail.id_buy_item=buy_item.id_buy_item')->join('supplier', 'buy_item.id_supplier=supplier.id_supplier')->join('items', 'buy_item_detail.id_item=items.id_item')->join('units', 'units.id_unit=items.id_unit')->where('buy_item_detail.id_buy_item', $id_buy)->join('users', 'users.id_user=buy_item.id_user')->get();
	}

	public function getAllDetail(){
		$query = $this->db->get('buy_item_detail');

		return $query;
	}

	public function getById($id){
		return $this->db->where('id_buy_item', $id)->get('buy_item');
	}

	public function getDetailById($id){
		return $this->db->where('id_buy_item_detail', $id)->get('buy_item_detail');
	}

	public function save($data){
		return $this->db->insert("buy_item", $data);
	}

	public function saveDetail($data){
		return $this->db->insert_batch("buy_item_detail", $data);
	}

	public function update($data, $where){
		return $this->db->update("buy_item", $data, $where);
	}

	public function updateDetail($data, $where){
		return $this->db->update("buy_item_detail", $data, $where);
	}

	public function delete($where){
		return $this->db->delete("buy_item", $where);
	}

	public function deleteDetail($where){
		return $this->db->delete("buy_item_detail", $where);
	}

	public function getLastID(){
		return $this->db->select_max('id_buy_item')->where('year(buy_date)', date('Y'))->where('month(buy_date)', date('m'))->get('buy_item');
	}

	public function getReport(){
		return $this->db->query("SELECT DISTINCT b.id_item, (SELECT item_name FROM items c WHERE c.id_item = b.id_item) item_name, SUM(subtotal) beli, count(b.id_item) qty FROM buy_item a JOIN buy_item_detail b ON a.id_buy_item=b.id_buy_item WHERE YEAR(a.buy_date) = '".date('Y')."' GROUP by b.id_item");
	}

	public function getSummary(){
		return $this->db->query("SELECT SUM(subtotal) beli, count(b.id_item) qty FROM buy_item a JOIN buy_item_detail b ON a.id_buy_item=b.id_buy_item WHERE YEAR(a.buy_date) = '".date('Y')."'");
	}
}