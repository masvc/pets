<?php
session_start();
include("funcs.php");

$lid = get_form_data("lid");
$lpw = get_form_data("lpw");

if (login_check($lid, $lpw)) {
    redirect("main.php");
} else {
    redirect("index.php");
}
