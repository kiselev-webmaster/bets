<?php get_header(); ?>
<div class="home-page ">
		<div class="page-title"><?php _e( 'Ставки', 'wp-bets' ); ?></div>
		<?php $get_posts = get_posts ('post_type=bets&numberposts=-1&order=ASC'); ?>
		<?php if($get_posts) : global $post; ?>
			<div class="bets-wrap">
				<div class="wrap-header grid-noBottom">
					<div class="col-1 text-center">id</div>
					<div class="col-3"><?php _e( 'заголовок', 'wp-bets' ); ?></div>
					<div class="col-3"><?php _e( 'тип', 'wp-bets' ); ?></div>
					<div class="col-3"><?php _e( 'статус', 'wp-bets' ); ?></div>
				</div>
				<?php foreach ($get_posts as $post) : setup_postdata ($post); ?>
					<?php 
						$terms_type = get_the_terms( $post->ID, 'type_bets' );
						$terms_status = get_the_terms( $post->ID, 'status_bets' );
						if( $terms_type ) $term_type = array_shift( $terms_type );
						if( $terms_status ) $term_status = array_shift( $terms_status );
					?>
					<div class="bets-item grid-noBottom">
						<div class="col-1 text-center"><?php the_ID(); ?></div>
						<div class="col-3"><?php the_title(); ?></div>
						<div class="col-3"><?php echo $term_type->name; ?></div>
						<div class="col-3"><?php echo $term_status->name; ?></div>
						<div class="col-2"><a href="<?php the_permalink(); ?>"><?php _e( 'просмотреть', 'wp-bets' ); ?></a></div>
					</div>
				<?php endforeach; ?>
				<?php wp_reset_postdata(); ?>
			</div>
		<?php endif; ?>
		
		<a href="<?php echo home_url('/dobavit-stavku/'); ?>" class="btn"><?php _e( 'Добавить ставку', 'wp-bets' ); ?></a>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
