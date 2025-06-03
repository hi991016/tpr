    <?php if (!is_singular('artwork')) : ?>
    <!-- @footer -->
    <footer class="c-footer">
        <div class="c-footer__container">
            <div class="c-footer__wrapper l-wrapper">
                <div class="c-footer__left">
                    <div class="c-footer__col">
                        <p class="c-footer__title">mailnews</p>
                        <p class="c-footer__subscribe" id="subscribeBtn">
                            subscribe <span>→</span>
                        </p>
                    </div>
                    <div class="c-footer__col">
                        <p class="c-footer__title">social</p>
                        <div class="c-footer__social">
                            <a href="https://www.instagram.com/tokyophotographicresearch/" aria-label="INSTAGRAM"
                                target="_blank">instagram</a>
                            <a href="https://twitter.com/tpr2020news" aria-label="TWITTER" target="_blank">twitter</a>
                            <a href="https://note.com/tpr/" aria-label="NOTE" target="_blank">note</a>
                        </div>
                    </div>
                    <div class="c-footer__col">
                        <p class="c-footer__title">contact</p>
                        <a href="mailto:info@tokyophotographicresearch.jp" class="c-footer__mail"
                            aria-label="MAIL">info@tokyophotographicresearch.jp</a>
                    </div>
                </div>
                <div class="c-footer__right">
                    <p class="c-footer__copyright">©︎ TOKYO PHOTOGRAPHIC RESEARCH PROJECT</p>
                </div>
            </div>
        </div>
    </footer>
    <!-- @@footer -->
    <?php endif; ?>

    <!--JB Tracker-->
    <!-- <script
        type="text/javascript"> var _paq = _paq || []; 
        (function () { if (window.apScriptInserted) return; _paq.push(['clientToken', 'P%2bsIjEMd6oQ%3d']); 
        var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0]; 
        g.type = 'text/javascript'; g.async = true; g.defer = true; g.src = 'https://prod.benchmarkemail.com/tracker.bundle.js'; 
        s.parentNode.insertBefore(g, s); window.apScriptInserted = true; })();
    </script> -->
    <!--/JB Tracker--> 
    <!-- BEGIN: Benchmark Email Signup Form Code -->
    <!-- <script type="text/javascript" id="lbscript1747194"
        src="https://lb.benchmarkemail.com//code/lbformnew.js?mFcQnoBFKMS0koHGGsvfIajgVtVj7bhtd9wS1TyiNsgxqq5MaycgMMj9ybR%252Bnt%252Fk"></script>
    <noscript>Please enable JavaScript <br /></noscript> -->
    <!-- END: Benchmark Email Signup Form Code -->

    <!-- @script -->
    <script src="<?= get_template_directory_uri() ?>/assets/js/libs.js"></script>
    <script src="<?= get_template_directory_uri() ?>/assets/js/jb.tracker.js"></script>
    <script src="<?= get_template_directory_uri() ?>/assets/js/main.js"></script>

    <?php wp_footer(); ?>
</body>

</html>