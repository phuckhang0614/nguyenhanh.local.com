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

        <!-- Begin Post related -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <h2 class="nguyenhanh-project_related_heading"><?php echo $lbTitlePostOther ?></h2> 
                </div>
                <?php
                    $html = '';
                    // Lấy Danh mục của bài viết hiện tại
                    // $relatedposts = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => '3', 'post__not_in' => array(get_the_ID()), 'category__not_in' => 20 ) );
                        $relatedposts = new WP_Query( array( 'post_type' => 'project', 'posts_per_page' => '3', 'post__not_in' => array(get_the_ID()) ) );
                        if ( $relatedposts->have_posts() ) :
                            while ( $relatedposts->have_posts() ) : 
                                $relatedposts->the_post();
                                if( $currentProductId != get_the_ID() ) :
                                    $html .= '<div class="col-lg-4 col-md-6 col-12 pix-pt-10">';
                                    $html .= '<article class="nguyenhanh_project-related-article" >';
                                    //
                                    $projectId = get_the_ID();

                                    $projectTitle = get_the_title();
                                    $projectTitle_trim = wp_trim_words($projectTitle, 4);// Đặt số từ mong muốn, ví dụ: 30 từ

                                    $projectUrl = get_permalink();
                                    $projectAvatar = get_the_post_thumbnail_url();
                                    $projectExcerpt = get_the_excerpt();
                                    //
                                    $featured_image_full = get_the_post_thumbnail($projectId, 'full', array('class' => 'attachment-full size-full'));
                                    //
                                    $html .= '<div class="nguyenhanh-project_related_card">';
                                    $html .= '<a class="nguyenhanh-project_related-thumbnail-link" href="'.$projectUrl.'">';
                                    $html .= '<div class="nguyenhanh-project_related-thumbnail-img">';
                                    $html .= $featured_image_full;
                                    $html .= '</div>';
                                    //
                                    // $terms = get_the_terms($projectId, 'price_nhom' );
                                    // foreach ( $terms as $term ) {
                                    //     $html .= '<div class="nguyenhanh_project_related-brand">';
                                    //     $html .= $term->name;
                                    //     $html .= '</div>';
                                    // }
                                    $html .= '</a>';
                                    //
                                    $html .= '<div class="nguyenhanh_project_related-text">';
                                    $html .= '<h3 class="nguyenhanh_project_related-title">';
                                    $html .= '<a href="'.$projectUrl.'" alt="'.$projectTitle_trim.'" title="'.$projectTitle_trim.'">';
                                    $html .= $projectTitle_trim;
                                    $html .= '</h3>';
                                    $html .= '</a>';
                                    //

                                    // giới hạn từ hiển thị trên excerpt
                                    $excerpt = get_the_excerpt();
                                    $projectExcerpt = wp_trim_words($excerpt, 30); // Đặt số từ mong muốn, ví dụ: 30 từ
                                    //

                                    $html .= '<div class="nguyenhanh_project_related-excerpt">';
                                    $html .= '<p>';
                                    $html .= $projectExcerpt;
                                    $html .= '</p>';
                                    $html .= '</div>';
                                    $html .= '<a class="nguyenhanh-project_related-read-more" href="'.$projectUrl.'" alt="'.$projectTitle.'" title="'.$projectTitle.'">';
                                    $html .= $lbSeeDetail;
                                    $html .= '</a>';
                                    $html .= '</div>';
                                    //
                                    $html .= '</div>';
                                    $html .= '</article>';
                                    $html .= '</div>';
                                endif;
                            endwhile;
                            wp_reset_query();
                        endif;
                    echo $html;
                ?>
            </div>
        <!-- End Post content -->

    </div>
</div>
<?php
get_footer();
           