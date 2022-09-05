<?php

get_header();
?>

<main id="site-content">

<?php if ( is_user_logged_in() ) {

?>
<h3>Courts Status</h3>
	<?php
	$args = array(
		'numberposts'	=> -1,
		'post_type'		=> 'courts',
		'meta_key'		=> 'status',
		'meta_value'	=> 'active'
	);


	// query
	$the_query = new WP_Query( $args );

	?>
	<?php if( $the_query->have_posts() ): ?>
		<ul>
		<?php while( $the_query->have_posts() ) : $the_query->the_post();
$fields = get_fields();
$mytitle= get_the_title($fields['location'][0]);
		?>
		<?php if ($mytitle!= $temp) {
			$temp=$mytitle;
			echo '<h5>'.$mytitle.'</h5>';
		} ?>
			<li>
				<a href="<?php the_permalink(); ?>">
				<?php echo get_post_meta( get_the_ID(),'name',true ); ?>
				:
				<?php if (get_post_meta( get_the_ID(),'allocated',true )=="false") echo 'Free'; else echo 'Busy'; ?>

				</a>
			</li>
		<?php endwhile; ?>
		</ul>
	<?php endif; ?>

	<?php wp_reset_query();	 // Restore global post data stomped by the_post(). ?>
<!-- READY GAMES-->
	<h3>Waiting Games</h3>
	<?php
	$posts = get_posts(array(
		'numberposts'	=> -1,
		'post_type'		=> 'games',
		'meta_key'		=> 'status',
		'meta_value'	=> array('ready'),
		'orderby' => 'ID',
	  'order' => 'ASC'
	));
	if (!$posts) echo 'No games.';
	if ($posts) {
		?>
		<table>
			<tr>
				<th>Location</th>
				<th>Game Type</th>
				<th>Player Rating</th>
				<th>Players</th>
			</tr>
	<?php }

	foreach ($posts as $post) :


	?><tr>
					<td> <?php  echo get_the_title( get_post_meta( $post->ID,'location',true ));?></td>
					<td> <?php echo get_post_meta( $post->ID,'game_type',true ); ?></td>
	        <td><?php echo get_post_meta( $post->ID,'player_rating',true ); ?></td>
					<td>  <?php
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
</td>
</tr>
		<?php
	endforeach;
	echo '</table>';
?>

<!-- Waiting List -->
<h3>Waiting Player</h3>
<?php
$posts = get_posts(array(
	'numberposts'	=> -1,
	'post_type'		=> 'games',
	'meta_key'		=> 'status',
	'meta_value'	=> array('waiting'),
	'orderby' => 'ID',
  'order' => 'ASC'
));
if (!$posts) echo 'No player.';
if ($posts) {
	?>
	<table>
		<tr>
			<th>Location</th>
			<th>Game Type</th>
			<th>Player Rating</th>
			<th>Players</th>
		</tr>
<?php }
foreach ($posts as $post) :

?><tr>
				<td><?php  echo get_the_title( get_post_meta( $post->ID,'location',true ));?></td>
				<td><?php echo get_post_meta( $post->ID,'game_type',true ); ?></td>
        <td><?php echo get_post_meta( $post->ID,'player_rating',true ); ?></td>
				<td>  <?php
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
				echo '</td>';
?>
</tr>
	<?php
endforeach;
echo '</table>';
?>



</main><!-- #site-content -->



<?php
} else {
    echo 'Welcome, visitor! Please <a href="/wp-login.php">Login</a> or <a href="/wp-register.php">Register</a>';
}


get_footer();
