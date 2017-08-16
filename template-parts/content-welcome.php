<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Atomic
 */
?>


<?php
$site_id  = rcp_site_creation_get_user_blog( get_current_user_id() );
if ( false === $site_id ) {
	?><h2>Ooops!</h2>
	<p>You need to register as a host before you can see this.</p>
	<?php
} else {
	$blog_url = get_site_url( $site_id );
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php
		// Get the post content
		$content = apply_filters( 'the_content', $post->post_content );
		?>
		<div class="content-left">
			<div class="entry-content">

				<?php atomic_remove_sharing(); ?>
				<h1>Welcome to the Beevy family!</h1>
				<p>We've finished setting up your store and it's ready for <em>you</em> to make it your own.</p>

				<p>
				<h2>Getting Started</h2>
				<p>
					Your store can be found at <a href="<?php echo $blog_url; ?>"><?php echo $blog_url; ?></a>
				</p>
				<p>
					<a class="button" href="<?php echo $blog_url; ?>">View Store</a>&nbsp;<a class="button" href="<?php echo $blog_url . '/wp-admin'; ?>">Manage Store</a>
				</p>
				</p>

			</div><!-- .entry-content -->
		</div><!-- .content-right-->

	</article><!-- #post-## -->
	<?php
}
