(function() {
				var pageWrap = document.getElementById( 'pagewrap' ),
					pages = [].slice.call( pageWrap.querySelectorAll( 'div.containerr' ) ),
					currentPage = 0,
					triggerLoading = [].slice.call( pageWrap.querySelectorAll( 'a.pageload-link' ) ),
					loader = new SVGLoader( document.getElementById( 'loader' ), { speedIn : 400, easingIn : mina.easeinout } );

				function init() {
					triggerLoading.forEach( function( trigger ) {
						trigger.addEventListener( 'click', function( ev ) {
							ev.preventDefault();
							loader.show();

							// after some time hide loader
							var url = $(this).attr('href');

							setTimeout( function() {
								loader.hide();
								$('.containerr').removeClass('show');
								$(url).addClass('show');
								$(document).scrollTop(0);
								//classie.removeClass( pages[ currentPage ], 'show' );
								// update..
								//currentPage = currentPage ? 0 : 1;
								//classie.addClass( pages[ currentPage ], 'show' );

							}, 2000 );
						} );
					} );
				}

				init();
			})();
