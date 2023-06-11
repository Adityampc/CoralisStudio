<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $page_title ?? "APP NAME" ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <style>
        .avatar {
            vertical-align: middle;
            /* width: 50px;
            height: 50px; */
            border-radius: 50%;
        }
    </style>
</head>

<body>

    <div class="text-center">
        <strong>Welcome <?= $user['name'] ?></strong>
        <br>
        <div class="rounded-circle">
            <img src="<?= base_url(IMG_PATH . "/$user[picture]") ?>" alt="Picture <?= $user['name'] ?>" class="w-25 avatar">
        </div>
        <div>
            <strong>Name</strong> <span> : <?= $user['name'] ?></span>
            <br>
            <strong>Email</strong> <span> : <?= $user['email'] ?></span>
        </div>
        <a href="<?= base_url('signout') ?>" class="btn btn-danger">Sign Out</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>