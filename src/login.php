<div class="row justify-content-center">
    <div class="col">
        <form class="form-signin" id="podaj-token">

            <h1 class="h2 mb-4 font-weight-normal"><?= $polecenieLogowania; ?></h1>
            <label for="t" class="sr-only">Token</label>
            <input type="text" id="t" name="t" class="form-control" placeholder="Token" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit" id="button-token"><?= $przyciskLogowania; ?></button>
        </form>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col">
        <p class="mt-5 mb-3 font-weight-bold"><?= $tekstWStopce ?></p>
    </div>
</div>
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