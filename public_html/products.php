<!doctype html>
<html ⚡>

<head>
    <title>Webjump | Backend Test | Products</title>
    <?PHP include("../.inc/head.php"); ?>
</head>
<!-- Header -->
<?PHP include("../.inc/header.php"); ?>
</header>
<!-- Header -->

<body>
    <!-- Main Content -->
    <main class="content">
        <div class="header-list-page">
            <h1 class="title">Products</h1>
            <a href="addProduct.php" class="btn-action">Add new Product</a>
        </div>
        <table class="data-grid" id="products">
            <tr class="data-row">
                <th class="data-grid-th">
                    <span class="data-grid-cell-content">Name</span>
                </th>
                <th class="data-grid-th">
                    <span class="data-grid-cell-content">SKU</span>
                </th>
                <th class="data-grid-th">
                    <span class="data-grid-cell-content">Price</span>
                </th>
                <th class="data-grid-th">
                    <span class="data-grid-cell-content">Quantity</span>
                </th>
                <th class="data-grid-th">
                    <span class="data-grid-cell-content">Categories</span>
                </th>
                <th class="data-grid-th">
                    <span class="data-grid-cell-content">Actions</span>
                </th>
            </tr>
        </table>
    </main>
    <!-- Main Content -->

    <!-- Footer -->
    <?PHP include("../.inc/footer.php"); ?>
    <!-- Footer -->

    <script>
        $.getJSON('process.php?url=api/product', function(obj) {
            var to_append;
            console.log(obj)
            $.each(obj.data, function(index, element) {
                to_append += '<tr class="data-row">'
                to_append += '<td class="data-grid-td">'
                to_append += '<span class="data-grid-cell-content">'
                to_append += element.name_product
                to_append += '</span>'
                to_append += '</td>'
                to_append += '<td class="data-grid-td">'
                to_append += '<span class="data-grid-cell-content">'
                to_append += element.sku_product
                to_append += '</span>'
                to_append += '</td>'
                to_append += '<td class="data-grid-td">'
                to_append += '<span class="data-grid-cell-content">'
                to_append += element.price_product
                to_append += '</span>'
                to_append += '</td>'
                to_append += '<td class="data-grid-td">'
                to_append += '<span class="data-grid-cell-content">'
                to_append += element.quantity_product
                to_append += '</span>'
                to_append += '</td>'
                to_append += '<td class="data-grid-td">'
                to_append += '<span class="data-grid-cell-content">'
                $.each(element.categories, (i, data) => {
                    to_append += data.name_category + "<br>"
                })
                to_append += '</span>'
                to_append += '</td>'
                to_append += '<td class="data-grid-td">'
                to_append += '<span class="data-grid-cell-content ">'
                to_append += '<a class="action-link" onclick="editProduct(' + element.id_product + ')">Edit</a><br>'
                to_append += '<a class="action-link" onclick="deleteProduct(' + element.id_product + ')">Delete</a>'
                to_append += '</span>'
                to_append += '</td>'

            });
            $("#products").append(to_append)
        });

        function editProduct(id) {
            location.href = 'editProduct.php?id=' + id
        }

        function deleteProduct(id) {
            var op = confirm('Deseja deletar o produto?')
            if (op) {
                $.ajax({
                    url: 'process.php?url=api/product',
                    type: 'POST',
                    data: {
                        'id': id,
                        '_method': 'delete'
                    },
                    success: (data) => {
                        window.location.reload()
                    },
                    error: (data) => {
                        alert("Erro ao deletar produto")
                    }
                })
            }
        }
    </script>
</body>

</html>