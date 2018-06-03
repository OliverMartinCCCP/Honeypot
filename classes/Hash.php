<?php

class Hash {
    public static function make($string, $salt = ''){
        return hash('sha256', $string . $salt);

    }

    public static function salt($length){
        var_dump(
            utf8_encode ( mcrypt_create_iv($length) ));
        return utf8_encode(mcrypt_create_iv($length));
    }

    public static function unique(){
        return self::make(uniqid());
    }
}