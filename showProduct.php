<?php
require 'server.php';
session_start();

$user = $_SESSION['user'];
if ($user[0]['role'] == 'admin') {
    header('Location: admin.php');
}

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <title>Document</title>
</head>
<body>
<?php include 'header.php'?>
<div class="container d-flex justify-content-start align-items-start mt-5">
    <div class="col-6 border border-2 p-2">
        <img src="../<?= $product[0]['image'] ?>" class="card-img-top w-100 object-fit-contain overflow-hidden" style="aspect-ratio: 1" alt="...">
    </div>
    <div class="col-4 ms-5">
        <h3> <?= $product[0]['title'] ?></h3>
        <h5 class="text-secondary">Description: <?= $product[0]['description'] ?></h5>
        <p>Category: <?= $product[0]['category']  ?> </p>
        <p class="text-secondary">Price: <?= $product[0]['price'] ?>$ </p>
        <p>Date: <?= $product[0]['date']  ?> </p>
    </div>
</div>
</body>
</html>