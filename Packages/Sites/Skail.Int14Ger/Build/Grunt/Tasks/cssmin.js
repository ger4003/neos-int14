module.exports = function(grunt) {
	grunt.config('cssmin', {
		options: {
			shorthandCompacting: false,
			roundingPrecision: -1,
			relativeTo: 'Resources/Public/',
			rebase: true
		},

		target: {
			files: {
				'Resources/Public/Css/app.min.css': [
					'<%= files.includes.css.main %>'
				],
				'Resources/Public/Css/app.ie.min.css': [
					'<%= files.includes.css.ie %>'
				]
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-cssmin');
};