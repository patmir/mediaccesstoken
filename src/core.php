<?php

class PatternSaver
{
    private $secret = 'G2C3xDxw';
    function __construct()
    {
        global $klucz;
        if (isset($klucz)) {
            $this->secret = $klucz;
        }
    }

    // ^(.*[A-Z]{3})(.*[_$\-+=!@]{1})(.*\d{5})$
    function savePattern($pattern, $key)
    {
        if ($key != $this->secret) {
            die("Zły klucz!");
        }
        if (strlen($pattern) < 4) {
            die("Zbyt krótki wzorzecz (min. 4 znaków)");
        }
        if (preg_match('/^[LSC]+$/', $key)) {
            die("Zły format wzorca. Dopuszczalne litery to: L, S, C");
        }
        $patternFile = fopen("custom/pattern", "w") or die("Brak dostępu do pliku wzorca! Sprawdź CHMOD'a.");
        fwrite($patternFile, $pattern);
        fclose($patternFile);
        die("OK");
    }
}
class PatternMatcher
{
    private $pattern;
    private $regex;
    private $folder = "pliki";
    private $rf_Litera = "(.*[a-zA-Z]{%d})";
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
        $patternFile = fopen("custom/pattern", "r") or die("Brak dostępu do pliku wzorca! Sprawdź CHMOD'a.");
        return fread($patternFile, filesize("custom/pattern"));
    }
    public function VerifyToken($token)
    {
        return preg_match($this->regex, $token);
    }
    public function MatchFile($token)
    {
        if ($this->VerifyToken($token) === 1) {
            // Token jest ok, szukamy pliku
            $files = glob($this->folder . "/*" . $token . "*");
            if (count($files) == 0) {
                return -2; // Brak pliku
            }
            $plik = $files[0];
            return $plik;
        } else {
            return -1; // Zły token
        }
    }
}
