<?php

add_shortcode('reposts', 'bb_repost_shortcode');

function bb_repost_shortcode($atts) {
	$html = '';

	$args = array(
			'post_type' => 'repost',
			'posts_per_page' => -1,
	);
	$reposts = get_posts($args);

	foreach ($reposts as $repost) {
		$source_article = get_post_meta($repost->ID, 'source_article', true);
		$source_excerpt = get_post_meta($repost->ID, 'source_excerpt', true);
		$source_tags 	= get_post_meta($repost->ID, '');

		$source_types 	= wp_get_post_terms($repost->ID, 'sourcetype');
		$source_type 	= $source_types[0];
		
		$source_tags 	= wp_get_post_terms($repost->ID, 'post_tag');

		$post_author 	= get_the_author_meta(  'user_nicename', $repost->post_author );
		$post_avatar 	= get_avatar($repost->post_author);
		$post_thumb 	= get_the_post_thumbnail($repost->ID, 'full');
		
		$tax_meta 		= get_tax_meta_all($source_type->term_id);
		$tag_line 		= $tax_meta['tagline'];

		$source_type_option = $source_type->name;

		switch($source_type_option){
			case 'We did this':
				$html .= '<div class="row repost-wrapper">
								<div class="small-6 medium-6 large-6 columns blogsidebar">
									';

									if(($tax_meta['avatar']['url'] ) == ''){
										$html .= $post_avatar.'<p class="author">'.$post_author.'</p>';
									}else{
										$html .= '<img class="small-16" src="'.$tax_meta['avatar']['url'].'">';
									}

							 	$html .= '
									<p class="date">'.date_format( date_create($repost->post_date), 'd/m/Y').'</p>';
				
				$html .= '</div>
						<div class="small-18 medium-18 large-18 columns">
							<h1>'.$repost->post_title.'</h1>
							<p>'.$source_excerpt.'</p>
							<div class="row repost-inner-wrapper">
								<div class="small-24 medium-20 large-20 columns">
									'.$post_thumb.'
					  			</div>
								<div class="small-24 medium-18 large-18 columns content">
									<p>'.$tag_line.'</p>
					  			</div>
					  		</div>
					  	</div>
					</div>';
				break;
			case "We're listening to this":
				$html .= '<div class="row repost-wrapper">
								<div class="small-6 medium-6 large-6 columns blogsidebar">
									';

									if(($tax_meta['avatar']['url'] ) == ''){
										$html .= $post_avatar.'<p class="author">'.$post_author.'</p>';
									}else{
										$html .= '<img class="small-16" src="'.$tax_meta['avatar']['url'].'">';
									}

							 	$html .= '
									<p class="date">'.date_format( date_create($repost->post_date), 'd/m/Y').'</p>
								</div>
						<div class="small-18 medium-18 large-18 columns">
							<h1>'.$source_type->description.'</h1>
							<div class="row repost-inner-wrapper">
								<div class="small-24 medium-6 large-6 columns thumb">
									'.$post_thumb.'
					  			</div>
								<div class="small-24 medium-18 large-18 columns content">
									<p>'.$repost->post_title.'</p>
										<a href="'.$source_article.'" target="_repost">';
										if($tax_meta['button_image']['url'] == ''){
											$html .= '<img class="small-6" src="http://brownbox.net.au/wp-content/uploads/2015/09/spotify-connect.png" alt="listen on spotify">';
										}else{
											$html .= '<img class="small-6" src="'.$tax_meta['button_image']['url'].'" alt="listen on spotify">';
										}
									
										$html .='</a>
									
					  			</div>
					  		</div>
					  	</div>
					</div>';
				break;
			case 'We read this':
				$html .= '<div class="row repost-wrapper">
								<div class="small-6 medium-6 large-6 columns blogsidebar">
									';

									if(($tax_meta['avatar']['url'] ) == ''){
										$html .= $post_avatar.'<p class="author">'.$post_author.'</p>';
									}else{
										$html .= '<img class="small-16" src="'.$tax_meta['avatar']['url'].'">';
									}

							 	$html .= '
									<p class="date">'.date_format( date_create($repost->post_date), 'd/m/Y').'</p>';
				foreach($source_tags as $key => $val){
					$html .= '<span class= "tag">'.$val->name.'</span>&nbsp;';
				}
				$html .= '</div>
						<div class="small-18 medium-18 large-18 columns">
							<h1>'.$repost->post_title.'</h1>
							<p>'.$source_excerpt.'</p>
							<div class="row repost-inner-wrapper">
								<div class="small-24 medium-6 large-6 columns thumb">
									'.$post_thumb.'
					  			</div>
								<div class="small-24 medium-18 large-18 columns content">
									<p>'.$repost->post_content.'</p>';
										if($tax_meta['button_image']['url'] == ''){
											$html .= '<a class="button" href="'.$source_article.'" target="_repost">More</a>';
										}else{
											$html .= '<a href="'.$source_article.'" target="_repost"><img class="small-6" src="'.$tax_meta['button_image']['url'].'" alt=""></a>';
										}
										$html .='
					  			</div>
					  		</div>
					  	</div>
					</div>';
				break;
			case 'We wrote this':
				$html .= '<div class="row repost-wrapper">
								<div class="small-6 medium-6 large-6 columns blogsidebar">
									';

									if(($tax_meta['avatar']['url'] ) == ''){
										$html .= $post_avatar.'<p class="author">'.$post_author.'</p>';
									}else{
										$html .= '<img class="small-16" src="'.$tax_meta['avatar']['url'].'">';
									}

							 	$html .= '
									<p class="date">'.date_format( date_create($repost->post_date), 'd/m/Y').'</p>';
				foreach($source_tags as $key => $val){
					$html .= '<span class= "tag">'.$val->name.'</span>&nbsp;';
				}
				$html .= '</div>
						<div class="small-18 medium-18 large-18 columns">
							<h1>'.$repost->post_title.'</h1>
							<p>'.$source_excerpt.'</p>
							<div class="row repost-inner-wrapper">
								<div class="small-24 medium-6 large-6 columns thumb">
									'.$post_thumb.'
					  			</div>
								<div class="small-24 medium-18 large-18 columns content">
									<p>'.$repost->post_content.'</p>';
										if($tax_meta['button_image']['url'] == ''){
											$html .= '<a class="button" href="'.$source_article.'" target="_repost">More</a>';
										}else{
											$html .= '<a href="'.$source_article.'" target="_repost"><img class="small-6" src="'.$tax_meta['button_image']['url'].'" alt=""></a>';
										}
										$html .='
					  			</div>
					  		</div>
					  	</div>
					</div>';
				break;
		}

		// echo '<pre>';
		// //print_r($reposts);
		//  print_r($source_type);
		//  echo '</pre>';
		// //var_dump($source_type);

		//$html .= '<h1>'.$repost->post_title.'</h1>';

	}

	return $html;
}

//function bb_repost