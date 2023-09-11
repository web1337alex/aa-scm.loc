<?php
global $CoreTheme;
$headerMenu = $CoreTheme::getMenu('headerMenu');
?>
<header class="header-4">
    <div class="header">
        <div class="container">
            <div class="row">
                <div class="col-1 col-xs-3 col-md-3 header__burger">
                    <span class="header__icon"></span>
                </div>
                <div class="col-3 col-xs-6 col-md-3 col-lg-6 header__logo">
                    <a href="<?= get_site_url() ?>" class="header__logoLink">
                        <?= wp_get_attachment_image($args['logo'], 'large') ?>
                    </a>
                </div>
                <div class="col-5 col-lg-7 header__menu">
                    <nav class="header__nav">
                        <div class="header__placeholder">
                            <div class="container">
                                <div class="row">
                                    <div class="col-xs-3 col-md-3 header__placeholder__block"></div>
                                </div>
                            </div>
                        </div>
                        <ul>
                            <? foreach ($headerMenu as $menuItem): ?>
                                <? if ($menuItem->level_menu == 1): ?>
                                    <li><a href="<?= $menuItem->url ?>"><?= $menuItem->title ?></a></li>
                                <? endif ?>
                            <? endforeach ?>
                        </ul>
                    </nav>
                </div>
                <div class="col-2">
                    <div class="header_address">
                        <p>г. Тюмень, улица Максима Горького 44.</p>
                    </div>
                </div>
                <div class="col-2 col-md-8 col-lg-2 header__phone">
                    <div class="header__contacts">
                        <a class="header__tel" href="tel:<?= $CoreTheme::$settings['clean_phone'] ?>"><?= $CoreTheme::$settings['phone'] ?></a>
                        <a class="button header__button" href="<?= $args['link']['url'] ?>"><?= $args['link']['text'] ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>