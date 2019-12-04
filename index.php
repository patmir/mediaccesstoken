<?php

/**
 * Mechanizm udostępniania plików po tokenie
 * @Author: Patryk Mirosław
 * @Email: miroslaw.patyk@gmail.com
 * @URL: https://github.com/patmir/patternimage
 * @License: UNLICENSE
 * 
 * This is free and unencumbered software released into the public domain.
 *
 * Anyone is free to copy, modify, publish, use, compile, sell, or
 * distribute this software, either in source code form or as a compiled
 * binary, for any purpose, commercial or non-commercial, and by any
 * means.
 * 
 * In jurisdictions that recognize copyright laws, the author or authors
 * of this software dedicate any and all copyright interest in the
 * software to the public domain. We make this dedication for the benefit
 * of the public at large and to the detriment of our heirs and
 * successors. We intend this dedication to be an overt act of
 * relinquishment in perpetuity of all present and future rights to this
 * software under copyright law.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS BE LIABLE FOR ANY CLAIM, DAMAGES OR
 * OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
 * ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 * 
 * For more information, please refer to <https://unlicense.org>
 */
class PatternSaver
{
    private $secret = 'G2C3xDxw';


    // ^(.*[A-Z]{3})(.*[_$\-+=!@]{1})(.*\d{5})$
    function savePattern($pattern, $key)
    {
        if ($key != $this->secret) {
            die("Zły klucz!");
        }
        if (strlen($pattern) < 5) {
            die("Zbyt krótki wzorzecz (min. 5 znaków)");
        }
        if (preg_match('/[^LSC]/', $key)) {
            die("Zły format wzorca. Dopuszczalne litery to: L, S, C");
        }
        $patternFile = fopen("pattern", "w") or die("Brak dostępu do pliku wzorca! Sprawdź CHMOD'a.");
        fwrite($patternFile, $pattern);
        fclose($patternFile);
        print("OK");
    }
}
class PatternMatcher
{
    private $pattern;
    private $regex;
    private $folder = "pliki";
    private $rf_Litera = "(.*[A-Z]{%d})";
    private $rf_Symbol = "(.*[_$\-+=!@]{%d})";
    private $rf_Cyfra = "(.*\d{%d})";
    function __construct()
    {
        $this->pattern = $this->loadPattern();
        $this->regex = $this->prepareRegex();
    }
    private function prepareRegex()
    {
        $regex = "/^";
        $prevChar = null;
        $prevCount = 0;
        foreach (str_split($this->pattern) as $PC) {
            if ($prevChar == null or $prevChar == $PC) {
                $prevChar = $PC;
                $prevCount++;
            } else {

                $regexForSprint = $this->rf_Litera;
                if ($prevChar === "C") {
                    $regexForSprint = $this->rf_Cyfra;
                } else if ($prevChar === "S") {
                    $regexForSprint = $this->rf_Symbol;
                }
                $regex .= sprintf($regexForSprint, $prevCount > 0 ? $prevCount : 1);
                $prevCount = 1;
                $prevChar = $PC;
            }
        }
        if ($prevCount > 0) {
            $regexForSprint = $this->rf_Litera;
            if ($prevChar === "C") {
                $regexForSprint = $this->rf_Cyfra;
            } else if ($prevChar == "S") {
                $regexForSprint = $this->rf_Symbol;
            }

            $regex .= sprintf($regexForSprint, $prevCount);
        }

        $regex .= "$/";
        return $regex;
    }
    private function loadPattern()
    {
        $patternFile = fopen("pattern", "r") or die("Brak dostępu do pliku wzorca! Sprawdź CHMOD'a.");
        return fread($patternFile, filesize("pattern"));
    }
    public function VerifyToken($token)
    {
        return preg_match($this->regex, $token);
    }
    public function MatchFile($token)
    {
        if ($this->VerifyToken($token) === 1) {
            // Token jest ok, szukamy pliku

        } else {
            die("Zły token!");
        }
    }
}

/** GET
 * 
 * Ogarniamy generowanie tokenu lub wyświetlanie zdjęcia
 */
if (isset($_POST['vt'])) {
    $res = (new PatternMatcher())->VerifyToken($_POST['vt']);

    if ($res !== 1) {
        die("Błędny token!");
    } else {
        echo "OK";
        die();
    }
}
if (isset($_GET['nw']) && isset($_GET['k'])) {
    // Mamy wzorzec i klucz
    $nw = $_GET['nw'];
    $k = $_GET['k'];
    if (empty($nw)) {
        die("Brak wzorca!");
    }
    $ps = new PatternSaver();
    $ps->savePattern($nw, $k);
} else if (isset($_GET['t'])) {
    //Mamy token
    $token = $_GET['t'];
    $image = (new PatternMatcher())->MatchFile($token);
} else {
    // Nie ma tokena, strona logowania
    print("Strona logowania");
}
