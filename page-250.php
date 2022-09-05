<?php

get_header();
?> <h2><?php the_title(); ?></h2>
<?php if ( is_user_logged_in() ) { ?>
<form action="#" method="POST">
	<?php wp_nonce_field( 'secret', 'security-verify' ); ?>

	<div>
		<label for="location"><?php _e( 'Location' ); ?></label>
<?php
		$args = array(
		        'post_type' => 'locations',
		        'posts_per_page' => -1
		    );
		$query = new WP_Query($args);
		if ($query->have_posts() ) :
		    echo '<select name="location">';
		    while ( $query->have_posts() ) : $query->the_post();
		            echo '<option value="' . get_the_ID() . '">' . get_the_title() . '</option>';
		    endwhile;
		    echo '</select>';
		    wp_reset_postdata();
		endif;
?>
<br><br>
<label for="gametype"><?php _e( 'Game Type' ); ?></label>
<select name="gametype">
	<option value="single">Single</option>
	<option value="double">Double</option>
</select>
<br><br>
<!-- Get User ID-->
<label for="user"><?php _e( 'User' ); ?></label>
<select name="user">
<?php $users = get_users();
foreach ($users as $user):?>
<option value="<?= $user->data->ID ?>"><?= $user->data->user_login ?></option>
<?php endforeach; ?>
</select>
<br><br>

<!-- Get player rating of user-->

	</div>

	<input id="submit" type="submit" name="add_user_submitted" id="submit" class="submit" value="<?php esc_attr_e( 'Submit', 'msk' ); ?>" />
</form>
<?php } else echo 'Please  <a href="/wp-login.php">Login</a>';
get_footer();
