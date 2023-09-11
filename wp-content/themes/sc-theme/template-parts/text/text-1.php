<?
    global $CoreTheme;
    if($args['image_type'] == 'thumbnail'){
        $args['img'] = get_post_thumbnail_id();
    }
?>
<section class="textblock textblock-1">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="sectiontitle"><?=$args['title']?></h2>
            </div>
        </div>
        <div class="row content">
            <div class="col-<?=(12-str_replace("col-", "", $args['img_width']))?> col-lg-12">
                <?=$args['text']?>
            </div>
            <div class="<?=$args['img_width']?> imgbox col-lg-12">
                <a data-fslightbox="textblock" href="<?=wp_get_attachment_image_url($args['img'], 'full')?>">
                <?=wp_get_attachment_image($args['img'], 'full')?>
            </a>
            </div>
        </div>
    </div>
</section>