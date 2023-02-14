<?php

class PHPUnit {
    public static function assertTrue($assert1, $assert2, $message){
        $assert = $assert1 === $assert2;
        if (!$assert) {
            log_message('debug', '##################### PHP Unit ############################');
            log_message('debug', 'PHPUnit::MESSAGE(' . $message . ') ERROR: ' . $assert1 . ' X ' . $assert2);
            log_message('debug', '##################### PHP Unit ############################');
        }
    }
}