<?php
    function getCleanPhone($phone){
        if(!is_array($phone)){
            return str_replace(["-", " ", "(", ")"], "", $phone);
        }
        else{
            $phones = [];
            foreach ($phone as $key => $p){
                $phones[$key] = str_replace(["-", " ", "(", ")"], "", $p);
            }
            return $phones;
        }
    }

    function getRgbaString($rgba){
        return "rgba(".$rgba['red'].", ".$rgba['green'].", ".$rgba['blue'].", ".$rgba['alpha'].")";
    }

    function getCleanPrice($price){
        $cleanPrice = preg_replace('/[^0-9]/', '', $price);
        $cleanPrice = strrev(chunk_split(strrev($cleanPrice), 3, ' '));
        $cleanPrice = trim($cleanPrice);
        return 'от '.$cleanPrice.' ₽';
    }

    function getImageType($ID){
        $imgData = wp_get_attachment_metadata($ID);
        return $imgData['sizes']['thumbnail']['mime-type'];
    }

    function debug($var, $array = true){
        echo "<pre>";
            if($array == true){
                print_r($var);
            } else {
                var_dump($var);
            }
        echo "</pre>";
    }

    function hexToRgb($hex, $alpha = false){
        $rgb = sscanf($hex, "#%02x%02x%02x");
        return $rgb;
    }

    function getYoutubeVideoID($url) {
        if(strripos($url, "youtube.com")) {
            parse_str(parse_url($url, PHP_URL_QUERY), $you);
            $youtube_id = $you["v"];
        }
        elseif(strripos($url, "youtu.be")) {
            $you_mass = explode("/", $url);
            $youtube_id = $you_mass[count($you_mass) - 1];
        }
        $youtube_id = explode("?", $youtube_id)[0];
        if(!empty($youtube_id)) return $youtube_id;
    }

    function getMenuItems($menuSlug){
        $locations = get_nav_menu_locations();
        if($locations && isset($locations[$menuSlug])){
            $menuItems = wp_get_nav_menu_items($locations[$menuSlug]);
            return $menuItems;
        }
    }

?>