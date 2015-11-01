module.exports = function(grunt) {
	grunt.config('jshint', {
		all: ['Gruntfile.js', 'Build/Grunt/Tasks/**/*.js', 'Resources/Public/Scripts/*.js']
	});

	grunt.loadNpmTasks('grunt-contrib-jshint');
};