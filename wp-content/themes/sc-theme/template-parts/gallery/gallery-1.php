<?php
    global $CoreTheme;
    /** @var array $args*/
?>

<section class="gallery gallery-2">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="sectiontitle"><?=$args['title']?></h2>
            </div>
        </div>
        <?if(!empty($args['slides'])):?>
            <div class="gallery__top swiper-container">
                <div class="swiper-wrapper">
                    <?foreach($args['slides'] as $slideKey => $topSlideItem):?>
                        <? if($topSlideItem['photo_resource'] == 'yt'){
                            $ytID = getYoutubeVideoID($topSlideItem['link']);
                            $topSlideItem['photo'] = "https://i.ytimg.com/vi/".$ytID."/maxresdefault.jpg";
                        }?>
                        <div class="swiper-slide">
                            <div class="gallery_slide">
                                <div class="gallery_image">
                                    <a href="<?=$topSlideItem['link']?>" data-fslightbox="gallery_video" class="gallery_link"><img src="<?=$topSlideItem['photo']?>" alt="Фото №<?=$slideKey+1?>" title="Изображение - Фото №<?=$slideKey+1?>"></a>
                                    <div class="gallery_videoblock">
                                        <?$cardVideoblockColor = $CoreTheme::returnColor('second-accent-color');
                                        $cardVideoblockColorRGB = hexToRgb($cardVideoblockColor);?>
                                        <div class="videoblock" style="background: radial-gradient(50% 50% at 50% 50%, rgba(<?=$cardVideoblockColorRGB[0]?>, <?=$cardVideoblockColorRGB[1]?>, <?=$cardVideoblockColorRGB[2]?>, 0) 81.77%, rgba(<?=$cardVideoblockColorRGB[0]?>, <?=$cardVideoblockColorRGB[1]?>, <?=$cardVideoblockColorRGB[2]?>, 0.44) 100%);">
                                            <div class="videoblock__inner" style="background: rgba(<?=$cardVideoblockColorRGB[0]?>, <?=$cardVideoblockColorRGB[1]?>, <?=$cardVideoblockColorRGB[2]?>, 0.44);">
                                                <a class="videoblock__button" style="background-color: <?=$cardVideoblockColor?>;" href="<?=$topSlideItem['link']?>" data-fslightbox="post-video-<?=$slideKey?>"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery__text">
                                    <?=$topSlideItem['text'];?>
                                </div>
                            </div>
                        </div>
                    <?endforeach?>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
            <div class="gallery__thumbs swiper-container">
                <div class="swiper-wrapper">
                    <?foreach($args['slides'] as $topSlideItem):?>
	                    <? if($topSlideItem['photo_resource'] == 'yt'){
		                    $ytID = getYoutubeVideoID($topSlideItem['link']);
		                    $topSlideItem['photo'] = "https://i.ytimg.com/vi/".$ytID."/maxresdefault.jpg";
	                    }?>
                        <div class="swiper-slide" style="background-image: url('<?=$topSlideItem['photo']?>');"></div>
                    <?endforeach?>
                </div>
                <div class="swiper-button-next"></div>
			    <div class="swiper-button-prev"></div>
            </div>
        <?endif?>
    </div>
    <?if($args['enable_button'] == true):?>
        <div class="container">
            <div class="row">
                <div class="col-12 jcc">
                    <a href="<?=$args['button']['url']?>" target="<?=$args['button']['target']?>" class="button gallery__button"><?=$args['button']['title']?></a>
                </div>
            </div>
        </div>
    <?endif?>
</section>