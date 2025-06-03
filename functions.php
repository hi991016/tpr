<?php
    /** Define */
    define( 'THEME_URL', get_stylesheet_directory() );
    define( 'CORE', THEME_URL . '/core' );
    /** Hook */

    // initialize custom settings for the website
    function initTheme() {
        // change the editor to old version
        add_filter('use_block_editor_for_post', '__return_false');
        add_filter('gutenberg_use_widgets_block_editor', '__return_false');
        add_filter('use_widgets_block_editor', '__return_false');
    }

    /** Functions */

    function remove_menus() {
        remove_menu_page( 'edit.php' );// 投稿.
		
		if ( current_user_can( 'editor' ) ) {// 投稿者の場合
			remove_menu_page( 'edit.php?post_type=page' ); // 固定.
			remove_menu_page( 'edit-comments.php' ); // コメント.
			remove_menu_page( 'tools.php' ); // ツール.
		}
    }

    function remove_admin_bar_menus( $wp_admin_bar ) {

			$wp_admin_bar->remove_menu( 'comments' ); // コメント.
			$wp_admin_bar->remove_menu( 'new-content' ); // 新規投稿.
	
	}

    function create_post_type() {
        register_post_type(
            'project',
            array(
                'label' => 'Project',
                'labels' => array(
                    'all_items' => 'プロジェクト一覧',
                    'add_new' => 'プロジェクト新規追加',
                    'add_new_item' => 'プロジェクト追加',
                    'edit_item' => 'プロジェクト編集',
                    'new_item' => 'プロジェクト追加',
                    'view_item' => 'プロジェクトビュー',
                    'search_items' => 'プロジェクト検索',
                    'not_found' => '見つかりません',
                    'not_found_in_trash' => 'ゴミ箱に見つかりません',
                ),
                'public' => true,
                'has_archive' => true,
                'menu_position' => 2,
                'supports' => [ 'title', 'thumbnail', 'editor' ],
            )
        );	

        register_post_type(
            'artwork',
            array(
                'label' => 'ARTWORK',
                'labels' => array(
                    'all_items' => 'アートワーク一覧',
                    'add_new' => 'アートワーク新規追加',
                    'add_new_item' => 'アートワーク追加',
                    'edit_item' => 'アートワーク編集',
                    'new_item' => 'アートワーク追加',
                    'view_item' => 'アートワークビュー',
                    'search_items' => 'アートワーク検索',
                    'not_found' => '見つかりません',
                    'not_found_in_trash' => 'ゴミ箱に見つかりません',
                ),
                'public' => true,
                'has_archive' => true,
                'menu_position' => 3,
                'supports' => [ 'title', 'thumbnail', 'editor' ],
            )
        );	
    }
    
    function create_taxonomy() {
        $labels = array(
            'name' => _x( 'カテゴリー', 'taxonomy general name' ),
            'singular_name' => _x( 'カテゴリー', 'taxonomy singular name' ),
            'search_items' =>  __( 'カテゴリー検索' ),
            'popular_items' => __( '人気のカテゴリ' ),
            'all_items' => __( 'カテゴリー一覧' ),
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => __( 'カテゴリー編集' ), 
            'update_item' => __( 'カテゴリーの更新' ),
            'add_new_item' => __( 'カテゴリー新規追加' ),
            'menu_name' => __( 'カテゴリー' ),
        );
        
        register_taxonomy('project_categories', 'project' ,array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'rewrite'                    => array('slug' => 'project_categories', 'with_front' => true),
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
        ));
    }
    
    function add_page_to_admin_menu() {
        add_menu_page( 'People', 'People', 'manage_categories', 'post.php?post=106&action=edit', '','dashicons-admin-post', 6);
        add_menu_page( 'About', 'About', 'manage_categories', 'post.php?post=104&action=edit', '','dashicons-admin-post', 7);
        add_menu_page( 'CV', 'CV', 'manage_categories', 'post.php?post=1005&action=edit', '','dashicons-admin-post', 8);
    }
    add_action( 'admin_menu', 'add_page_to_admin_menu' );

    add_action('init', 'initTheme');
    add_theme_support('post-thumbnails', array('post', 'project', 'artwork'));
    add_action( 'admin_menu', 'remove_menus' );
	add_action( 'admin_bar_menu', 'remove_admin_bar_menus', 999 );
    add_action('init', 'create_post_type');
    add_action( 'init', 'create_taxonomy', 0 );

    add_action('init', function() {
        remove_post_type_support('project', 'editor');
        remove_post_type_support('artwork', 'editor');
        remove_post_type_support('page', 'editor');
    }, 99);

    // ===== bogo =====
    // Hide flags in Bogo's language switcher
    function bogo_use_flags_false(){
        return false;
    }
    add_filter( 'bogo_use_flags','bogo_use_flags_false');

    // Changed the notation of Bogo's language switcher
    add_filter('bogo_language_switcher_links', function ($links) {
        for ($i = 0; $i < count($links); $i++) {
            if ('ja' === $links[$i]['locale']) { 
                $links[$i]['title'] = 'JP';
                $links[$i]['native_name'] = 'JP';
            }
            if ('en_US' === $links[$i]['locale']) {
                $links[$i]['title'] = 'EN';
                $links[$i]['native_name'] = 'EN';
            }
        }
        return $links;
    });

    // Added Bogo multilingual post type
    function my_bogo_localizable_post_types( $localizable ) {
        // Add post type names to the array.
        $localizable[] = 'project';
        $localizable[] = 'artwork';
        return $localizable;
    }
    add_filter( 'bogo_localizable_post_types', 'my_bogo_localizable_post_types' );

    // Location Bogo multilingual post type
    function your_plugins_loaded() {
        load_plugin_textdomain('yourpluginsdomain', false, basename( dirname( __FILE__ ) ) . '/languages' );
    }
    add_action( 'plugins_loaded', 'your_plugins_loaded' );

    // dropdown acf post type bogo
    function append_language_to_post_title($title, $post, $field, $post_id) {
        if ($field['name'] == 'selected_artworks') {
            $locale = get_post_meta($post->ID, '_locale', true);
            if ($locale) {
                $language = ($locale == 'ja') ? 'JP' : 'EN';
                $title .= ' (' . $language . ')';
            }
        }
        return $title;
    }
    add_filter('acf/fields/post_object/result', 'append_language_to_post_title', 10, 4);

    // filter post bogo dropdown acf
    function filter_artwork_dropdown_by_language($args, $field, $post_id) {
        if ($field['name'] == 'selected_artworks') {
            // get current lang
            $current_locale = get_post_meta($post_id, '_locale', true);
            // filter with lang current
            if ($current_locale) {
                $args['meta_query'] = array(
                    array(
                        'key'     => '_locale',
                        'value'   => $current_locale,
                        'compare' => '=',
                    )
                );
            }
        }
        return $args;
    }
    add_filter('acf/fields/post_object/query/name=selected_artworks', 'filter_artwork_dropdown_by_language', 10, 3);