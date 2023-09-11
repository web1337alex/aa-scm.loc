<?php
    /** @var array $args */
    global $CoreTheme;
?>

<section class="steps steps-1">
    <div class="container steps__header">
        <div class="row">
            <div class="col-12"><?=$CoreTheme::constructTitle($args)?></div>
        </div>
        <div class="row content">
            <div class="col-12"><?=$args['text']?></div>
        </div>
    </div>
    <?php if(!empty($args['steps-items'])):?>
        <div class="container">
            <div class="row steps__wrap">
                <?php foreach($args['steps-items'] as $iStepKey => $step):?>
                    <div class="col-lg-12 col-4 steps__item">
                        <div class="steps__image"><?=wp_get_attachment_image($step['image'], 'full')?></div>
                        <div class="steps__digit sectiontitle">0<?=($iStepKey + 1)?></div>
                        <div class="steps__title"><?=$step['title']?></div>
                        <div class="steps__description"><?=$step['description']?></div>
                    </div>
                <?php endforeach?>
            </div>
        </div>
    <?php endif?>
</section>