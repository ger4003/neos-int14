module.exports = function(grunt) {
	grunt.config.init({
		pkg: grunt.file.readJSON('package.json'),

		files: {
			// All our own sources for linting and code style checking
			src: {
				js: 'Resources/Public/Scripts/Custom/*.js'
			},
			// Individual include definitions for JS and CSS
			includes: {
				js: {
					// Ordered list of internet explorer scripts for header inclusion
					header_ie: [
						'Resources/Public/Scripts/Vendor/jquery.placeholder.js',
						'Resources/Public/Scripts/Vendor/script_ie.js'
					],
					// Ordered list of scripts for footer inclusion
					footer: [
						'Resources/Public/Scripts/Vendor/bootstrap.min.js',
						'Resources/Public/Scripts/Vendor/jquery-ui.min.js',
						'Resources/Public/Scripts/Vendor/jquery.easing.1.3.js',
						'Resources/Public/Scripts/Vendor/jquery.mousewheel.min.js',
						'Resources/Public/Scripts/Vendor/SmoothScroll.min.js',
						'Resources/Public/Scripts/Vendor/prettyphoto/js/jquery.prettyPhoto.js',
						'Resources/Public/Scripts/Vendor/modernizr.js',
						'Resources/Public/Scripts/Vendor/wow.min.js',
						'Resources/Public/Scripts/Vendor/jquery.sharre.min.js',
						'Resources/Public/Scripts/Vendor/jquery.flexslider-min.js',
						'Resources/Public/Scripts/Vendor/jquery.knob.js',
						'Resources/Public/Scripts/Vendor/jquery.mixitup.min.js',
						'Resources/Public/Scripts/Vendor/masonry.min.js',
						'Resources/Public/Scripts/Vendor/jquery.masonry.min.js',
						'Resources/Public/Scripts/Vendor/jquery.fitvids.js',
						'Resources/Public/Scripts/Vendor/perfect-scrollbar-0.4.10.with-mousewheel.min.js',
						'Resources/Public/Scripts/Vendor/jquery.nouislider.min.js',
						'Resources/Public/Scripts/Vendor/jquery.validity.min.js',
						'Resources/Public/Scripts/Vendor/tweetie.min.js',
						'Resources/Public/Scripts/Vendor/script.js',
						'Resources/Public/Scripts/Vendor/rs-plugin/js/jquery.themepunch.enablelog.js',
						'Resources/Public/Scripts/Vendor/rs-plugin/js/jquery.themepunch.revolution.js',
						'Resources/Public/Scripts/Vendor/rs-plugin/js/jquery.themepunch.tools.min.js',
						'Resources/Public/Scripts/Custom/jquery.stagesSlider.js',
						'Resources/Public/Scripts/Custom/main.js'
					]
				},
				css: {
					main: [
						'Resources/Public/Css/Vendor/bootstrap.min.css',
						'Resources/Public/Css/Vendor/fontello.css',
						'Resources/Public/Scripts/Vendor/prettyphoto/css/prettyPhoto.css',
						'Resources/Public/Css/Vendor/animation.css',
						'Resources/Public/Css/Vendor/flexslider.css',
						'Resources/Public/Css/Vendor/perfect-scrollbar-0.4.10.min.css',
						'Resources/Public/Css/Vendor/jquery.validity.css',
						'Resources/Public/Css/Vendor/jquery-ui.min.css',
						'Resources/Public/Css/Vendor/style.css',
						'Resources/Public/Css/Vendor/style.revslider.css',
						'Resources/Public/Scripts/Vendor/rs-plugin/css/settings.css',
						'Resources/Public/Css/Custom/main.css'
					],
					ie: [
						'Resources/Public/Css/Vendor/ie.css'
					]
				}
			}
		}
	});

	grunt.loadTasks('Build/Grunt/Tasks');

	grunt.registerTask('default', ['cssmin', 'uglify']);
	grunt.registerTask('checkstyle', ['jshint', 'jscs']);
	grunt.registerTask('dowatch', ['default', 'concurrent:watch']);
};