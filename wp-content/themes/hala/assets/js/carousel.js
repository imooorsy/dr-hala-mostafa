/* Scroll-snap carousel with prev/next + progress bar. RTL aware. */
( function () {
	'use strict';

	function init( root ) {
		var track = root.querySelector( '.carousel__track' );
		var prev = root.querySelector( '[data-carousel-prev]' );
		var next = root.querySelector( '[data-carousel-next]' );
		var thumb = root.querySelector( '.carousel__thumb' );
		if ( ! track ) { return; }

		function rtl() { return getComputedStyle( track ).direction === 'rtl'; }
		function step() {
			var item = track.querySelector( '.carousel__item' );
			if ( ! item ) { return track.clientWidth; }
			var gap = parseFloat( getComputedStyle( track ).columnGap ) || 0;
			var per = Math.max( 1, Math.floor( track.clientWidth / ( item.offsetWidth + gap ) ) );
			return per * ( item.offsetWidth + gap );
		}
		function update() {
			var max = track.scrollWidth - track.clientWidth;
			var pos = Math.abs( track.scrollLeft );
			var ratio = max > 0 ? pos / max : 0;
			var w = track.scrollWidth > 0 ? Math.min( 1, track.clientWidth / track.scrollWidth ) : 1;
			if ( thumb ) {
				thumb.style.width = ( w * 100 ) + '%';
				thumb.style.insetInlineStart = ( ratio * ( 1 - w ) * 100 ) + '%';
			}
			if ( prev ) { prev.disabled = pos < 4; }
			if ( next ) { next.disabled = pos > max - 4; }
		}
		function go( dir ) {
			track.scrollBy( { left: dir * ( rtl() ? -1 : 1 ) * step(), behavior: 'smooth' } );
		}
		if ( prev ) { prev.addEventListener( 'click', function () { go( -1 ); } ); }
		if ( next ) { next.addEventListener( 'click', function () { go( 1 ); } ); }
		track.addEventListener( 'scroll', function () { window.requestAnimationFrame( update ); }, { passive: true } );
		window.addEventListener( 'resize', update );
		track.addEventListener( 'keydown', function ( e ) {
			if ( 'ArrowLeft' === e.key ) { go( rtl() ? 1 : -1 ); e.preventDefault(); }
			if ( 'ArrowRight' === e.key ) { go( rtl() ? -1 : 1 ); e.preventDefault(); }
		} );
		update();
	}

	document.querySelectorAll( '[data-carousel]' ).forEach( init );
}() );
