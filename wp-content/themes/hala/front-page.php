<?php
/**
 * Template Name: Home
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;
get_header();

$pid = get_the_ID();
$f   = static function ( string $name, $default = '' ) use ( $pid ) {
	return hala_f( $name, $pid, $default );
};
?>

<?php if ( hala_on( 'hero_on', $pid ) ) : ?>
<section class="home-hero" aria-labelledby="hero-title">
	<div class="container home-hero__grid">
		<div class="home-hero__text">
			<span class="eyebrow"><?php echo esc_html( $f( 'hero_eyebrow', hala_s( 'About the doctor' ) ) ); ?></span>
			<h1 id="hero-title"><?php echo hala_hl( $f( 'hero_title', hala_s( "Between the precision of *medicine* and the majesty of the word\nA journey in anaesthesia and literary creativity" ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h1>
			<p class="home-hero__lead"><?php echo esc_html( $f( 'hero_text', hala_s( 'Professor of Anaesthesia at Kasr Al Ainy Faculty of Medicine, Cairo University; physician, researcher and author, combining precise clinical care in critically ill patients with scientific enrichment and contemporary literature.' ) ) ); ?></p>
			<div class="btn-row">
				<?php echo hala_btn( $f( 'hero_btn_label', hala_s( 'More about the doctor' ) ), $f( 'hero_btn_url', hala_url( 'about' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
				<?php echo hala_link_arrow( $f( 'hero_btn2_label', hala_s( 'Scientific & literary books' ) ), $f( 'hero_btn2_url', hala_url( 'shop' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			</div>
		</div>
		<figure class="home-hero__portrait">
			<?php echo hala_img( $f( 'hero_image' ), 'hala-portrait', 'portrait.jpg', array( 'alt' => esc_attr( hala_s( 'Dr. Hala Mostafa Gomaa' ) ), 'loading' => 'eager', 'fetchpriority' => 'high' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			<figcaption><span class="dot" aria-hidden="true"></span><?php echo esc_html( $f( 'hero_badge', hala_s( 'Dr. Hala Mostafa Gomaa' ) ) ); ?></figcaption>
		</figure>
	</div>
</section>
<?php endif; ?>

<?php
if ( hala_on( 'exp_on', $pid ) ) :
	$cards = $f( 'exp_cards', array() );
	if ( ! $cards ) {
		$cards = array(
			array( 'title' => hala_s( 'Medicine & academia' ), 'tone' => 'burgundy', 'items' => hala_s( "Specialist teaching for undergraduate, postgraduate and master's students at Kasr Al Ainy.\nSupervising MD and MSc theses in anaesthesia and critical care." ) ),
			array( 'title' => hala_s( 'Publications & international publishing' ), 'tone' => 'burgundy', 'items' => hala_s( "Peer-reviewed research in journals such as Egyptian Journal of Anaesthesia.\nBook chapters in international medical references such as InTechOpen.\n19+ international peer-reviewed chapters." ) ),
			array( 'title' => hala_s( 'Pen & literary creativity' ), 'tone' => 'gold', 'items' => hala_s( "Writings that combine the human dimension of medicine with historical vision.\nArticles and essays that bring science closer to the reader." ) ),
		);
	}
	?>
<section class="section home-expertise" aria-labelledby="exp-title">
	<div class="container home-expertise__grid">
		<div class="home-expertise__intro">
			<h2 id="exp-title"><?php echo hala_hl( $f( 'exp_title', hala_s( '*Areas* of expertise and experience' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
			<p><?php echo esc_html( $f( 'exp_text', hala_s( 'A career spanning university hospitals and the clinical bedside, combining precision in practice, depth in academic research and the elegance of authorship: to offer lasting contributions that serve generations of physicians and enrich the scientific and literary library.' ) ) ); ?></p>
			<div class="btn-row">
				<?php echo hala_btn( $f( 'exp_btn_label', hala_s( 'Buy the books of Dr. Hala Mostafa' ) ), $f( 'exp_btn_url', hala_url( 'shop' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
				<?php echo hala_link_arrow( $f( 'exp_btn2_label', hala_s( 'Scientific research' ) ), $f( 'exp_btn2_url', hala_url( 'research' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			</div>
		</div>
		<div class="home-expertise__cards">
			<?php foreach ( $cards as $c ) : ?>
				<article class="exp-card exp-card--<?php echo esc_attr( $c['tone'] ?? 'burgundy' ); ?>">
					<h3><?php echo esc_html( $c['title'] ); ?></h3>
					<ul>
						<?php foreach ( preg_split( '/\r\n|\r|\n/', trim( (string) $c['items'] ) ) as $li ) : ?>
							<?php if ( '' !== trim( $li ) ) : ?><li><?php echo esc_html( $li ); ?></li><?php endif; ?>
						<?php endforeach; ?>
					</ul>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php
if ( hala_on( 'books_on', $pid ) && class_exists( 'WooCommerce' ) ) :
	$pick = $f( 'books_pick', array() );
	$args = array( 'post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => (int) $f( 'books_count', 8 ), 'no_found_rows' => true );
	if ( $pick ) {
		$args['post__in'] = $pick;
		$args['orderby']  = 'post__in';
	}
	$books = new WP_Query( $args );
	if ( $books->have_posts() ) :
		?>
<section class="section home-books" aria-labelledby="books-title">
	<div class="container">
		<div class="section-head">
			<span class="eyebrow"><?php echo esc_html( $f( 'books_eyebrow', hala_s( 'Library & publications' ) ) ); ?></span>
			<h2 id="books-title" class="section-title"><?php echo hala_hl( $f( 'books_title', hala_s( 'Literary and medical *books*' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
			<p class="section-lead"><?php echo esc_html( $f( 'books_text', hala_s( 'A complete library of publications documenting a career of giving at Kasr Al Ainy and beyond.' ) ) ); ?></p>
			<?php echo hala_btn( $f( 'books_btn_label', hala_s( 'View all books' ) ), $f( 'books_btn_url', hala_url( 'shop' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		</div>
		<div class="carousel carousel--4" data-carousel>
			<div class="carousel__track" tabindex="0" aria-label="<?php echo esc_attr( hala_s( 'Books' ) ); ?>">
				<?php
				while ( $books->have_posts() ) :
					$books->the_post();
					?>
					<div class="carousel__item"><?php get_template_part( 'template-parts/card', 'book' ); ?></div>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
			<?php get_template_part( 'template-parts/carousel-controls' ); ?>
		</div>
	</div>
</section>
	<?php endif; ?>
<?php endif; ?>

<?php if ( hala_on( 'ann_on', $pid ) ) : ?>
<section class="section section--tight cta-section" aria-label="<?php echo esc_attr( hala_s( 'Featured book' ) ); ?>">
	<div class="container">
		<div class="cta-panel cta-panel--announce">
			<div class="cta-panel__body">
				<h2><?php echo esc_html( $f( 'ann_text', hala_s( 'With deep joy and gratitude to God, I present my third book in the field of extracorporeal life support (ECMO)' ) ) ); ?></h2>
				<?php echo hala_btn( $f( 'ann_btn_label', hala_s( 'Get your copy' ) ), $f( 'ann_btn_url', hala_url( 'shop' ) ), array( 'variant' => 'light' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			</div>
			<div class="cta-panel__art" aria-hidden="true"><?php echo hala_img( $f( 'ann_art' ), 'large', 'ecmo.png', array( 'alt' => '' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
		</div>
	</div>
</section>
<?php endif; ?>

<?php
if ( hala_on( 'res_on', $pid ) ) :
	$pick = $f( 'res_pick', array() );
	$args = array( 'post_type' => 'hala_research', 'post_status' => 'publish', 'posts_per_page' => (int) $f( 'res_count', 4 ), 'no_found_rows' => true );
	if ( $pick ) {
		$args['post__in'] = $pick;
		$args['orderby']  = 'post__in';
	}
	$res = new WP_Query( $args );
	if ( $res->have_posts() ) :
		?>
<section class="section home-research" aria-labelledby="res-title">
	<div class="container">
		<div class="section-head">
			<?php if ( $f( 'res_eyebrow', '' ) ) : ?><span class="eyebrow"><?php echo esc_html( $f( 'res_eyebrow' ) ); ?></span><?php endif; ?>
			<h2 id="res-title" class="section-title"><?php echo hala_hl( $f( 'res_title', hala_s( 'Research and *scientific publishing*' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
			<p class="section-lead"><?php echo esc_html( $f( 'res_text', hala_s( 'Advanced scientific documentation and research reviews that enrich the medical library and equip practitioners with the latest clinical evidence' ) ) ); ?></p>
			<?php echo hala_btn( $f( 'res_btn_label', hala_s( 'View more research' ) ), $f( 'res_btn_url', hala_url( 'research' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		</div>
		<div class="grid grid--2">
			<?php
			while ( $res->have_posts() ) :
				$res->the_post();
				?>
				<div class="grid-item"><?php get_template_part( 'template-parts/card', 'research' ); ?></div>
			<?php endwhile; wp_reset_postdata(); ?>
		</div>
	</div>
</section>
	<?php endif; ?>
<?php endif; ?>

<?php
if ( hala_on( 'art_on', $pid ) ) :
	$arts = new WP_Query( array( 'lang' => hala_lang(), 'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => (int) $f( 'art_count', 6 ), 'no_found_rows' => true, 'ignore_sticky_posts' => true ) );
	if ( $arts->have_posts() ) :
		?>
<section class="section home-articles" aria-labelledby="art-title">
	<div class="container">
		<div class="section-head">
			<span class="eyebrow"><?php echo esc_html( $f( 'art_eyebrow', hala_s( 'The blog' ) ) ); ?></span>
			<h2 id="art-title" class="section-title"><?php echo hala_hl( $f( 'art_title', hala_s( 'Insights between the realm of medicine and the depth of *history*' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
			<p class="section-lead"><?php echo esc_html( $f( 'art_text', hala_s( 'An intellectual space where medical precision, advances in care and the charm of historical tales meet.' ) ) ); ?></p>
			<?php echo hala_btn( $f( 'art_btn_label', hala_s( 'View more' ) ), $f( 'art_btn_url', hala_url( 'blog' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		</div>
		<div class="carousel" data-carousel>
			<div class="carousel__track" tabindex="0" aria-label="<?php echo esc_attr( hala_s( 'Latest articles' ) ); ?>">
				<?php
				while ( $arts->have_posts() ) :
					$arts->the_post();
					?>
					<div class="carousel__item"><?php get_template_part( 'template-parts/card', 'post' ); ?></div>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
			<?php get_template_part( 'template-parts/carousel-controls' ); ?>
		</div>
	</div>
</section>
	<?php endif; ?>
<?php endif; ?>

<?php if ( hala_on( 'vis_on', $pid ) ) : ?>
<section class="section section--tight home-vision" aria-labelledby="vis-title">
	<div class="container">
		<div class="vision-panel">
			<div class="vision-panel__photo"><?php echo hala_img( $f( 'vis_image' ), 'hala-portrait', 'portrait-2.jpg', array( 'alt' => '' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
			<div class="vision-panel__body">
				<span class="eyebrow"><?php echo esc_html( $f( 'vis_eyebrow', hala_s( 'Literary creativity beyond the limits of medicine' ) ) ); ?></span>
				<h2 id="vis-title"><?php echo hala_hl( $f( 'vis_title', hala_s( 'My vision: safety that reassures hearts.. and knowledge that lights the future' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
				<p><?php echo esc_html( $f( 'vis_text', hala_s( 'I believe medicine is not only a science but a message of mercy, and that the written word is a lasting extension of that message. Between the operating theatre and the page, I seek to build bridges of knowledge for physicians and readers alike.' ) ) ); ?></p>
				<?php echo hala_btn( $f( 'vis_btn_label', hala_s( 'Go to the main page' ) ), $f( 'vis_btn_url', hala_url( 'about' ) ), array( 'variant' => 'light' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			</div>
			<div class="vision-panel__art" aria-hidden="true"><?php echo hala_img( $f( 'vis_art' ), 'large', 'tablet.png', array( 'alt' => '' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
		</div>
	</div>
</section>
<?php endif; ?>

<?php
if ( hala_on( 'bcta_on', $pid ) ) {
	get_template_part( 'template-parts/book-cta' );
}
if ( hala_on( 'nl_on', $pid ) ) {
	get_template_part( 'template-parts/newsletter-cta' );
}

get_footer();
