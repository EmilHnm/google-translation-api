<?php
namespace EmilHnm\GoogleTranslationApi\Models;

class Options {

    public function __construct(
        public string | null $from = null,
        public string | null $to = null,
        public string | null $tld = null,
        public string | null $client = null,
    )
    {
        
    }
}