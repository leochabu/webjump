<!doctype html>
<html ⚡>

<head>
    <title>Webjump | Backend Test | Add Product</title>
    <?PHP include("../.inc/head.php"); ?>
</head>
<!-- Header -->
<?PHP include("../.inc/header.php"); ?>
<!-- Header -->
<!-- Main Content -->
<main class="content">
    <h1 class="title new-item">New Product</h1>

    <form id="form-product" method="POST" enctype="multipart/form-data">
        <div class="input-field">
            <label for="sku" class="label">Product SKU</label>
            <input type="text" id="sku" name="sku" class="input-text" autocomplete="sku-product" />
        </div>
        <div class="input-field">
            <label for="name" class="label">Product Name</label>
            <input type="text" id="name" name="name" class="input-text" autocomplete="name-product" />
        </div>
        <div class="input-field">
            <label for="price" class="label">Price</label>
            <input type="text" id="price" name="price" class="input-text" autocomplete="price-product" />
        </div>
        <div class="input-field">
            <label for="quantity" class="label">Quantity</label>
            <input type="number" id="quantity" name="quantity" class="input-text" autocomplete="quantity-product" />
        </div>
        <div class="input-field">
            <label for="category" class="label">Categories</label>
            <select multiple id="category-list" name="category-list[]" class="input-text">
            </select>
        </div>
        <div class="input-field">
            <label for="description" class="label">Description</label>
            <textarea id="description" name="description" class="input-text"></textarea>
        </div>
        <div class="actions-form">
            <a href="products.php" class="action back">Back</a>
            <input class="btn-submit btn-action" type="submit" value="Save Product" />
        </div>

    </form>
    <div id="div-alert"></div>
</main>
<!-- Main Content -->

<!-- Footer -->
<?PHP include("../.inc/footer.php"); ?>

<script>
    $(document).ready(() => {
        $.ajax({
            type: "GET",
            url: 'process.php?url=api/category/',
            success: (obj) => {
                if (obj.status === 'success') {
                    $.each(obj.data, function(index, element) {
                        $('#category-list').append("<option value='" + element.id_category + "'>" + element.name_category + "</option>");
                    })
                }
            },
            error: (obj) => {

            }
        })
    })
    $("#form-product").submit((e) => {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: 'process.php?url=api/product/',
            data: $("#form-product").serialize(),
            success: (obj) => {
                if (obj.status === 'success') {
                    $("#div-alert").removeClass("error")
                    $("#div-alert").addClass("success")
                    $("#div-alert").html("Produto cadastrado com sucesso")
                    $("#form-product").trigger('reset')
                } else {
                    $("#div-alert").removeClass("success")
                    $("#div-alert").addClass("error")
                    $("#div-alert").html("Erro ao cadastrar produto: " + JSON.stringify(obj))
                }
            },
            error: (obj) => {
                $("#div-alert").addClass("error")
                $("#div-alert").html("Erro ao cadastrar produto")
            }
        })
    })
</script>
</body>

</html>