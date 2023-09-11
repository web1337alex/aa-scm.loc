<?global $CoreTheme;?>
<section class="services services-4" id="services" style="background-image: url('<?=wp_get_attachment_url($args['bg'])?>');">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="sectiontitle"><?=$args['title']?></h2>
            </div>
        </div>
        <div class="row">
            <?if(!empty($args['items'])):?>
                <div class="col-8 col-lg-12">
                    <div class="services__list">
                        <?foreach($args['items'] as $item):?>
                            <div class="service" style="background-image: url('<?=wp_get_attachment_url($item['image'])?>');">
                                <div class="service__footer">
                                    <div class="service__title"><?=$item['title']?></div>
                                    <div class="service__button">
                                        <a href="<?=$item['link']?>" class="button"><?=$args['button_text']?></a>
                                    </div>
                                </div>
                            </div>
                        <?endforeach?>
                    </div>
                </div>
            <?endif?>
        </div>
    </div>
</section>