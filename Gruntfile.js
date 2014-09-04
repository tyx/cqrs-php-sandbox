module.exports = function (grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        bowercopy: {
            options: {
                srcPrefix: 'bower_components',
                destPrefix: 'web/assets'
            },
            scripts: {
                files: {
                    'js/semantic.js': 'semantic-ui/build/packaged/javascript/semantic.min.js'
                }
            },
            stylesheets: {
                files: {
                    'css/semantic.css': 'semantic-ui/build/packaged/css/semantic.min.css'
                }
            },
            fonts: {
                files: {
                    'fonts': 'semantic-ui/build/packaged/fonts'
                }
            }
        }
    });
    grunt.loadNpmTasks('grunt-bowercopy');
    grunt.registerTask('default', ['bowercopy']);
};
