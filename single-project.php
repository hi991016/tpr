<?php 
    get_header(); 

    $default_id = get_the_ID();
    
    $projects_posts1 = array(
        'post_type' => 'project',
        'posts_per_page' => -1,
        'meta_key'          => 'number',
        'orderby'           => 'meta_value',
        'order'             => 'DESC',
    );

    $projects_posts = new WP_Query( $projects_posts1 );
    $arr_posts = $projects_posts->posts;

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
    
    <!-- @main -->
    <main>
        <?php 
            $number = get_field('number'); 
            $category = get_the_terms(get_the_ID(), 'project_categories' ); 
            $images = get_field('images'); 
            $gallery = get_field('gallery'); 
            $years = get_field('years');
            $year = $years['year'];
        ?>
        <!-- @section detail -->
        <section class="p-detail">
            <div class="p-detail__container">
                <div class="p-detail__wrapper l-wrapper">
                    <!-- // -->
                    <div class="p-detail__heading">
                        <p class="p-detail__num"><?= $number; ?></p>

                        <div class="p-detail__title">
                            <h1><?php the_title(); ?></h1>
                            <div class="p-detail__type">
                                <p class="p-detail__category"><?= $category[0]->name ?></p>
                                <p class="p-detail__year is-now"><?= $year; ?></p>
                            </div>
                        </div>
                    </div>
                    <!-- // -->
                    <div class="p-detail__swiper">
                        <div class="detail-swiper swiperDetail" data-projects-swiper>
                            <div class="swiper-wrapper">
                                <?php 
                                    if (!empty($gallery)) :
                                        foreach ($gallery as $key => $value) :
                                ?>
                                <div class="swiper-slide">
                                    <figure>
                                        <img src="<?= $value["url"] ?>" alt="<?= $value["alt"] ?>" loading="lazy">
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
                            <div class="slider-total"></div>
                            <button class="button-swiper swiper-button-next"></button>
                            <button class="button-swiper swiper-button-prev"></button>
                        </div>
                    </div>
                    <!-- // -->
                    <div class="p-detail__tabs">
                        <?php 
                            $overview = get_field('overview');
                            $post_content_overview = $overview["post_content"];
                            $table_content_overview = $overview["table_content"];

                            $info = get_field('info');

                            if (!empty($info)) {
                                $post_content_info = $info["post_content"];
                                $table_content_info = $info["table_content"];
                            }
                        ?>
                        <div class="tabs-wrapper">
                            <ul class="tabs">
                                <li class="tab-link active" data-tabs-items>overview</li>
                                <?php if (empty($post_content_info) && empty($table_content_info)) : ?>
                                    <li></li>
                                <?php else : ?>
                                    <li class="tab-link" data-tabs-items>info</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <div class="content-wrapper">
                            <div class="tab-content active" data-tabs-content>
                                <div class="tab-content--top">
                                    <?= $post_content_overview; ?>
                                </div>

                                <div class="tab-content--table">
                                    <table style="width:100%;">
                                        <tr>
                                            <th></th>
                                            <th></th>
                                        </tr>

                                        <?php 
                                            if (!empty($table_content_overview)) :
                                                foreach ($table_content_overview as $key => $value) :
                                        ?>

                                        <tr>
                                            <td class="table-title"><?= $value["item_title"]; ?></td>
                                            <td class="table-content"><?= $value["item_text"]; ?></td>
                                        </tr>

                                        <?php 
                                                endforeach;
                                            endif;
                                        ?>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-content" data-tabs-content>
                                <div class="tab-content--top">
                                    <?= $post_content_info; ?>
                                </div>
                                <div class="tab-content--table">
                                    <table style="width:100%;">
                                        <?php 
                                            if (!empty($table_content_info)) :
                                                foreach ($table_content_info as $key => $value) :  
                                        ?>

                                        <tr>
                                            <td class="table-title"><?= $value["item_title"]; ?></td>
                                            <td class="table-content"><?= $value["item_text"]; ?></td>
                                        </tr>

                                        <?php 
                                                endforeach;
                                            endif;
                                        ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- // -->
                    <?php if (!empty($images)) : ?>

                    <div class="p-detail__images">
                        <h2>installation view</h2>
                        <div class="p-detail__masonary">
                            <div class="p-detail__list">
                                <?php 
                                    foreach ($images as $key => $value) : 
                                        $thumbnail = $value["thumbnail"];
                                        $caption = $value["caption"];
                                ?>
                                <div class="p-detail__items">
                                    <figure>                                    
                                        <img src="<?= $thumbnail["url"] ?>" key-items="<?= $key ?>" alt="<?= $caption ?>" loading="lazy" data-lightbox-img>
                                    </figure>
                                </div>
                                <?php endforeach; ?>  
                            </div>
                        </div>
                    </div>

                    <div class="p-detail__lightbox" data-lightbox>
                        <div class="p-detail__top">
                            <div class="lightbox-head">
                                <h2><?php the_title(); ?></h2>
                                <p><?= $category[0]->name ?></p>
                                <p><?= $year; ?></p>
                            </div>
                            <div class="lightbox-icon" data-lightbox-close>
                                <svg xmlns="http://www.w3.org/2000/svg" aria-label="close" width="16.414"
                                    height="16.414" viewBox="0 0 16.414 16.414">
                                    <g id="close" transform="translate(-1384.293 -37.293)">
                                        <line id="Line_31" data-name="Line 31" x1="15" y2="15"
                                            transform="translate(1385 38)" fill="none" stroke="#000" stroke-width="2" />
                                        <line id="Line_32" data-name="Line 32" x2="15" y2="15"
                                            transform="translate(1385 38)" fill="none" stroke="#000" stroke-width="2" />
                                    </g>
                                </svg>
                            </div>
                        </div>

                        <div class="p-detail__mid">
                            <div class="lightbox-swiper" data-lightbox-swiper>
                                <div class="swiper-wrapper">
                                    <?php 
                                        foreach ($images as $key => $value) : 
                                            $thumbnail = $value["thumbnail"];
                                            $caption = $value["caption"];
                                            $info = $value["info_images"];
                                            $title = $info["title_info"];
                                            $text = $info["text_info"];
                                    ?>
                                    <div 
                                        class="swiper-slide" 
                                        key-items="<?= $key ?>" 
                                        data-caption="<?= $caption ?>"
                                        data-title="<?= $title ?>"
                                        data-content="<?= $text ?>"
                                    >
                                        <figure>
                                            <img src="<?= $thumbnail["url"] ?>" alt="<?= $caption ?>" loading="lazy">
                                        </figure>
                                    </div>
                                    <?php endforeach; ?>  
                                </div>
                                <div class="p-detail__control">
                                    <button class="button-swiper swiper-button-next"></button>
                                    <button class="button-swiper swiper-button-prev"></button>
                                </div>
                            </div>
                        </div>

                        <div class="p-detail__bottom">
                            <div class="lightbox-caption" data-lightbox-caption></div>
                            <div class="lightbox-right">
                                <div class="lightbox-info" data-text-toggler>
                                    <p data-text-close>info</p>
                                </div>

                                <div class="lightbox-counter">
                                    <span class="current" data-lightbox-current>1</span>
                                    <span>/</span>
                                    <span class="total" data-lightbox-total>18</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-detail__text" data-text>
                            <div class="text-content">
                                <h3 class="text-title" data-text-title></h3>
                                <div class="text-desc" data-text-desc></div>
                            </div>
                        </div>
                    </div>

                    <?php endif; ?>  
                    <!-- // -->
                    <div class="p-detail__pager">
                        <?php 
                            $next_post = null;
                            if ($index > 0) {
                                $next_post = $arr_posts[$index - 1];
                            }
                        ?>
                        <?php if (!empty($next_post)) : ?>
                        <a href="<?= get_permalink($next_post->ID); ?>" class="pager-next">
                            NEXT
                            <span><?= $next_post->post_title ?></span>
                        </a>
                        <?php endif; ?>

                        <!-- // -->

                        <?php 
                            $prev_post = null;
                            if ($index < count($arr_posts) - 1) {
                                $prev_post = $arr_posts[$index + 1];
                            }
                        ?>
                        <?php if (!empty($prev_post)) : ?>
                        <a href="<?= get_permalink($prev_post->ID); ?>" class="pager-prev">
                            PREV
                            <span><?= $prev_post->post_title ?></span>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- @@section detail -->
    </main>
    <!-- @@main -->
<?php get_footer(); ?>