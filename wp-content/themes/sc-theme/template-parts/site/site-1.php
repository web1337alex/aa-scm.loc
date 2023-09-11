<?php
    /** @var array $args */
    global $CoreTheme;
?>

<section class="sites sites-1 common common-1">
    <div class="container">
        <div class="row">
            <div class="col-12"><?=$CoreTheme::constructTitle($args)?></div>
        </div>
        <div class="row content">
            <div class="col-12"><?=$args['text']?></div>
        </div>
        <div class="row cards">
            <?php foreach($args['site-items'] as $site){
                get_template_part('template-parts/items/common', '2', $site);
            }?>
        </div>
    </div>
</section>

