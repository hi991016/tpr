<?php get_header(); ?>
    
    <?php 
        $locale = get_locale();
        $about = get_field('about_field', $locale == "en_US" ? 151 : 104);
    ?>

    <!-- @main -->
    <main>
        <!-- @section about -->
        <section class="p-about">
            <div class="p-about__container">
                <div class="p-about__wrapper l-wrapper">
                    <div class="p-about__list">
                        
                        <?php 
                            if (!empty($about)) :
                                foreach ($about as $key => $value) :
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
        <!-- @@section about -->
    </main>
    <!-- @@main -->

<?php get_footer(); ?>