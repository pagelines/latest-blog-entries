<?php
/*
Section: Latest Blog Entries
Author: Enrique Chávez
Author URI: http://tmeister.net
Version: 1.0.5
Description: Latest Blogs Entries is a very powerful section for Pagelines which displays your recent posts with thumbnail, excerpt, title, date and read more link . It’s the perfect solution to show specific entries on the home page or in any other page. With more that 15 options in general.
Class Name: TmLatestBlog
Cloning: true
External: http://tmeister.net/themes-and-sections/latest-blog-entries/
Demo: http://pagelines.tmeister.net/latest-blog-posts/
Workswith: templates, main, morefoot
V3: true
**/


class TmLatestBlog extends PageLinesSection {

	/**
	 *
	 * Section Variable Glossary (Auto Generated)
	 * ------------------------------------------------
	 *  $this->id			- The unique section slug & folder name
	 *  $this->base_url 	- The root section URL
	 *  $this->base_dir 	- The root section directory path
	 *  $this->name 		- The section UI name
	 *  $this->description	- The section description
	 *  $this->images		- The root section images URL
	 *  $this->icon 		- The section icon url
	 *  $this->screen		- The section screenshot url
	 *  $this->oset			- Option settings array... needed for '$this->opt' (contains clone_id, post_id)
	 *
	 * 	Advanced Variables
	 * 		$this->view				- If the section is viewed on a page, archive, or single post
	 * 		$this->template_type	- The PageLines template type
	 */

	var $domain = 'tm_latest';

	function section_persistent(){
		add_image_size('latest', 180, 100, true);
	}

	function section_scripts(){
		return array(
			'carouFredSel' => array(
				'file'       => $this->base_url . '/jquery.carouFredSel-6.1.0-packed.js',
				'dependancy' => array('jquery'),
				'location'   => 'footer',
				'version'    => '6.1.0'
			),
		);
	}

	function section_styles(){
		wp_enqueue_script( 'carouFredSel', $this->base_url . '/jquery.carouFredSel-6.1.0-packed.js', array( 'jquery' ), '6.1.0', true );
	}

	function dmshify(){
        if( function_exists('pl_has_editor') ){
            return $this->prefix();
        }else{
            return '#nodms';
        }
    }

	function get_dms_clone_id($prefix){
        preg_match('/"([^"]*)"/', $prefix, $match);
        return $match[1];
    }

	function section_head( $clone_id = null ){
		global $pagelines_ID;

		$clone_id      = function_exists('pl_has_editor') ? $this->get_dms_clone_id( $this->prefix() ) : $clone_id;
		$jsTarget =  ".latest".$clone_id;


		$oset              = array('post_id' => $pagelines_ID, 'clone_id' => $clone_id);
		$effect            = ( $this->opt('tm_latest_effect', $oset) ) ? $this->opt('tm_latest_effect', $oset) : 'scroll';
		$effect_duration   = ( $this->opt('tm_latest_effect_duration', $oset) ) ? $this->opt('tm_latest_effect_duration', $oset) : '1000';
		$pause_on_hover    = ( $this->opt('tm_latest_pause_on_hover', $oset) == 'on') ? 'true' : 'false';
		$pause_duration    = ( $this->opt('tm_latest_duration_pause', $oset) ) ? $this->opt('tm_latest_duration_pause', $oset) : '5000';
		$disable_autostart = ( $this->opt('tm_latest_autostart', $oset) == 'on') ? true : false;

		/*Styles*/
		$section_bg = ( $this->opt('tm_latest_section_title_bg', $oset) ) ? pl_hashify( $this->opt('tm_latest_section_title_bg', $oset)) : '#f7f7f7';
		$main_bg = ( $this->opt('tm_latest_main_bg', $oset) ) ? pl_hashify( $this->opt('tm_latest_main_bg', $oset)) : '#ffffff';
		$border  = ( $this->opt('tm_latest_menu_border', $oset) ) ? pl_hashify( $this->opt('tm_latest_menu_border', $oset)) : '#EEEEEE';
		$shadow  = ( $this->opt('tm_latest_shadow', $oset) ) ? pl_hashify( $this->opt('tm_latest_shadow', $oset)) : '#e4e4e4';
		$title   = ( $this->opt('tm_latest_title_color', $oset) ) ? pl_hashify( $this->opt('tm_latest_title_color', $oset)) : '#4c4c4c';
		$text    = ( $this->opt('tm_latest_text_color', $oset) ) ? pl_hashify( $this->opt('tm_latest_text_color', $oset)) : '#555555';



	?>
		<style>
			.latest<?php echo $clone_id?> ul.slides li,
			<?php echo $this->dmshify() ?> ul.slides li{
				background:<?php echo $main_bg ?>;
				border: 1px solid <?php echo $border ?>;
			}
			.latest<?php echo $clone_id?> ul.slides li:hover,
			<?php echo $this->dmshify() ?> ul.slides li:hover {
			    -webkit-box-shadow: 3px 3px 0 <?php echo $shadow ?>;
			    -moz-box-shadow: 3px 3px 0 <?php echo $shadow ?>;
			    box-shadow: 3px 3px 0 <?php echo $shadow ?>;
			}
			.latest<?php echo $clone_id?> ul.slides li h3 a,
			<?php echo $this->dmshify() ?> u.slides li h3 a{
				color:<?php echo $title ?> !important;
			}
			.latest<?php echo $clone_id?> ul.slides li,
			<?php echo $this->dmshify() ?> ul.slides li{
				color:<?php echo $text ?> !important;
			}
			.latest<?php echo $clone_id?> .block-title span,
			<?php echo $this->dmshify() ?> .block-title span{
				background:<?php echo $section_bg ?> !important;
			}
		</style>
		<script>
			jQuery(document).ready(function($) {
				function renderLatest(){
					$("<?php echo $jsTarget ?> .slides").each( function(a, b){

						var highest = 0;
						$this = $(this);
						$this.find('li').each(function(a, item){
							highest = ( $(item).height() > highest ) ? $(item).height() : highest;
						});

						$this.find('li').each(function(a, item){
							$item = $(item);
							$item.css({'height':highest});
							$item.find('.read-more').each( function(a, item){
								$item = $(item);
								$item.css({'position': 'absolute', 'bottom': '5px'})
							} );
						});

					});

					$("<?php echo $jsTarget ?> .slides").carouFredSel({
						align       : "center",
						width:'100%',
						<?php echo ( $disable_autostart ) ? 'auto:false,' : 'auto: {timeoutDuration:'.$pause_duration.'},'?>
						scroll: {
							duration:<?php echo $effect_duration?>,
							fx: '<?php echo $effect?>',
							pauseOnHover: <?php echo $pause_on_hover?>
						},
						prev:'.latest<?php echo $clone_id?> #prev_pag',
						next:'.latest<?php echo $clone_id?> #next_pag'
					});
				}
				setTimeout(renderLatest,1000)
			});
		</script>
	<?php
	}



 	function section_template( $clone_id = null ) {
 		global $post, $pagelines_ID;

		$clone_id      = function_exists('pl_has_editor') ? $this->get_dms_clone_id( $this->prefix() ) : $clone_id;

		$current_page_post = $post;
		$oset              = array('post_id' => $pagelines_ID, 'clone_id' => $clone_id);
		$limit             = ( $this->opt('tm_latest_items', $oset) ) ? $this->opt('tm_latest_items', $oset) : '8';
		$set               = ( $this->opt('tm_latest_set', $oset) ) ? $this->opt('tm_latest_set', $oset) : null;
		$title             = ( $this->opt('tm_latest_title', $oset) ) ? $this->opt('tm_latest_title', $oset) : 'Latest from the Blog';

		$show_thumb        =  ( $this->opt('tm_latest_thumb', $oset) == 'on'  || $this->opt('tm_latest_thumb', $oset) == '1'  ) ? false : true;
		$show_title        =  ( $this->opt('tm_latest_show_title', $oset) == 'on'  || $this->opt('tm_latest_show_title', $oset) == '1') ? false : true;

		$use_wp_excerpt 	=  ( $this->opt('tm_use_wp_excerpt', $oset) == 'on'  || $this->opt('tm_use_wp_excerpt', $oset) == '1') ? false : true;

		$show_date         =  ( $this->opt('tm_latest_date', $oset) == 'on'  || $this->opt('tm_latest_date', $oset) == '1') ? false : true;
		$show_excerpt      =  ( $this->opt('tm_latest_excerpt', $oset) == 'on'  || $this->opt('tm_latest_excerpt', $oset) == '1') ? false : true;
		$show_read_more    =  ( $this->opt('tm_latest_read_more', $oset) == 'on'  || $this->opt('tm_latest_read_more', $oset) == '1') ? false : true;
		$read_more_text    =  ( $this->opt('tm_latest_read_more_text', $oset ) ) ? $this->opt('tm_latest_read_more_text', $oset )  : 'Read More';

		$limit_excerpt     = ( $this->opt('tm_limit_excerpt', $oset) ) ? $this->opt('tm_limit_excerpt', $oset) : '20';


		$posts = $this->get_posts( $set, $limit );
		if( !count($posts) ){
			echo setup_section_notify($this, __('Sorry, there are no posts to display.', 'post'), get_admin_url().'edit.php?post_type=post', 'Please create some posts' );
			return;
		}




 	?>


		<div class="latest-slider latest<?php echo $clone_id?>">
			<h1 class="block-title">
				<span data-sync="tm_latest_title"> <?php echo $title?> </span>
			</h1>
			<ul class="slides">
				<?php foreach ($posts as $post): global $post; setup_postdata( $post ); $img = wp_get_attachment_image_src( $post->ID ); ?>
					<li class="post">
						<?php if ($show_thumb): ?>
							<div class="blog-thumb">
								<a href="<?php the_permalink() ?>" title="<?php the_title() ?>">
									<?php echo the_post_thumbnail( 'latest' ) ?>
								</a>
							</div>
						<?php endif ?>

						<div class="blog-title">
							<?php if ($show_title): ?>
								<div class="big">
									<h3><a href="<?php the_permalink()?>"><?php the_title()?></a></h3>
								</div>
							<?php endif ?>
						</div>
						<?php if ($show_date): ?>
							<p class="post-meta"><?php echo get_the_date(); ?></p>
						<?php endif ?>

						<div class="clear"></div>

						<?php if ($show_excerpt): ?>
							<div class="excerpt">
								<?php if ($use_wp_excerpt): ?>
									<p><?php echo $this->latest_excerpt( get_the_excerpt(), $limit_excerpt ); ?></p>
								<?php else: ?>
									<p><?php echo $this->latest_excerpt( get_the_content(), $limit_excerpt ); ?></p>
								<?php endif ?>

							</div>
							<div class="clear"></div>
						<?php endif ?>

						<?php if ($show_read_more): ?>
							<div class="read-more">
								<a href="<?php the_permalink() ?>"><?php echo $read_more_text ?></a>
							</div>
						<?php endif ?>

					</li>
				<?php endforeach; $post = $current_page_post; ?>

			</ul>
			<div class="clearfix"></div>
			<div class="latest_pagination">
				<div class="nav" id="prev_pag"></div>
		    	<div class="nav" id="next_pag"></div>
			</div>

		</div>

 	<?php
	}

	/**
	 *
	 * Section Page Options
	 *
	 * Section optionator is designed to handle section options.
	 */
	function section_optionator( $settings ){

		$settings = wp_parse_args($settings, $this->optionator_default);
		$opt_array = array(
			'tm_latest_title' 	=> array(
				'type'			=> 'text',
				'inputlabel'	=> __('Title', $this->domain),
				'title' 		=> __('Section Title', $this->domain),
				'shortexp'		=> __('Default: "Latest from the Blog"', $this->domain),
				'exp'			=> __('If set the title will show on the top of the section', $this->domain),
			),
			'tm_latest_set' 	=> array(
				'type' 			=> 'select_taxonomy',
				'taxonomy_id'	=> 'category',
				'title' 		=> __('Select the category to show', $this->domain),
				'shortexp'		=> __('The category to show', $this->domain),
				'inputlabel'	=> __('Select a category', $this->domain),
				'exp' 			=> __('Select the category you would like to show on this page. if don\'t select a set the slider will show the last entries for all the categories', $this->domain)
			),
			'tm_latest_items' => array(
				'type' 			=> 'count_select',
				'inputlabel'	=> __('Number of post to show', $this->domain),
				'title' 		=> __('Number of post', $this->domain),
				'shortexp'		=> __('Default value is 8', $this->domain),
				'exp'			=> __('The amount of post to show.', $this->domain),
				'count_start'	=> 1,
 				'count_number'	=> 20,
			),

			'tm_latest_section_title_bg'  => array(
                'inputlabel' 	=> __( 'Color', $this->domain ),
                'type' => 'colorpicker',
                'title' => __( 'Section Title Background', $this->domain )
            ),

			'tm_latest_main_bg'	=> array(
				'inputlabel' 	=> __( 'Color', $this->domain ),
				'type' => 'colorpicker',
                'title' => __( 'Item Background', $this->domain )
			),

			'tm_latest_menu_border'	=> array(
				'inputlabel' 	=> __( 'Color', $this->domain ),
				'type' => 'colorpicker',
                'title' => __( 'Item Border', $this->domain )
			),

			'tm_latest_shadow'	=> array(
				'inputlabel' 	=> __( 'Color', $this->domain ),
				'type' => 'colorpicker',
                'title' => __( 'Item Shadow', $this->domain )
			),

			'tm_latest_title_color'	=> array(
				'inputlabel' 	=> __( 'Color', $this->domain ),
				'type' => 'colorpicker',
                'title' => __( 'Title Background', $this->domain ),
			),

			'tm_latest_text_color'	=> array(
				'inputlabel' 	=> __( 'Color', $this->domain ),
				'type' => 'colorpicker',
                'title' => __( 'Content Text', $this->domain ),
			),

			'tm_latest_thumb' => array(
				'type'			=> 'check',
				'title'			=> __('Show Thumbnail image', $this->domain),
				'inputlabel'	=> __('Don\'t show the thumbnail image ', $this->domain),
				'shortexp'		=> __('Default: Visible', $this->domain),
				'exp'			=> __('Determines whether to show the thumbnail image.', $this->domain)
			),
			'tm_latest_show_title' => array(
				'type'			=> 'check',
				'title'			=> __('Show title', $this->domain),
				'inputlabel'	=> __('Don\'t show the title', $this->domain),
				'shortexp'		=> __('Default: Visible', $this->domain),
				'exp'			=> __('Determines whether to show the post title.', $this->domain)
			),
			'tm_latest_date' => array(
				'type'			=> 'check',
				'title'			=> __('Show Date', $this->domain),
				'inputlabel'	=> __('Don\'t show the date', $this->domain),
				'shortexp'		=> __('Default: Visible', $this->domain),
				'exp'			=> __('Determines whether to show the post date.', $this->domain)
			),
			'tm_latest_excerpt' => array(
				'type'			=> 'check',
				'title'			=> __('Show Excerpt', $this->domain),
				'inputlabel'	=> __('Don\'t show the excerpt', $this->domain),
				'shortexp'		=> __('Default: Visible', $this->domain),
				'exp'			=> __('Determines whether to show the post excerpt.', $this->domain)
			),
			'tm_use_wp_excerpt' => array(
				'type'			=> 'check',
				'title'			=> __('WP Excerpt', $this->domain),
				'inputlabel'	=> __('Don\'t use the WP excerpt', $this->domain),
				'shortexp'		=> __('Default: WP Excerpt', $this->domain),
				'exp'			=> __('Determines whether to use the WP excerpt text or use the post content instead. to show the post excerpt.', $this->domain)
			),
			'tm_limit_excerpt' => array(
				'type' 			=> 'count_select',
				'title'			=> __('Excerpt - Words to show', $this->domain),
				'inputlabel'	=> __('Words', $this->domain),
				'shortexp'		=> __('Default: 20', $this->domain),
				'exp'			=> __('In any case, whether you use wp excerpt or the post content, determine how many words you want to display in each box.', $this->domain),
				'count_start'	=> 5,
 				'count_number'	=> 50,
			),
			'tm_latest_read_more' => array(
				'type'			=> 'check',
				'title'			=> __('Show read more', $this->domain),
				'inputlabel'	=> __('Don\'t show the read more', $this->domain),
				'shortexp'		=> __('Default: Visible', $this->domain),
				'exp'			=> __('Determines whether to show the post read more.', $this->domain)
			),

			'tm_latest_read_more_text' => array(
				'type'			=> 'text',
				'title'			=> __('"Read More" text', $this->domain),
				'inputlabel'	=> __('Text to show', $this->domain),
				'shortexp'		=> __('Default: Read More', $this->domain),
				'exp'			=> __('Change the "Read More" text to show in the link.', $this->domain)
			),


			'tm_latest_autostart' => array(
				'type'			=> 'check',
				'title'			=> __('Disable autostart scroll', $this->domain),
				'inputlabel'	=> __('Disable Autostart scroll', $this->domain),
				'shortexp'		=> __('', $this->domain),
				'exp'			=> __('Determines whether the slider auto scroll.', $this->domain)
			),
			'tm_latest_effect' => array(
				'title'			=> 'Transition Effect',
				'type'         	=> 'select',
				'selectvalues' 	=> array(
					'scroll'    => array('name' => __( 'Scroll', $this->domain) ),
					'fade'      => array('name' => __( 'Fade', $this->domain) ),
					'crossfade' => array('name' => __( 'CrossFade', $this->domain) ),
					'cover'     => array('name' => __( 'Cover', $this->domain) ),
					'uncover'   => array('name' => __( 'UnCover', $this->domain) ),
				),
				'inputlabel'   	=> __( 'Select the transition effect', $this->domain ),
				'shortexp' 		=> 'Default value: Scroll',
				'exp'      		=> 'Indicates which effect to use for the transition.'
			),
			'tm_latest_effect_duration' 	=> array(
				'type'			=> 'text',
				'inputlabel'	=> 'Transition Time',
				'title' 		=> 'Transition Time',
				'shortexp'		=> 'Default value: 4 seconds.',
				'exp'			=> 'Determines the duration of the transition in milliseconds. 1000 = 1 second',
			),
			'tm_latest_pause_on_hover' => array(
				'type'			=> 'check',
				'title'			=> __('Pause on hover', $this->domain),
				'inputlabel'	=> __('Pause on hover', $this->domain),
				'shortexp'		=> __('', $this->domain),
				'exp'			=> __('Determines whether the timeout between transitions should be paused "onMouseOver"', $this->domain)
			),
			'tm_latest_duration_pause' 	=> array(
				'type'			=> 'text',
				'inputlabel'	=> 'Pause Duration',
				'title' 		=> 'Pause Duration',
				'shortexp'		=> '',
				'exp'			=> 'The amount of milliseconds the carousel will pause. 1000 = 1 second',
			),


		);

		$settings = array(
			'id' 		=> $this->id.'_meta',
			'name' 		=> $this->name,
			'icon' 		=> $this->icon,
			'clone_id'	=> $settings['clone_id'],
			'active'	=> $settings['active']
		);

		register_metatab($settings, $opt_array);
	}

	function get_posts( $set = null, $limit = null){
		$query                  = array();
		$query['category_name'] = $set;

		if(isset($limit)){
			$query['showposts'] = $limit;
		}

		$q = new WP_Query($query);

		if(is_array($q->posts))
			return $q->posts;
		else
			return array();
	}


	function latest_excerpt($text, $limit) {
		$text = strip_shortcodes( $text );
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]&gt;', $text);
		$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
		$text = wp_trim_words( $text, $limit, $excerpt_more );
		return $text;
	}

} /* End of section class - No closing php tag needed */