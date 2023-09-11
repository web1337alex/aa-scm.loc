<?php

add_action( 'wp_ajax_ajax_form_action', 'ajax_action_callback' );
add_action( 'wp_ajax_nopriv_ajax_form_action', 'ajax_action_callback' );

function ajax_action_callback() {

    $formSettings = get_field('form_settings', 'options');

    $errors = [];
    if(!wp_verify_nonce($_POST['nonce'], 'ajax-form-nonce')){
        $errors['incorrect'] = $formSettings['messages']['invalid_nonce'];
    }

    if($_POST['honeypot'] == true){
        $errors['spam'] = $formSettings['messages']['spam'];
    }
    $message = "";
    foreach($_POST as $key => $value){
        if($key == 'action' || $key == 'nonce' || strpos($key, 'privacybox') === true){
            break;
        }
        else{
            $value = sanitize_text_field($value);
            if($value == null){
                $errors['empty'] = $formSettings['messages']['empty_fields'];
            }
            else{
                if($value == 'on'){
                    break;
                }
                if(strpos($key, '_key') == true){
                    $message .= "<b>{$value}: </b>";
                } else {
                    $message .= "{$value}<br>";
                }
            }

        }
    }

    if(!empty($errors)){
        wp_send_json_error($errors);
    }
    else{
        $home_url = wp_parse_url(home_url());
        $subject = 'Заявка «Мастера маркетинга»';
		$email_from = get_option('admin_email');
        $headers = 'From: ' . $home_url['host'] . ' <' . $email_from . '>' . "\r\n" . 'Reply-To: ' . $email_from;

        $mails = "";
        foreach($formSettings['emails'] as $iKeyMail => $email){
            $mails .= $email['email'];
            if(($iKeyMail + 1) != count($formSettings['emails'])){
                $mails .= ', ';
            }
        }
        wp_mail($mails, $subject, $message, $headers);
        wp_send_json_success($formSettings['messages']['success']);
    }

    wp_die();
}

?>