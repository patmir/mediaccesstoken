<div class="row justify-content-center mb-3">
    <div class="col">
        <a class="media-display img-fluid" href="<?= $file ?>"></a>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col">
        <a class="btn btn-lg btn-primary btn-success" type="button" id="button-pobierz" href="<?= $file ?>" download><?= $przyciskPobierz; ?></a>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col">
        <p class="mt-5 mb-3 font-weight-bold"><?= $tekstWStopce ?></p>
    </div>
</div>
</div>
<script type="text/javascript" src="src/jquery.media.js"></script>
<script type="text/javascript" src="src/jquery.metadata.js"></script>
<script type="text/javascript">
    $(function() {
        $('a.media-display').media({
            width: 'auto',
            height: 'auto',
            bgColor: 'none',
            attrs: {
                autoplay: "",
                controls: "",
                loop: ""
            }
        });
    });
</script>