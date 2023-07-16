<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
?>
<div <?php echo get_block_wrapper_attributes(); ?>>
	<?php global $embed_post; ?>
	<?php $post = $embed_post->get_embeded_post($attributes); ?>
	<?php if (! empty($post['permalink'])): ?>
		<div onClick="{location.href = '<?= esc_url($post['permalink']) ?>'}">
	<?php else: ?>
		<div>
	<?php endif; ?>
		<img src="<?= esc_url($post['featured_image']); ?>" />	
		<hr class="divider-block-embed-post">
		<div class="text-container-embed-post">
		<div class="categories-block-embed-post">
			<?= esc_html($post['categories']) ?>
		</div>
		<h3 class="title-block-embed-post">
			<?= esc_html($post['title']) ?>
		</h3>
		<p class="excerpt-block-embed-post">
			<?= esc_html($post['excerpt']) ?>
		</p>
		</div>
	</div>
</div>