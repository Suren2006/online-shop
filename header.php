
<div class="container d-flex justify-content-between align-items-center">
    <div>
        <h1>
            <a href="./profile.php" class="text-decoration-none ">
                LOGO
            </a>
        </h1>
    </div>
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
    <div>
        <div class="dropdown">
            <button class="border-0 bg-transparent dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?= $user[0]['first_name'] . ' ' . $user[0]['last_name'] ?>
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" id="log_out" >Log Out</a></li>
            </ul>
        </div>
    </div>
</div>