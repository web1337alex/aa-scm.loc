<?php
global $CoreTheme;
/** @var array $args */
$formID = $args['id'];
$form = get_field('form_settings', 'options')['forms'][$formID];
if(empty($form) || $form == false):?>
    <p class="msg error">Форма с указанным ID не заполнена или не существует</p>
<?else: ?>
    <form id="sc-form-<?=$formID?>" name="sc-form-<?=$formID?>" class="sc-form form <?=$form['colortext']?>">
        <div class="form__inner" style="background-color: <?=$CoreTheme::returnColor($form['color_bg'])?>;">
            <div class="form__row row">
                <?=$CoreTheme::constructTitle($form['title'])?>
            </div>
            <div class="form__row row">
                <div class="form__text"><?=$form['text']?></div>
            </div>
            <?if(!empty($form['fields'])):?>
                <div class="form__row row">
                    <?foreach($form['fields'] as $ikeyField => $itemField):?>
                        <div class="inputbox <?=$itemField['type']?>">
                            <input type="hidden" name="<?=$itemField['name']?>_key" value="<?=$itemField['placeholder']?>">
                            <?if($itemField['type'] == 'text' || $itemField['type'] == 'tel' || $itemField['type'] == 'email'):?>
                                <input type="<?=$itemField['type']?>" name="<?=$itemField['name']?>" placeholder="<?=$itemField['placeholder']?>">
                            <?elseif($itemField['type'] == 'checkbox'):?>
                                <input type="<?=$itemField['type']?>" name="<?=$itemField['name']?>" id="field_<?=$iKeySlide?>_<?=$ikeyField?>_<?=$itemField['name']?>">
                                <label for="field_<?=$iKeySlide?>_<?=$ikeyField?>_<?=$itemField['name']?>"><span class="toggle"></span><?=$itemField['placeholder']?></label>
                            <?endif?>
                        </div>
                    <?endforeach;?>
                </div>
            <?endif;?>
            <?if($form['privacy'] === true):?>
                <div class="form_row row">
                    <div class="inputbox privacy">
                        <input type="checkbox" id="privacybox<?=$formID?>" name="privacybox<?=$formID?>" class="privacybox__input">
                        <label for="privacybox<?=$formID?>"><span class="checkbox"></span>Я даю согласие на обработку своих персональных данных</label>
                    </div>
                </div>
            <?endif?>
            <div class="form_row row">
                <div class="inputbox submit">
                    <input type="submit" class="button button-submit" value="<?=$form['submit_text']?>" style="background-color: <?=$CoreTheme::returnColor($form['submit_color']['color_list'])?>;">
                    <input type="checkbox" name="honeypot" class="honeypot">
                </div>
            </div>
        </div>
    </form>
<?endif?>
