<html>
<head>
    <title>Products & Cart in Codeigniter</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    
</head>
<body>
    <div class="container">
        <br />
        <h3 align="center">Available Products</h3>
        <br />
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-6">
                    <button type="button" id="home_button" class="btn btn-default btn-xs" onClick="window.open('<?=base_url();?>','_self')">Main Menu</button>
                    </div>
                    <div class="col-md-6" align="right">
                        <button type="button" id="view_cart" class="btn btn-default btn-xs" onClick="window.open('<?=base_url();?>index.php/CartController/index','_self')">View Cart</button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <span id="result_message"></span>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Nmae</th>
                            <th>Unit Price</th>
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

<script type="text/javascript" language="javascript" >

    function fetchData(){
        $.ajax({
            url:"<?php echo base_url(); ?>index.php/GalleryController/getAllProducts",
            method:"POST",
            data:{data_action:'fetch_all'},
            success:function(data){
                $('tbody').html(data);
            }
        });
    }

    function addToCart(id){
        event.preventDefault();

        $.ajax({
            url:"<?php echo base_url() . 'index.php/CartController/addToCart' ?>",
            method:"POST",
            data:{ id:id },
            dataType:"json",
            success:function(data){
                if(data.result){
                    $('#result_message').html('<div class="alert alert-success">Product added to Cart</div>');
                    fetchData();
                } else if (!data.result){
                    $('#result_message').html('<div class="alert alert-danger">Something went wrong</div>');
                }
            }
        })
    };

    $(document).ready(function(){
        fetchData();
    });

</script>