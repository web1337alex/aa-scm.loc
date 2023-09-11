<?global $CoreTheme;?>
<section class="reviews reviews-1">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="sectiontitle"><?=$args['title']?></h2>
            </div>
        </div>
        <?if(!empty($args['reviews'])):?>
            <div class="row reviewsRow">
                <?foreach($args['reviews'] as $review):?>
                    <div class="col-6 reviewItem col-lg-12">
                        <div class="reviewItem__row">
                            <div class="reviewItem__img">
                                <?=wp_get_attachment_image($review['photo'], "large")?>
                            </div>
                            <div class="reviewItem__text">
                                <div class="reviewItem__description"><?=$review['text']?></div>
                                <div class="reviewItem__name"><?=$review['name']?></div>
                                <div class="reviewItem__position"><?=$review['position']?></div>
                            </div>
                        </div>
                    </div>
                <?endforeach?>
            </div>
        <?endif?>
    </div>
</section>