<html>
<head>
    <title>Products & Cart in Codeigniter</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css"/>
    <!--
    <style>
        .dropzone {
            width: 200px;
            height: 100px;
            min-height: 0px !important;
            }   
    </style>
    -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
</head>

<body>
    <div class="container">
        <br />
        <h3 align="center">Product List Manager</h3>
        <br />
        
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-6">
                    <button type="button" id="home_button" class="btn btn-default btn-xs" onClick="window.open('<?=base_url();?>','_self')">Main Menu</button>
                    </div>
                    <div class="col-md-6" align="right">
                        <button type="button" id="add_button" class="btn btn-default btn-xs">Add New Product</button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <span id="success_message"></span>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Current Photo</th>
                            <th style="width: 200px;">Add New Photo</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th style="width:5%">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

<div id="productModal" class="modal fade">
    <div class="modal-dialog">
        <form name="product_form" method="post" id="product_form">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Product</h4>
                    <span id="result_message"></span>
                </div>
                <div class="modal-body">
                    <label>Enter Name</label>
                    <input type="text" name="name" id="name" class="form-control" />
                    <span id="name_error" class="text-danger"></span>
                    <br />
                    <label>Enter Price</label>
                    <input type="text" name="price" id="price" class="form-control" />
                    <span id="price_error" class="text-danger"></span>
                    <br />
                    <span id="price_error" class="text-danger"></span>
                    <label>Enter the stock</label>
                    <input type="text" name="stock" id="stock" class="form-control" />
                    <span id="stock_error" class="text-danger"></span>
                    <br />
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" id="id">
                    <input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" language="javascript" >

Dropzone.autoDiscover = false;

$(document).ready(function(){

    fetchData();

    $('#add_button').click(function(){
        $('#product_form')[0].reset();
        $('#result_message').html('');
        $('.modal-title').text("Add Product");
        $('#action').val('Add');
        $('#productModal').modal('show');
    });

    $(document).on('submit', '#product_form', function(event){
        event.preventDefault();
        var id = $('#id').val();

        $.ajax({
            url:"<?php echo base_url() . 'index.php/ProductController/addProduct' ?>",
            method:"POST",
            data: $('#product_form').serialize(),
            dataType:"json",
            success:function(data){
                if(data.result){
                    if (id!=''){                        
                        setTimeout(function() { 
                            $('#productModal').modal('hide');
                            $('#product_form')[0].reset();
                        }, 600);
                    }else{
                        $('#product_form')[0].reset();
                    }
                    fetchData();
                    $('#result_message').html('<div class="alert alert-success">Data Saved</div>');
                } else if (!data.result){
                    $('#result_message').html('<div class="alert alert-danger">Something went wrong</div>');
                }
            }
        })
    });

    $(document).on('click', '.edit-product', function(){
        var id = $(this).data('id-product');
        $.ajax({
            url:"<?php echo base_url(); ?>index.php/ProductController/getProduct",
            method:"POST",
            data:{ id:id },
            dataType:"json",
            success:function(data){
                data = data.result;
                
                $('#result_message').html('');
                $('#productModal').modal('show');

                $('#id').val(id);
                $('#name').val(data['name']);
                $('#image').val(data['image']);
                $('#price').val(data['price']);
                $('#stock').val(data['stock']);

                $('.modal-title').text('Edit Product');
                $('#action').val('Save changes');
            }
        })
    });

    $(document).on('click', '.delete-product', function(){
        var id = $(this).data('id-product');

        if(confirm("Are you sure you want to delete this?")){
            $.ajax({
                url:"<?php echo base_url(); ?>index.php/ProductController/deleteProduct",
                method:"POST",
                data:{id:id},
                dataType:"JSON",
                success:function(data) {
                    data = data.result;
                    if(data) {
                        $('#success_message').html('<div class="alert alert-success">Data Deleted</div>');
                        fetchData();
                    }
                }
            })
        }
    });

    $('#productModal').on('hidden.bs.modal', function () {
        $('#product_form')[0].reset();
        $('#id').val('');
    });
    
});

function fetchData(){
    $.ajax({
        url:"<?php echo base_url(); ?>index.php/ProductController/getAllProducts",
        method:"POST",
        success:function(data){
            $('tbody').html(data);
            $('.dropzone').each(function(){
                var id = $(this).data('id');
                $(this).dropzone({
                    url: '<?php echo base_url() ?>' + 'index.php/ProductController/uploadPhoto/' + id,
                    maxFiles: 1,
                    paramName: 'file',
                    maxFilesize: 2048,
                    parallelUploads: 1,
                    uploadMultiple: false
                });
            });
        }
    });
}

</script>
