<?php

namespace EmilHnm\GoogleTranslationApi;

class GoogleToken
{
    private function TL($a) {
        $b = 406644;
        $b1 = 3293161072;
    
        $jd = ".";
        $bStr = "+-a^+6";
        $Zb = "+-3^+b+-f";
    
        $e = [];
        $f = 0;
        $g = 0;
        // Convert string to array of integers (UTF-8 encoding logic)
        while ($g < mb_strlen($a, 'UTF-8')) {
            $m = Utils::JS_charCodeAt(mb_substr($a,$g, 1, 'UTF-8'));
            if ($m < 128) {
                $e[$f++] = $m;
            } else {
                if ($m < 2048) {
                    $e[$f++] = ($m >> 6) | 192;
                } else {
                    if (55296 == ($m & 64512) && $g + 1 < mb_strlen($a, 'UTF-8') && 56320 == (ord($a[$g + 1]) & 64512)) {
                        $m = 65536 + (($m & 1023) << 10) + (ord($a[++$g]) & 1023);
                        $e[$f++] = ($m >> 18) | 240;
                        $e[$f++] = (($m >> 12) & 63) | 128;
                    } else {
                        $e[$f++] = ($m >> 12) | 224;
                        $e[$f++] = (($m >> 6) & 63) | 128;
                    }
                }
                $e[$f++] = ($m & 63) | 128;
            }
            $g++;
        }
    
        // Perform the transformation with RL function
        $c = $b;
        foreach ($e as $value) {
            $c += $value;
            $c = $this->RL($c, $bStr);
        }
        $c = $this->RL($c, $Zb);
        $c ^= $b1;
    
        if ($c < 0) {
            $c = ($c & 2147483647) + 2147483648;
        }
        $c %= 1e6;
        return $c . $jd . ($c ^ $b);
    }

    private function charCodeAt(string $string) {
        list(, $ord) = unpack('N', mb_convert_encoding($string, 'UCS-4BE', 'UTF-8'));
        return $ord;
    }

    private function RL( $a,  $b) {
        $t = "a";
        $Yb = "+";
        for ($c = 0; $c < strlen($b) - 2; $c += 3) {
            $d = $b[$c + 2];
            $e = $d >= $t ? ord($d[0]) - 87 : (int)$d;
            $f = $b[$c + 1] == $Yb ? $a >> $e : $a << $e;
            $a = $b[$c] == $Yb ? $a + $f & 4294967295 : $a ^ $f;
        }
        return $a;
    }

    public function getToken(string $text) {
        return $this->TL($text);
    }
}