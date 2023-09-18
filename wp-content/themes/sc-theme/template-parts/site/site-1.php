<?php

/** @var array $args */
global $CoreTheme;
?>

<section class="common common-1 tagsSection">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="sectiontitle">
                    <?= $CoreTheme::constructTitle($args); ?>
                </div>
            </div>
        </div>
        <div class="row content">
            <div class="col-12">
                <?= $args['text'] ?>
            </div>
        </div>
        <? if (!empty($args['tabs'])): ?>
            <div class="row tags common__tags tabs">
                <span class="tag tab__button active" data-tab="allSites">Все сайты</span>
                <? foreach ($args['tabs'] as $iketTab => $tabItem): ?>
                    <? if ($args['tabs'] > 0): ?>
                        <span class="tag tab__button" data-tab="tab_<?= $iketTab ?>">
                            <?= $tabItem['tab'] ?>
                        </span>
                    <? endif; ?>
                <? endforeach ?>
            </div>
        <? endif ?>

        <? if (!empty($args['tabs'])): ?>
            <div class="row cards contentTabs">
                <div id="allSites" class="tab__item active">
                    <div class="cards row">
                        <? foreach ($args['tabs'] as $tabs) {
                            foreach ($tabs['sites'] as $site) {
                                get_template_part('template-parts/items/common', '2', $site);
                            }
                        } ?>
                    </div>
                </div>
                <?php foreach ($args['tabs'] as $iketTab => $tabItem):?>
                    <div id="tab_<?=$iketTab?>" class="tab__item">
                        <?if($tabItem['text'] != null):?>
                            <div class="row content mb-4">
                                <div class="col-12"><?=$tabItem['text']?></div>
                            </div>
                        <?php endif?>
                        <div class="cards row">
                            <? foreach ($tabItem['sites'] as $site) {
                                get_template_part('template-parts/items/common', '2', $site);
                            } ?>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        <? endif ?>

    </div>
</section>
