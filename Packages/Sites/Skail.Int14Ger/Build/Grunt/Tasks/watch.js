module.exports = function(grunt) {
	grunt.config('watch', {
		scripts: {
			files: ['<%= files.includes.js.header_ie %>', '<%= files.includes.js.footer %>'],
			tasks: ['uglify'],
			options: {
				spawn: false
			}
		},
		stylesheets: {
			files: ['<%= files.includes.css.main %>', '<%= files.includes.css.ie %>'],
			tasks: ['cssmin'],
			options: {
				spawn: false
			}
		}
	});

	grunt.config('concurrent', {
		// Can be called with "concurrent:watch"
		watch: {
			// The Grunt watcher for scripts and the Compass watcher are started concurrently
			tasks: ['watch:scripts', 'watch:stylesheets'],
			options: {
				logConcurrentOutput: true
			}
		}
	});


	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-concurrent');
};