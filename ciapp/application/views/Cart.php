<html>
<head>
    <title>Products & Cart in Codeigniter</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <!--HealthSafe Test (Codeigniter)-->
</head>
<body>
    <div class="container">
        <br />
        <h3 align="center">Your Shopping Cart</h3>
        <br />
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-6">
                        <button type="button" id="home_button" class="btn btn-default btn-xs" onClick="window.open('<?=base_url();?>index.php/GalleryController/index','_self')">Continue shopping</button>
                    </div>
                    <div class="col-md-6" align="right">
                        <button type="button" id="empty_button" class="btn btn-default btn-xs" onClick="emptyCart()">Empty Cart</button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <span id="success_message"></span>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Unit Price</th>
                            <th style="width:5%">Quantity</th>
                            <th>Total Price</th>
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

$(document).ready(function(){
    fetchData();

    $(document).on('click', '.delete-product', function(){
        var id = $(this).data('id-product');
        if(confirm("Are you sure you want to delete this?")){
            $.ajax({
                url:"<?php echo base_url(); ?>index.php/CartController/removeFromCart",
                method:"POST",
                data:{id:id},
                dataType:"JSON",
                success:function(data){
                    data = data.result;
                    if(data){
                        $('#success_message').html('<div class="alert alert-success">The product has been removed</div>');
                        fetchData();
                    }
                }
            })
        }
    });
});

function fetchData(){
    $.ajax({
        url:"<?php echo base_url(); ?>index.php/CartController/fetchShoppingCart",
        method:"POST",
        data:{data_action:'fetch_all'},
        success:function(data)
        {
            $('tbody').html(data);
        }
    });
}

function updateQuantity(id, price){
    var quantity = $('#item-'+id).val();
    var total_r_price = price*quantity;
    total_r_price = total_r_price.toFixed(2);
    if (quantity < 1) {
        $('#item-'+id).val('1');
    } else {
        $.ajax({
            url:"<?php echo base_url() . 'index.php/CartController/updateQuantity' ?>",
            method:"POST",
            data:{id:id, quantity:quantity},
            dataType:"json",
            success:function(data){
                document.getElementById("total_price-"+id).innerHTML = total_r_price;
                fetchData();
            }
        });
    }
}

function emptyCart(){
    if(confirm("Are you sure you want to Empty the Cart ? ")){
        $.ajax({
            url:"<?php echo base_url(); ?>index.php/CartController/emptyCart",
            method:"POST",
            dataType:"JSON",
            success:function(data){
                data = data.result;
                if(data){
                    $('#success_message').html('<div class="alert alert-success">The Cart has been emptied</div>');
                    fetchData();
                }
            }
        })
    }
}

</script>