<!doctype html>
<html ⚡>

<head>
    <title>Webjump | Backend Test | Add Category</title>
    <?PHP include("../.inc/head.php"); ?>
</head>
<!-- Header -->
<?PHP include("../.inc/header.php"); ?>
<!-- Header -->
<!-- Main Content -->
<main class="content">
    <h1 class="title new-item">New Category</h1>

    <form id="form-category" method='POST'>
        <div class="input-field">
            <label for="category-name" class="label">Category Name</label>
            <input type="text" id="category-name" name="category-name" class="input-text" autocomplete="category-name" />

        </div>
        <div class="input-field">
            <label for="category-code" class="label">Category Code</label>
            <input type="text" id="category-code" name="category-code" class="input-text" autocomplete="category-code" />

        </div>
        <div class="actions-form">
            <a href="categories.php" class="action back">Back</a>
            <input class="btn-submit btn-action" type="submit" value="Save" />
        </div>
    </form>
    <div id="div-alert"></div>
</main>
<!-- Main Content -->

<!-- Footer -->
<?PHP include("../.inc/footer.php"); ?>
<!-- Footer -->
</body>

<script>
    $(document).ready(function() {
        $("#form-category").submit((e) => {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: 'process.php?url=api/category/',
                data: $("#form-category").serialize(),
                success: (obj) => {
                    if (obj.status === 'success') {
                        $("#div-alert").removeClass("error")
                        $("#div-alert").addClass("success")
                        $("#div-alert").html("Categoria cadastrada com sucesso")
                        $("#form-category").trigger('reset')
                    } else {
                        $("#div-alert").removeClass("success")
                        $("#div-alert").addClass("error")
                        $("#div-alert").html("Erro ao cadastrar categoria: " + JSON.stringify(obj))
                    }
                },
                error: (obj) => {
                    $("#div-alert").addClass("error")
                    $("#div-alert").html(obj.responseJSON.data)
                }
            })
        })
    })
</script>

</html>