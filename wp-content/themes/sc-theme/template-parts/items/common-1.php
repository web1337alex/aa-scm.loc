<?global $CoreTheme;
/** @var object $args*/?>
<div class="card col-4">
    <? $postContent = getAddPostContent($args);?>
    <div class="card__top" style="background-image: url('<?=$postContent['image']?>');">
        <div class="card__box <?if($postContent['visible']['video'] == true):?> jcsb <?else:?> jce <?endif?>">
            <?if($postContent['visible']['video'] == true):?>
                <?$cardVideoblockColor = $CoreTheme::returnColor('second-accent-color');
                $cardVideoblockColorRGB = hexToRgb($cardVideoblockColor);?>
                <div class="videoblock" style="background: radial-gradient(50% 50% at 50% 50%, rgba(<?=$cardVideoblockColorRGB[0]?>, <?=$cardVideoblockColorRGB[1]?>, <?=$cardVideoblockColorRGB[2]?>, 0) 81.77%, rgba(<?=$cardVideoblockColorRGB[0]?>, <?=$cardVideoblockColorRGB[1]?>, <?=$cardVideoblockColorRGB[2]?>, 0.44) 100%);">
                    <div class="videoblock__inner" style="background: rgba(<?=$cardVideoblockColorRGB[0]?>, <?=$cardVideoblockColorRGB[1]?>, <?=$cardVideoblockColorRGB[2]?>, 0.44);">
                        <a class="videoblock__button" style="background-color: <?=$cardVideoblockColor?>;" href="<?=$postContent['video']?>" data-fslightbox="post-video-<?=$args->ID?>"></a>
                    </div>
                </div>
            <?endif?>
            <a href="<?=$postContent['url']?>" class="button">Подробнее</a>
        </div>
    </div>
    <div class="card__bottom">
        <?if($postContent['visible']['date'] == true):?>
            <p class="card__date"><?=$postContent['date']?></p>
        <?endif?>
        <p class="card__title <?if($postContent['visible']['price'] == true):?> mb-2 <?else:?> mb-1 <?endif?>"><?=$postContent['title']?></p>
        <?if($postContent['visible']['params'] == true):?>
            <div class="card__params">
                <?foreach($postContent['params'] as $cardParam):?>
                    <div class="card__param">
                        <span class="key"><?=$cardParam['key']?>:</span>
                        <span class="value"><?=$cardParam['value']?></span>
                    </div>
                <?endforeach?>
            </div>
        <?else:?>
            <?if(isset($postContent['desc'])):?>
                <p class="card__desc"><?=$postContent['desc']?></p>
            <?endif?>
        <?endif?>
        <?if($postContent['visible']['price'] == true):?>
            <p class="card__price">
                <span class="title">Стоимость</span>
                <span class="price"><?=getCleanPrice($postContent['price']);?></span>
            </p>
        <?endif?>
    </div>
</div>