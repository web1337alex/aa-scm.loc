<?php
    /** @var array $args  */

    global $CoreTheme;
    if($args['all_cases'] == 'all'){
        $args['items'] = get_posts([
            'post_type' => 'cases',
            'numberposts' => -1,
            'fields' => 'ids'
        ]);

        if(!empty($args['items'])){
            $caseCategories = get_terms([
                'taxonomy' => 'case_category',
                'object_ids' => $args['items'],
            ]);
            $allPosts = get_posts([
                'post_type' => 'cases',
                'post__in' => $args['items'],
                'numberposts' => -1,
            ]);
        }
    }

    else{

        if(!empty($args['items'])){
            
            $terms = [];

            foreach ($args['items'] as $post_id) {
                $post_terms = wp_get_post_terms($post_id, 'case_category');
                foreach ($post_terms as $term) {
                    $terms[] = $term->term_id;
                }
            }
            
            $caseCategoriesIds = array_unique($terms);

            $caseCategories = get_terms([
                'taxonomy' => 'case_category',
                'include' => $caseCategoriesIds
            ]);
            

            $allPosts = get_posts([
                'post_type' => 'cases',
                'post__in' => $args['items'],
                'numberposts' => -1,
            ]);
        }

    }

?>

<section class="common common-1">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="sectiontitle"><?=$args['title']?></div>
            </div>
        </div>
        <?if(!empty($caseCategories)):?>
            <div class="row tags common__tags tabs">
                <span class="tag tab__button active" data-tab="all">Все кейсы</span>
                <?foreach($caseCategories as $caseCat):?>
                    <?if($caseCat->count > 0):?>
                        <span class="tag tab__button" data-tab="<?=$caseCat->slug?>"><?=$caseCat->name?></span>
                    <?endif;?>
                <?endforeach?>
            </div>
        <?endif?>

        <?if(!empty($caseCategories)):?>
            <div class="row cards contentTabs">
                <div id="all" class="tab__item active">
                    <div class="cards row">
                        <?foreach($allPosts as $ikeyPost => $postItem){
                            /** @var array $postItem */
                            get_template_part('template-parts/items/common', '1', $postItem);
                        }?>
                    </div>
                </div>
                <?foreach($caseCategories as $ikeyCaseCat => $caseCat):?>
                    <div id="<?=$caseCat->slug?>" class="tab__item">
                        <div class="cards row">
                            <?
                                if($caseCat->count > 0){
                                    $currentPosts = get_posts([
                                        'post_type' => 'cases',
                                        'numberposts' => -1,
                                        'post__in' => $args['items'],
                                        'tax_query' =>[
                                            [
                                                'taxonomy' => 'case_category',
                                                'field' => 'term_id',
                                                'terms' => $caseCat->term_id
                                            ]
                                        ]
                                    ]);
                                }
                            ?>
                            <?foreach($currentPosts as $ikeyPost => $postItem){
                                /** @var array $postItem */
                                get_template_part('template-parts/items/common', '1', $postItem);
                            }?>
                        </div>
                    </div>
                <?endforeach?>
            </div>
        <?endif?>
    </div>
</section>