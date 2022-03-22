<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductController extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helpers('url');
        $this->load->model('Product');
    }

    public function index()
    {
        $this->load->view('Products');
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
                    <td><div class="dropzone" data-id="'.$row->id.'"></div></td>
                    <td>'.$row->name.'</td>
                    <td>$'.$row->price.'</td>
                    <td>'.$row->stock.'</td>
                    <td style="width:15%">
                        <button type="button" name="edit" class="btn btn-warning btn-xs edit-product" data-id-product="'.$row->id.'">Edit</button> 
                        <button type="button" name="delete" class="btn btn-danger btn-xs delete-product" data-id-product="'.$row->id.'">Delete</button>
                    </td>
                </tr>';
            }
        } else {
            $output = '<tr>
                        <td colspan="5" align="center">No Data Found</td>
                        </tr>';
        }

        header('Content-Type: application/json');
        echo json_encode( $output );
    }

    public function addProduct() 
    {
        $data = $this->input->post();
        $output = $this->Product->addUpdateProduct($data);

        header('Content-Type: application/json');
        echo json_encode( array('result' => $output ));
    }

    public function getProduct() 
    {
        $id = $this->input->post('id');
        $output = $this->Product->getProduct($id);

        header('Content-Type: application/json');
        echo json_encode( array('result' => $output )); 
    }

    public function deleteProduct() 
    {
        $id = $this->input->post('id');
        $output = $this->Product->deleteProduct($id);

        header('Content-Type: application/json');
        echo json_encode( array('result' => $output )); 
    }

    public function uploadPhoto($id) 
    {
        $path = $_FILES["file"]["tmp_name"];
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $output = $this->Product->savePhoto($id,$base64);

        header('Content-Type: application/json');
        echo json_encode( array('result' => $output ));
    }

}
