module.exports = function(grunt) {
	grunt.config('uglify', {
		options: {
			mangle: {
				except: ['jQuery']
			},
			beautify: false,
			report: true
		},

		header: {
			options: {
				sourceMap: true
			},
			files: {
				'Resources/Public/Scripts/app.header.ie.min.js': [
					'<%= files.includes.js.header_ie %>'
				]
			}
		},
		footer: {
			options: {
				sourceMap: true
			},
			files: {
				'Resources/Public/Scripts/app.footer.min.js': [
					'<%= files.includes.js.footer %>'
				]
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-uglify');
};