<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header();
?>

<main id="site-content">

		<?php
	if ( have_posts() ) {

		while ( have_posts() ) {

			the_post();
$location = get_post_meta( get_the_ID(),'location',true );
$court_id = get_the_ID();
$game = get_posts(array(
	'numberposts'	=> 1,
	'post_type'		=> 'games',
	'meta_key'		=> 'court',
	'meta_value'	=> get_the_ID()
));
    //Get the images ids from the post_metadata
    $images = acf_photo_gallery('picture_gallery', get_the_ID());
?>
<h5><?= get_post_meta( $court_id,'name',true ); ?></h5>
<h6>Court Status</h6>
<?php
if ($game) { echo "Game Playing";
foreach ($game as $post) : ?>
<?php // FREEING COURTS
if (get_post_meta( $post->ID,'user_1',true )==get_current_user_id()||
		get_post_meta( $post->ID,'user_2',true )==get_current_user_id()||
		get_post_meta( $post->ID,'user_3',true )==get_current_user_id()||
		get_post_meta( $post->ID,'user_4',true )==get_current_user_id()||
		current_user_can('administrator'))
		{
		?>
		<form action="#" method="POST">
			<?php wp_nonce_field( 'freegame', 'security-freegame-verify' ); ?>
			<input id="game" type="hidden" name="game" value="<?php echo $post->ID ?>">
			<input id="court" type="hidden" name="court" value="<?php echo $court_id ?>">
			<input id="submit" type="submit" name="free_game_submitted" id="submit" class="submit" value="<?php esc_attr_e( 'Free Court', 'msk' ); ?>" />
		</form>
	<?php } ?>


				<h6>Game Type:</h6> <?php echo get_post_meta( $post->ID,'game_type',true ); ?>
				<h6>Player Rating:</h6> <?php echo get_post_meta( $post->ID,'player_rating',true ); ?>
				<h6>Players:</h6>  <?php
				$user_id = array( get_post_meta( $post->ID,'user_1',true ),
													get_post_meta( $post->ID,'user_2',true ),
													get_post_meta( $post->ID,'user_3',true ),
													get_post_meta( $post->ID,'user_4',true ));
				$args = array('include' => $user_id );
				$users = new WP_User_Query($args);
				$users = $users->get_results();

				// Array of WP_User objects.
				foreach ( $users as $user ) {
						echo '<span>' . esc_html( $user->display_name ) . ' </span>';
				}

?>

	<?php
endforeach;
} else {
	echo "Free";
}
?>




<h6>Location:</h6>
<p><?php echo get_the_title( $location[0]);?></p>
<h6>Address:</h6>
<p> <?php echo get_post_meta( $location[0],'address',true ); ?></p>
<h6>Zip Code:</h6>
<p> <?php echo get_post_meta( $location[0],'zip_code',true ); ?></p>

<h6>Images</h6>
<?php     if( count($images) ):
				//Cool, we got some data so now let's loop over it
				foreach($images as $image):
						$title = $image['title']; //The title
						$full_image_url= $image['full_image_url']; //Full size image url
						$thumbnail_image_url= $image['thumbnail_image_url']; //Get the thumbnail size image url 150px by 150px
					?>
			<a target="_blank" href="<?=$full_image_url ?>">
				<img src="<?= $thumbnail_image_url ?>">
				<?=$title ?>
			</a>
	<?php
				endforeach;
			endif;
?>
<h6>Name:</h6>
<p> <?php echo get_post_meta( $court_id,'name',true ); ?></p>
<h6>Number:</h6>
<p> <?php echo get_post_meta( $court_id,'number',true ); ?></p>
<h6>Layout:</h6>
<p> <?php echo get_post_meta( $court_id,'layout',true ); ?></p>
<h6>Direction:</h6>
<p> <?php echo get_post_meta( $court_id,'direction',true ); ?></p>
<h6>Vicinity of Door:</h6>
<p> <?php echo get_post_meta( $court_id,'door',true ); ?></p>
<?php
		}
	}
	?>


</main><!-- #site-content -->


<?php
get_footer();
