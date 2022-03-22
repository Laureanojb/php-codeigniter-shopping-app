<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CartController extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helpers('url');
        $this->load->helpers('ip');

        $this->load->model('Cart');
    }

    public function index()
    {
        $this->load->view('Cart');
    }

    public function fetchShoppingCart()
    {
        $ip = getCustomerIP();
        $data = $this->Cart->fetch($ip);
        $output = '';

        if ($data) {
            $cart_price = 0;
            foreach ($data as $row) {
                $total_r_price = number_format(($row->price*$row->quantity),2,".",",");
                $cart_price += ($row->price*$row->quantity);
                $output .= '
                            <tr>
                                <td><img src="'.$row->image.'" height="100px" /></td>
                                <td>'.$row->name.'</td>
                                <td>$'.$row->price.'</td>
                                <td><input type="number" style="width: 50px;" min="1" max="99" value='.$row->quantity.' id="item-'.$row->id.'" class="updateQuantity" onchange="updateQuantity('.$row->id.','.$row->price.')"></td>
                                <td id="total_price-'.$row->id.'">$'.$total_r_price.'</td>
                                <td style="width:5%"><button type="button" name="delete" class="btn btn-danger btn-xs delete-product" data-id-product="'.$row->id.'">Remove</button></td>
                            </tr>';
            }
            $output .= '<tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td colspan="2" style="text-align: right;">Total Shopping Cart:</td>
                            <td>$<strong>'.$cart_price.'</strong></td>
                        </tr>';
        } else {
            $output = '<tr>
                         <td colspan="5" align="center">The cart is empty</td>
                       </tr>';
        }
        header('Content-Type: application/json');
        echo json_encode( $output );
    }

    public function addToCart()
    {
        $ip = getCustomerIP();
        $data = $this->input->post();
        $output = $this->Cart->add($data,$ip);

        header('Content-Type: application/json');
        echo json_encode( array('result' => $output ));
    }

    public function updateQuantity() 
    {
        $id = $this->input->post('id');
        $ip = getCustomerIP();
        $quantity = $this->input->post('quantity');
        $data['id'] = $id;
        $data['quantity']   = $quantity;
        $output = $this->Cart->updateQuantity($data,$ip);

        header('Content-Type: application/json');
        echo json_encode( array('result' => $output ));
    }

    public function removeFromCart() {
        $id = $this->input->post('id');
        $output = $this->Cart->remove($id);
        
        header('Content-Type: application/json');
        echo json_encode( array('result' => $output )); 
    }

    public function emptyCart() {
        $ip = $this->input->ip_address();
        $output = $this->Cart->empty($ip);
        
        header('Content-Type: application/json');
        echo json_encode( array('result' => $output )); 
    }

}
