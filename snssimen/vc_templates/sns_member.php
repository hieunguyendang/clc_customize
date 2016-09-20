<?php

$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$extra_class = esc_attr($extra_class) ? 'sns-member '.esc_attr($extra_class) : 'sns-member';
$output .= '<div class="'.$extra_class.'">';
$begin_link = '';
if ( ! empty( $link ) ) {
	$link = vc_build_link( $link );
	$begin_link = '<a href="' . esc_url( $link['url'] ) . '"'
	               . ( $link['target'] ? ' target="' . esc_attr( $link['target'] ) . '"' : '' )
	               . ( $link['title'] ? ' title="' . esc_attr( $link['title'] ) . '"' : '' )
	               . '>';
}
if($avartar != ''){
	$avartar = preg_replace('/[^\d]/', '', $avartar);
	$img =   wp_get_attachment_image_src( $avartar , '');
	$img = '<img src="'.$img[0].'" alt="'.esc_attr($name).'" />';
	if ( $begin_link !='' ) {
		$img = $begin_link. $img . '</a>';
	}
	
	$avartar_class = ($avartar_style!='') ? 'avartar '.$avartar_style :'avartar';
	$output .= '<div class="'.$avartar_class.'">'.$img.'</div>';
}
if ($name != ''){
	if ( $begin_link !='' ) {
		$name = $begin_link. esc_attr($name) . '</a>';
	}
	$output .= '<h3 class="name">'.$name.'</h3>';
}
if ($role != ''){
	$output .= '<p class="role">'.esc_attr($role).'</p>';
}
if (trim(strip_tags($short_desc)) != ''){
	$output .= '<div class="short_desc">'.esc_textarea($short_desc).'</div>';
}
//$social_links = explode ("," , $social_links);
//if( in_array('facebook',$social_links) || in_array('twitter',$social_links) || in_array('youtube',$social_links) || in_array('dribbble',$social_links) || in_array('linkedin',$social_links) || in_array('pinterest',$social_links) || in_array('behance',$social_links) || in_array('google',$social_links) ) {
	$social = '<div class="social-icons"><ul>';
	if( $facebook != '') {
	 	$social .= '<li><a class="facebook" href="' . esc_url( $facebook ) . '" target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a></li>';
	}
	if( $twitter != '') {
	 	$social .= '<li><a class="twitter" href="' . esc_url( $twitter ) . '" target="_blank" title="twitter"><i class="fa fa-twitter"></i></a></li>';
	}
	if( $linkedin != '') {
	 	$social .= '<li><a class="linkedin" href="' . esc_url( $linkedin ) . '" target="_blank" title="linkedin"><i class="fa fa-linkedin"></i></a></li>';
	}
	if( $dribbble != '') {
	 	$social .= '<li><a class="dribbble" href="' . esc_url( $dribbble ). '" target="_blank" title="dribbble"><i class="fa fa-dribbble"></i></a></li>';
	}
	if( $behance != '') {
	 	$social .= '<li><a class="behance" href="' . esc_url( $behance ) . '" target="_blank" title="behance"><i class="fa fa-behance"></i></a></li>';
	}
	if( $youtube != '') {
	 	$social .= '<li><a class="youtube" href="' . esc_url( $youtube ) . '" target="_blank" title="youtube"><i class="fa fa-youtube"></i></a></li>';
	}
	if( $pinterest != '') {
	 	$social .= '<li><a class="pinterest" href="' . esc_url( $pinterest ) . '" target="_blank" title="pinterest"><i class="fa fa-pinterest"></i></a></li>';
	}
	if( $google != '') {
	 	$social .= '<li><a class="google" href="' . esc_url( $google ) . '" target="_blank" title="google plus"><i class="fa fa-google-plus"></i></a></li>';
	}
	$social .= '</ul></div>';
	$output .= $social;
//}
$output .= '</div>';
echo $output;
