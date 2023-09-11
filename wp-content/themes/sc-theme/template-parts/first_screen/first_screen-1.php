<?php
    /** @var array $args */
    global $CoreTheme;
?>


<section class="fs fs-1">
    <div class="fs__swiper">
        <div class="fs__wrapper swiper-wrapper">
            <?php foreach($args['slides'] as $iKeySlide => $slide):?>
                <div class="fs__slide swiper-slide" style="background-image: url('<?=wp_get_attachment_url($slide['bg_image'])?>');">
                    <div class="fs__slideInner" style="background-image: linear-gradient(90.26deg, rgba(<?=$slide['gradient']['first_color']['red']?>, <?=$slide['gradient']['first_color']['green']?>, <?=$slide['gradient']['first_color']['blue']?>, 1) 43.11%, rgba(<?=$slide['gradient']['second_color']['red']?>, <?=$slide['gradient']['second_color']['green']?>, <?=$slide['gradient']['second_color']['blue']?>, 0) 75.78%);">
                        <div class="fs__container container">
                            <div class="row fs__row">
                                <div class="fs__left col col-7 col-lg-12">
                                    <div class="fs__text">
                                        <h1 class="fs__title" style="color: <?=$slide['title']['color']?>; font-family: '<?=$slide['title']['font_weight']?>'; font-size: <?=($slide['title']['font-size'] / 100)?>rem;"><?=$slide['title']['text']?></h1>
                                        <div class="fs__subtitle" style="color: <?=$slide['subtitle']['color']?>; font-family: '<?=$slide['subtitle']['font_weight']?>'; font-size: <?=($slide['subtitle']['font-size'] / 100)?>rem;"><?=$slide['subtitle']['text']?></div>
                                    </div>
                                    <div class="fs__bottom <?php if( $slide['advantages_bottom'] == 1):?>setBottom<?php endif?>">
	                                    <?php if( $slide['advantages_visible'] == 1 && !empty($slide['advantages'])):?>
                                            <ul class="fs__advantages <?=$slide['icons']?> <?php if( $slide['bg_icons'] == 'color'):?> addBg<?php endif?>">
	                                            <?php foreach($slide['advantages'] as $adv):?>
                                                    <li <?php if( $slide['bg_icons'] === 'color' && !empty($slide['color_adv'])):?> style="background-color: rgba(<?=implode(', ', $slide['color_adv'])?>);" <?php endif?>>
                                                        <span class="icon"></span>
                                                        <span class="iconText" style="font-size:<?=($slide['adv_text']['font-size'] / 100)?>em; font-family: <?=$slide['adv_text']['font_weight']?>; color: <?=$slide['adv_text']['color']?>;"><?=$adv['text']?></span>
                                                    </li>
	                                            <?php endforeach?>
                                            </ul>
	                                    <?php endif?>
	                                    <?php if(!empty($slide['buttons'])):?>
                                            <div class="fs__buttons">
	                                            <?php foreach($slide['buttons'] as $button):?>
                                                    <?if(substr($button['link'], 0, 1) === "#"):?>
                                                        <button data-fancybox data-src="<?=$button['link']?>" class="button" style="background-color: var(--<?=$button['color']?>);"><?=$button['text']?></button>
                                                    <?else:?>
                                                        <a href="<?=$button['link']?>" class="button" style="background-color: var(--<?=$button['color']?>);"><?=$button['text']?></a>
                                                    <?endif?>
                                                <?php endforeach?>
                                            </div>
	                                    <?php endif?>
                                    </div>
                                </div>
                                <div class="fs__right col col-5 col-lg-12">
	                                <?php if( $args['control'] == 1):?>
                                        <div class="swiper-button-prev"></div>
                                        <div class="swiper-button-next"></div>
	                                <?php endif?>
	                                <?php if(!empty($slide['right_side'])):?>
		                                <?php if( $slide['right_side']['type'] == 'video'):?>
			                                <?php $slideColor = $CoreTheme::returnColor($slide['right_side']['videoplay']['color']);
                                            $slideColorRGB = $CoreTheme::hexToRgb($slideColor);?>
                                            <div class="videoblock" style="background: radial-gradient(50% 50% at 50% 50%, rgba(<?=$slideColorRGB[0]?>, <?=$slideColorRGB[1]?>, <?=$slideColorRGB[2]?>, 0) 81.77%, rgba(<?=$slideColorRGB[0]?>, <?=$slideColorRGB[1]?>, <?=$slideColorRGB[2]?>, 0.44) 100%);">
                                                <div class="videoblock__inner" style="background: rgba(<?=$slideColorRGB[0]?>, <?=$slideColorRGB[1]?>, <?=$slideColorRGB[2]?>, 0.44);">
                                                    <a class="videoblock__button" style="background-color: <?=$slideColor?>;" href="<?=$slide['right_side']['videoplay']['link']?>" data-fslightbox="slide-<?=$iKeySlide?>"></a>
                                                </div>
                                            </div>
		                                <?php elseif( $slide['right_side']['type'] == 'form'):?>
                                            <div class="form">
                                                <?php echo do_shortcode($slide['right_side']['form']['shortcode']);?>
                                            </div>
		                                <?php endif?>
	                                <?php endif?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
	        <?php endforeach?>
        </div>
    </div>
</section>


