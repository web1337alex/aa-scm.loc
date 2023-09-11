<?php
    /** @var array $args */
    global $CoreTheme;
?>

<section class="faq faq-1">
    <div class="container">
        <div class="row">
            <div class="col-12"><?=$CoreTheme::constructTitle($args)?></div>
        </div>
        <div class="row content">
            <div class="col-12"><?=$args['text']?></div>
        </div>
    </div>
    <?php if(!empty($args['faq_items'])):?>
        <div class="container">
            <div class="row accordion">
                <?php foreach($args['faq_items'] as $faqItem):?>
                    <div class="col-6 col-lg-12">
                        <div class="accordion__item faq__item">
                            <div class="accordion__header faq__header"><?=$faqItem['q']?></div>
                            <div class="faq__body accordion__body">
                                <div class="content"><?=$faqItem['a']?></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
    <?php endif;?>
</section>