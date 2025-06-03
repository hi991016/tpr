<?php 
    get_header(); 

    $default_id = get_the_ID();
    
    $artworks_posts1 = array(
        'post_type' => 'artwork',
        'posts_per_page' => -1,
        'orderby'           => 'meta_value',
        'order'             => 'DESC',
    );

    $artworks_posts = new WP_Query( $artworks_posts1 );
    $arr_posts = $artworks_posts->posts;

    $index = "";
    foreach ( $arr_posts as $key => $element ) {
        if ( $element->ID  == $default_id ) {
            $index = $key;
        }
    }
?>

    <!-- @custom cursor -->
    <div class="cursor cursor-prev">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="16.16" viewBox="0 0 30 16.16">
            <path id="Path_45" data-name="Path 45" d="M4.57-14.811l8.08-8.08v6.7H34.57v2.768H12.65v6.7Z"
                transform="translate(-4.57 22.891)" fill="#fff" />
        </svg>
    </div>
    <div class="cursor cursor-next">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="16.16" viewBox="0 0 30 16.16">
            <g id="cursor_next" transform="translate(-1225.57 -895.109)">
                <path id="Path_45" data-name="Path 45" d="M34.57-14.811l-8.08-8.08v6.7H4.57v2.768h21.92v6.7Z"
                    transform="translate(1221 918)" fill="#fff" />
            </g>
        </svg>
    </div>
    <!-- @@custom cursor -->

    <main class="artworkpage">
        <?php 
            $artwork_name = get_field('name'); 
            $artwork_title = get_field('title'); 
            $artwork_gallery = get_field('gallery'); 
        ?>
        <section class="details">
            <div class="details__container">
                <div class="details__wrapper">
                    <div class="details__heading">
                        <h1 class="name"><?= !empty($artwork_name) ? $artwork_name : esc_attr(get_the_title()); ?></h1>
                        <p class="title"><?= $artwork_title; ?></p>
                    </div>
                </div>
                <div class="details__center">
                    <div class="details__swiper" data-artwork-swiper>
                        <div class="swiper-wrapper">
                            <?php 
                                if (!empty($artwork_gallery)) :
                                    foreach ($artwork_gallery as $key => $value) :
                                        $thumbnail = $value["images"];
                                        $caption = $value["caption"];
                            ?>
                            <div class="swiper-slide" data-caption="<?= $caption ?>">
                                <figure>
                                    <img src="<?= $thumbnail["url"]; ?>" alt="<?= $caption; ?>" loading="lazy" data-artwork-img>
                                </figure>
                            </div>
                            <?php 
                                    endforeach;
                                else :
                            ?>
                                <figure>
                                    <img src="<?= get_template_directory_uri() ?>/assets/img/no-image.webp" alt="NO IMAGE" loading="lazy">
                                </figure>
                            <?php 
                                endif;
                            ?>
                        </div>
                        <div class="p-detail__control">
                            <button class="button-swiper swiper-button-next"></button>
                            <button class="button-swiper swiper-button-prev"></button>
                        </div>
                    </div>
                </div>
                <div class="details__bottom">
                    <div class="details__bottom_l">
                        <p data-artwork-info>info</p>
                        <p onclick="window.history.back()" data-back>back</p>
                    </div>
                    <div class="details__bottom_r">
                        <div class="details__caption" data-artwork-caption></div>
                        <div class="details__counter">
                            <span class="current" data-artwork-current>1</span>
                            <span>/</span>
                            <span class="total" data-artwork-total>7</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

<?php get_footer(); ?>