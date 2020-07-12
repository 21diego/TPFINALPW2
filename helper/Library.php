<?php


class Library {

    public static function randomizeName($type){
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return 'img-'.substr(str_shuffle($permitted_chars), 0, 20).$type;
    }

    public static function uploadImage($image, $source){

        if (isset($image) && $image['error'] === UPLOAD_ERR_OK) {
            $type = '.' . explode('/',$image['type'])[1];
            $name = self::randomizeName($type);
            $tmpname = $image['tmp_name'];

            if(move_uploaded_file($tmpname,$source.$name)){
                return $name;
            }
            else{
                throw new CannotMoveFileException("Can't move the file into the destiny folder");
            }
        }
        else{
            throw new Exception("The file's value not set");
        }
    }

    public static function getTodayArg(){
        $today = new DateTime("now");
        $today->setTimezone(new DateTimeZone("America/Argentina/Buenos_Aires"));
        return $today;
    }

    public static function deleteImage($source){
        return unlink($source);
    }

    /**
     * @return bool
     */
    public static function existeSesion() {
        return !empty($_SESSION);
    }
}