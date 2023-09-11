<?global $CoreTheme;?>


<section class="team team-1">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="sectiontitle"><?=$args['title']?></h2>
            </div>
        </div>
        <?if(!empty($args['stuff'])):?>
            <div class="row stuff">
                <?foreach($args['stuff'] as $stuffItem):?>
                    <div class="col-3 stuff__item">
                        <div class="stuff__photo">
                            <?=wp_get_attachment_image($stuffItem['photo'], "large")?>
                            <div class="stuff__plus">
                                <div class="stuff__plus__inner"></div>
                            </div>
                        </div>
                        <div class="stuff__text">
                            <p class="stuff__name"><?=$stuffItem['name']?></p>
                            <p class="stuff__desc"><?=$stuffItem['text']?></p>
                        </div>
                    </div>
                <?endforeach?>
            </div>
        <?endif?>
    </div>
</section>