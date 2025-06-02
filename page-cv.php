<?php get_header(); ?>
    
    <?php 
        $locale = get_locale();
        $cv = get_field('cv_field', $locale == "en_US" ? 1002 : 1005);
    ?>

    <!-- @main -->
    <main>
        <!-- @section cv -->
        <section class="p-about cv">
            <div class="p-about__container">
                <div class="p-about__wrapper l-wrapper">
                    <div class="p-about__list">
                        
                        <?php 
                            if (!empty($cv)) :
                                foreach ($cv as $key => $value) :
                        ?>

                            <?php 
                                $title = $value["title"];
                                $text = $value["text"];
                            ?>        

                        <div class="p-about__items">
                            <div class="p-about__title">
                                <h2><?= $title ?></h2>
                            </div>

                            <div class="p-about__content">
                                <?= $text ?>
                            </div>
                        </div>

                        <?php 
                                endforeach;
                            endif;
                        ?> 

                    </div>
                </div>
            </div>
        </section>
        <!-- @@section cv -->
    </main>
    <!-- @@main -->

<?php get_footer(); ?>