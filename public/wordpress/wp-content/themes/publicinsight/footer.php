<?php
/**
 * The template for displaying the footer
 *
 * Contains the opening of the #site-footer div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

?>
		<footer class="container footer">
			<div class="row overwrite-row">
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<div class="line"></div>
				</div>
			</div>
			<div class="row">
				<div class="col-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
					<ul class="list-inline">
						<li class="list-inline-item"><a href="<?php echo esc_url(home_url('/newsflow')); ?>">Newsflow</a></li>
						<li class="list-inline-item"><a href="<?php echo esc_url(home_url('/calendar')); ?>">Calendar</a></li>
						<li class="list-inline-item"><a href="<?php echo esc_url(home_url('/about')); ?>">About</a></li>
						<li class="list-inline-item"><a href="<?php echo esc_url(home_url('/contact')); ?>">Contact</a></li>
						<li class="list-inline-item"><a href="<?php echo esc_url(home_url('/subscription')); ?>">Subscription</a></li>
					</ul>
				</div>
				<div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 inline-padding">
					
				</div>
			</div>
		</footer>

		<?php wp_footer(); ?>
		
	</body>
</html>
