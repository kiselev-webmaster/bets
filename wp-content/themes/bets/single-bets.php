<?php get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
		<?php if (have_posts()) :  while (have_posts()) : the_post(); ?>
		    <div class="page-title"><?php the_title (); ?></div>
		    <?php the_content (); ?>
		    <div class="bets-wrap">
				<div class="wrap-header grid-noBottom-noGutter">
					<div class="col-1 text-center">id</div>
					<div class="col-3"><?php _e( 'заголовок', 'wp-bets' ) ?></div>
					<div class="col-2"><?php _e( 'тип', 'wp-bets' ) ?></div>
					<div class="col-2"><?php _e( 'статус', 'wp-bets' ) ?></div>
				</div>
					<?php 
						$terms_type = get_the_terms( $post->ID, 'type_bets' );
						$terms_status = get_the_terms( $post->ID, 'status_bets' );
						if( $terms_type ) $term_type = array_shift( $terms_type );
						if( $terms_status ) $term_status = array_shift( $terms_status );
					?>
					<div class="bets-item grid-noBottom-middle-noGutter">
						<div class="col-1 text-center"><?php the_ID(); ?></div>
						<div class="col-3"><?php the_title(); ?></div>
						<div class="col-2"><?php echo $term_type->name; ?></div>
						<div class="col-2"><?php echo $term_status->name; ?></div>
						<div class="col-4">
							<div class="form-add-meta">
								<form>
											<input name="post_id" type="hidden" value="<?php echo $post->ID; ?>" />
										<input name="meta_value" type="number" min="100" max="1000" placeholder="100">
										<input type="submit" class="btn" value="<?php _e( 'Ставка пройдет!', 'wp-bets' ) ?>" <?php if($_COOKIE['add_meta_bets']) //echo('disabled="true"'); ?> >
								</form>
							</div>
						</div>
					</div>
					
					<div class="grid">
						<div class="col-7"></div>
						<div class="col-5">
							<p class="msg-ok"><?php _e( 'Поздравляем! Ваша ставка прошла', 'wp-bets' ) ?></p>
							<p class="disabled"><?php _e( 'Одного раза было достаточно.', 'wp-bets' ) ?></p>
						</div>
					</div>
			</div>
		<?php endwhile; ?>
		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
