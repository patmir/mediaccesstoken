    <div class="container d-flex flex-column justify-content-center align-content-center">
        <a class="media-display justify-content-center d-flex flex-row" href="<?= $file ?>"></a>
    </div>
    <footer class="text-center d-flex flex-row justify-content-center align-content-center">
        <p class="mt-5 mb-3 font-weight-bold"><?= $tekstWStopce ?></p>
    </footer>
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