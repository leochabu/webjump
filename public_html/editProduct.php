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

    <form id="form-edit-product" method="POST">
        <div class="input-field">
            <label for="sku" class="label">Product SKU</label>
            <input type="hidden" id="id" name="id" />
            <input type="hidden" id="_method" name="_method" value="PUT" />
            <input type="text" id="sku" name="sku" class="input-text" />
        </div>
        <div class="input-field">
            <label for="name" class="label">Product Name</label>
            <input type="text" id="name" name="name" class="input-text" />
        </div>
        <div class="input-field">
            <label for="price" class="label">Price</label>
            <input type="text" id="price" name="price" class="input-text" />
        </div>
        <div class="input-field">
            <label for="quantity" class="label">Quantity</label>
            <input type="text" id="quantity" name="quantity" class="input-text" />
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
    function deleteProductImage() {
        let id = $("#id").val()
        let _method = 'delete'
        $.ajax({
            url: 'process.php?url=api/image',
            type: "POST",
            data: {
                'id': id,
                '_method': _method
            },
            success: () => {
                window.location.reload()
            }
        })
    }
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

        let getParam = new URLSearchParams(window.location.search)
        if (getParam.has('id')) {
            let cats = []
            let id = getParam.get('id')
            let forImage = ''
            $.getJSON('process.php?url=api/product/' + id, function(obj) {
                console.log(JSON.stringify(obj))
                $("#id").val(obj.data.id_product)
                $("#sku").val(obj.data.sku_product)
                $("#name").val(obj.data.name_product)
                $("#price").val(obj.data.price_product)
                $("#quantity").val(obj.data.quantity_product)
                $("#description").val(obj.data.description_product)
                $.each(obj.data.categories, function(index, element) {
                    cats.push(element.id_category)
                    console.log(element.id_category + " |" + element.name_category)
                })
                $.each(obj.data.images, (a, data) => {
                    forImage += '<img src="' + data.image_product + '" layout="responsive" width="100" alt="Tênis Runner Bolt" />'
                    $("#product-image").html(forImage)
                })
                $("#category-list").val(cats);
            })
        } else {
            alert("É necessário selecionar um produto para editar")
        }
    })

    $("#form-edit-product").submit((e) => {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: 'process.php?url=api/product',
            data: $("#form-edit-product").serialize(),
            success: (obj) => {
                if (obj.status === 'success') {
                    $("#div-alert").removeClass("error")
                    $("#div-alert").addClass("success")
                    $("#div-alert").html("Produto alterado com sucesso")
                } else {
                    $("#div-alert").removeClass("success")
                    $("#div-alert").addClass("error")
                    $("#div-alert").html("Erro ao alterar produto: " + JSON.stringify(obj))
                }
            },
            error: (obj) => {
                $("#div-alert").addClass("error")
                $("#div-alert").html(obj.responseJSON.data)
            }
        })
    })
</script>
</body>

</html>