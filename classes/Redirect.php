

<?php
class Redirect {
    public static function to($location = null) {
        if($location) {
            if(is_numeric($location)) {
                switch ($location) {
                    case 404:
                        header('HTTP/1.0 404 Not Found');
                        include_once '../header.php';
                        include 'includes/errors/404.php';
                        include_once '../footer.php';
                        exit();
                    break;
                }
            }
            header('Location: ' . $location);
            exit();
        }
    }
}