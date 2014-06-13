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
                    './bower_components/bootstrap-datepicker-dasprid/bootstrap-datepicker.js',
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
                    './bower_components/bootstrap-datepicker-dasprid/bootstrap-datepicker.js',
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
        },
        phplint: {
            all: [
                'config/**/*.php{,.dist}',
                'module/**/*.{php,phtml}'
            ]
        },
        phpcs: {
            all: {
                dir: ['config', 'module']
            },
            options: {
                bin: 'vendor/bin/phpcs',
                standard: 'psr2',
                encoding: 'utf-8',
                extensions: 'php'
            }
        },
        phpunit: {
            AjastaAddress: {
                dir: 'module/AjastaAddress',
                configuration: 'module/AjastaAddress/phpunit.xml.dist'
            },
            options: {
                bin: 'vendor/bin/phpunit'
            }
        },
        jslint: {
            client: {
                src: [
                    'assets/javascript/**/*.js'
                ],
                directives: {
                    browser: true,
                    predef: [
                        'jQuery'
                    ],
                    unparam: true
                }
            }
        },
        mkdir: {
            build: {
                options: {
                    create: [
                        'build/coverage',
                        'build/logs'
                    ]
                }
            }
        }
    });

    // Plugin loading
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-mkdir');
    grunt.loadNpmTasks('grunt-phpcs');
    grunt.loadNpmTasks("grunt-phplint");
    grunt.loadNpmTasks('grunt-phpunit');
    grunt.loadNpmTasks('grunt-jslint');

    // Task definition
    grunt.registerTask('default', ['watch']);
    grunt.registerTask('compile', ['copy', 'less', 'concat', 'uglify']);
    grunt.registerTask('test', function (env) {
        if (env === 'ci') {
            // In CI, we want to collect coverage reports
            grunt.task.run(['mkdir:build']);

            var phpunitConfig = grunt.config.get('phpunit');

            for (var property in phpunitConfig) {
                if (property === 'options') {
                    continue;
                }

                phpunitConfig[property].coveragePhp = 'build/coverage/' + property + '.cov';
            }

            grunt.config.set('phpunit', phpunitConfig)
        }

        grunt.task.run(['phplint', 'phpcs', 'phpunit', 'jslint']);
    });
};
