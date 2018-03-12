<?php
//use reg expressions to get the post IDs from gallery shortcode
function fsng_getGalleryIDs(){

	$post_content = get_the_content();
	$hasGallery = preg_match( '/\[gallery.*ids=.(.*).\]/', $post_content, $ids );
	$flexHtml = ' ';
	
	//create html list for the slider
	if( get_post_gallery() ){
		$array_id = explode( ",", $ids[1] );
		$flexHtml .= "
					<div class=\"flexslider\">\n";
		$flexHtml .= "<ul class=\"slides\">\n";
			foreach ( $array_id as $id ){
			$caption =  get_post( $id );
			
			$flexHtml .= "<li>";
			$flexHtml .= wp_get_attachment_image( $id,'full');

			if( !empty( $caption->post_excerpt ) ){
				$flexHtml .= "<p class=\"flex-caption\">";
				$flexHtml .= $caption->post_excerpt;
				$flexHtml .= "</p>";
			}
			$flexHtml .= "</li>\n";
		}
		$flexHtml .= "</ul></div>";
	}
	else{
		$flexHtml = false;
	}
	return $flexHtml;
}

//filter that replaces Gallery shortcode with the newly generated flexslider html
function fsng_replaceGallery( $content ){

	global $post;
	$new_content = $content;
		if( is_singular() ){ //make sure that the gallery is on a page/single post
			$newGalleryHtml = fsng_getGalleryIDs();

			if( false != $newGalleryHtml ){
				$new_content = preg_replace( '/\[gallery.*ids=.(.*).\]/', $newGalleryHtml, $content );
			}
		}
	return wpautop( $new_content );
	}

if( 'yes' == get_option( 'fs_wp_options' )['fs_wp_field_enable_gallery'] ) {
	add_filter( 'the_content', 'fsng_replaceGallery' );
}
?>