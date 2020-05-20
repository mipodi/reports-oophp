<?php

namespace Anax\View;

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= $title . $titleExtended ?></title>
    <!-- <link rel="stylesheet" href="css/style.css"> -->
    <script src="https://use.fontawesome.com/e5579368c4.js"></script>
</head>
<body>

<navbar class="navbar">
    <!-- <a href="?">Show all content</a> |
    <a href="?route=admin">Admin</a> |
    <a href="?route=create">Create</a> |
    <a href="?route=reset">Reset database</a> |
    <a href="?route=pages">View pages</a> |
    <a href="?route=blog">View blog</a> | -->
    <a href="<?= url("cms/index") ?>">Show all</a> |
    <a href="<?= url("cms/admin") ?>">Admin</a> |
    <a href="<?= url("cms/create") ?>">Create</a> |
    <a href="<?= url("cms/reset") ?>">Reset Database</a> |
    <a href="<?= url("cms/showpages") ?>">View Pages</a> |
    <a href="<?= url("cms/blog") ?>">View Blog</a> |

</navbar>




<h1>My Content Database</h1>

<main>
