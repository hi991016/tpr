<?php
    get_header(); 
    $cate = !empty($_GET['cate']) ? $_GET['cate'] : 'all';
    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
?>

    <!-- @main -->
    <main>
        <!-- @section top -->
        <section class="p-top">
            <div class="p-top__container">
                <div class="p-top__wrapper l-wrapper">
                    <h1 class="p-top__heading">project</h1>

                    <?php
                        $projects_posts1 = array(
                            'post_type' => 'project',
                            'posts_per_page' => -1,
                            'meta_key'          => 'number',
                            'orderby'           => 'meta_value',
                            'order'             => 'DESC',
                        );

                        $projects_posts = new WP_Query( $projects_posts1 );
                    ?>

                    <div class="p-top__list">

                        <?php
                            if( $projects_posts->have_posts() ) :
                                $i =0;
                                    while( $projects_posts->have_posts() ) :
                                        $projects_posts->the_post();
                        ?>
                        
                        <div class="p-top__items">

                            <a href="<?php the_permalink(); ?>" class="p-top__content">
                                <?php
                                    $number = get_field('number', get_the_ID());
                                ?>
                                <p class="p-top__number"><?= $number; ?></p>
                                <p class="p-top__title"><?php the_title(); ?></p>
                                <div class="p-top__type">
                                    <?php 
                                        $terms1 = get_the_terms( get_the_ID(), 'project_categories' ); 
                                        if(!empty($terms1[0])):
                                    ?>
                                    <p class="p-top__category"><?= $terms1[0]->name; ?></p>
                                    <?php endif; ?>

                                    <?php
                                        $years = get_field('years', get_the_ID());
                                        $now = $years['is_now'];
                                        $year = $years['year'];

                                        if (!empty($now)) :
                                    ?>
                                    <p class="p-top__year is-now">NOW</p>
                                    <?php else : ?>
                                    <p class="p-top__year"><?= $year; ?></p>
                                    <?php endif; ?>
                                </div>
                            </a>

                            <?php
                                $thumbnail = wp_get_attachment_url(get_post_thumbnail_id($post->ID), 'thumbnail');
                                if (!empty($thumbnail)) :
                            ?>
                            <img src="<?= $thumbnail; ?>" alt="<?php the_title(); ?>" class="p-top__img" loading="lazy">
                            <?php endif; ?>
                        </div>

                        <?php
                                        $i++;
                                    endwhile;
                                else: echo 'No projects found';
                            endif; wp_reset_postdata();
                        ?>
                        
                    </div>

                    <a href="https://legacy.tokyophotographicresearch.jp/" target="_blank"
                        class="p-top__archives">ARCHIVES 2018-2021
                    </a>
                </div>
            </div>
        </section>
        <!-- @@section top -->
    </main>
    <!-- @@main -->

<?php get_footer(); ?>