

			 <!-- Cái này Script để chạy cái drop down - xem CSS á -->
				$(document).ready(function(){
			
					var userMenu = $('.header-user-dropdown .header-user-menu');
			
					userMenu.on('touchend', function(e){
			
						userMenu.addClass('show');
			
						e.preventDefault();
						e.stopPropagation();
			
					});
			 <!-- Hết Script -->
			
					// This code makes the user dropdown work on mobile devices
			
					$(document).on('touchend', function(e){
			
						// If the page is touched anywhere outside the user menu, close it
						userMenu.removeClass('show');
			
					});
			
				});
