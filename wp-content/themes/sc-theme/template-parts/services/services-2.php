<?php /** @var array $args */ 
global $CoreTheme;?>
<section class="services services-2" id="services">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="sectiontitle"><?=$args['title']?></h2>
            </div>
        </div>
        <div class="row">
        <?php 
            if($args['query'] == 'all'){
                $allServices = get_posts([
                    'numberposts' => -1,
                    'post_type' => 'services'
                ]);
                $args['items'] = [];
                foreach($allServices as $iKeyService => $service){
                    $args['items'][$iKeyService]['title'] = $service->post_title;
                    $args['items'][$iKeyService]['link'] = get_permalink($service->ID);
                    $args['items'][$iKeyService]['image'] = get_post_thumbnail_id($service->ID);
                }
            }
            ?>
            <?if(!empty($args['items'])):?>
                <div class="col-12 col-lg-12">
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
