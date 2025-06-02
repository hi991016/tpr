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
                    <div class="p-top__inner">
                        <h1 class="p-top__heading">project</h1>
                        <ul>
                            <li class="active" data-tabs-items>grid</li>
                            <li data-tabs-items>list</li>
                        </ul>
                    </div>

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

                    <div class="p-top__layout active" data-tabs-content>
                        <div class="p-top__grid">
                            <?php if ($projects_posts->have_posts()): ?>
                                <?php while ($projects_posts->have_posts()): $projects_posts->the_post(); ?>
                                    <?php
                                        $post_id = get_the_ID();
                                        $number = get_field('number', $post_id) ?: '';
                                        $thumbnail = wp_get_attachment_url(get_post_thumbnail_id($post_id), 'thumbnail') ?: '';
                                        $category = get_the_terms($post_id, 'project_categories')[0]->name ?? '';
                                        $years = get_field('years', $post_id);
                                        $year_display = !empty($years['is_now']) ? 'NOW' : ($years['year'] ?? '');
                                    ?>
                                    <a href="<?php the_permalink(); ?>" class="project-link">
                                        <figure>
                                            <img src="<?= esc_url($thumbnail); ?>" alt="<?= esc_attr(get_the_title()); ?>" loading="lazy">
                                        </figure>
                                        <div class="group">
                                            <p class="number"><?= esc_html($number); ?></p>
                                            <div>
                                                <p class="category"><?= esc_html($category); ?>,</p>
                                                <p class="year<?= !empty($years['is_now']) ? ' is-now' : ''; ?>"><?= esc_html($year_display); ?></p>
                                            </div>
                                        </div>
                                        <p class="title"><?= esc_html(get_the_title()); ?></p>
                                    </a>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <p>No projects found</p>
                            <?php endif; wp_reset_postdata(); ?>
                        </div>
                    </div>

                    <div class="p-top__layout" data-tabs-content>
                        <div class="p-top__list">
                            <?php if ($projects_posts->have_posts()): ?>
                                <?php while ($projects_posts->have_posts()): $projects_posts->the_post(); ?>
                                    <?php
                                        $post_id = get_the_ID();
                                        $number = get_field('number', $post_id) ?: '';
                                        $thumbnail = wp_get_attachment_url(get_post_thumbnail_id($post_id), 'thumbnail') ?: '';
                                        $category = !empty(get_the_terms($post_id, 'project_categories')) ? get_the_terms($post_id, 'project_categories')[0]->name : '';
                                        $years = get_field('years', $post_id) ?: ['is_now' => false, 'year' => ''];
                                        $year_display = !empty($years['is_now']) ? 'NOW' : ($years['year'] ?: '');
                                    ?>
                                    <div class="p-top__items">
                                        <a href="<?php the_permalink(); ?>" class="p-top__content">
                                            <p class="p-top__number"><?php echo esc_html($number); ?></p>
                                            <p class="p-top__title"><?php echo esc_html(get_the_title()); ?></p>
                                            <div class="p-top__type">
                                            <?php if ($category): ?>
                                                <p class="p-top__category"><?php echo esc_html($category); ?></p>
                                            <?php endif; ?>
                                            <?php if ($year_display): ?>
                                                <p class="p-top__year<?php echo !empty($years['is_now']) ? ' is-now' : ''; ?>"><?php echo esc_html($year_display); ?></p>
                                            <?php endif; ?>
                                            </div>
                                        </a>
                                        <?php if ($thumbnail): ?>
                                        <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="p-top__img" loading="lazy">
                                        <?php endif; ?>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <p>No projects found</p>
                            <?php endif; wp_reset_postdata(); ?>
                        </div>
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