<?php get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<?php the_title( '<div class="page-title">', '</div>' ); ?>
			
			<?php if ( is_user_logged_in() ): $current_user = wp_get_current_user(); ?>
				<p><?php _e( 'Привет', 'wp-bets' ) ?>, <?php echo $current_user->user_login; ?></p>
				
				<div class="add-bets-wrap">
					<form action="page.php">
						<div class="grid">
								<div class="col-6"><input name="post_title" type="text" placeholder="<?php _e( 'Заголовок ставки:', 'wp-bets' ) ?>"  required=""/></div>
							<div class="col-6">
								<select name="type_bets" class="form-control" id="type">
							      <?php
		                          	$categories =  get_categories('taxonomy=type_bets&hide_empty=0');
		                          	foreach ($categories as $category) {
		                          	  $option = '<option value="'.$category->term_id.'">';
		                          	  $option .= $category->cat_name;
		                          	  $option .= '</option>';
		                          	  echo $option;
		                          	}
		                          ?>
							    </select>
							</div>
						</div>
						<div class="grid">
							<div class="col-12"><textarea name="post_content" id="" rows="10" placeholder="<?php _e( 'Введите описание:', 'wp-bets' ) ?>"></textarea></div>
						</div>
						<div class="grid-middle">
							<div class="col-3"><input type="submit" class="btn" value="<?php _e( 'Отправить', 'wp-bets' ) ?>" ></div>
							<div class="col-9"><div class="msg-ok"><?php _e( 'все ок, ставка отправлена', 'wp-bets' ) ?></div></div>
						</div>						
					</form>
				</div>
			<?php else: ?>
				<p><?php _e( 'Что бы добавить ставку необходимо авторизоваться', 'wp-bets' ) ?></p>
			<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
