<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Model
{
	
	public function fetchAll()
	{
		$this->db->where('stock >', '0');
		$this->db->order_by('name', 'DESC');
		$query  = $this->db->get('products');
		$query  = $query->result();
		$result = $query ?? false;

		return $result;
	}	

	public function addUpdateProduct($data)
	{
		if (isset($data['id'])) {
			$id = $data['id'];
			unset($data['id']);
		} else { $id = false; }
		if ($id && is_numeric($id) && $id>0) {
			$this->db->where('id', $id);
			$result = $this->db->update('products', $data) ? true : false;
		} else {
			$result = $this->db->insert('products', $data) ? true : false;
		}

		return $result;
    }

	public function getProduct($id) 
	{
		$this->db->where('id', $id);
		$query = $this->db->get('products');
		$result = $query->result();	

		return $result ? reset($result) : false;
	}

	public function deleteProduct($id) 
	{
		$this->db->where('id', $id);
		$result = $this->db->delete('products') ? true : false;

		return $result;
	}

	public function savePhoto($id,$image) 
	{
		$this->db->where('id', $id);
		$this->db->set('image', $image);

		return $this->db->update('products') ? true : false;
	}

	private function checkStock($id) 
	{	
		$this->db->select('stock');
		$this->db->where('id', $id);
		$query = $this->db->get('products');	
		$result = $query->result();
		$row = reset($result);

		return $stock = $row->stock ?? 0;
	}

}
