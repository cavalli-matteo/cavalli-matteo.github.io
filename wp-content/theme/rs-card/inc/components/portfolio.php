<?php	
	if($_POST['tax_query']){
		$args_ajax = array(
			'posts_per_page'   => $_POST['more_count'],
			'orderby'          => 'date',
			'order'            => 'DESC',
			'post_type'        => 'portfolio',
			'tax_query' => array(
				array(
					'taxonomy' => 'portfolio_categories',
					'field' => 'term_id',
					'terms' => $_POST['portfolio_cat'],
				)
			),
			'offset'           => $_POST['offset'],
			'post_status'      => 'publish',
			'suppress_filters' => true
		);
	}else{
		$args_ajax = array(
			'posts_per_page'   => $_POST['more_count'],
			'orderby'          => 'date',
			'order'            => 'DESC',
			'post_type'        => 'portfolio',
			'offset'           => $_POST['offset'],
			'post_status'      => 'publish',
			'suppress_filters' => true
		);				
	}
	
	if(empty($_POST['popup_style'])){
		$popup_style = 'single_popup';
	}else{
		$popup_style = $_POST['popup_style'];
	}
	
	if($popup_style == 'cross_popup') {
		$data_popup = 'type2';
	}else{
		$data_popup = 'type1';
	}
	
	if(empty($_POST['display_type'])){
		$display_type = 'grid';
	}else{
		$display_type = $_POST['display_type'];
	}
	
	if($display_type == 'grid'){
		$container_class = 'pf-grid';
		$grid_class = 'pf-grid-item';
		$centered_info = 'text-left';
	}else{
		$container_class = 'pf-slider';
		$grid_class = 'pf-slider-item';
		$centered_info = 'text-center';
	}
    $posts_array = get_posts( $args_ajax );
    if($posts_array): $i= intval($_POST['click_count']);
		$section_item_count = $_POST['section_item_count'];
        foreach($posts_array as $post):setup_postdata($post);
            $alt = rscard_the_attached_image_alt();
			$content = get_field('content');
			$outer_link = get_field('outer_link');
			$image_size = get_field('image_size');
			$disable_popup = get_field('disable_popup');
			$disable_inner_link = get_field('disable_inner_link');
			$project_fields = get_field('project_fields');
			$logo_image = get_field('logo_image');
			if($display_type == 'grid'){
				if($image_size== 'Big'){
					$size_class = 'size22';
					$image_size = 'rs-card-portfolio-big';
				}else{
					$size_class = 'size11';
					$image_size = 'rs-card-portfolio-small';
				}
			}else{
				$image_size = 'rs-card-portfolio-slider';
			}
			$terms = get_the_terms( get_the_ID(), 'portfolio_categories' );
			$term_slug = '';
			$term_name = '';
			if($terms){
				foreach($terms as $term_item){
					$term_slug .= $term_item->slug.' ';
					$term_name .= '<span>'.$term_item->name.' </span>';
				}
			}
?>
<div class="<?php echo esc_attr($grid_class); ?><?php if($display_type == 'grid'):?> <?php echo esc_html($size_class);?> <?php echo esc_html($term_slug);?><?php endif;?>">
	<article class="pf-item" <?php
				if(has_post_thumbnail(get_the_ID())):
					$image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), $image_size, false);
			?> style="background-image: url('<?php echo esc_url($image[0]);?>')"<?php endif;?>>
		<div class="pf-item-cont <?php echo esc_attr($centered_info);?> clear-mrg">
			<?php if(!empty($logo_image)):?>
				<img class="pf-item-logo" src="<?php echo esc_url($logo_image['url']);?>" alt="<?php echo esc_attr($logo_image['alt']);?>">
			<?php endif;?>

			<h2 class="pf-item-title"><?php the_title();?></h2>

			<div class="pf-item-cat">
				<?php echo wp_kses_post($term_name);?>
			</div>
		</div>
		<div class="pf-btn-group <?php echo esc_attr($centered_info);?>">
			<?php if(empty($disable_popup)):?>
				<a class="pf-btn pf-btn-zoom" href="#"><i class="rsicon rsicon-zoom_in"></i></a>
			<?php endif;?>
			<?php if(empty($disable_inner_link)):?>
				<a class="pf-btn pf-btn-eye" href="<?php the_permalink();?>"><i class="rsicon rsicon-eye"></i></a>
			<?php endif;?>
			<?php if(!empty($outer_link)):?>
				<a target="_blank" class="pf-btn pf-btn-link" href="<?php echo esc_url($outer_link);?>"><i class="rsicon rsicon-link"></i></a>
			<?php endif;?>
		</div>
		
		<?php if($popup_style == 'cross_popup'):?>
			<div class="pf-popup-slide">
				<div class="pf-popup-item">
					<?php if($content):?>														
						<?php 
							$i=1;
							foreach($content as $cont):
							if(!empty($cont['popup_header'])):
								if($i==1):
						?>
								<div class="pf-popup-media">
								<?php endif;?>
									<?php if($cont['popup_header'] && $cont['popup_header'] == 'Image' && $cont['image']):?>
										<div class="pf-embed" data-type="image" data-width="670" data-height="470" data-url="<?php echo esc_url($cont['image']['sizes']['rs-card-portfolio-popup']);?>"></div>
									<?php elseif($cont['popup_header'] && $cont['popup_header'] == 'Video Upload' && ($cont['mp4_file'] || $cont['webm_file'] || $cont['ogv_file'])):?>	
											<div class="pf-embed" data-type="video" data-url="<?php if(!empty($cont['video_poster'])):?>poster:<?php echo esc_url($cont['video_poster']);?>,<?php endif; if($cont['mp4_file']):?> mp4: <?php echo esc_url($cont['mp4_file']);?>,<?php endif;if($cont['webm_file']): ?> webm: <?php echo esc_url($cont['webm_file']);?><?php endif;if($cont['ogv_file']): ?> , ogv: <?php echo esc_url($cont['ogv_file']);?><?php endif;?>"></div>																
									<?php elseif($cont['popup_header'] && $cont['popup_header'] == 'Video Iframe' && $cont['iframe_url']):?>
										<div class="pf-embed" data-type="iframe" data-width="670" data-height="470" data-url="<?php echo esc_url($cont['iframe_url']);?>"></div>															
									<?php endif;?>
								<?php if($i==1):?>
								</div>
								<?php endif;?>
							<?php endif;?>
						<?php $i++; endforeach;?>														
					<?php endif;?>

					<div class="pf-popup-info">
						<header class="pf-popup-head clear-mrg">
							<h2 class="pf-popup-title"><?php the_title();?></h2>
							<h3 class="pf-popup-cat"><?php echo wp_kses_post($term_name);?></h3>
						</header>

						<div class="pf-popup-cont">
							<?php  if(!empty($project_fields)):?>
								<dl class="pf-popup-def-list">
									<?php foreach($project_fields as $field):?>
										<?php if(!empty($field['project_field_name'])):?>
											<dt><?php echo esc_html($field['project_field_name']);?></dt>
										<?php endif;?>
										<?php if(!empty($field['project_field_value'])):?>
											<dd><?php echo wp_kses_post($field['project_field_value']);?></dd>
										<?php endif;?>
									<?php endforeach;?>
								</dl>
							<?php endif;?>

							<div class="pf-popup-text clear-mrg">
								<?php the_excerpt();?>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php 
		elseif($content):
			foreach($content as $cont):
		?>
				<div class="pf-popup-slide">
					<div class="pf-popup-item">
						<?php if(!empty($cont['popup_header'])):?>
							<div class="pf-popup-media">
								<?php if($cont['popup_header'] && $cont['popup_header'] == 'Image' && $cont['image']):?>
									<div class="pf-embed" data-type="image" data-width="670" data-height="470" data-url="<?php echo esc_url($cont['image']['sizes']['rs-card-portfolio-popup']);?>"></div>
								<?php elseif($cont['popup_header'] && $cont['popup_header'] == 'Video Upload' && ($cont['mp4_file'] || $cont['webm_file'] || $cont['ogv_file'])):?>	
										<div class="pf-embed" data-type="video" data-url="poster:<?php echo esc_url($poster);?><?php if($cont['mp4_file']):?>, mp4: <?php echo esc_url($cont['mp4_file']);?>,<?php endif;if($cont['webm_file']): ?> webm: <?php echo esc_url($cont['webm_file']);?><?php endif;if($cont['ogv_file']): ?> , ogv: <?php echo esc_url($cont['ogv_file']);?><?php endif;?>"></div>																
								<?php elseif($cont['popup_header'] && $cont['popup_header'] == 'Video Iframe' && $cont['iframe_url']):?>
									<div class="pf-embed" data-type="iframe" data-width="670" data-height="470" data-url="<?php echo esc_url($cont['iframe_url']);?>"></div>															
								<?php endif;?>
							</div>
						<?php endif;?>
						<div class="pf-popup-info">
							<header class="pf-popup-head clear-mrg">
								<?php if(!empty($cont['title'])):?>
									<h2 class="pf-popup-title"><?php echo esc_html($cont['title']);?></h2>
								<?php endif;?>
								<h3 class="pf-popup-cat"><?php echo wp_kses_post($term_name);?></h3>
							</header>

							<div class="pf-popup-cont">
								<?php  if(!empty($project_fields)):?>
									<dl class="pf-popup-def-list">
										<?php foreach($project_fields as $field):?>
											<?php if(!empty($field['project_field_name'])):?>
												<dt><?php echo esc_html($field['project_field_name']);?></dt>
											<?php endif;?>
											<?php if(!empty($field['project_field_value'])):?>
												<dd><?php echo wp_kses_post($field['project_field_value']);?></dd>
											<?php endif;?>
										<?php endforeach;?>
									</dl>
								<?php endif;?>

								<div class="pf-popup-text clear-mrg">
									<?php echo wp_kses_post($cont['description']);?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach;?>
		<?php endif;?>
	</article>
</div>
<?php
    $i--;
        endforeach;
    endif;exit;
?>