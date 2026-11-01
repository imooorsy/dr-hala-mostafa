/* AJAX category filter + pagination for the books grid and the blog grid. Falls back to normal links. */
( function () {
	'use strict';

	var tabs = document.querySelector( '[data-filter-tabs]' );
	var grid = document.querySelector( '[data-filter-grid]' );
	var pag = document.querySelector( '[data-filter-pagination]' );
	var data = window.halaData || {};
	if ( ! tabs || ! grid || ! window.fetch ) { return; }

	var type = tabs.getAttribute( 'data-filter-type' ) || 'post';
	var term = ( tabs.querySelector( '.is-active' ) || {} ).getAttribute ? tabs.querySelector( '.is-active' ).getAttribute( 'data-term' ) || '' : '';
	var busy = false;

	function pageOf( href ) {
		var m = /page[\/-](\d+)/.exec( href ) || /[?&]paged=(\d+)/.exec( href ) || /#page-(\d+)/.exec( href );
		return m ? parseInt( m[1], 10 ) : 1;
	}

	function load( paged ) {
		if ( busy ) { return; }
		busy = true;
		grid.classList.add( 'is-loading-grid' );
		var fd = new FormData();
		fd.append( 'action', 'hala_filter' );
		fd.append( 'nonce', data.nonce );
		fd.append( 'type', type );
		fd.append( 'term', term );
		fd.append( 'paged', paged );
		fd.append( 'lang', data.lang || '' );
		fetch( data.ajax, { method: 'POST', body: fd, credentials: 'same-origin' } )
			.then( function ( r ) { return r.json(); } )
			.then( function ( res ) {
				if ( ! res.success ) { throw new Error( 'bad' ); }
				grid.innerHTML = res.data.html;
				if ( pag ) { pag.innerHTML = res.data.pagination; }
				var top = grid.getBoundingClientRect().top + window.scrollY - 140;
				if ( paged > 1 || window.scrollY > top + 400 ) { window.scrollTo( { top: top, behavior: 'smooth' } ); }
			} )
			.catch( function () { window.location.reload(); } )
			.then( function () { busy = false; grid.classList.remove( 'is-loading-grid' ); } );
	}

	tabs.addEventListener( 'click', function ( e ) {
		var a = e.target.closest( 'a[data-term]' );
		if ( ! a ) { return; }
		e.preventDefault();
		tabs.querySelectorAll( 'a' ).forEach( function ( t ) {
			var on = t === a;
			t.classList.toggle( 'is-active', on );
			t.setAttribute( 'aria-selected', on ? 'true' : 'false' );
		} );
		term = a.getAttribute( 'data-term' ) || '';
		load( 1 );
	} );

	if ( pag ) {
		pag.addEventListener( 'click', function ( e ) {
			var a = e.target.closest( 'a.page-numbers' );
			if ( ! a ) { return; }
			e.preventDefault();
			load( pageOf( a.getAttribute( 'href' ) ) );
		} );
	}
}() );
