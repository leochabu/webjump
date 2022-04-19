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

    <form id="form-edit-category" method='POST'>
        <div class="input-field">
            <label for="category-name" class="label">Category Name</label>
            <input type="text" id="category-name" name="category-name" class="input-text" />
            <input type="hidden" id="_method" name="_method" value='PUT' />
            <input type="hidden" id="id" name="id" />

        </div>
        <div class="input-field">
            <label for="category-code" class="label">Category Code</label>
            <input type="text" id="category-code" name="category-code" class="input-text" />

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
    $(document).ready(()=>{
        let getParam = new URLSearchParams(window.location.search)
        if(getParam.has('id')){
            let id = getParam.get('id')
            $.getJSON('process.php?url=api/category/'+id, function(obj) {
                $("#id").val(obj.data.id_category)
                $("#category-name").val(obj.data.name_category)
                $("#category-code").val(obj.data.code_category)
            })
        }else{
            alert("É necessário selecionar uma categoria para editar")
        }
    })

    $("#form-edit-category").submit((e) => {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: 'process.php?url=api/category/',
            data: $("#form-edit-category").serialize(),
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
</script>

</html>