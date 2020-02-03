<?php
require_once('../../controllers/includes.php');

if(isset($_POST['id'])) {
    $c = new Comment;
    $c->delete($_POST['id']);
}