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
    
    function pagination_tdc($post_type, $wp_query, $paged, $cat = "", $filter = "") {
        if( $wp_query->max_num_pages <= 1 ) return;

        $paged = $paged;
        $max = intval( $wp_query->max_num_pages );
       
        if ( $paged >= 1 ) $links[] = $paged;

        if ( $paged >= 3 ) {
               $links[] = $paged - 1;
               $links[] = $paged - 2;
        }
       
        if ( ( $paged + 2 ) <= $max ) {
               $links[] = $paged + 2;
               $links[] = $paged + 1;
        }

        $html = '';
        $html .= '<div class="c-pagination" data-cat="'.$cat.'" role="navigation">' . "\n";
        
        if ( ! in_array( 1, $links ) ) {
            $class = 1 == $paged ? ' class="item current"' : '';
            if(!$class) {
                $html .= '<a class="item" href="'.build_url($post_type, $cat, 1, $filter).'" >1</a>';
            } else {
                $html .= '<a '.$class.'>1</a>';
            }
            if ( ! in_array( 2, $links ) )
                $html .= '<a>…</a>';
        }
        sort( $links );

        foreach ( (array) $links as $link ) {
            $class = $paged == $link ? ' class="item current"' : '';
            if(!$class) {
                $html .= '<a class="item" href="'.build_url($post_type, $cat, $link, $filter).'">'.$link .'</a>' . "\n";
            } else {
                $html .= '<a '.$class.'>'. $link .'</a>';
            }
        }

        if (!in_array( $max, $links ) ) {
            if ( ! in_array( $max - 1, $links ) ) $html .= '<a class="item">…</a>' . "\n";
            // $class = $paged == $max ? ' class="item"' : '';
            $html .= '<a class="item" href="'.build_url($post_type, $cat, $max, $filter).'">'.$max.'</a>';
        }

        $html .= '</div>' . "\n";
        return $html;
    }
    
    function build_url($post_type, $cat, $paged, $filter){
        if ($cat) {
            $url = home_url('/'.$post_type.'/page/'.$paged).'/?cate='.$cat;
        } elseif ($filter) {
            $url = home_url('/'.$post_type.'/page/'.$paged).'/?'.$filter;
        } else {
            $url = home_url('/'.$post_type.'/page/'.$paged);
        }
        return $url;
    }

    function add_page_to_admin_menu() {
        add_menu_page( 'People', 'People', 'manage_categories', 'post.php?post=106&action=edit', '','dashicons-admin-post', 4);
        add_menu_page( 'About', 'About', 'manage_categories', 'post.php?post=104&action=edit', '','dashicons-admin-post', 4);
        add_menu_page( 'CV', 'CV', 'manage_categories', 'post.php?post=1005&action=edit', '','dashicons-admin-post', 4);
    }
    add_action( 'admin_menu', 'add_page_to_admin_menu' );

    add_action('init', 'initTheme');
    // add_theme_support( 'post-thumbnails' );
    add_theme_support('post-thumbnails', array('post', 'project'));
    add_action( 'admin_menu', 'remove_menus' );
	add_action( 'admin_bar_menu', 'remove_admin_bar_menus', 999 );
    add_action('init', 'create_post_type');
    add_action( 'init', 'create_taxonomy', 0 );

    add_action('init', function() {
        remove_post_type_support('project', 'editor');
        remove_post_type_support('page', 'editor');
    }, 99);

    // add_action('init', function() {
    //     if($_GET['post'] == '106' && $_GET['action'] == 'edit' || $_GET['post'] == '104' && $_GET['action'] == 'edit')
    //         remove_post_type_support('page', 'editor');
    // }, 99);

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
        return $localizable;
    }
    add_filter( 'bogo_localizable_post_types', 'my_bogo_localizable_post_types' );

    // Location Bogo multilingual post type
    function your_plugins_loaded() {
        load_plugin_textdomain('yourpluginsdomain', false, basename( dirname( __FILE__ ) ) . '/languages' );
    }
    add_action( 'plugins_loaded', 'your_plugins_loaded' );