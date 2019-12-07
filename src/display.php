<a class="media" href="<?= $file ?>"></a>
<a class="btn btn-lg btn-primary btn-success" type="button" id="button-pobierz" href="<?= $file ?>" download><?= $przyciskPobierz; ?></a>
</div>

<script type="text/javascript" src="src/jquery.media.js"></script>
<script type="text/javascript" src="src/jquery.metadata.js"></script>
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