<?php
// add custom post type------------------------------------
function post_types()
{
    // Event Post type
    register_post_type('event', array(
        //'capability_type' => 'event',
        'map_meta_cap' => true,
        'supports' => array('title', 'editor', 'excerpt'),
        'rewrite' => array('slug' => 'events'),
        'has_archive' => true,
        'public' => true,
        'labels' => array(
            'name' => 'Events',
            'add_new_item' => 'Add New Event',
            'edit_item' => 'Edit Event',
            'all_items' => 'All Events',
            'singular_name' => 'Event'
        ),
        'menu_icon' => 'dashicons-calendar-alt'
    ));
    add_action('init', 'post_types');
}
//end of add custom post type-------------------------------

// add menu -------------------------------
function register_my_menus()
{
    register_nav_menus(
        array(
            'header-menu' => __('Header Menu'),
            'extra-menu' => __('Extra Menu')
        )
    );
}
add_action('init', 'register_my_menus');
//end of add menu -------------------------------

// menu -------------------------------
?>
<nav class="main-navigation">
    <ul>
        <li <?php if (is_page('about-us') or wp_get_post_parent_id(0) == 16) echo 'class="current-menu-item"' ?>><a href="<?php echo site_url('/about-us') ?>">About Us</a></li>
        <li <?php if (get_post_type() == 'program') echo 'class="current-menu-item"' ?>><a href="<?php echo get_post_type_archive_link('program') ?>">Programs</a></li>
        <li <?php if (get_post_type() == 'event' or is_page('past-events')) echo 'class="current-menu-item"';  ?>><a href="<?php echo get_post_type_archive_link('event'); ?>">Events</a></li>
        <li <?php if (get_post_type() == 'campus') echo 'class="current-menu-item"' ?>><a href="<?php echo get_post_type_archive_link('campus'); ?>">Campuses</a></li>
        <li <?php if (get_post_type() == 'post') echo 'class="current-menu-item"' ?>><a href="<?php echo site_url('/blog'); ?>">Blog</a></li>
    </ul>
</nav>
<?php
//end of menu -------------------------------

//register------------------------------------------------------------
global $wpdb, $PasswordHash, $current_user, $user_ID;
if (isset($_POST['task']) && $_POST['task'] == 'register') {
    // get data from form
    $password1  = $wpdb->escape(trim($_POST['password1']));
    $password2  = $wpdb->escape(trim($_POST['password2']));
    $first_name = $wpdb->escape(trim($_POST['first_name']));
    $last_name  = $wpdb->escape(trim($_POST['last_name']));
    $email      = $wpdb->escape(trim($_POST['email']));
    $username   = $wpdb->escape(trim($_POST['username']));
// if
    if ($email == "" || $password1 == "" || $password2 == "" || $username == "" || $first_name == ""   || $last_name == "") {
        $error = 'Please don\'t leave the required fields.';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email address.';
    } else if (email_exists($email)) {
        $error = 'Email already exist.';
    } else if ($password1 != $password2) {
        $error = 'Password do not match.';
    } else {
        // insert user
        $user_id = wp_insert_user(array(
            'first_name' => apply_filters('pre_user_first_name', $first_name),
            'last_name'  => apply_filters('pre_user_last_name', $last_name),
            'user_pass'  => apply_filters('pre_user_user_pass', $password1),
            'user_login' => apply_filters('pre_user_user_login', $username),
            'user_email' => apply_filters('pre_user_user_email', $email),
            'role' => 'subscriber'
        ));
        if (is_wp_error($user_id)) {
            $error = 'Error on user creation.';
        } else {
            do_action('user_register', $user_id);

            $success = 'You\'re successfully register';
        }
    }
}
// register-------------------------------------------------------------------------------------

//login -------------------------------
?>
<div class="site-header__util">
    <?php if (is_user_logged_in()) { ?>
        <a href="<?php echo esc_url(site_url('/my-notes')); ?>" class="btn btn--small btn--orange float-left push-right">My Notes</a>
        <a href="<?php echo wp_logout_url();  ?>" class="btn btn--small  btn--dark-orange float-left btn--with-photo">
            <span class="site-header__avatar"><?php echo get_avatar(get_current_user_id(), 60); ?></span>
            <span class="btn__text">Log Out</span>
        </a>
    <?php } else { ?>
        <a href="<?php echo wp_login_url(); ?>" class="btn btn--small btn--orange float-left push-right">Login</a>
        <a href="<?php echo wp_registration_url(); ?>" class="btn btn--small  btn--dark-orange float-left">Sign Up</a>
    <?php } ?>
    <a href="<?php echo esc_url(site_url('/search')); ?>" class="search-trigger js-search-trigger"><i class="fa fa-search" aria-hidden="true"></i></a>
</div>
<?php
//end of login -------------------------------

//WP_Query -------------------------------
$homepageEvents = new WP_Query(array(
    'posts_per_page' => 2,
    'post_type' => 'event',
    'meta_key' => 'event_date',
    'orderby' => 'meta_value_num',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'event_date',
            'compare' => '>=',
            'value' => $today,
            'type' => 'numeric'
        )
    )
));
while ($homepageEvents->have_posts()) {
    $homepageEvents->the_post();
    get_template_part('template-parts/content', 'event');
}
//end of WP_Query -------------------------------


//of add style & script -------------------------------
wp_enqueue_script('name', get_theme_file_uri('/js/...'), NULL, '1.0', true);
wp_enqueue_style ('name', '');
//end of add style & script -------------------------------

the_permalink();
get_footer();
have_posts();
the_post();
the_title();
get_the_category_list(', ');
the_time('n.j.y');
the_author_posts_link();
get_the_archive_title();
get_the_archive_description();
get_post_type_archive_link('event');
get_theme_file_path('/inc/search-route.php');
get_site_url();
wp_enqueue_style();
wp_list_pages();
the_content();
update_user_meta($user_id, 'naam', $naam);
wp_redirect(site_url('link-external-copy'));
wp_insert_user();
apply_filters();