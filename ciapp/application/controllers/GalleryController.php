<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GalleryController extends CI_Controller 
{

    public function __construct()
    {
        parent::__construct();

        $this->load->helpers('url');
        $this->load->model('Product'); 
    }

    public function index()
    {
        $this->load->view('Gallery');
    }

    public function getAllProducts()
    {
        $data = $this->Product->fetchAll();
        $output = '';

        if ($data) {
          foreach ($data as $row) {
              $output .= '
                          <tr>
                            <td><img src="'.$row->image.'" height="100px" /></td>
                            <td>'.$row->name.'</td>
                            <td>$'.$row->price.'</td>
                            <td style="width:5%">
                                <button type="button" name="addtocart" class="btn btn-success btn-xs delete" data-id-product="'.$row->id.'" onClick="addToCart('.$row->id.')">Add to Cart</button>
                            </td>
                          </tr>';
          }
        } else {
            $output = '<tr>
                        <td colspan="3" align="center">No Data Found</td>
                       </tr>';
        }

        header('Content-Type: application/json');
        echo json_encode( $output );
    }

}
