<?php global $CoreTheme;?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=get_the_title()?></title>
    <?wp_head()?>    
</head>
<body>
    <div class="wrapper">
        <?=$CoreTheme::renderBlock('header', 'options');?>