module.exports = function(grunt) {
    grunt.loadNpmTasks('grunt-postcss');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.initConfig({
        postcss: {
            options: {
                map: true,
                processors: [
                    require('autoprefixer')({
                        browsers: ['last 2 versions']
                    })
                ]
            },
            dist: {
                src: 'blocks/dynamic_images/css/*.css'
            }
        },
        sass: {
            dist: {
                files: {
                    'blocks/dynamic_images/css/view.css': 'src/view.scss',
                    'blocks/dynamic_images/form.css': 'src/form.scss'
                }
            }
        },
        watch: {
            src: {
                files: ['src/view.scss','src/form.scss'],
                tasks: ['default'],
            },
        },
    });

    grunt.registerTask('default', ['postcss:dist'], ['sass']);
};
