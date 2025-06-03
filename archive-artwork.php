<?php get_header(); ?>

    <!-- @main -->
    <main>
        <!-- @section artwork -->
        <section class="p-artwork">
            <div class="p-artwork__container">
                <div class="p-artwork__wrapper l-wrapper">
                    <div class="p-artwork__heading">
                        <h1>artwork</h1>
                    </div>

                    <?php
                        $artworks_posts1 = array(
                            'post_type' => 'artwork',
                            'posts_per_page' => -1,
                            'orderby'           => 'meta_value',
                            'order'             => 'DESC',
                        );
                        $artworks_posts = new WP_Query( $artworks_posts1 );
                    ?>

                    <div class="p-artwork__list">
                        <?php if ($artworks_posts->have_posts()): ?>
                            <?php while ($artworks_posts->have_posts()): $artworks_posts->the_post(); ?>
                                <?php
                                    $post_id = get_the_ID();
                                    $thumbnail = wp_get_attachment_url(get_post_thumbnail_id($post_id), 'thumbnail') ?: '';
                                    $artwork_name = get_field('name', $post_id);
                                    $artwork_title = get_field('title', $post_id);
                                ?>
                                <a href="<?php the_permalink(); ?>" class="p-artwork__items">
                                    <figure>
                                        <img src="<?= esc_url($thumbnail); ?>" alt="<?= esc_attr(get_the_title()); ?>" loading="lazy">
                                    </figure>
                                    <div class="p-artwork__inner">
                                        <p class="name"><?= !empty($artwork_name) ? $artwork_name : esc_attr(get_the_title()) ?></p>
                                        <p class="title"><?= $artwork_title; ?></p>
                                    </div>
                                </a>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p>No projects found</p>
                        <?php endif; wp_reset_postdata(); ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- @@section artwork -->
    </main>
    <!-- @@main -->

<?php get_footer(); ?>