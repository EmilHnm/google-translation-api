<?php
namespace EmilHnm\GoogleTranslationApi;

class Utils {

    static function getUserAgent(): string {
        $browser = UserAgents::BROWSER;
        $browserKeys = array_keys($browser);
        $browserNmb = rand(0, count($browserKeys) - 1);
        $browserKey = $browserKeys[$browserNmb];
        $userAgenLength = count($browser[$browserKey]) - 1;
        $userAgentNmb = rand(0, $userAgenLength);
        return $browser[$browserKey][$userAgentNmb];
    }
    
    static function JS_charCodeAt($char)
    {
        if(mb_strlen($char, 'UTF-8') !== 1) {
            throw new \Exception('The string must be a single character');
        }
        $converted = iconv('UTF-8', 'UTF-16LE', $char);

        for ($i = 0; $i < iconv_strlen($converted, 'UTF-16LE'); $i++) {
            $character = iconv_substr($converted, $i, 1, 'UTF-16LE');
            $codeUnits = unpack('v*', $character);
            return $codeUnits[1];
        }
    }
}
