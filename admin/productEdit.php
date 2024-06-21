<?php
require '../server.php';
$id = $_GET['id'];

$product = $k->db->query("SELECT * FROM products WHERE id = $id")->fetch_all(true);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <style>
        body {
            height: 100vh;
        }
    </style>
</head>
<body>

<div class="w-100 h-100 d-flex justify-content-center align-items-center">
    <?php include './aside.php'?>

    <div>
        <h1>Edit Product #<?= $product[0]['id'] ?></h1>
        <form action="" class="d-flex justify-content-between align-items-center flex-column gap-4 w-100" id="editproduct">
            <input type="text" name="title" id="title" value="<?= $product[0]['title'] ?>" class="form-control">
            <input type="text" name="description" id="description" value="<?= $product[0]['description'] ?>"class="form-control">
            <input type="number" name="price" id="price" value="<?= $product[0]['price'] ?>" class="form-control">
            <select name="category" id="category" class="form-control" required>
                <option value="Category" selected disabled>Category</option>
                <option value="Hello">Hello</option>
                <option value="Hello 1">Hello 1</option>
                <option value="Hello 2">Hello 2</option>
            </select>
            <p id="category_error" class="text-danger m-0"></p>
            <button type="submit" class="btn btn-success w-100">
                Add
            </button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<script>
    $("#editproduct").submit(function(e) {
        e.preventDefault();
        const title = $("#title").val()
        const description = $("#description").val()
        const price = $("#price").val()
        const category = $("#category").val();
        $('#category_error').empty()

        if (category == null) {
            $('#category_error').append("Select Category")
        }else {
            $.ajax({
                url: '../server.php',
                type: "POST",
                data: {
                    id: <?= $product[0]['id'] ?>,
                    title: title,
                    description: description,
                    price: price,
                    category: category,
                    action: "editProduct"
                },
                success: function (r) {
                    const {success, error} = JSON.parse(r);
                    if (success) {
                        alert("Success");
                    }
                    if (error) {
                        alert(error);
                    }
                    location.href = 'allproducts.php'
                }
            }
        )}

    })
</script>
</body>
</html>
