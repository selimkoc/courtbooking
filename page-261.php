<?php

get_header();
?> <h2><?php the_title(); ?></h2>
<?php if ( is_user_logged_in() ) { ?>
<form action="#" method="POST">
	<?php wp_nonce_field( 'secret-group', 'group-security-verify' ); ?>

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
<?php $groups = get_posts([
  'post_type' => 'groups',
  'post_status' => 'publish',
  'numberposts' => -1
  // 'order'    => 'ASC'
]);
?>
<!-- Get User ID-->
<label for="group"><?php _e( 'Group' ); ?></label>
<select name="group">
<?php
foreach ($groups as $group):?>
<option value="<?= $group->ID ?>"><?= $group->post_title ?></option>
<?php endforeach; ?>
</select>
<br><br>

	</div>

	<input id="submit" type="submit" name="add_group_submitted" id="submit" class="submit" value="<?php esc_attr_e( 'Submit', 'msk' ); ?>" />
</form>
<?php } else echo 'Please  <a href="/wp-login.php">Login</a>';
get_footer();
