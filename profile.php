<?php
require 'server.php';

session_start();

$user = $_SESSION['user'];
if ($user[0]['role'] == 'admin') {
    header('Location: admin.php');
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <title>Document</title>
    <style> 
        .card_hover:hover {
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container d-flex justify-content-start align-items-start flex-wrap w-100 mt-5">
        <?php
         
            if (!empty($products)) {
                foreach ($products as $product) { ?>
                    <div class="card col-lg-3 col-sm-6 col-12 p-3 card_hover">
                        <img src="../<?= $product['image'] ?>" class="card-img-top w-100 object-fit-contain overflow-hidden" style="aspect-ratio: 1" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?= $product['title'] ?></h5>
                            <p class="card-text"><?= $product['description'] ?></p>
                            <p class="text-secondary"> <?= $product['price'] ?>$ </p>
                            <a href="./showProduct.php?id=<?= $product['id'] ?>" class="text-decoration-none">More...</a>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <h1> There is not any products here.</h1>
        <?php } ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <script>
        $('#log_out').click(function (e) {
            e.preventDefault()
            $.ajax({
                url: './server.php',
                type: 'POST',
                data: {
                    action: 'logout'
                },
                success: function () {
                    alert('Success');
                    location.href = './index.html'
                }

            })
        })
    </script>
</body>
</html>