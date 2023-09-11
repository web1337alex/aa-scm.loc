<?global $CoreTheme;
/** @var object $args*/?>
<div class="card col-4">
    <div class="card__top" style="background-image: url('<?=wp_get_attachment_url($args['image'])?>');">
        <div class="card__box jce>">
            <a href="<?=$args['link']?>" data-fancybox data-type="iframe" data-preload="false" class="button">Посмотреть</a>
        </div>
    </div>
    <div class="card__bottom">
        <p class="card__title mb-1"><?=$args['title']?></p>
    </div>
</div>