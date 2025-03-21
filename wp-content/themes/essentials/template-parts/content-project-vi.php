<?php
/**
* Template part for displaying project
*
* @link https://developer.wordpress.org/themes/basics/template-hierarchy/
*
* @package essentials
*/

$opts = array(
	'layout' 		=> 'default',
	'style' 		=> 'default',
	'content_col' 		=> 10,
	'content_classes' 		=> 'offset-md-1',
	'has_sidebar'	=> false
);
if(!empty(pix_get_option('blog-layout'))){
	$opts['layout'] = pix_get_option('blog-layout');
}
if(!empty(pix_get_option('blog-style'))){
	$opts['style'] = pix_get_option('blog-style');
}


if($opts['layout']!='default'){
	$opts['content_col'] = 7;
	$opts['has_sidebar'] = true;
	$opts['content_classes'] = '';
}
$attr = array(
	'class' => 'rounded-xl shadow'
);

//begin get thumbnail
$postId = get_the_ID();
$featured_image_full = get_the_post_thumbnail($postId, 'full', array('class' => 'attachment-full size-full rounded-xl shadow pix-hover-item'));
//end get thumbnail

$post_thumb = false;
if(!empty(pix_get_option('post-with-intro'))&&pix_get_option('post-with-intro')){
	$post_thumb = true;
}
if(!empty($_GET["post_intro"])){
	switch ($_GET["post_intro"]) {
		case 'true':
		$post_thumb = true;
		break;
		case 'false':
		$post_thumb = false;
		break;
	}
}
	?>
	<div class="col-12 col-md-12 col-lg-12">
		<div id="primary" class="content-area">
			<main id="main" class="site-main">

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php
					// $attr = array(
					// 	'class' => 'rounded-xl shadow'
					// );
					// essentials_post_thumbnail('post-thumbnail', $attr);
					echo $featured_image_full;
					?>
				</article>
			</main>
		</div>
	</div>

<div class="col-12 col-md-12 col-lg-12 ">
	<div class="content-area pix-post-area">
		<main class="site-main post-full-width">
			<article <?php post_class(); ?>>
				<header class="entry-header">
					<?php

					if ( 'project' === get_post_type() ) :

						$author = get_the_author();
						$avatar = get_avatar_url(get_the_author_meta('ID'), array('size'=>80));

						$cat_args = array( 'fields' => 'names' );
						$cat_args = array( 'fields' => 'all' );
						$cats = wp_get_post_categories(get_the_ID(), $cat_args);


						$post_intro = true;
						if(!pix_get_option('post-with-intro')){
							$post_intro = false;
						}
						if(!empty($_GET["post_intro"])){
							switch ($_GET["post_intro"]) {
								case 'true':
								$post_intro = true;
								break;
								case 'false':
								$post_intro = false;
								break;
							}
						}
						if(!$post_intro){
							$text_class = 'text-heading-default';
							$title_sliding = 'pix-sliding-headline';
							if( !empty(pix_get_option('blog-disable-title-animation')) ){
					            if(pix_get_option('blog-disable-title-animation')){
					                $title_sliding = $text_class;
					            }
					        }
							if(!function_exists('essentials_core_plugin')){
								the_title( '<h1 class="cus-title-post pix-post-title pix-mt-30 pix-mb-20">', '</h1>', true );
							}else{
								the_title( '<h1 class="pix-post-title cus-title-post pix-mt-30 pix-mb-20 '.$title_sliding.' font-weight-bold" data-class="'.$text_class.'">', '</h1>', true );
							}

						}

						?>

					<!-- .entry-meta -->
					<?php endif; ?>
				</header><!-- .entry-header -->

				<div class="entry-content" id="pix-entry-content">
					<?php
					the_content( sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'essentials' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
						) );

						wp_link_pages( array(
							'before' => '<div class="page-links">' . esc_attr__( 'Pages:', 'essentials' ),
							'after'  => '</div>',
						) );


						if(get_the_tags()){

							if(!empty(get_the_tags())){
								?>
								<div class="clearfix w-100"></div>
								<div class="pix-py-20 pix-post-tags">
									<?php
									foreach (get_the_tags() as $value) {
										?>
										<a href="<?php echo get_tag_link( $value ); ?>" class="btn btn-sm btn-white shadow-sm shadow-hover-sm text-xs2 text-body-default fly-sm pix-mr-10 pix-mb-10 font-weight-bold"><?php echo esc_attr( $value->name ); ?></a>
										<?php
									}
									?>
								</div>
								<?php
							}
						}



						?>
					</div><!-- .entry-content -->
				<?php
					if(!empty(get_the_author_meta( 'description' ))){

				?>
					<footer class="entry-footer d-inline-block w-100">
						<?php


						$show_author_box = true;
						if( !empty(pix_get_option('pix-disable-blog-author-box')) ){
							if(pix_get_option('pix-disable-blog-author-box')){
								$show_author_box = false;
							}
						}
						if($show_author_box){

							if(!empty(get_the_author_meta('first_name'))){
								$author = get_the_author_meta('first_name');
								$author .= ' '. get_the_author_meta('last_name');
							}else{
								$author = get_the_author();
							}



							?>
							<div class="media bg-white rounded-xl shadow-sm pix-p-30 pix-my-20">
								<?php
								$avatar = get_avatar_url(get_the_author_meta('ID'), array('size'=>160));
								if($avatar !== FALSE){
									?>
									<img class="pix_blog_lg_avatar pix-mr-30 shadow" src="<?php echo esc_url($avatar); ?>" alt="<?php echo esc_attr( $author ); ?>">
									<?php
								}
								?>
								<div class="media-body">
									<a class="text-heading-default" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><h6 class="mt-0 font-weight-bold text-heading-default"><?php echo esc_attr( $author ); ?></h6></a>
									<?php
									if(!empty(get_the_author_meta( 'job' ))){
										?>
										<div class="mb-0 pix-pt-5 text-sm text-body-default"><?php echo get_the_author_meta( 'job' ); ?></div>
										<?php
									}

									if(!empty(get_the_author_meta('user_url'))){
										$url_txt = get_the_author_meta('user_url');
										if(strpos($url_txt, 'http://') === 0){
											$url_txt = substr($url_txt, strlen('http://'));
										}
										if(strpos($url_txt, 'https://') === 0){
											$url_txt = substr($url_txt, strlen('https://'));
										}
										?>
										<a class="text-sm text-heading-default font-weight-bold" href="<?php echo esc_url ( get_the_author_meta('user_url') ); ?>"><?php echo esc_attr( $url_txt ); ?></a>
										<?php
									}

									?>
									<p class="mb-0 pix-pt-20"><?php the_author_meta( 'description' ); ?></p>
								</div>
							</div>

						<?php } ?>




					</footer><!-- .entry-footer -->
				<?php } ?>

				<?php
					$show_social = true;
					if( !empty(pix_get_option('pix-disable-blog-social')) ){
						if(pix_get_option('pix-disable-blog-social')){
							$show_social = false;
						}
					}
					if($show_social){
						get_pix_social_links();
					}

				?>
				</article><!-- #post-<?php the_ID(); ?> -->

			</main><!-- #main -->
		</div><!-- #primary -->
	</div>




	<!-- Post navigation -->


	<?php
		// Related posts
		get_pix_related_posts();
	?>

	<?php
	// Comments
	if ( comments_open() || get_comments_number() ) :
		?>
		<div class="col-12 col-md-8 offset-md-2 pix-pt-40 pix-pb-80">
			<?php comments_template(); ?>
		</div>
		<?php
	endif;

	?>
