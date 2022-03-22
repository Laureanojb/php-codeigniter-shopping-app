<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Model
{

	public function fetch($ip)
	{
		$this->db->select('p.id, p.name, p.price, p.image, c.quantity');
		$this->db->join('products p','p.id = c.product_id');
		$this->db->order_by('p.name', 'DESC');
		$query  = $this->db->get('cart c');

		$query  = $query->result();
		$result = $query ?? false;
        
		return $result;
	}	

	public function add($data,$ip)
    {
		$id = $data['id'];
        $quantity = 1;
		$mydata = array();

		$stock = $this->checkStock($id);

		$this->db->where('product_id', $id);
		$this->db->where('ip_client', $ip);
		$query = $this->db->get('cart');

		if ($query->num_rows() > 0) {
			$result = $query->result();
			$row = reset($result);
			$quantity_before = (int)$row->quantity;
			$quantity = $quantity_before + 1;
			if ($quantity <= $stock) {
				$this->db->where('product_id', $id);
				$this->db->where('ip_client', $ip);
				$this->db->set('quantity', $quantity);
				return $this->db->update('cart') ? true : false;
			} else {
				return false;
			}
		} else {
			$mydata['product_id'] = $id;
			$mydata['quantity']   = $quantity;
			$mydata['ip_client']  = $ip;
			if ($quantity <= $stock) {
				return $this->db->insert('cart', $mydata) ? true : false;
			} else {
				return false;
			}
		}
	}

	public function remove($id) 
    {
		$this->db->where('product_id', $id);
		$result = $this->db->delete('cart') ? true : false;

		return $result;
	}

	public function empty($ip) 
    {
		$this->db->where('ip_client', $ip);
		$result = $this->db->delete('cart') ? true : false;

		return $result;
	}

    public function updateQuantity($data) 
    {	
		$ip = $this->input->ip_address();
		$id = $data['id'];
		$quantity = $data['quantity'];
		$stock = $this->checkStock($id);
		if ($quantity <= $stock) {
			$this->db->where('product_id', $id);
			$this->db->where('ip_client', $ip);
			$this->db->set('quantity', $quantity);
			return $this->db->update('cart') ? true : false;
		} else {
			return false;
		}
	}

	public function uploadPhoto($data) 
    {	
		$id = $data['id'];
		$image = $data['image'];

		$type = pathinfo($image, PATHINFO_EXTENSION);
		$data_image = file_get_contents($image);
		$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data_image);

		if ($quantity <= $stock) {
			$this->db->where('id', $id);
			$this->db->set('image', $base64);
			return $this->db->update('product') ? true : false;
		} else {
			return false;
		}
	}

    private function checkStock($id) {	
		$this->db->select('stock');
		$this->db->where('id', $id);
		$query = $this->db->get('products');	
		$result = $query->result();
		$row = reset($result);
		
		return $stock = $row->stock ?? 0;
	}

}
