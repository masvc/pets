<?php
session_start();
include("funcs.php");

logout();
?>
<script>
    alert('ログアウトされました');
    window.location.href = 'index.php';
</script>