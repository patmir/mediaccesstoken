<div class="container d-flex flex-column py-2 align-content-center text-center">
    <form class="form-signin d-flex flex-column py-2 align-content-center" id="podaj-token">

        <h1 class="h2 py-2 d-block font-weight-normal"><?= $polecenieLogowania; ?></h1>
        <label for="t" class="sr-only">Token</label>
        <input type="text" id="t" name="t" class="form-control my-2 d-block " placeholder="Token" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit" id="button-token"><?= $przyciskLogowania; ?></button>
    </form>
</div>
<footer class="text-center d-flex flex-row justify-content-center align-content-center">
    <p class="mt-5 mb-3 font-weight-bold"><?= $tekstWStopce ?></p>
</footer>
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
                        .html("<?= $przyciskLogowaniaWeryfikacja; ?>");
                }
            }).done(function(resp) {
                if (resp == "OK") {
                    $("#button-token").addClass("btn-success").removeClass("btn-warning")
                        .html("<?= $przyciskLogowaniaOk; ?>");
                    setTimeout(function() {
                        var cleanUrl = actionurl.replace(/#.*$/, '').replace(/\?.*$/, '');
                        cleanUrl += "?t=" + token;
                        window.location.href = cleanUrl;
                    }, 1000);
                } else {
                    $("#button-token").addClass("btn-danger").removeClass("btn-warning")
                        .html("<?= $przyciskLogowaniaZlyToken; ?>");
                    setTimeout(function() {
                        $("#button-token").html("Wejdź").addClass("btn-primary").removeClass("btn-danger");
                    }, 2000);


                }
            });
        });
    });
</script>