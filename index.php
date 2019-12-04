<?php

/**
 * Bazowe klaski
 * 
 */
class PatternSaver
{
    private $secret = 'G2C3xDxw';

    function savePattern($pattern, $key)
    {
        if ($key != $this->secret) {
            die("Zły klucz!");
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
    function __construct()
    {
        $this->pattern = $this->loadPattern();
    }

    private function loadPattern()
    {
        $patternFile = fopen("pattern", "r") or die("Brak dostępu do pliku wzorca! Sprawdź CHMOD'a.");
        return fread($patternFile, filesize($patternFile));
    }

    public function MatchFile($token)
    { }
}

/** GET
 * 
 * Ogarniamy generowanie tokenu lub wyświetlanie zdjęcia
 */
if (isset($_GET['nw']) && isset($_GET['k'])) {
    // Mamy wzorzec i klucz
    $nw = $_GET['nw'];
    $k = $_GET['k'];
    if (empty($nw)) {
        die("Brak wzorca!");
    }
    $ps = new PatternSaver();
    $ps->savePattern($nw, $k);
} else if (isset($GET['t'])) {
    //Mamy token


} else {
    // Nie ma tokena, strona logowania
}
