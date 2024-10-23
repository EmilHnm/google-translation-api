<?php

require 'vendor/autoload.php';

use EmilHnm\GoogleTranslationApi\GoogleTrans;
use EmilHnm\GoogleTranslationApi\Models\Options;

$trans = new GoogleTrans();

try {
    $result = $trans->translate('異次元', new Options(from: 'auto', to: 'en'));
    echo $result->text;
} catch (Exception $e) {
    echo $e->getMessage();
}