<html>
<head>
    <title>Products & Cart in Codeigniter</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    
</head>
<body>
    <div class="container">

        <div class="row" style="padding-top: 50px;">
            <div class="col-md-12 text-center">
                <h3 align="center">Product Manager & Shopping Cart in Codeigniter</h3>
            </div>
        </div>

        <div class="row" style="padding-top: 50px;">
            <div class="col-md-12 text-center">
                <button type="button" id="manage_button" class="btn btn-warning btn-lg" onClick="window.open('<?=base_url();?>index.php/ProductController/index','_self')">Manage Products</button>
                <button type="button" id="cart_button" class="btn btn-success btn-lg" onClick="window.open('<?=base_url();?>index.php/GalleryController/index','_self')">Shopping</button> 
            </div>
        </div>

    </div>
</body>
</html>