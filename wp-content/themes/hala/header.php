<?php
/**
 * Site header.
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;

$brand_name    = hala_opt( 'brand_name', hala_s( 'Hala Mostafa' ) );
$brand_name_en = hala_opt( 'brand_name_en', 'Hala Mostafa' );
$avatar        = hala_opt( 'brand_avatar' );
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#7a2a2e">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#content"><?php hala_e( 'Skip to content' ); ?></a>

<header class="site-header" id="site-header">
	<div class="site-header__inner">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="<?php echo esc_attr( $brand_name . ' — ' . hala_s( 'Home' ) ); ?>">
			<?php echo hala_img( $avatar, 'thumbnail', 'avatar.jpg', array( 'class' => 'brand__avatar', 'width' => 38, 'height' => 38, 'alt' => '', 'loading' => 'eager' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			<span class="brand__text"><span><?php echo esc_html( $brand_name ); ?></span><span><?php echo esc_html( $brand_name_en ); ?></span></span>
		</a>

		<nav class="primary-nav" aria-label="<?php echo esc_attr( hala_s( 'Main menu' ) ); ?>">
			<?php hala_menu( 'primary' ); ?>
		</nav>

		<div class="header-actions">
			<?php echo hala_btn( hala_s( 'Buy the doctor\'s books' ), hala_url( 'shop' ), array( 'class' => 'btn-cta', 'size' => 'sm' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			<?php if ( class_exists( 'WooCommerce' ) ) { echo hala_cart_pill(); } // phpcs:ignore WordPress.Security.EscapeOutput ?>
			<?php hala_lang_switcher( 'toggle' ); ?>
			<button class="nav-toggle" type="button" aria-expanded="false" aria-controls="mobile-menu" aria-label="<?php echo esc_attr( hala_s( 'Menu' ) ); ?>"><span class="nav-toggle__bars"></span></button>
		</div>
	</div>
</header>

<div class="mobile-menu" id="mobile-menu">
	<div class="mobile-menu__backdrop" data-nav-close></div>
	<div class="mobile-menu__panel" role="dialog" aria-modal="true" aria-label="<?php echo esc_attr( hala_s( 'Menu' ) ); ?>">
		<nav aria-label="<?php echo esc_attr( hala_s( 'Main menu' ) ); ?>"><?php hala_menu( 'primary' ); ?></nav>
		<?php echo hala_btn( hala_s( 'Buy the doctor\'s books' ), hala_url( 'shop' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
	</div>
</div>

<main id="content" class="site-main">
