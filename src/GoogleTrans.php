<?php

namespace EmilHnm\GoogleTranslationApi;

use Error;
use Symfony\Component\HttpClient\HttpClient;
use EmilHnm\GoogleTranslationApi\Models\Result;
use EmilHnm\GoogleTranslationApi\Models\Options;
use EmilHnm\GoogleTranslationApi\Models\Detected;

class GoogleTrans
{


    private function request(string | array $text, Options | null $otps = null)
    {
        $_opts = $otps ?? new Options();
        $_text = $text;
        $e = new Error();

        $fromTo = [$_opts->from, $_opts->to];

        foreach ($fromTo as $lang) {
            if ($lang && !Languages::isSupported($lang)) {
                $e = new \Exception("The language 「{$lang}」is not supported!");
                throw $e;
            }
        }

        if (is_array($_text)) {
            $str = "";
            for ($i = 0; $i < count($_text); $i++) {
                $t = $_text[$i];
                if (strlen($t) === 0 && $i === 0) {
                    $e = new \Exception("The first element of the text array is an empty string");
                    throw $e;
                } else {
                    $str .= $t . "\n";
                }
            }
            $_text = $str;
        }

        if (strlen($_text) === 0) {
            $e = new \Exception("The text is an empty string");
            throw $e;
        }

        if (strlen($_text) > 15000) {
            $e = new \Exception("The text is over the maximum character limit ( 15k )!");
            throw $e;
        }

        $_opts->from = $_opts->from ?? 'auto';
        $_opts->to = $_opts->to ?: 'en';
        $_opts->tld = $_opts->tld ?? 'com';
        $_opts->client = $_opts->client ?? 't';

        $_opts->from = Languages::getCode($_opts->from);
        $_opts->to = Languages::getCode($_opts->to);

        $url = "https://translate.google.{$_opts->tld}/translate_a/single";

        $token = (new GoogleToken)->getToken($_text);

        $params = [
            'client' => $_opts->client,
            'sl' => $_opts->from,
            'tl' => $_opts->to,
            'hl' => 'en',
            'dt' => ["at", "bd", "ex", "ld", "md", "qca", "rw", "rm", "ss", "t"],
            'ie' => 'UTF-8',
            'oe' => 'UTF-8',
            'otf' => 1,
            'ssel' => 0,
            'tsel' => 0,
            'kc' => 7,
            'q' => $_text,
            'tk' => $token,
        ];

        $headers = [
            'User-Agent' => Utils::getUserAgent(),
            // 'Accept-Encoding' => "gzip",
        ];


        $query = $this->buildParams($params);

        $res = HttpClient::create()->request('GET', "$url?$query", [
            'headers' => $headers,
        ]);

        return $res;
    }

    private function buildParams(array $params) {
        return preg_replace('/%5B\d+%5D(?==)/', '', http_build_query($params));
    }

    public function translate(string | array $text, Options | null $otps = null): Result
    {
        $res = $this->request($text, $otps);

        $result = new Result(
            text: "",
            textArray: [],
            resultPronunciation: "",
            sourcePronounciation: "",
            hasCorrectedLang: false,
            src: "",
            hasCorrectedText: false,
            correctedText: "",
            translations: [],
            raw: [],
        );

        if ($res->getStatusCode() !== 200) return $result;

        $body = json_decode($res->getContent());

        $result->raw = $body;

        foreach ($body[0] as $obj) {
            if (isset($obj[0])) {
                $result->text .= $obj[0];
            }
            if (isset($obj[2])) {
                $result->resultPronunciation .= $obj[2];
            }

            if(isset($obj[3])) {
                $result->sourcePronounciation .= $obj[3];
            }
        }
        

        if ($body[2] === $body[8][0][0]) {
            $result->src = $body[2];
        } else {
            $result->hasCorrectedLang = true;
            $result->src = $body[8][0][0];
        }

        if ($body[1] && $body[1][0][2]) $result->translations = $body[1][0][2];

        if (isset($body[7]) && isset($body[7][0])) {
            $str = $body[7][0];
            $str = str_replace('<b><i>', '[', $str);
            $str = str_replace('</i></b>', ']', $str);
            $result->correctedText = $str;

            if (isset($body[7][5])) {
                $result->hasCorrectedText = true;
            }
        }

        if (strpos($result->text, "\n") !== false) {
            $result->textArray = explode("\n", $result->text);
        } else {
            $result->textArray[] = $result->text;
        }

        return $result;
    }

}
