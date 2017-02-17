module.exports = function(grunt) {
	// Project configuration.
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		uglify: {
			options: {
				compress: {
					drop_console: true
				},
				preserveComments: 'some'
			},
			default: {
				files: {
					'bootstrap-notify.min.js': ['remarkable-bootstrap-notify.js']
				}
			}
		},
		jshint: {
			options: {
				jshintrc: 'jshintrc.json'
			},
			default: {
				src: 'remarkable-bootstrap-notify.js'
			}
		},
		exec: {
			'meteor-test': 'node_modules/.bin/spacejam test-packages ./'
		}
	});

	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-exec');

	grunt.registerTask('test', ['jshint', 'exec:meteor-test']);
	grunt.registerTask('default', ['uglify']);
};
