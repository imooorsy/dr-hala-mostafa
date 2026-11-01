<?php
/**
 * Single book.
 *
 * @package hala
 * @version 1.6.4
 */

defined( 'ABSPATH' ) || exit;
get_header( 'shop' );

while ( have_posts() ) :
	the_post();
	global $product;
	$product = wc_get_product( get_the_ID() );
	$pid     = get_the_ID();
	$kind    = hala_book_kind( $pid );

	$eyebrow  = hala_f( 'eyebrow', $pid );
	$inc_t    = hala_f( 'includes_title', $pid );
	$includes = hala_f( 'includes', $pid );
	$why_t    = hala_f( 'why_title', $pid );
	$why_i    = hala_f( 'why_items', $pid );
	$why_art  = hala_f( 'why_art', $pid );
	$faqs     = array();
	foreach ( (array) hala_f( 'faqs', $pid, array() ) as $row ) {
		$faqs[] = array( 'q' => $row['q'], 'a' => $row['a'] );
	}
	?>
<div class="product-page">
	<?php wc_print_notices(); ?>
	<section class="book-hero">
		<div class="container book-hero__grid">
			<div class="book-hero__info">
				<?php if ( $eyebrow ) : ?><span class="eyebrow eyebrow--link"><?php echo esc_html( $eyebrow ); ?></span><?php endif; ?>
				<h1><?php the_title(); ?></h1>
				<div class="book-hero__desc"><?php echo wp_kses_post( wpautop( has_excerpt() ? get_the_excerpt() : wp_trim_words( wp_strip_all_tags( get_the_content() ), 70 ) ) ); ?></div>
				<div class="book-hero__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
				<?php if ( $product->is_purchasable() && $product->is_in_stock() ) : ?>
					<form class="cart book-hero__buy" id="hala-atc" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype="multipart/form-data">
						<?php
						woocommerce_quantity_input(
							array(
								'min_value'   => 1,
								'max_value'   => $product->is_sold_individually() ? 1 : $product->get_max_purchase_quantity(),
								'input_value' => 1,
								'product_name' => $product->get_name(),
							)
						);
						?>
						<button type="submit" name="add-to-cart" value="<?php echo esc_attr( (string) $product->get_id() ); ?>" class="btn btn--primary btn--atc"><span class="btn__label"><?php hala_e( 'Add to cart' ); ?></span><span class="btn__icon" aria-hidden="true"><?php echo hala_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span></button>
					</form>
				<?php else : ?>
					<p class="badge"><?php hala_e( 'Currently unavailable' ); ?></p>
				<?php endif; ?>
			</div>
			<div class="book-hero__cover"><?php echo hala_cover( $pid, 'large', 'eager' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
		</div>
	</section>

	<section class="section book-body">
		<div class="container container--narrow">
			<div class="prose"><?php the_content(); ?></div>

			<?php if ( $includes ) : ?>
				<h2 class="book-includes__title"><?php echo esc_html( $inc_t ? $inc_t : hala_s( 'What you will find inside the complete reference:' ) ); ?></h2>
				<div class="prose book-includes"><?php echo wp_kses_post( $includes ); ?></div>
			<?php endif; ?>
		</div>
	</section>

	<?php if ( $why_t || $why_i ) : ?>
	<section class="section section--tight">
		<div class="container">
			<div class="cta-panel cta-panel--why">
				<div class="cta-panel__body">
					<?php if ( $why_t ) : ?><h2><?php echo esc_html( $why_t ); ?></h2><?php endif; ?>
					<ul class="check-list">
						<?php foreach ( preg_split( '/\r\n|\r|\n/', trim( (string) $why_i ) ) as $li ) : ?>
							<?php if ( '' !== trim( $li ) ) : ?><li><?php echo esc_html( $li ); ?></li><?php endif; ?>
						<?php endforeach; ?>
					</ul>
				</div>
				<div class="cta-panel__art" aria-hidden="true"><?php echo hala_img( $why_art, 'large', 'blob.png', array( 'alt' => '' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( $faqs ) : ?>
	<section class="section faq-section" aria-labelledby="book-faq">
		<div class="container container--narrow">
			<h2 id="book-faq" class="faq-title"><?php hala_e( 'Frequently asked questions:' ); ?></h2>
			<?php get_template_part( 'template-parts/accordion', null, array( 'items' => $faqs, 'id' => 'bfaq' ) ); ?>
		</div>
	</section>
	<?php endif; ?>

	<?php
	$hala_rel = new WP_Query(
		array(
			'lang' => hala_lang(), 'post_type'      => 'product',
			'posts_per_page' => 6,
			'post__not_in'   => array( $pid ),
			'no_found_rows'  => true,
		)
	);
	if ( $hala_rel->have_posts() ) :
		?>
	<section class="section related-books" aria-labelledby="rel-books">
		<div class="container">
			<div class="section-head"><h2 id="rel-books" class="section-title"><?php echo hala_hl( hala_s( 'Similar *books*' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2></div>
			<div class="carousel" data-carousel>
				<div class="carousel__track" tabindex="0" aria-label="<?php echo esc_attr( hala_s( 'Similar books' ) ); ?>">
					<?php
					while ( $hala_rel->have_posts() ) :
						$hala_rel->the_post();
						?>
						<div class="carousel__item"><?php get_template_part( 'template-parts/card', 'book' ); ?></div>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>
				<?php get_template_part( 'template-parts/carousel-controls' ); ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php get_template_part( 'template-parts/newsletter-cta' ); ?>

	<?php if ( $product->is_purchasable() && $product->is_in_stock() ) : ?>
	<div class="sticky-atc" data-sticky-atc aria-hidden="true">
		<div class="sticky-atc__inner">
			<span class="sticky-atc__thumb"><?php echo hala_cover( $pid, 'hala-thumb' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
			<div class="sticky-atc__info"><strong><?php the_title(); ?></strong><span class="sticky-atc__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span></div>
			<button type="submit" form="hala-atc" name="add-to-cart" value="<?php echo esc_attr( (string) $product->get_id() ); ?>" class="btn btn--primary" tabindex="-1"><span class="btn__label"><?php hala_e( 'Add to cart' ); ?></span><span class="btn__icon" aria-hidden="true"><?php echo hala_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span></button>
		</div>
	</div>
	<?php endif; ?>
</div>
	<?php
endwhile;

get_footer( 'shop' );
