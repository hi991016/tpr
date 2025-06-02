<?php get_header(); ?>

    <?php 
        $locale = get_locale();
        $people = get_field('people_field', $locale == "en_US" ? 148 : 106);

        // sort alphabet
        function cmp( $a, $b ) {
            if ( $a == $b ) return 0;
            elseif ( $a > $b ) return 1;
            elseif ( $a < $b ) return -1;
        }

        if (!empty($people)) {
            uasort( $people, 'cmp' );
        }
    ?>

    <!-- @main -->
    <main>
        <!-- @section people -->
        <section class="p-people">
            <div class="p-people__container">
                <div class="p-people__wrapper l-wrapper">
                    <div class="p-people__heading">
                        <h1>people</h1>
                    </div>

                    <div class="p-people__list" id="people-list">

                        <?php 
                            $group = array();

                            if (!empty($people)) {
                                $array = array_values($people);
                                foreach ( $array as $value ) {
                                    $group[$value['alphabet']][] = $value;
                                }
                                // var_dump($group);
                            }
                        ?>

                        <?php 
                            if (!empty($group)) :
                                foreach ($group as $key => $value) :
                        ?>
                        
                            <div class="p-people__items">
                                <div class="p-people__info">
                                    <div class="p-people__alphabet">
                                        <p><?= $value[0]["alphabet"] ?></p>
                                    </div>


                                    <div class="p-people__group">
                                        <?php 
                                            if (!empty($value)) :
                                                foreach ($value as $key => $val) :
                                        ?>
                                            <?php
                                                $en = $val["english_name"];
                                                $jp = $val["japanese_name"];
                                                $category = $val["job_category"];
                                                $images = $val["image"];
                                                $text = $val["text"];
                                            ?>

                                        <div class="p-people__accordion">
                                            <div class="p-people__title js-accordion">
                                                <p class="p-people__name en"><?= $en ?></p>
                                                <p class="p-people__name jp"><?= $jp ?></p>
                                                <p class="p-people__category"><?= $category ?></p>
                                            </div>

                                            <div class="p-people__panel">
                                                <div class="p-people__content">
                                                    <figure class="p-people__images">
                                                        <img src="<?= $images["url"] ?>" alt="<?= $en ?>">
                                                    </figure>

                                                    <div class="p-people__text">
                                                        <?= $text?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php 
                                                endforeach;
                                            endif;
                                        ?> 
                                    </div>
                                </div>
                            </div>

                        <?php 
                                endforeach;
                            endif;
                        ?> 
                    </div>
                </div>
        </section>
        <!-- @@section people -->
    </main>
    <!-- @@main -->

<?php get_footer(); ?>