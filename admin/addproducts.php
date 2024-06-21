<?php
session_start();

$user = $_SESSION['user'];

if ($user[0]['role'] == "user") {
    header("Location: profile.php");
}



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

</head>
<style>
    body {
        height: 100vh;
    }
</style>
<body>


<?php include './aside.php'?>
<div class="w-100 h-100 d-flex justify-content-center align-items-center">
    <div>
        <h1>Add Product</h1>
        <div class="w-100">
            <form action="" class="d-flex justify-content-between align-items-center flex-column gap-4 w-100" id="addproduct" enctype="multipart/form-data">
                <input type="text" name="title" id="title" placeholder="Title" class="form-control">
                <input type="text" name="description" id="description" placeholder="Description" class="form-control">
                <input type="number" name="price" id="price" placeholder="Price" class="form-control">
                <select name="category" id="category" class="form-select">
                    <option value="Category" selected disabled>Category</option>
                    <option value="Hello">Category 1</option>
                    <option value="Hello 1">Category 2</option>
                    <option value="Hello 2">Category 3</option>
                </select>
                <div class="input-group mb-3">
                    <input type="file" class="form-control" name="img"  id="inputGroupFile02 img">
                    <label class="input-group-text" for="inputGroupFile02">Upload</label>
                </div>
                <img src="" alt="name" hidden id="img_frame" class="card-img-top object-fit-cover overflow-hidden"  style="aspect-ratio: 1;width : 200px">
                <button type="submit" class="btn btn-success w-100">
                    Add
                </button>
            </form>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<script>

    $("#img").change(function(e) {
        const img  = $("#img")
        const img_url = URL.createObjectURL(e.target.files[0])
        const frame = $("#img_frame")

        frame.attr('src', img_url)
        frame.removeAttr("hidden")
        img.attr('hidden')
        console.log(img_url)
    })

    $("#addproduct").submit(function(e) {
        e.preventDefault();
        const title = $("#title").val()
        const description = $("#description").val()
        const price = $("#price").val()
        const category = $("#category").val();
        const files = $("#img")[0]
        const img = files.files[0];


        const formData = new FormData();
        formData.append('title', title);
        formData.append('description', description);
        formData.append('price', price);
        formData.append('category', category);
        formData.append('img', img);
        formData.append('action', "addProduct");


        $.ajax({
            url: '../server.php',
            type: "POST",
            contentType: false,
            processData: false,
            data: formData,
            success: function(r) {
                alert(r);
                location.reload()
            }
        })

    })
</script>

</body>
</html>