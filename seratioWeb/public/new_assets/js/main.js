/**
 * main.js
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 *
 * Copyright 2014, Codrops
 * http://www.codrops.com
 */
(function() {

	var support = { animations : Modernizr.cssanimations },
		container = document.getElementById( 'ip-container' ),
		header = container.querySelector( 'header.ip-header' ),
		loader = new PathLoader( document.getElementById( 'ip-loader-circle' ) ),
		animEndEventNames = { 'WebkitAnimation' : 'webkitAnimationEnd', 'OAnimation' : 'oAnimationEnd', 'msAnimation' : 'MSAnimationEnd', 'animation' : 'animationend' },
		// animation end event name
		animEndEventName = animEndEventNames[ Modernizr.prefixed( 'animation' ) ];

	function init() {
		var onEndInitialAnimation = function() {
			if( support.animations ) {
				this.removeEventListener( animEndEventName, onEndInitialAnimation );
			}

			startLoading();
		};

		// disable scrolling
		window.addEventListener( 'scroll', noscroll );

		// initial animation
		classie.add( container, 'loading' );

		if( support.animations ) {
			container.addEventListener( animEndEventName, onEndInitialAnimation );
		}
		else {
			onEndInitialAnimation();

		}
	}

	function startLoading() {
		// simulate loading something..
		var simulationFn = function(instance) {
			var progress = 0,
				interval = setInterval( function() {
					progress = Math.min( progress + Math.random() * 0.1, 1 );

					instance.setProgress( progress );

					// reached the end
					if( progress === 1 ) {
						classie.remove( container, 'loading' );
						classie.add( container, 'loaded' );
						clearInterval( interval );

						var onEndHeaderAnimation = function(ev) {
							if( support.animations ) {
								if( ev.target !== header ) return;
								this.removeEventListener( animEndEventName, onEndHeaderAnimation );
							}
							TweenMax.staggerTo([".onee",".one",".two",".threee",".three",".four",".five",".six",".seven",".sevenn",".sevennn",".eight",".fivee", ".ten", ".pro", ".eu", ".bit", ".block", ".block_demo", ".cceg_block", ".city_block", ".cyber_futures", ".coin1"],0,{ opacity:1,transform:"rotate(45deg)",scale:1,ease:Elastic.easeOut},.15);


							classie.add( document.body, 'layout-switch' );
							window.removeEventListener( 'scroll', noscroll );
	var targetItem = $('.box');
	targetItem.on("mouseenter", function(event) {
	TweenLite.to($(this), 0, {scale:1.1,ease: Elastic.easeOut});
	});

	targetItem.on("mouseleave", function(event) {
	TweenLite.to($(this), 0, {scale:1, ease: Elastic.easeOut});
	});

							/*animation*/
							TweenLite.to(".lineone", 2, { height:"200px", ease:Back.easeOut});
							TweenLite.from(".lineTwo", 2, { height:"0px",opacity:0, ease:Back.easeOut});
							TweenLite.to(".arrow", 2, { bottom:"-380px", ease:Back.easeOut});
							TweenMax.staggerTo([".facebook",".rss",".googlep",".linkedin",".youtube",".twitter", ".tumb", ".instagram", ".blog", ".edu"],1.8,{ right:0,opacity:1,ease: Elastic.easeOut},.20);




						};

						if( support.animations ) {
							header.addEventListener( animEndEventName, onEndHeaderAnimation );
						}
						else {
							onEndHeaderAnimation();
						}
					}
				}, 80 );
		};

		loader.setProgressFn( simulationFn );
	}

	function noscroll() {
		window.scrollTo( 0, 0 );
	}

	init();

});
