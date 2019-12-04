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
        die("OK");
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
            $files = glob($this->folder . "/*" . $token . "*");
            if (count($files) == 0) {
                die("Nie znaleziono pliku!");
            }
            $plik = $files[0];
            /* if ($this->isImage($plik)) {
                $imgData = file_get_contents($plik);
                return base64_encode($imgData);
            } else {*/
            return $plik;
            // }
        } else {
            die("Zły token!");
        }
    }

    /*  private function isImage($path)
    {
        $a = getimagesize($path);
        $image_type = $a[2];

        if (in_array($image_type, array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_BMP))) {
            return true;
        }
        return false;
    }*/
}
?>
<?php
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
}
?>
<!doctype html>
<html lang="en">

<head>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <link href="branding/styl.css" rel="stylesheet">

    <?php if (isset($_GET['nw']) && isset($_GET['k'])) : ?>
        <?php
            // Mamy wzorzec i klucz
            $nw = $_GET['nw'];
            $k = $_GET['k'];
            if (empty($nw)) {
                die("Brak wzorca!");
            }
            $ps = new PatternSaver();
            $ps->savePattern($nw, $k); ?>
    <?php elseif (isset($_GET['t'])) : ?>
        <?php   //Mamy token
            $token = $_GET['t'];
            $file = (new PatternMatcher())->MatchFile($token);
            ?>
        <Title>Plik dla <?= $token; ?></title>
</head>
<?php include("branding/header.php"); ?>
<a class="media" href="<?= $file ?>"></a>
<a class="btn btn-lg btn-primary btn-success" type="button" id="button-pobierz" href="<?= $file ?>" download>Pobierz</a>
</div>

<script type="text/javascript" src="branding/jquery.media.js"></script>
<script type="text/javascript" src="branding/jquery.metadata.js"></script>
<script type="text/javascript">
    $(function() {
        $('a.media').media({
            width: 'auto',
            height: 'auto',
            attrs: {
                autoplay: "",
                controls: "",
                loop: ""
            }
        });
    });
</script>
<?php else : ?>
    <Title>Podaj Token</title>
    </head>
    <?php include("branding/header.php"); ?>

    <form class="form-signin" id="podaj-token">

        <h1 class="h2 mb-4 font-weight-normal">Podaj Token</h1>
        <label for="t" class="sr-only">Password</label>
        <input type="text" id="t" name="t" class="form-control" placeholder="Token" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit" id="button-token">Wejdź</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2019 </p>
    </form>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#podaj-token").on('submit', function(e) {
                e.preventDefault();
                var token = $("input#t").val();
                var actionurl = e.currentTarget.action;
                $.ajax({
                    method: "POST",
                    url: actionurl,
                    data: {
                        vt: token
                    },
                    beforeSend: function(f) {

                        $("#button-token")
                            .addClass("btn-warning")
                            .removeClass("btn-primary btn-success btn-danger")
                            .html("Weryfikacja...");
                    }
                }).done(function(resp) {
                    if (resp == "OK") {
                        $("#button-token").addClass("btn-success").removeClass("btn-warning")
                            .html("OK");
                        setTimeout(function() {
                            var cleanUrl = actionurl.replace(/#.*$/, '').replace(/\?.*$/, '');
                            cleanUrl += "?t=" + token;
                            window.location.href = cleanUrl;
                        }, 1000);
                    } else {
                        $("#button-token").addClass("btn-danger").removeClass("btn-warning")
                            .html("Zły Token!");
                        setTimeout(function() {
                            $("#button-token").html("Wejdź").addClass("btn-primary").removeClass("btn-danger");
                        }, 2000);


                    }
                });
            });
        });
    </script>
    </body>
<?php endif; ?>

</body>

</html>