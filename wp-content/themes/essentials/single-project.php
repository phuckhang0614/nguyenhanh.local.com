<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package essentials
 */

get_header();

$classes = '';
$styles = '';

if(get_post_type()=='project'){
 if(!empty(pix_get_option('blog-bg-color'))){
 	if(pix_get_option('blog-bg-color')=='custom'){
 		$styles = 'background:'.pix_get_option('custom-blog-bg-color').';';
        $classes = '';
 	}else{
 		$classes = 'bg-'.pix_get_option('blog-bg-color'). ' ';
 	}
 }
}else{
 if(!empty(pix_get_option('pages-bg-color'))){
 	if(pix_get_option('pages-bg-color')=='custom'){
 		$styles = 'background:'.pix_get_option('custom-pages-bg-color').';';
 	}else{
 		$classes = 'bg-'.pix_get_option('pages-bg-color'). ' ';
 	}
 }
}

$add_intro_placeholder = false;
if(get_post_type()=='project'){
    $post_intro = false;
    if(!empty(pix_get_option('post-with-intro'))&&pix_get_option('post-with-intro')){
        $post_intro = true;
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
    if($post_intro){
        get_template_part( 'template-parts/intro' );
    }else{
        $add_intro_placeholder = true;
    }
}else{
    get_template_part( 'template-parts/intro' );
}


if(!get_post_meta( get_the_ID(), 'pix-hide-top-padding', true )){
		$classes .= 'pix-pt-20';
}

$containerClass = 'container';
if(get_post_type()=='project' && !empty(pix_get_option('blog-full-width-layout'))){
	$containerClass = 'container-fluid';
}

?>

<div id="content" class="site-content <?php echo esc_html( $classes );?>" style="<?php echo esc_html( $styles ); ?>" >
	<div class="<?php echo esc_attr($containerClass); ?>">
		<div class="row">

			<?php

            if($add_intro_placeholder){
                ?>
                <div class="pix-main-intro-placeholder"></div>
                <?php
            }

            $blog_layout = 'default';
            if(!empty(pix_get_option('blog-layout'))){
                $blog_layout = pix_get_option('blog-layout');
            }
            if(!empty($_GET["blog_layout"])){
                switch ($_GET["blog_layout"]) {
                    case 'default':
                        $blog_layout = 'default';
                        break;
                    case 'right-sidebar':
                        $blog_layout = 'right-sidebar';
                        break;
                    case 'left-sidebar':
                        $blog_layout = 'left-sidebar';
                        break;
                }
            }
			while ( have_posts() ) :
				the_post();
                if(get_post_type()=='project'){
                    switch ($blog_layout) {
                        case 'left-sidebar':
                            get_template_part( 'template-parts/content', 'post-sidebar' );
                            break;
                        case 'right-sidebar':
                            get_template_part( 'template-parts/content', 'post-sidebar' );
                            break;
                        case 'default-normal':
                            get_template_part( 'template-parts/content', 'post-normal' );
                            break;
                        default:
                            if(ICL_LANGUAGE_CODE == 'en') {
                                get_template_part( 'template-parts/content', 'project-en' );
                            } else {
                                get_template_part( 'template-parts/content', 'project-vi' );
                            }
                    }
                }elseif (get_post_type() == 'elementor_library') {
                    // Elementor template page
                    ?>
                    <div class="col-12 col-md-10 offset-md-1">
                		<div id="primary" class="content-area">
                			<main id="main" class="site-main">
                				<article id="post-<?php the_ID(); ?>">
                                    <?php
                                        get_template_part( 'template-parts/content', 'page' );
                                    ?>
                                </article>
                            </main>
                        </div>
                    </div>
                <?php
            }elseif (get_post_type() == 'search') {
                get_template_part( 'template-parts/content', 'search' );
            }elseif (get_post_type() == 'none') {
                get_template_part( 'template-parts/content', 'none' );
            }else{
                ?>
				<div class="col-12">
				<?php
    	            get_template_part( 'template-parts/content', 'page' );
				?>
				</div>
				<?php
            }
			endwhile;
			?>
        </div>

        <!-- Begin Change Language -->
        <?php 
        if( ICL_LANGUAGE_CODE == 'en' )
            { 
                $lbTitlePostOther ='Get the most recent articles';
                 $lbSeeDetail = 'View more';
            }
        else
            {
                $lbTitlePostOther ='Bài viết liên quan';
                $lbSeeDetail = 'Xem chi tiết';
            }
        ?>
        <!-- End Change Language -->

        <!-- Begin Query số lượng bài viết -->
        <?php
            // Lấy danh mục của bài viết hiện tại
            $categories = get_the_category(get_the_ID());
            $category_ids = array();
            if ($categories) {
                foreach ($categories as $individual_category) {
                    $category_ids[] = $individual_category->term_id;
                }
            }

            // Truy vấn bài viết liên quan
            $relatedposts = new WP_Query(array(
                'post_type'      => 'post',
                'posts_per_page' => 3,
                'category__in'   => $category_ids,
                'post__not_in'   => array(get_the_ID())
            ));

            // Chỉ hiển thị tiêu đề nếu có nhiều hơn 1 bài viết liên quan
            if ($relatedposts->found_posts > 1) :
        ?>
        <!-- End Query số lượng bài viết -->

        <!-- Begin Post related -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <?php if ($relatedposts->post_count >= 1) : ?>
                <h2 class="nguyenhanh-post_related_heading"><?php echo $lbTitlePostOther; ?></h2>
                <?php else : ?>
            </div>
            <?php
                while ($relatedposts->have_posts()) : 
                    $relatedposts->the_post();
                    ?>
                    <div class="col-lg-4 col-md-6 col-12 pix-pt-10">
                        <article class="nguyenhanh_post-related-article">
                            <div class="nguyenhanh-post_related_card">
                                <a class="nguyenhanh-post_related-thumbnail-link" href="<?php the_permalink(); ?>">
                                    <div class="nguyenhanh-post_related-thumbnail-img">
                                        <?php the_post_thumbnail('full', array('class' => 'attachment-full size-full')); ?>
                                    </div>
                                </a>
                                <div class="nguyenhanh_post_related-text">
                                    <h3 class="nguyenhanh_post_related-title">
                                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                            <?php echo wp_trim_words(get_the_title(), 4); ?>
                                        </a>
                                    </h3>
                                    <div class="nguyenhanh_post_related-excerpt">
                                        <p><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                                    </div>
                                    <a class="nguyenhanh-post_related-read-more" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                        <?php echo $lbSeeDetail; ?>
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            ?>
        </div>
        <?php endif; ?>
        <!-- End Post related -->

    </div>
</div>
<?php
get_footer();
?>  