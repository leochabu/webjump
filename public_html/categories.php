<!doctype html>
<html ⚡>

<head>
    <title>Webjump | Backend Test | Categories</title>
    <?PHP include("../.inc/head.php"); ?>
</head>
<!-- Header -->
<?PHP include("../.inc/header.php"); ?>
<!-- Header -->

<body>
    <!-- Main Content -->
    <main class="content">
        <div class="header-list-page">
            <h1 class="title">Categories</h1>
            <a href="addCategory.php" class="btn-action">Add new Category</a>
        </div>
        <table class="data-grid" id="categories">
            <tr class="data-row">
                <th class="data-grid-th">
                    <span class="data-grid-cell-content">Name</span>
                </th>
                <th class="data-grid-th">
                    <span class="data-grid-cell-content">Code</span>
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
</body>
<script>
    $.getJSON('process.php?url=api/category', function(obj) {
        var to_append;
        $.each(obj.data, function(index, element) {
            to_append += '<tr class="data-row">'
            to_append += '<td class="data-grid-td">'
            to_append += '<span class="data-grid-cell-content">'
            to_append += element.name_category
            to_append += '</span>'
            to_append += '</td>'
            to_append += '<td class="data-grid-td">'
            to_append += '<span class="data-grid-cell-content">'
            to_append += element.code_category
            to_append += '</span>'
            to_append += '</td>'
            to_append += '<td class="data-grid-td">'
            to_append += '<span class="data-grid-cell-content ">'
            to_append += '<a class="action-link" onclick="editCategory(' + element.id_category + ')">Edit</a><br>'
            to_append += '<a class="action-link" onclick="deleteCategory(' + element.id_category + ')">Delete</a>'
            to_append += '</span>'
            to_append += '</td>'

        });
        $("#categories").append(to_append)
    });

    function editCategory(id) {
        $.ajax({
            url: 'editCategory.php',
            type: 'POST',
            data: [{
                'id': id
            }]
        })
        location.href = 'editCategory.php?id=' + id
    }

    function deleteCategory(id) {
        var op = confirm('Deseja deletar a categoria?')
        if (op) {
            $.ajax({
                url: 'process.php?url=api/category',
                type: 'POST',
                data: {
                    'id': id,
                    '_method': 'delete'
                },
                success: (data) => {
                    window.location.reload()
                },
                error: (data) => {
                    alert("Erro ao deletar categoria")
                }
            })
        }

    }
</script>

</html>