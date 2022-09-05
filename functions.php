
// Location custom post type function
function create_locations() {

    register_post_type( 'locations',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Locations' ),
                'singular_name' => __( 'Location' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'location'),
            'show_in_rest' => true,

        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_locations' );


// Courts custom post type function
function create_courts() {

    register_post_type( 'courts',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Courts' ),
                'singular_name' => __( 'Court' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'court'),
            'show_in_rest' => true,

        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_courts' );


// User Groups custom post type function
function create_groups() {

    register_post_type( 'groups',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Groups' ),
                'singular_name' => __( 'Group' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'group'),
            'show_in_rest' => true,

        )
    );
}

// Hooking up our function to theme setup
add_action( 'init', 'create_groups' );


// User Games custom post type function
function create_games() {

    register_post_type( 'games',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Games' ),
                'singular_name' => __( 'Game' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'game'),
            'show_in_rest' => true,

        )
    );
}

// Hooking up our function to theme setup
add_action( 'init', 'create_games' );




// User Game Logs custom post type function
function create_gamelogs() {

    register_post_type( 'gamelogs',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Game Logs' ),
                'singular_name' => __( 'Game Log' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'gamelog'),
            'show_in_rest' => true,

        )
    );
}

// Hooking up our function to theme setup
add_action( 'init', 'create_gamelogs' );


/**
 * Overwrite args of custom post type registered by plugin
 */
add_filter( 'register_post_type_args', 'change_capabilities_of_group_document' , 10, 2 );

function change_capabilities_of_group_document( $args, $post_type ){


if ($post_type =='groups') {
 // Change the capabilities of the "course_document" post_type
 $args['capabilities'] = array(
            'edit_post' => 'edit_group_document',
            'edit_posts' => 'edit_group_documents',
            'edit_others_posts' => 'edit_other_group_documents',
            'publish_posts' => 'publish_group_documents',
            'read_post' => 'read_group_document',
            'read_private_posts' => 'read_private_group_documents',
            'delete_post' => 'delete_group_document'
        );
}

if ($post_type =='games') {
 // Change the capabilities of the "course_document" post_type
 $args['capabilities'] = array(
            'edit_post' => 'edit_game_document',
            'edit_posts' => 'edit_game_documents',
            'edit_others_posts' => 'edit_other_game_documents',
            'publish_posts' => 'publish_game_documents',
            'read_post' => 'read_game_document',
            'read_private_posts' => 'read_private_game_documents',
            'delete_post' => 'delete_game_document'
        );
}

if ($post_type =='gamelogs') {
 // Change the capabilities of the "course_document" post_type
 $args['capabilities'] = array(
            'edit_post' => 'edit_gamelog_document',
            'edit_posts' => 'edit_gamelog_documents',
            'edit_others_posts' => 'edit_other_gamelog_documents',
            'publish_posts' => 'publish_gamelog_documents',
            'read_post' => 'read_gamelog_document',
            'read_private_posts' => 'read_private_gamelog_documents',
            'delete_post' => 'delete_gamelog_document'
        );
}

  // Give the course_document post type it's arguments
  return $args;



}


/**
add group capability
*/
add_action('admin_init','rpt_add_role_caps',999);

function rpt_add_role_caps() {

    $role = get_role('subscriber');
    $role->add_cap( 'read_group_document');
    $role->add_cap( 'edit_group_document' );
    $role->add_cap( 'edit_group_documents' );
    $role->add_cap( 'edit_other_group_documents' );
    $role->add_cap( 'edit_published_group_documents' );
    $role->add_cap( 'publish_group_documents' );
    $role->add_cap( 'read_private_group_documents' );
    $role->add_cap( 'delete_group_document' );

    $role->add_cap( 'read_game_document');
    $role->add_cap( 'edit_game_document' );
    $role->add_cap( 'edit_game_documents' );
    $role->add_cap( 'edit_other_game_documents' );
    $role->add_cap( 'edit_published_game_documents' );
    $role->add_cap( 'publish_game_documents' );
    $role->add_cap( 'read_private_game_documents' );
    $role->add_cap( 'delete_game_document' );

		$role->add_cap( 'read_gamelog_document');
    $role->add_cap( 'edit_gamelog_document' );
    $role->add_cap( 'publish_gamelog_documents' );


}


function wpse28782_remove_menu_items() {
    if( !current_user_can( 'administrator' ) ):
        remove_menu_page( 'edit.php?post_type=gamelogs' );
    endif;
}
add_action( 'admin_menu', 'wpse28782_remove_menu_items' );



// Remove add new Game Log menu on Admin Area
function admin_style() {
  wp_enqueue_style('admin-styles', get_template_directory_uri().'/remove-gamelog.css');
}
add_action('admin_enqueue_scripts', 'admin_style');


add_action('init', 'my_custom_css_stylesheet');

function my_custom_css_stylesheet() {
    wp_register_style( 'custom-design', get_template_directory_uri().'/remove-gamelog.css' );
}
wp_enqueue_style( 'custom-design' );


function set_ready_games_to_free_court($location)
{
	$mylocation =$location;
	$posts = new WP_Query( array(
		'post_type' => 'games',
		'posts_per_page'	=> 1,
		'orderby' => 'ID',
		'order' => 'ASC',
		'meta_query' => array(
			'relation' => 'AND', // both of below conditions must match
			array(
				'key' => 'status',
				'value' => 'ready'
			),array(
				'key' => 'location',
				'value' => $mylocation,

			)
		)
		));

	if($posts->have_posts()) :
			while($posts->have_posts()) :
				 $posts->the_post();

	$game_id = get_the_ID();
	$location = get_post_meta( $game_id,'location',true );
	$location ='"'.$location.'"';


	$courts = new WP_Query( array(
	 'post_type' => 'courts',
	 'posts_per_page'	=> 1,
	 'orderby' => 'ID',
	 'order' => 'ASC',
	 'meta_query' => array(
		 'relation' => 'AND', // both of below conditions must match
		 array(
			 'key' => 'allocated',
			 'value' => 'false'
		 ),
		 array(
			 'key' => 'location',
			 'value' => $location,
			 'compare' =>  'LIKE',
		 )
	 )
	 ));

	if($courts->have_posts()) :
		 while($courts->have_posts()) :
				$courts->the_post();
							 $court_id = get_the_ID();
							 update_post_meta($court_id, 'allocated', 'true');
							 update_post_meta($game_id, 'court', $court_id);
							 update_post_meta($game_id, 'status', 'playing');
							 update_post_meta($game_id, 'start_time', date("d/m/Y g:i a"));
			endwhile;
	endif;

	endwhile;
	 endif;


}

// ADD USER TO THE GAME
function add_user_to_game() {
	if ( ! isset( $_POST['add_user_submitted'] ) || ! isset( $_POST['security-verify'] ) )  {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['security-verify'], 'secret' ) ) {
		return;
	}

// CHECK WAITING GAME WITH PLAYER RATING
$player_rating = intval(get_user_meta( $_POST['user'],'player_rating',true ));
$posts = new WP_Query( array(
	'post_type' => 'games',
	'numberposts'	=> 1,
	'orderby' => 'ID',
	'order' => 'ASC',
	'meta_query' => array(
		'relation' => 'AND', // both of below conditions must match
		array(
			'key' => 'status',
			'value' => 'waiting'
		),
		array(
			'key' => 'location',
			'value' => $_POST['location']
		),
		array(
			'key' => 'game_type',
			'value' => $_POST['gametype']
		),
		array(
			'key' => 'player_rating',
			'value' => array($player_rating-1, $player_rating, $player_rating+1)
		)
	)
	));


if($posts->have_posts()) :
		while($posts->have_posts()) :
			 $posts->the_post();
$post_id = get_the_ID();
endwhile;
 endif;


if ($post_id) {
	if ($_POST['gametype']=='single') {
		update_post_meta($post_id, 'user_2', $_POST['user']);
		update_post_meta($post_id, 'status', 'ready');

	}
	else { // Double

			$counter = 1;
			if (intval(get_post_meta( $post_id,'user_1',true ))) $counter++;
			if (intval(get_post_meta( $post_id,'user_2',true ))) $counter++;
			if (intval(get_post_meta( $post_id,'user_3',true ))) $counter++;
			$meta = 'user_'.$counter;

      update_post_meta($post_id, $meta, $_POST['user']);

			if ($counter == 4 ) update_post_meta($post_id, 'status', 'ready');

				}


} else {
// ADD NEW GAME

		$my_game_args = array(
							'post_title'   => 'game',
							'post_content'   => 'game',
							'post_status'   => 'publish',
							'post_type' => 'games'
							);
// insert the post into the database

$cpt_id = wp_insert_post( $my_game_args, $wp_error);

add_post_meta( $cpt_id, 'location', $_POST['location'] );
add_post_meta( $cpt_id, 'game_type', $_POST['gametype'] );
add_post_meta( $cpt_id, 'user_1', $_POST['user'] );
add_post_meta( $cpt_id, 'player_rating', $player_rating );
add_post_meta( $cpt_id, 'status', 'waiting' );

}

// SET READY GAMES TO COURTS
set_ready_games_to_free_court($_POST['location'] );

wp_redirect('/');

	// Redirect user back to the form, with an error or success marker in $_GET.

}
add_action( 'template_redirect', 'add_user_to_game' );


function free_court() {
	if ( ! isset( $_POST['free_game_submitted'] ) || ! isset( $_POST['security-freegame-verify'] ) )  {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['security-freegame-verify'], 'freegame' ) ) {
		return;
	}


	update_post_meta($_POST['court'], 'allocated', 'false');
	// GET GAME DATA
	$location = get_post_meta( $_POST['game'],'location',true );
	$court = get_post_meta( $_POST['game'],'court',true );
	$user_1 = get_post_meta( $_POST['game'],'user_1',true );
	$user_2 = get_post_meta( $_POST['game'],'user_2',true );
	$user_3 = get_post_meta( $_POST['game'],'user_3',true );
	$user_4 = get_post_meta( $_POST['game'],'user_4',true );
	$game_type = get_post_meta( $_POST['game'],'game_type',true );
	$player_rating = get_post_meta( $_POST['game'],'player_rating',true );
	$start_time = get_post_meta( $_POST['game'],'start_time',true );
	$end_time =  date("d/m/Y g:i a");
	// DELETE GAME
	wp_delete_post($_POST['game']);
	// CREATE GAME LOG
	$my_gamelog_args = array(
						'post_title'   => 'gamelog',
						'post_content'   => 'gamelog',
						'post_status'   => 'publish',
						'post_type' => 'gamelogs'
						);
// insert the game log into the database

$cpt_id = wp_insert_post( $my_gamelog_args, $wp_error);

add_post_meta( $cpt_id, 'location', $location );
add_post_meta( $cpt_id, 'court', $court );
add_post_meta( $cpt_id, 'user_1', $user_1 );
add_post_meta( $cpt_id, 'user_2', $user_2 );
add_post_meta( $cpt_id, 'user_3', $user_3 );
add_post_meta( $cpt_id, 'user_4', $user_4 );
add_post_meta( $cpt_id, 'game_type', $game_type );
add_post_meta( $cpt_id, 'player_rating', $player_rating );
add_post_meta( $cpt_id, 'start_time', $start_time );
add_post_meta( $cpt_id, 'end_time', $end_time );

// SET READY GAMES TO COURTS
set_ready_games_to_free_court($location);


wp_redirect('/');

}

add_action( 'template_redirect', 'free_court' );

function add_group() {
	if ( ! isset( $_POST['add_group_submitted'] ) || ! isset( $_POST['group-security-verify'] ) )  {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['group-security-verify'], 'secret-group' ) ) {
		return;
	}

	// ADD NEW GAME

			$my_game_args = array(
								'post_title'   => 'game',
								'post_content'   => 'game',
								'post_status'   => 'publish',
								'post_type' => 'games'
								);
	// insert the post into the database

	$cpt_id = wp_insert_post( $my_game_args, $wp_error);

	add_post_meta( $cpt_id, 'location', $_POST['location'] );
	add_post_meta( $cpt_id, 'user_1',  get_post_meta( $_POST['group'],'user_1',true ) );
	add_post_meta( $cpt_id, 'user_2',  get_post_meta( $_POST['group'],'user_2',true ) );
	add_post_meta( $cpt_id, 'user_3',  get_post_meta( $_POST['group'],'user_3',true ) );
	add_post_meta( $cpt_id, 'user_4',  get_post_meta( $_POST['group'],'user_4',true ) );
	add_post_meta( $cpt_id, 'status', 'ready' );

	// SET READY GAMES TO COURTS
	set_ready_games_to_free_court($_POST['location']);


wp_redirect('/');

}

add_action( 'template_redirect', 'add_group' );
