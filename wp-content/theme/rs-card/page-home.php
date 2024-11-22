<?php
/**
 * The main template file
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * template name: Homepage
 *
 * @package WordPress
 * @subpackage Rs-Card
 * @since Rs-Card 1.0
 */

get_header();
if(have_posts()):
    $image = get_field('image');
    $hover_image = get_field('hover_image');
    $status = get_field('status');
    $first_title_field = get_field('first_title_field');
    $second_title_field = get_field('second_title_field');
    $subtitle = get_field('subtitle');
    $about_fields = get_field('about_fields');
    $vacation = get_field('vacation');
    $vacation_info = get_field('vacation_info');
    $enable_social_icons = get_field('enable_social_icons');
    $description_text = get_field('description_text');
    $resume_attachment = get_field('resume_attachment');
    $button_link = get_field('button_link');
    $button_text = get_field('button_text');
    $menu_id = get_field('menu_id');
    $about_description = get_field('about_description');
    $about_editor = get_field('about_editor');
	$rscard_options = get_option('rscard_options');
    $hide_about_section = get_field('hide_about_section');
		if(!isset($hide_about_section[0])):
?>
    <section id="<?php echo esc_attr($menu_id);?>" class="section section-about">
		<div class="animate-up">
			<div class="section-box">
				<div class="profile">
					<div class="row">
						<?php if($image):?>
							<div class="col-sm-5">
								<div class="profile-photo">
									<?php echo rs_card_post_thumbnail('',$image['id'], 'rs-card-profile-photo','photo' );?>
                                    <?php if(!empty($hover_image)):
	                                    echo rs_card_post_thumbnail('',$hover_image, 'rs-card-profile-photo','photo-hover' )
                                    ?>
                                    <?php endif;?>
                                </div>
							</div>
						<?php endif;?>
						<div class="col-sm-7">
							<div class="profile-info">
								<?php if($status):?>
									<div class="profile-items clearfix">
										<div class="profile-preword"><span><?php echo esc_html($status);?></span></div>
										
										<?php if(!empty($rscard_options['display-header-share'])):?>
											<div class="profile-share">
												<button id="profileShareBtn"><i class="rsicon rsicon-share"></i></button>																						
											</div>
										<?php endif;?>
									</div>
								<?php
								endif;
								if($first_title_field || $second_title_field):
									?>
									<h1 class="profile-title">
										<?php if($first_title_field):?>
											<span><?php echo esc_html($first_title_field);?></span>
										<?php
										endif;
										if($second_title_field):
											echo esc_html($second_title_field);
										endif;
										?>
									</h1>
								<?php
								endif;
								if($subtitle):
								?>
								<h2 class="profile-position"><?php echo esc_html($subtitle);?></h2></div>
							<?php endif;?>
                            <ul class="profile-list">
                                <?php if(((empty($about_description) || $about_description == 'repeater_fields') && !empty($about_fields))):?>
                                    <?php foreach($about_fields as $field): ?>
                                        <li class="clearfix">
                                            <?php if($field['field_name']):
                                                ?>
                                                <strong class="title"><?php echo esc_html($field['field_name'])?></strong>
                                            <?php
                                            endif;
                                            if($field['field_value']):
                                                ?>
                                                <span class="cont"><?php echo wp_kses_post($field['field_value']);?></span>
                                            <?php
                                            endif; ?>
                                        </li>
                                        <?php endforeach;
                                    elseif(!empty($about_editor)):
                                    ?>
                                        <div class="about_editor"><?php echo $about_editor;?></div>
                                    <?php
                                    endif;
                                    if($vacation || $vacation_info):
                                        ?>
                                        <li class="clearfix">
                                            <?php if($vacation):?>
                                                <strong class="title"><span class="button"><?php echo esc_html($vacation); ?></span></strong>
                                            <?php endif;?>
                                            <?php if($vacation_info):?>
                                                <span class="cont">
                                                    <?php
                                                        if($highlighted_textfiled_icon = get_field('highlighted_textfiled_icon')):
                                                            echo wp_kses_post($highlighted_textfiled_icon);
                                                        endif;
                                                        echo esc_html($vacation_info);
                                                    ?>
                                                </span>
                                            <?php endif;?>
                                        </li>
                                    <?php endif;?>
                            </ul>
						</div>
					</div>
				</div>
				<?php if(isset($enable_social_icons[0]) && $enable_social_icons[0] == 'Enable'):?>
					<div class="profile-social">
						<?php get_template_part('inc/components/social'); ?>
					</div>
				<?php endif;?>
			</div>
			
			<?php if($resume_attachment || $description_text):?>
				<div class="section-txt-btn">
					<?php 
					if($resume_attachment):
						$btn_link = $resume_attachment;
					elseif($button_link):
						$btn_link = $button_link;
					else:
						$btn_link = '';
					endif;
						
					?>
					<?php if($btn_link):?>						
						<p><a class="btn btn-lg btn-border ripple" target="_blank" href="<?php echo esc_url($btn_link);?>">
							<?php if($button_text): echo esc_html($button_text);endif;?>
						</a></p>						
					<?php endif;?>
					<?php if($description_text):?>
						<?php echo wp_kses_post($description_text);?>					
					<?php endif;?>
				</div>
			<?php endif;?>
		</div>
    </section>			
	
    <?php
	endif;
    $sections = get_field('sections');
	if($sections):
		$section_item_count = 1;
		foreach($sections as $section):
			if($section["acf_fc_layout"] == 'skills_section'):
				$title = $section['section_title'];
				$skills = $section['skill'];
				$custom_editor = $section['custom_editor'];
				$menu_id = $section['menu_id'];
				if(empty($section['disable_the_background'])){
					$bg_class="section-box";
				}else{
					$bg_class="section-box-transparent";
				} 
			?>
				<section id="<?php echo esc_attr($menu_id);?>" class="section section-skills">
					<div class="animate-up">
						<?php if($title):?>
							<h2 class="section-title"><?php echo esc_html($title);?></h2>
						<?php endif;?>
						<?php if($skills):?>
							<div class="<?php echo esc_attr($bg_class);?>">
							<?php $i=0; foreach($skills as $skill):?>
								<?php if($i==0 || ($i%2)==0):?>
								<div class="row">
								<?php endif;?>
									<div class="col-sm-6">
										<div class="progress-bar">
											<div class="bar-data">
												<?php if($skill['title']):?>
													<span class="bar-title"><?php echo esc_html($skill['title']);?></span>
												<?php endif;?>
												<?php if($skill['value']):?>
													<span class="bar-value"><?php echo esc_html($skill['value']);?></span>
												<?php endif;?>						
											</div>
											<div class="bar-line">
												<span class="bar-fill" data-width="<?php echo intval($skill['percent']); ?>%"></span>
											</div>
										</div>
									</div>
								<?php if(($i+1)%2==0 || ($i+1)== count($skills)):?>
								</div>
								<?php endif;?>
							<?php $i++; endforeach;?>
							</div>
						<?php endif;?>
						<?php if($custom_editor):?>
							<div class="section-txt-btn"><?php echo $custom_editor;?></div>
						<?php endif;?>
					</div>
				</section>
			<?php
				elseif($section["acf_fc_layout"] == 'interests_section'):
					$description = $section['description'];
					$interests = $section['interests'];
					$title = $section['section_title'];
					
					$custom_editor = $section['custom_editor'];
					$menu_id = $section['menu_id'];
					if(empty($section['disable_the_background'])){
						$bg_class="section-box";
					}else{
						$bg_class="section-box-transparent";
					}
			?>
				<section id="<?php echo esc_attr($menu_id);?>" class="section section-interests">
					<div class="animate-up">
						<?php if($title):?>
							<h2 class="section-title"><?php echo esc_html($title);?></h2>
						<?php endif;?>
						<div class="<?php echo esc_attr($bg_class);?>">
							<?php
								if($description): echo wp_kses_post($description); endif;
								if($interests):
							?>
							<ul class="interests-list">
								<?php foreach($interests as $interest):?>
									<li>
										<i class="map-icon <?php echo esc_attr($interest['interest_class']);?>"></i>
										<?php if($interest['interest_name']):?>
											<span><?php echo esc_html($interest['interest_name']);?></span>
										<?php endif;?>
									</li>
								<?php endforeach;?>
							</ul>
							<?php endif;?>
						</div>
						<?php if($custom_editor):?>
							<div class="section-txt-btn"><?php echo $custom_editor;?></div>
						<?php endif;?>
					</div>
				</section>
			<?php
				elseif($section["acf_fc_layout"] == 'experience_section'):
					$title = $section['section_title'];
					
					$experiences = $section['experiences'];
					$custom_editor = $section['custom_editor'];
					$menu_id = $section['menu_id'];
					if(empty($section['disable_the_background'])){
						$bg_class="section-box";
					}else{
						$bg_class="section-box-transparent";
					}
			?>
				<section id="<?php echo esc_attr($menu_id);?>" class="section section-experience">
					<div class="animate-up">
						<?php if($title):?>
							<h2 class="section-title"><?php echo esc_html($title);?></h2>
						<?php endif;?>
							<?php if($experiences):?>
								<div class="timeline">
									<div class="timeline-bar"></div>
									<div class="timeline-inner clearfix">
										<?php
										$i=0;foreach ($experiences as $experience):
												if ($i % 2 == 0):
													$class = 'timeline-box-left';
													$class_inner = 'animate-right';
												else:
													$class = 'timeline-box-right';
													$class_inner = 'animate-left';										
												endif;
										?>
											<div class="timeline-box <?php echo esc_attr($class); ?>">
												<span class="dot"></span>
												<div class="timeline-box-inner <?php echo esc_attr($class_inner); ?>">
													<span class="arrow"></span>
													<div class="timeline-head">
													<?php if($experience['years']):?>														
														<div class="date"><?php echo esc_html($experience['years']);?></div>
													<?php
														endif;
														if($experience['position']):
													?>
															<h3>
															<?php if($experience['position_link']):?>
																<a href="<?php echo esc_url($experience['position_link']);?>">
															<?php endif;?>
																<?php echo esc_html($experience['position']);?>
															<?php if($experience['position_link']):?>
																</a>
															<?php endif;?>
															</h3>
													<?php endif;?>
														<?php if($experience['image_link']):?>
															<a class="img" href="<?php echo esc_url($experience['image_link']);?>">
														<?php endif;?>
															<img <?php if(!$experience['image_link']) echo 'class="img"';?> src="<?php echo esc_url($experience['image']['sizes']['rs-card-exp-logo']);?>" alt="">
														<?php if($experience['image_link']):?>
															</a>
														<?php endif;?>
													<?php if($experience['workplace']):?>
														<h4><?php echo esc_html($experience['workplace']);?></h4>
													<?php
														endif;?>
														</div>
													<?php	
														if($experience['description']): echo wp_kses_post($experience['description']); endif;
													?>
												</div>
											</div>
										<?php $i++; endforeach; ?>
									</div>
								</div>
							<?php endif;?>
						<?php if($custom_editor):?>
							<div class="section-txt-btn"><?php echo $custom_editor;?></div>
						<?php endif;?>
					</div>
				</section>
			<?php
				elseif($section["acf_fc_layout"] == 'education_section'):
					$title = $section['section_title'];
					
					$education_fields = $section['education_fields'];
					$custom_editor = $section['custom_editor'];
					$menu_id = $section['menu_id'];
					if(empty($section['disable_the_background'])){
						$bg_class="section-box";
					}else{
						$bg_class="section-box-transparent";
					}
			?>
				<section id="<?php echo esc_attr($menu_id);?>" class="section section-education">
					<div class="animate-up">
						<?php if($title):?>
							<h2 class="section-title"><?php echo esc_html($title);?></h2>
						<?php endif;?>
							<?php if($education_fields):?>
							<div class="timeline">
								<div class="timeline-bar"></div>
								<div class="timeline-inner clearfix">
									<?php								
									$i=0;foreach ($education_fields as $education):
											if ($i % 2 == 0):
												$class = 'timeline-box-left';
												$class_inner = 'animate-right';
											else:
												$class = 'timeline-box-right';
												$class_inner = 'animate-left';										
											endif;
									?>
										<div class="timeline-box timeline-box-compact <?php echo esc_attr($class); ?>">
											<span class="dot"></span>

											<div class="timeline-box-inner <?php echo esc_attr($class_inner); ?>">
												<?php if($education['years']):?>
													<span class="arrow"></span>
													<div class="date"><?php echo esc_html($education['years']);?></div>
												<?php
												endif;
												if($education['education_name']):
													?>
													<h3><?php echo esc_html($education['education_name']);?></h3>
												<?php endif;?>
												<?php if($education['image_link']):?>
													<a class="img" href="<?php echo esc_url($education['image_link']);?>">
												<?php endif;?>
													<img <?php if(!$education['image_link']) echo 'class="img"';?> src="<?php echo esc_url($education['image']['sizes']['rs-card-exp-logo']);?>" alt="">
												<?php if($education['image_link']):?>
													</a>
												<?php endif;?>
												<?php if($education['education_place']):?>
													<h4>
													<?php if($education['education_place_link']):?>
														<a href="<?php echo esc_url($education['education_place_link']);?>">
													<?php endif;?>
													<?php echo esc_html($education['education_place']);?>
													<?php if($education['education_place_link']):?>
														</a>
													<?php endif;?>
													</h4>
												<?php endif;?>
											</div>
										</div>
									<?php $i++; endforeach; ?>
								</div>
							</div>
							<?php endif;?>
						<?php if($custom_editor):?>
							<div class="section-txt-btn"><?php echo $custom_editor;?></div>
						<?php endif;?>
					</div>
				</section>
			<?php
				elseif($section["acf_fc_layout"] == 'references_section'):
					$title = $section['section_title'];
					
					$references = $section['references'];
					$slide_speed = $section['slide_speed'];
					$custom_editor = $section['custom_editor'];
					$adaptive_height = $section['adaptive_height'];
					$turn_auto_rotate_on = $section['turn_auto_rotate_on'];
					$menu_id = $section['menu_id'];
					if($slide_speed){
						$speed = intval($slide_speed)*1000;
					}else{
						$speed = 8000;
					}
					if( empty( $adaptive_height ) ){
						$adaptive_height = 'false';
                    }else{
						$adaptive_height = 'true';
                    }
					if( empty( $turn_auto_rotate_on ) ){
						$turn_auto_rotate_on = 'false';
					}else{
						$turn_auto_rotate_on = 'true';
					}
					if(empty($section['disable_the_background'])){
						$bg_class="section-box";
					}else{
						$bg_class="section-box-transparent";
					}
			?>
				<section id="<?php echo esc_attr($menu_id);?>" class="section section-references">
					<div class="animate-up">
						<?php if($title):?>
							<h2 class="section-title"><?php echo esc_html($title);?></h2>
						<?php endif;?>						
							<?php if($references):?>
								<div class="<?php echo esc_attr($bg_class);?>">
                                    <ul class="ref-slider" data-speed="<?php echo intval($speed);?>" data-adaptive="<?php echo esc_attr($adaptive_height);?>" data-rotate="<?php echo esc_attr($turn_auto_rotate_on);?>">
										<?php foreach ($references as $reference): ?>
											<li>
												<div class="ref-box">
													<?php if($reference['quote']):?>
														<div class="person-speech"><?php echo wp_kses_post($reference['quote']);?></div>
													<?php endif;?>
													<div class="person-info clearfix">
														<?php if($reference['author_thumbnail']):?>
															<?php if($reference['author_link']):?>
																<a href="<?php echo esc_url($reference['author_link'])?>">
															<?php endif;?>
																<img class="person-img" src="<?php echo esc_url($reference['author_thumbnail']['url']);?>" alt="<?php echo esc_attr($reference['author_thumbnail']['alt']);?>">
															<?php if($reference['author_link']):?>
																</a>
															<?php endif;?>
														<?php
															endif;
															if($reference['author_name'] || $reference['author_position']):
														?>
															<div class="person-name-title">
																<?php if($reference['author_name']):?>
																	<span class="person-name">
																		<?php if($reference['author_link']):?>
																			<a href="<?php echo esc_url($reference['author_link'])?>">
																		<?php endif;?>
																			<?php echo esc_html($reference['author_name']);?>
																		<?php if($reference['author_link']):?>
																			</a>
																		<?php endif;?>
																	</span>
																<?php
																	endif;
																	if($reference['author_position']):
																?>
																	<span class="person-title"><?php echo esc_html($reference['author_position']);?></span>
																<?php endif;?>
															</div>
														<?php endif;?>
													</div>
												</div>
											</li>
										<?php endforeach; ?>
									</ul>
									<div class="ref-slider-nav">
										<span class="slider-prev"></span>
										<span class="slider-next"></span>
									</div>
								</div>
							<?php endif;?>
						<?php if($custom_editor):?>
							<div class="section-txt-btn"><?php echo $custom_editor;?></div>
						<?php endif;?>
					</div>
				</section>
			<?php
				elseif($section["acf_fc_layout"] == 'calendar_section'):
					$title = $section['section_title'];
					
					$section_background = $section['section_background'];
					$busy_days = $section['busy_days'];
					$busy_message = $section['busy_message'];
					$custom_editor = $section['custom_editor'];
					$menu_id = $section['menu_id'];
					
					if(empty($section['disable_the_background'])){
						$bg_class="section-box";
					}else{
						$bg_class="section-box-transparent";
					}
					
					$week_start = $section['week_start'];
					$busy_days_to_js = '';
					foreach($busy_days as $day){
						$busy_days_to_js .= $day['busy_day']. '&';
					};
					if(0 < strlen($busy_days_to_js)){
						$busy_days_to_js = substr($busy_days_to_js, 0, strlen($busy_days_to_js) - 1);
					}
					if(isset($week_start[0]) && $week_start[0] == 'Start From Monday'){
						$week_start_data = " data-weekstart=monday";
					}else{
						$week_start_data = '';
					}
					if($section_background){					
						$bg_url = $section_background;
					}else{
						$bg_url = get_template_directory_uri().'/img/rs-calendar-cover.jpg';
					}
			?>
				<section id="<?php echo esc_attr($menu_id);?>" class="section section-calendar">
					<div class="animate-up">
						<?php if($title):?>
							<h2 class="section-title"><?php echo esc_html($title);?></h2>
						<?php endif;?>
						<div class="<?php echo esc_attr($bg_class);?>">
							<div class="calendar-busy"<?php echo esc_attr($week_start_data);?>>
								<div class="calendar-today" style="background: url('<?php echo esc_url($bg_url); ?>')">
									<div class="valign-outer">
										<div class="valign-middle">
											<div class="valign-inner">
												<div class="date">
													<span class="day"></span>
													<span class="month"></span>
												</div>
												<div class="week-day"></div>
											</div>
										</div>
									</div>
								</div>

								<div class="calendar-cont">
									<div class="calendar-header">
										<div class="calendar-nav">
											<span class="active-date"><span class="active-month"></span><span class="active-year"></span></span>
											<a class="calendar-prev ripple-centered" title="Prev"><i class="rsicon rsicon-chevron_left"></i></a>
											<a class="calendar-next ripple-centered" title="Next"><i class="rsicon rsicon-chevron_right"></i></a>
										</div>
									</div>
									<input type="hidden" value="<?php echo esc_attr($busy_days_to_js);?>" class="busy_days_to_js">
									<table class="calendar-body">
										<thead class="calendar-thead"></thead>
										<tbody class="calendar-tbody"></tbody>
									</table>
									<?php if($busy_message):?>
										<div class="calendar-busy-note"><?php echo esc_html($busy_message);?></div>
									<?php endif;?>
								</div>
							</div>
						</div>
						<?php if($custom_editor):?>
							<div class="section-txt-btn"><?php echo $custom_editor;?></div>
						<?php endif;?>
					</div>
				</section>
			<?php
				elseif($section["acf_fc_layout"] == 'blog_section'):
				$title = $section['section_title'];
				
				$posts_count = $section['posts_count'];
				$categories = $section['post_categories'];
				$custom_editor = $section['custom_editor'];
				$menu_id = $section['menu_id'];
				if($categories){
					$cat = implode($categories, ',');
				}else{
					$cat = '';
				}
				if(empty($section['disable_the_background'])){
					$bg_class="section-box";
				}else{
					$bg_class="section-box-transparent";
				}

			?>
				<section id="<?php echo esc_attr($menu_id);?>" class="section section-blog">
					<div class="animate-up">
						<?php if($title):?>
							<h2 class="section-title"><?php echo esc_html($title);?></h2>
						<?php endif;?>
							<?php $args = array(
								'posts_per_page'   => $posts_count,
								'category'         => $cat,
								'orderby'          => 'date',
								'order'            => 'DESC',
								'post_type'        => 'post',
								'post_status'      => 'publish',
								'suppress_filters' => true
							);
							$posts_array = get_posts( $args );
							if($posts_array): ?>
							<div class="blog-grid">
								<div class="grid-sizer"></div>
								<?php foreach($posts_array as $post):setup_postdata($post); ?>																								
									<div class="grid-item">
										<?php get_template_part('inc/components/post'); ?>
									</div>								
								<?php endforeach; wp_reset_postdata(); ?>
							</div>
							<?php endif;?>
						<?php if($custom_editor):?>
							<div class="section-txt-btn"><?php echo $custom_editor;?></div>
						<?php endif;?>
					</div>
				</section>
			<?php
			elseif($section["acf_fc_layout"] == 'contact_section'):
				$title = $section['section_title'];
				
				$contact_form_title = $section['contact_form_title'];
				$contact_form_shortcode = wp_kses_post($section['contact_form_shortcode']);
				$contact_fields = $section['contact_fields'];
				$google_map_latitude = $section['google_map_latitude'];
				$google_map_longitude = $section['google_map_longitude'];
				$custom_editor = $section['custom_editor'];
				$menu_id = $section['menu_id'];
				if(empty($section['disable_the_background'])){
					$bg_class="section-box";
				}else{
					$bg_class="section-box-transparent";
				}
			?>
				<section id="<?php echo esc_attr($menu_id);?>" class="section section-contact">
					<div class="animate-up">
						<?php if($title):?>
							<h2 class="section-title"><?php echo esc_html($title);?></h2>
						<?php endif;?>

						<div class="row">
							<?php if($contact_form_title || $contact_form_shortcode): ?>
								<div class="col-sm-6">
									<div class="section-box">
										<?php if($contact_form_title):?>
											<h3><?php echo esc_html($contact_form_title);?></h3>
										<?php
											endif;
											if($contact_form_shortcode):
												echo do_shortcode($contact_form_shortcode);
											endif;
										?>
									</div>
								</div>
							<?php
								endif;
								if($contact_fields || ($google_map_latitude && $google_map_longitude)):
							?>
							<div class="col-sm-6">
								<div class="section-box contact-info <?php if($google_map_latitude && $google_map_longitude) echo 'has-map'; ?>">
									<?php if($contact_fields):?>
										<ul class="contact-list">
											<?php foreach($contact_fields as $field):?>
												<li class="clearfix">
													<?php if(isset($field["name"])):?>
														<strong><?php echo esc_html($field["name"]);?></strong>
													<?php
														endif;
														if(isset($field["value"])):
													?>
														<span><?php echo wp_kses_post($field["value"]);?></span>
													<?php endif;?>
												</li>
											<?php endforeach;?>
										</ul>
									<?php
										endif;
										if($google_map_latitude && $google_map_longitude):
									?>
									<div id="map" data-latitude="<?php echo esc_attr($google_map_latitude);?>" data-longitude="<?php echo esc_attr($google_map_longitude);?>"></div>
									<?php endif;?>
								</div>
							</div>
							<?php endif;?>
						</div>
						<?php if($custom_editor):?>
							<div class="section-txt-btn"><?php echo $custom_editor;?></div>
						<?php endif;?>
					</div>
				</section>

			<?php	
				elseif($section["acf_fc_layout"] == 'portfolio_section'):
				$title = $section['section_title'];				
				$popup_style = $section['popup_style'];
				$display_type = $section['display_type']; 
				
				if($section['posts_count']){
					$posts_count = intval($section['posts_count']);
				}else{
					$posts_count = 9;
				}
				
				if($section['more_button_items_count']){
					$more_button_items_count = intval($section['more_button_items_count']);
				}else{
					$more_button_items_count = 3;
				}    
				
				if(empty($popup_style)){
					$popup_style = 'single_popup';
				}
				
				if($popup_style == 'cross_popup') {
					$data_popup = 'type2';
				}else{
					$data_popup = 'type1';
				}
				
				if(empty($section['disable_the_background'])){
					$bg_class="section-box";
				}else{
					$bg_class="section-box-transparent";
				}
				
				if(empty($display_type)){
					$display_type = 'grid';
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
				
				$portfolio_categories = $section['portfolio_categories'];
				$custom_editor = $section['custom_editor'];
				$menu_id = $section['menu_id'];
					if($portfolio_categories):
						$args_posts = array(
							'posts_per_page'   => $posts_count,
							'orderby'          => 'date',
							'order'            => 'DESC',
							'post_type'        => 'portfolio',
							'tax_query' => array(
								array(
									'taxonomy' => 'portfolio_categories',
									'field' => 'term_id',
									'terms' => $portfolio_categories
								)
							),
							'post_status'      => 'publish',
							'suppress_filters' => true
						);
							
						if(count($portfolio_categories)>1):
							$all_cat = true;
						else:
							$all_cat = false;
						endif;				
					else:
						$args_posts = array(
							'posts_per_page'   => $posts_count,
							'orderby'          => 'date',
							'order'            => 'DESC',
							'post_type'        => 'portfolio',
							'post_status'      => 'publish',
							'suppress_filters' => true
						);				
						$all_cat = false;
					endif;
				?>
				<section id="<?php echo esc_attr($menu_id);?>" class="section section-portfolio">
					<div class="animate-up">
						<?php if($title):?>
							<h2 class="section-title"><?php echo esc_html($title);?></h2>
						<?php endif;?>
						<div class="<?php echo esc_attr($bg_class);?>">
							<?php if($all_cat && $display_type == 'grid'):?>
								<div class="filter">
									<div class="filter-inner">
										<div class="filter-btn-group">
											<button data-filter="*"><?php esc_html_e('All','rs-card');?></button>
											<?php
											$args = array(
												'hide_empty'             => false,
												'include'                => $portfolio_categories,
												'number'                 => '',
											);

											$terms = get_terms('portfolio_categories', $args);
											foreach($terms as $term):
											?>
												<button data-filter=".pf-<?php echo esc_attr($term->term_id);?>"><?php echo esc_html($term->name);?></button>
											<?php endforeach;?>
										</div>
										<div class="filter-bar">
											<span class="filter-bar-line"></span>
										</div>
									</div>
								</div>
							<?php endif;?>

							<div class="<?php echo esc_attr($container_class);?> pf-container" data-popup="<?php echo esc_attr($data_popup);?>" data-view="<?php echo $display_type; ?>">							
							<?php if($display_type == 'grid'):?><div class="pf-grid-sizer"></div><?php endif;?>
							<?php 				
							$posts_array = get_posts( $args_posts );				
							if($posts_array): $i= 1;
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
							if($terms):								
								foreach($terms as $term_item){
									$term_slug .= 'pf-'.$term_item->term_id.' ';
									$term_name .= '<span>'.$term_item->name.' </span>';
								}
							endif;
							?>
								<div class="<?php echo esc_attr($grid_class);?><?php if($display_type == 'grid'):?> <?php echo esc_html($size_class);?> <?php echo esc_html($term_slug);?><?php endif;?>">
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
																		<div class="pf-embed" data-type="video" data-url="<?php if(!empty($cont['video_poster'])):?>poster:<?php echo esc_url($cont['video_poster']);?>,<?php endif; if($cont['mp4_file']):?> mp4: <?php echo esc_url($cont['mp4_file']);?>,<?php endif;if($cont['webm_file']): ?> webm: <?php echo esc_url($cont['webm_file']);?><?php endif;if($cont['ogv_file']): ?> , ogv: <?php echo esc_url($cont['ogv_file']);?><?php endif;?>"></div>																
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
								<?php $i++; endforeach;?>								
							<?php endif;?>
						</div>
						<?php if ( empty( $section['disable_more_button'] ) && $display_type != 'slider' ): ?>
							<?php
							if ( $portfolio_categories ):
								$tax_query     = true;
								$portfolio_cat = $portfolio_categories;
							else:
								$tax_query     = false;
								$portfolio_cat = '';
							endif;
							?>
							<div class="pf-grid-more text-center"
								 data-cat="<?php echo esc_attr( json_encode( $portfolio_cat ) ); ?>"
								 data-tax="<?php echo esc_attr( $tax_query ); ?>"
								 data-path="<?php echo esc_url( get_template_directory() . '/inc/components/portfolio.php' ); ?>"
								 data-count="<?php echo intval( $section_item_count ); ?>"
								 data-more-count="<?php echo esc_attr( $more_button_items_count ); ?>"
								 data-offset="<?php echo intval( $posts_count ); ?>"
								 data-popup_style="<?php echo esc_attr( $popup_style ); ?>"
								 data-display_type="<?php echo esc_attr( $display_type ); ?>"
								 data-loaded-count="0">

								<span class="ajax-loader"></span>
								<button class="btn btn-border ripple"><i class="rsicon rsicon-add"></i></button>
							</div>
						<?php endif; ?>
						</div>
						<?php if($custom_editor):?>
							<div class="section-txt-btn"><?php echo $custom_editor;?></div>
						<?php endif;?>
					</div>
				</section>
				<?php
				elseif($section["acf_fc_layout"] == 'clients_section'):
					$title = $section['section_title'];
					
					$clients = $section['clients'];
					$custom_editor = $section['custom_editor'];
					$menu_id = $section['menu_id'];
					if(empty($section['disable_the_background'])){
						$bg_class="section-box";
					}else{
						$bg_class="section-box-transparent";
					}
				?>
					<section id="<?php echo esc_attr($menu_id);?>" class="section section-clients">
						<div class="animate-up">
							<?php if($title):?>
								<h2 class="section-title"><?php echo esc_html($title);?></h2>
							<?php endif;?>
							<div class="<?php echo esc_attr($bg_class);?>">
								<?php if($clients):?>
									<div class="clients-carousel">
										<?php foreach($clients as $client):?>
											<div class="client-logo">                                       
												<?php if($client['url']):?>
													<a href="<?php echo esc_url($client['url']);?>" target="_blank">
												<?php endif;?>
													<img src="<?php echo esc_url($client['image']['sizes']['rs-card-clients']);?>" alt=""/>
												<?php if($client['url']):?>
													</a>
												<?php endif;?>                                                
											</div>
										<?php endforeach;?>
									</div>
								<?php endif;?>
							</div>
						<?php if($custom_editor):?>
							<div class="section-txt-btn"><?php echo $custom_editor;?></div>
						<?php endif;?>
						</div>
					</section>
				<?php
				elseif($section["acf_fc_layout"] == 'price_box'):
					$title = $section['section_title'];
					
					$boxes = $section['boxes'];
					$custom_editor = $section['custom_editor'];
					$menu_id = $section['menu_id'];
					if(empty($section['disable_the_background'])){
						$bg_class="section-box";
					}else{
						$bg_class="section-box-transparent";
					}
				?>
				<section id="<?php echo esc_attr($menu_id);?>" class="section section-prices">
					<div class="animate-up">
						<?php if($title):?>
							<h2 class="section-title"><?php echo esc_html($title);?></h2>
						<?php endif;?>
							<?php if($boxes):?>                        
									<?php $i = 1;
									foreach($boxes as $box):
										if($box['primary_box']):
											$primary_class=" box-primary";
										else:
											$primary_class="";
										endif;
										
										if(count($boxes) == 1 || count($boxes) == 2){
											$box_class = "col-sm-4";
											if($i ==1 && count($boxes) == 1){
												$box_class2 = " col-sm-offset-4";
											}elseif($i ==1 && count($boxes) == 2){
												$box_class2 = " col-sm-offset-2";
											}else{
												$box_class2 = "";
											}
										}elseif(count($boxes) == 3 || count($boxes) == 5 || count($boxes) == 6){
											$box_class = "col-sm-4";
											if(count($boxes) == 5 && $i ==4){
												$box_class2 = " col-sm-offset-2";
											}else{
												$box_class2 = "";
											}
										}elseif(count($boxes) == 4){
											$box_class = "col-sm-3";
											$box_class2 = "";
										}
										
										if(((count($boxes) != 5 || count($boxes) != 6) && $i == 1) || ((count($boxes)== 5 || count($boxes)== 6)  && ($i == 4 || $i==1))):
									?>
										<div class="row price-list">
									<?php endif;?>
											<div class="<?php echo esc_attr($box_class), esc_attr($box_class2);?>">
												<div class="price-box<?php echo esc_attr($primary_class);?>">
													<?php if($box['primary_price'] || $box['secondary_price']):?>
														<div class="price-box-top">
															<?php if($box['primary_price']):?>
																<span><?php echo esc_html($box['primary_price']);?></span>
															<?php
															endif;
															if($box['secondary_price']):
															?>
																<small><?php echo esc_html($box['secondary_price']);?></small>
															<?php endif;?>
														</div>
													<?php endif;?>
													<div class="price-box-content">
														<?php if($box['title']):?>
															<h3><?php echo esc_html($box['title']);?></h3>
														<?php
														endif;
														if($box['description']):
															echo wp_kses_post($box['description']);
														endif;
														if($box['button_text'] || $box['button_url']):
															if($box['button_url']):
														?>
														<div class="btn-wrap">
														<a class="btn btn-lg btn-border" href="<?php echo esc_url($box['button_url']);?>">
															<?php if($box['button_text']): echo esc_html($box['button_text']); endif;?>
														<?php
															endif;
															if($box['button_url']):
														?>
														</a>
														</div>
														<?php endif;?>
														<?php endif;?>
													</div>
												</div>
											</div>
										<?php if(((count($boxes) != 5 || count($boxes) != 6) && $i == count($boxes)) || ((count($boxes)== 5 || count($boxes)== 6)  && ($i == 3 || $i==count($boxes)))):?>
										</div>
										<?php endif;?>
									<?php $i++; endforeach;?> 
							<?php endif;?>
						<?php if($custom_editor):?>
							<div class="section-txt-btn"><?php echo $custom_editor;?></div>
						<?php endif;?>
					</div>
				</section>
				 <?php
					elseif($section["acf_fc_layout"] == 'editor_section'):
						$editor = $section['editor'];
						$title = $section['section_title'];						
						$custom_editor = $section['custom_editor'];
						$menu_id = $section['menu_id'];
						if(empty($section['disable_the_background'])){
							$bg_class="section-box";
						}else{
							$bg_class="section-box-transparent";
						}
				?>
					<section id="<?php echo esc_attr($menu_id);?>" class="section section-text">
						<div class="animate-up">
							<?php if($title):?>
								<h2 class="section-title"><?php echo esc_html($title);?></h2>
							<?php endif;?>
							<?php if($editor):?>
								<div class="<?php echo esc_attr($bg_class);?>">
									<?php echo $editor; ?>
								</div>
							<?php endif;?>
							<?php if($custom_editor):?>
								<div class="section-txt-btn"><?php echo $custom_editor;?></div>
							<?php endif;?>
						</div>
					</section>
				<?php
					elseif($section["acf_fc_layout"] == 'statistics_section'):
						$title = $section['section_title'];						
						$statistics = $section['statistics'];
						$custom_editor = $section['custom_editor'];
						$menu_id = $section['menu_id']; 
						$section_alignment = $section['section_alignment'];
						if(empty($section['disable_the_background'])){
							$bg_class="section-box";
						}else{
							$bg_class="section-box-transparent";
						}						
				?>
					<section id="<?php echo esc_attr($menu_id);?>" class="section section-statistics text-<?php echo esc_attr($section_alignment);?>">
						<div class="animate-up">
							<?php if($title):?>
								<h2 class="section-title"><?php echo esc_html($title);?></h2>
							<?php endif;?>
							<div class="<?php echo esc_attr($bg_class);?>">
								<?php $i=1; foreach($statistics as $statistic):
									$col_class = '4';
									$offset_class = '';
                                    if(count($statistics) == 2):
								        $offset_class = ' col-sm-offset-2';
                                    elseif(count($statistics) == 1):
	                                    $offset_class = ' col-sm-offset-4';
                                    else:
	                                    $col_class = '3';
                                    endif;
                                    ?>
									<?php if($i ==1 || (($i-1)%4 == 0)):?>
										<div class="row">
									<?php endif;?>
											<div class="col-sm-<?php echo esc_attr($col_class), esc_attr($offset_class);?>">
												<div class="statistic">
													<?php if (!empty($statistic['number'])):?>
														<div class="statistic-value"><?php echo intval($statistic['number']);?></div>
													<?php endif;?>
													<?php if (!empty($statistic['title'])):?>
														<h3 class="statistic-title">
															<?php if (!empty($statistic['icon'])):?>
																<?php echo wp_kses_post($statistic['icon']);?>
															<?php endif;?>
															<?php echo esc_html($statistic['title']);?>
														</h3>
													<?php endif;?>
													<?php if (!empty($statistic['textfield'])):?>
														<div class="statistic-cont">
															<p><?php echo esc_html($statistic['textfield']);?></p>
														</div>
													<?php endif;?>
												</div>
											</div>
									<?php if($i%4 == 0 || $i== count($statistics)):?>
										</div>
									<?php endif;?>
								<?php $i++; endforeach;?>
							</div>
							<?php if($custom_editor):?>
								<div class="section-txt-btn"><?php echo $custom_editor;?></div>
							<?php endif;?>
						</div>
					</section>	
				<?php
					elseif($section["acf_fc_layout"] == 'services_section'):
						$title = $section['section_title'];
						
						$services = $section['services'];
						$custom_editor = $section['custom_editor'];
						$menu_id = $section['menu_id']; 
						$section_alignment = $section['section_alignment']; 
						if(empty($section['disable_the_background'])){
							$bg_class="section-box";
						}else{
							$bg_class="section-box-transparent";
						}
				?>
					<section id="<?php echo esc_attr($menu_id);?>" class="section section-services text-<?php echo esc_attr($section_alignment);?>">
						<div class="animate-up">
							<?php if($title):?>
								<h2 class="section-title"><?php echo esc_html($title);?></h2>
							<?php endif;?>
							<div class="<?php echo esc_attr($bg_class);?>">
								<?php if(!empty($services)):?>									
									<?php $i = 1; 
										foreach($services as $service): 
											if(count($services) == 1):
												$class = '12';
											elseif(count($services) == 2):
												$class = '6';
											else:
												$class = '4';
											endif;
										if($i ==1 || (($i-1)%3 == 0)):
									?>
										<div class="row">
									<?php endif;?>
											<div class="col-sm-<?php echo esc_attr($class);?>">
												<div class="service">
													<?php if(!empty($service['icon'])):?>
														<div class="service-icon"><?php echo wp_kses_post($service['icon']);?></div>
													<?php endif;?>
													<?php if(!empty($service['title'])):?>
														<h3 class="service-title"><?php echo esc_html($service['title']);?></h3>
													<?php endif;?>
													<?php if(!empty($service['secondary_title'])):?>
														<h4 class="service-sub-title"><?php echo esc_html($service['secondary_title']);?></h4>
													<?php endif;?>
													<?php if(!empty($service['description'])):?>
														<div class="service-cont">
															<hr>
															<?php echo wp_kses_post($service['description']);?>
														</div>
													<?php endif;?>
												</div>
											</div>
									<?php if($i%3 == 0 || $i== count($services)):?>
										</div>
									<?php endif;$i++; endforeach;?>
								<?php endif;?>
							</div>
							<?php if($custom_editor):?>
								<div class="section-txt-btn"><?php echo $custom_editor;?></div>
							<?php endif;?>
						</div>
					</section>
				<?php
				endif;
				$section_item_count++;
			endforeach;
			wp_reset_postdata();
		endif;
        if (comments_open()) {
            comments_template('', true);
        }
endif; ?>

<?php get_footer(); ?>
