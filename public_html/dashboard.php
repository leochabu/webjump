<!doctype html>
<html ⚡>

<head>
    <title>Webjump | Backend Test | Dashboard</title>
    <?PHP include("../.inc/head.php"); ?>
</head>
<!-- Header -->
<?PHP include("../.inc/header.php"); ?>
<!-- Header -->
<!-- Main Content -->
<main class="content">
    <div class="header-list-page">
        <h1 class="title">Dashboard</h1>
    </div>
    <div class="infor">
        You have <span id='quant-prod'></span> products added on this store: <a href="addProduct.php" class="btn-action">Add new Product</a>
    </div>
    <div id="product-list">

    </div>

</main>
<!-- Main Content -->

<!-- Footer -->
<?PHP include("../.inc/footer.php"); ?>
<!-- Footer -->

<script>
    $(document).ready(() => {
        $.getJSON('process.php?url=api/product', function(obj) {
            var to_append = "";
            let i = 0
            let count = 0
            console.log(obj)
            to_append += '<ul  class="product-list">'
            $.each(obj.data, function(index, element) {
                count++
                if (i == 4) {
                    to_append += '</ul>'
                    to_append += '<ul  class="product-list">'
                    i = 0;
                }
                to_append += '<li>'
                to_append += '<div class="product-image min-150">'
                to_append += '<img src="https://via.placeholder.com/150" layout="responsive" width="100" alt="" />'
                to_append += '</div>'
                to_append += '<div class="product-info">'
                to_append += '<div class="product-name"><span>' + element.name_product + '</span></div>'
                to_append += '<div class="product-price"><span class="special-price">' + element.quantity_product + ' available</span> <span>R$ ' + element.price_product + '</span></div>'
                to_append += '</div>'
                to_append += '</li>'
                i++

            })
            to_append += '</ul>'
            $("#product-list").html(to_append);
            $("#quant-prod").html(count);
            console.log(to_append)
        })
    })
</script>
</body>

</html>