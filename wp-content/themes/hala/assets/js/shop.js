/* Shop helpers: quantity stepper (+/−) and auto-update on the cart page. */
( function () {
	'use strict';

	var timer;

	document.addEventListener( 'click', function ( e ) {
		var btn = e.target.closest( '.qty-btn' );
		if ( ! btn ) { return; }
		e.preventDefault();
		var wrap = btn.closest( '.qty-stepper' );
		var input = wrap && wrap.querySelector( 'input.qty, input[type="number"]' );
		if ( ! input ) { return; }

		var dir = parseInt( btn.getAttribute( 'data-qty-dir' ), 10 ) || 0;
		var min = input.min !== '' ? parseFloat( input.min ) : 0;
		var max = input.max !== '' ? parseFloat( input.max ) : Infinity;
		var step = parseFloat( input.step ) || 1;
		var val = ( parseFloat( input.value ) || 0 ) + dir * step;
		val = Math.max( min, Math.min( max, val ) );
		// On the single-book page quantity can never be zero.
		if ( ! btn.closest( '.woocommerce-cart-form' ) ) { val = Math.max( 1, val ); }
		if ( String( val ) === input.value ) { return; }
		input.value = val;
		input.dispatchEvent( new Event( 'input', { bubbles: true } ) );
		input.dispatchEvent( new Event( 'change', { bubbles: true } ) );

		var cartForm = btn.closest( '.woocommerce-cart-form' );
		if ( cartForm ) {
			clearTimeout( timer );
			timer = setTimeout( function () {
				var update = cartForm.querySelector( '[name="update_cart"]' );
				if ( update ) {
					update.disabled = false;
					update.removeAttribute( 'aria-disabled' );
					update.click();
				}
			}, 450 );
		}
	} );
}() );
