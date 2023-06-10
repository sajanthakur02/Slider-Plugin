# Slider-Plugin
I created a slider without install plugin. I created a own plugin and do some custom code for slider 
Create a short code

inside of custom-slider.php
#slider Code
function slider() {
	$sliderValue = get_option('custom_slider_1');
	$slides = explode(',', $sliderValue); ?>
	<header class="intro">
	<div class="intro-slideshow">
	<?php foreach ($slides as $slide) {  
		$imageUrl = wp_get_attachment_image_url($slide, $size = 'thumbnail'); ?>
		<img src=<?= "'$imageUrl'" ?> alt="" width="300" height="300" class="alignnone size-full wp-image-538" />
<?php } ?>
</div>
</header>
<?php }
add_shortcode('custom_slider', 'slider');
