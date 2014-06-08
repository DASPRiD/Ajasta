module.exports = function(grunt) {
    grunt.initConfig({
        copy: {
            main: {
                files: [
                    {
                        expand: true,
                        cwd: './bower_components/bootstrap/fonts',
                        src: '**',
                        dest: './public/assets/fonts/',
                        flatten: true,
                        filter: 'isFile'
                    },
                    {
                        expand: true,
                        cwd: './bower_components/bootstrap-chosen',
                        src: 'chosen-sprite.png',
                        dest: './public/assets/stylesheets/'
                    },
                    {
                        expand: true,
                        cwd: './bower_components/datatables/examples/resources/bootstrap/images',
                        src: '**',
                        dest: './public/assets/images/'
                    }
                ]
            }
        },
        less: {
            development: {
                options: {
                    compress: true
                },
                files: {
                    './public/assets/stylesheets/main.css': './assets/stylesheets/main.less'
                }
            }
        },
        concat: {
            options: {
                separator: ';',
                stripBanners: true
            },
            main: {
                src: [
                    './bower_components/jquery/dist/jquery.js',
                    './bower_components/jquery-ui/ui/jquery.ui.core.js',
                    './bower_components/jquery-ui/ui/jquery.ui.widget.js',
                    './bower_components/jquery-ui/ui/jquery.ui.mouse.js',
                    './bower_components/jquery-ui/ui/jquery.ui.sortable.js',
                    './bower_components/bootstrap/dist/js/bootstrap.js',
                    './bower_components/datatables/media/js/jquery.dataTables.js',
                    './bower_components/datatables/examples/resources/bootstrap/3/dataTables.bootstrap.js',
                    './bower_components/chosen/chosen.jquery.js',
                    './bower_components/bootstrap-switch/dist/js/bootstrap-switch.js',
                    './bower_components/momentjs/min/moment-with-langs.js',
                    './bower_components/Bootstrap-DatePicker/bootstrap-datepicker.js',
                    './assets/javascript/main.js'
                ],
                dest: './public/assets/javascript/main.js'
            }
        },
        uglify: {
            options: {
                mangle: false
            },
            main: {
                files: {
                    './public/assets/javascript/main.js': './public/assets/javascript/main.js'
                }
            }
        },
        watch: {
            main: {
                files: [
                    './bower_components/jquery/jquery.js',
                    './bower_components/jquery-ui/ui/jquery-ui.js',
                    './bower_components/bootstrap/dist/js/bootstrap.js',
                    './bower_components/Bootstrap-DatePicker/bootstrap-datepicker.js',
                    './bower_components/boostrap-switch/dist/js/bootstrap-switch.js',
                    './bower_components/chosen/coffee/chosen.jquery.coffee',
                    './bower_components/datatables/media/js/jquery.dataTables.js',
                    './bower_components/momentjs/moment.js',
                    './assets/javascript/main.js'
                ],
                tasks: ['concat:main','uglify:main']
            },
            less: {
                files: ['./assets/stylesheets/*.less'],
                tasks: ['less']
            }
        }
    });

    // Plugin loading
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-uglify');

    // Task definition
    grunt.registerTask('default', ['watch']);
};
