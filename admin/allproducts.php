<?php

require '../server.php';

session_start();

$user = $_SESSION['user'];

if ($user[0]['role'] == "user") {
    header("Location: profile.php");
}



if (isset($_GET['query']) && isset($_GET['type'])) {
    $query = $_GET['query'];
    $type = $_GET['type'];
    $products = $k->db->query("SELECT * FROM products WHERE $type LIKE '%$query%' ")->fetch_all(true);
}else {
    $products = $k->db->query("SELECT * FROM products ")->fetch_all(true);
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

    .card_hover:hover {
        box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
    }

</style>
<body>


<?php include './aside.php'?>
<div class="w-100 h-100 d-flex justify-content-center align-items-start ">
    <div class="col-10 px-5  mt-5">
        <div class="d-flex justify-content-between align-items-center mb-5" >    
            <h1>ALL Products</h1>
            <form class="d-flex" role="search" id="search_form" method="get">
                <input class="form-control me-2" type="search" placeholder="Search" name="query" aria-label="Search">
                <select name="type" id="type" class="form-select">
                    <option selected disabled>Search By</option>
                    <option value="title">Name</option>
                    <option value="description">Description</option>
                    <option value="category">Category</option>
                </select>
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
        <div class="d-flex justify-content-between align-items-start flex-wrap w-100">
            <?php 
                if (!empty($products)) {
                    foreach ($products as $product) { ?>
                        <div class="card col-lg-3 col-sm-5 col-12 card_hover">
                            <img src="../<?= $product['image'] ?>" class="card-img-top w-100 object-fit-contain overflow-hidden" style="aspect-ratio: 1" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><a href="./showProduct.php?id=<?= $product['id'] ?>"  class="text-decoration-none text-black"> <?= $product['title'] ?></a> </h5>
                                <p class="card-text"><?= $product['description'] ?></p>
                                <p class="text-secondary"> <?= $product['price'] ?>$ </p>
                                <a class="btn btn-primary btn-small" href="./productEdit.php?id=<?= $product['id'] ?>">Edit</a>
                                <button class="deleteBtn btn btn-danger" data-id="<?= $product['id'] ?>">Delete</button>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <h1> There is not any products here.</h1>
            <?php } ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<script>


    $('.deleteBtn').click(function (e) {
        const id = $(this).data('id');

        $.ajax({
            url: "../server.php",
            type: "POST",
            data: {
                id: id,
                action: "deletefunction"
            },
            success: function(r) {
                alert('success');
                location.reload();
            }
        })
    })



</script>
</body>
</html>