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
include_once("config.php");
include_once("src/core.php");
$title = "Token";
$errorMessage = "";
/** POST
 * 
 * Ogarniamy generowanie tokenu lub wyświetlanie zdjęcia
 */
if (isset($_POST['vt'])) {
    $res = (new PatternMatcher())->VerifyToken($_POST['vt']);

    if ($res !== 1) {
        die("Błędny token!");
    } else {
        die("OK");
    }
} else if (isset($_GET['nw']) && isset($_GET['k'])) {
    // Mamy wzorzec i klucz
    $nw = $_GET['nw'];
    $k = $_GET['k'];
    if (empty($nw)) {
        die("Brak wzorca!");
    }
    $ps = new PatternSaver();
    $ps->savePattern($nw, $k);
}
// Będzie login lub display
$showError = false;
?>
<?php if (isset($_GET['t'])) {
    //Mamy token
    $token = $_GET['t'];
    $file = (new PatternMatcher())->MatchFile($token);
    if ($file < 0) {
        $showError = true;
        $errorMessage = $file == -1 ? $zlyToken : $brakPliku;
        // Mamy cyrk z tokenem, pokazujemy stronę logowania z błędem
        $title = $polecenieLogowania;
        include_once("src/header.php");
        include_once("src/login.php");
    } else {
        $title = "Plik dla " . $token;
        include_once("src/header.php");
        include_once("src/display.php");
    }
} else {
    $title = $polecenieLogowania;
    include_once("src/header.php");
    include_once("src/login.php");
} ?>
</body>

</html>