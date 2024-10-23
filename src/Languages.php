<?php
namespace EmilHnm\GoogleTranslationApi;

class Languages {
    const LANGS = [
        "auto" => "Automatic",
        "af" => "Afrikaans",
        "sq" => "Albanian",
        "am" => "Amharic",
        "ar" => "Arabic",
        "hy" => "Armenian",
        "az" => "Azerbaijani",
        "eu" => "Basque",
        "be" => "Belarusian",
        "bn" => "Bengali",
        "bs" => "Bosnian",
        "bg" => "Bulgarian",
        "ca" => "Catalan",
        "ceb" => "Cebuano",
        "ny" => "Chichewa",
        "zh" => "Chinese (Simplified)",
        "zh-cn" => "Chinese (Simplified)",
        "zh-sg" => "Chinese (Simplified)",
        "zh-tw" => "Chinese (Traditional)",
        "zh-hk" => "Chinese (Traditional)",
        "co" => "Corsican",
        "hr" => "Croatian",
        "cs" => "Czech",
        "da" => "Danish",
        "nl" => "Dutch",
        "en" => "English",
        "eo" => "Esperanto",
        "et" => "Estonian",
        "tl" => "Filipino",
        "fi" => "Finnish",
        "fr" => "French",
        "fy" => "Frisian",
        "gl" => "Galician",
        "ka" => "Georgian",
        "de" => "German",
        "el" => "Greek",
        "gu" => "Gujarati",
        "ht" => "Haitian Creole",
        "ha" => "Hausa",
        "haw" => "Hawaiian",
        "he" => "Hebrew",
        "iw" => "Hebrew",
        "hi" => "Hindi",
        "hmn" => "Hmong",
        "hu" => "Hungarian",
        "is" => "Icelandic",
        "ig" => "Igbo",
        "id" => "Indonesian",
        "ga" => "Irish",
        "it" => "Italian",
        "ja" => "Japanese",
        "jw" => "Javanese",
        "kn" => "Kannada",
        "kk" => "Kazakh",
        "km" => "Khmer",
        "ko" => "Korean",
        "ku" => "Kurdish (Kurmanji)",
        "ky" => "Kyrgyz",
        "lo" => "Lao",
        "la" => "Latin",
        "lv" => "Latvian",
        "lt" => "Lithuanian",
        "lb" => "Luxembourgish",
        "mk" => "Macedonian",
        "mg" => "Malagasy",
        "ms" => "Malay",
        "ml" => "Malayalam",
        "mt" => "Maltese",
        "mi" => "Maori",
        "mr" => "Marathi",
        "mn" => "Mongolian",
        "my" => "Myanmar (Burmese)",
        "ne" => "Nepali",
        "no" => "Norwegian",
        "ps" => "Pashto",
        "fa" => "Persian",
        "pl" => "Polish",
        "pt" => "Portuguese",
        "pa" => "Punjabi",
        "ro" => "Romanian",
        "ru" => "Russian",
        "sm" => "Samoan",
        "gd" => "Scots Gaelic",
        "sr" => "Serbian",
        "st" => "Sesotho",
        "sn" => "Shona",
        "sd" => "Sindhi",
        "si" => "Sinhala",
        "sk" => "Slovak",
        "sl" => "Slovenian",
        "so" => "Somali",
        "es" => "Spanish",
        "su" => "Sundanese",
        "sw" => "Swahili",
        "sv" => "Swedish",
        "tg" => "Tajik",
        "ta" => "Tamil",
        "te" => "Telugu",
        "th" => "Thai",
        "tr" => "Turkish",
        "uk" => "Ukrainian",
        "ur" => "Urdu",
        "uz" => "Uzbek",
        "vi" => "Vietnamese",
        "cy" => "Welsh",
        "xh" => "Xhosa",
        "yi" => "Yiddish",
        "yo" => "Yoruba",
        "zu" => "Zulu",
        "fil" => "Filipino",
    ];

    static function getCode(string $desiredLang): string {
        $unSupported = "UNSUPPORTED";
        $lowerLanguage = strtolower($desiredLang);

        $langs = self::LANGS;
        // Check if the language code exists
        if (isset($langs[$lowerLanguage])) {
            return $lowerLanguage;
        }
    
        // Find a match where the value matches the desired language
        $keys = array_filter(array_keys($langs), function($key) use ($langs, $lowerLanguage) {
            return strtolower($langs[$key]) === $lowerLanguage;
        });
    
        // Return the matching language code or "UNSUPPORTED" if not found
        if (empty($keys)) {
            return $unSupported;
        }
    
        return reset($keys);
    }

    public static function isSupported(string $desiredLang): bool {
        $code = self::getCode($desiredLang);
        if(empty($code) || $code === "UNSUPPORTED") {
            return false;
        }
        return true;
    }
    
}

