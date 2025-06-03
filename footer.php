    <?php if (!is_singular('artwork')) : ?>
        <?php require __DIR__ . '/components/footer.php' ?>
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