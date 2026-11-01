/* Hala theme — core behaviour (vanilla JS, no dependencies). */
( function () {
	'use strict';

	var d = document;
	var root = d.documentElement;
	var data = window.halaData || {};

	/* ---------- Header: scrolled state + mobile menu ---------- */
	var header = d.getElementById( 'site-header' );
	function onScroll() {
		if ( header ) { header.classList.toggle( 'is-scrolled', window.scrollY > 8 ); }
	}
	onScroll();
	window.addEventListener( 'scroll', onScroll, { passive: true } );

	var toggle = d.querySelector( '.nav-toggle' );
	function setNav( open ) {
		root.classList.toggle( 'nav-open', open );
		d.body.classList.toggle( 'nav-open', open );
		if ( toggle ) { toggle.setAttribute( 'aria-expanded', open ? 'true' : 'false' ); }
	}
	if ( toggle ) {
		toggle.addEventListener( 'click', function () { setNav( ! d.body.classList.contains( 'nav-open' ) ); } );
	}
	d.addEventListener( 'click', function ( e ) {
		if ( e.target.closest( '[data-nav-close]' ) || e.target.closest( '.mobile-menu a' ) ) { setNav( false ); }
		// Close language dropdowns when clicking elsewhere.
		d.querySelectorAll( '.lang-switch[open]' ).forEach( function ( el ) { if ( ! el.contains( e.target ) ) { el.removeAttribute( 'open' ); } } );
	} );
	d.addEventListener( 'keydown', function ( e ) {
		if ( 'Escape' === e.key ) {
			setNav( false );
			d.querySelectorAll( '.lang-switch[open]' ).forEach( function ( el ) { el.removeAttribute( 'open' ); } );
		}
	} );
	window.matchMedia( '(min-width: 1001px)' ).addEventListener( 'change', function ( m ) { if ( m.matches ) { setNav( false ); } } );

	/* ---------- Accordion (keyboard friendly: native buttons) ---------- */
	d.addEventListener( 'click', function ( e ) {
		var q = e.target.closest( '.accordion__q' );
		if ( ! q ) { return; }
		var item = q.closest( '.accordion__item' );
		var acc = q.closest( '.accordion' );
		var open = ! item.classList.contains( 'is-open' );
		acc.querySelectorAll( '.accordion__item.is-open' ).forEach( function ( o ) {
			o.classList.remove( 'is-open' );
			o.querySelector( '.accordion__q' ).setAttribute( 'aria-expanded', 'false' );
		} );
		if ( open ) {
			item.classList.add( 'is-open' );
			q.setAttribute( 'aria-expanded', 'true' );
		}
	} );

	/* FAQ live filter */
	var faqInput = d.querySelector( '[data-faq-filter]' );
	if ( faqInput ) {
		var empty = d.querySelector( '[data-faq-empty]' );
		faqInput.addEventListener( 'input', function () {
			var term = faqInput.value.trim().toLowerCase();
			var shown = 0;
			d.querySelectorAll( '[data-faq-item]' ).forEach( function ( it ) {
				var hit = ! term || it.textContent.toLowerCase().indexOf( term ) > -1;
				it.hidden = ! hit;
				if ( hit ) { shown++; }
			} );
			if ( empty ) { empty.hidden = shown > 0; }
		} );
	}

	/* ---------- Collapsible blocks (coupon) — delegated so AJAX re-renders keep working ---------- */
	d.addEventListener( 'click', function ( e ) {
		var btn = e.target.closest( '.coupon-box__toggle' );
		if ( ! btn ) { return; }
		var panel = d.getElementById( btn.getAttribute( 'aria-controls' ) );
		var open = btn.getAttribute( 'aria-expanded' ) !== 'true';
		btn.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
		btn.closest( '.coupon-box' ).classList.toggle( 'is-open', open );
		if ( panel ) { panel.hidden = ! open; }
	} );

	/* ---------- AJAX forms (contact / newsletter) with graceful no-JS fallback ---------- */
	d.addEventListener( 'submit', function ( e ) {
		var form = e.target.closest( '[data-hala-form]' );
		if ( ! form || ! window.fetch ) { return; }
		e.preventDefault();

		var note = form.parentNode.querySelector( '.form-note' ) || form.querySelector( '.form-note' );
		var btn = form.querySelector( '[type="submit"]' );
		var fd = new FormData( form );
		fd.set( 'action', form.getAttribute( 'data-hala-form' ) );

		form.querySelectorAll( '[aria-invalid]' ).forEach( function ( f ) { f.removeAttribute( 'aria-invalid' ); } );
		var bad = Array.prototype.filter.call( form.querySelectorAll( '[required]' ), function ( f ) { return ! f.checkValidity(); } );
		if ( bad.length ) {
			bad.forEach( function ( f ) { f.setAttribute( 'aria-invalid', 'true' ); } );
			bad[0].focus();
			if ( note ) { note.className = 'form-note is-error'; note.textContent = ( data.i18n || {} ).invalid || ''; }
			return;
		}
		if ( note ) { note.className = 'form-note'; note.textContent = ( data.i18n || {} ).sending || ''; }
		if ( btn ) { btn.classList.add( 'is-loading' ); }

		fetch( data.ajax, { method: 'POST', body: fd, credentials: 'same-origin' } )
			.then( function ( r ) { return r.json().then( function ( j ) { return { ok: r.ok, json: j }; } ); } )
			.then( function ( res ) {
				if ( note ) {
					note.className = 'form-note ' + ( res.ok && res.json.ok ? 'is-ok' : 'is-error' );
					note.textContent = res.json.message || ( ( data.i18n || {} ).error || '' );
				}
				if ( res.ok && res.json.ok ) { form.reset(); }
			} )
			.catch( function () {
				if ( note ) { note.className = 'form-note is-error'; note.textContent = ( data.i18n || {} ).error || ''; }
			} )
			.then( function () { if ( btn ) { btn.classList.remove( 'is-loading' ); } } );
	} );

	/* ---------- Sticky add-to-cart bar (single book) ---------- */
	var sticky = d.querySelector( '[data-sticky-atc]' );
	var hero = d.querySelector( '.book-hero' );
	if ( sticky && hero && 'IntersectionObserver' in window ) {
		new IntersectionObserver( function ( entries ) {
			var visible = entries[0].isIntersecting;
			var past = entries[0].boundingClientRect.bottom < 0;
			var show = ! visible && past;
			sticky.classList.toggle( 'is-visible', show );
			sticky.setAttribute( 'aria-hidden', show ? 'false' : 'true' );
			sticky.querySelectorAll( 'button' ).forEach( function ( b ) { b.tabIndex = show ? 0 : -1; } );
		}, { threshold: 0 } ).observe( hero );
	}
}() );
