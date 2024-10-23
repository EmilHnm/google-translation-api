<?php 

namespace EmilHnm\GoogleTranslationApi\Models;

class Result {
    public function __construct(
        public string $text,
        public array $textArray,
        public string $resultPronunciation,
        public string $sourcePronounciation,
        public bool $hasCorrectedLang,
        public string $src,
        public bool $hasCorrectedText,
        public string $correctedText,
        public array $translations,
        public array $raw,
    )
    {
        
    }
}