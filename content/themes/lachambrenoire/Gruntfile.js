'use strict';
module.exports = function(grunt) {
  // Load all tasks
  require('load-grunt-tasks')(grunt);
  // Show elapsed time
  require('time-grunt')(grunt);

  var appConfig = {
    app: 'assets/src',
    dev: 'assets/build/dev',
    prod: 'assets/build/prod',
    vendors: 'assets/vendor'
  };
  // List of vendors/lib
  var vendorList = [
    '<%= config.vendors %>/bootstrap-sass-official/assets/javascripts/bootstrap/transition.js',
    '<%= config.vendors %>/bootstrap-sass-official/assets/javascripts/bootstrap/alert.js',
    '<%= config.vendors %>/bootstrap-sass-official/assets/javascripts/bootstrap/button.js',
    '<%= config.vendors %>/bootstrap-sass-official/assets/javascripts/bootstrap/carousel.js',
    '<%= config.vendors %>/bootstrap-sass-official/assets/javascripts/bootstrap/collapse.js',
    '<%= config.vendors %>/bootstrap-sass-official/assets/javascripts/bootstrap/dropdown.js',
    '<%= config.vendors %>/bootstrap-sass-official/assets/javascripts/bootstrap/modal.js',
    '<%= config.vendors %>/bootstrap-sass-official/assets/javascripts/bootstrap/tooltip.js',
    '<%= config.vendors %>/bootstrap-sass-official/assets/javascripts/bootstrap/popover.js',
    '<%= config.vendors %>/bootstrap-sass-official/assets/javascripts/bootstrap/scrollspy.js',
    '<%= config.vendors %>/bootstrap-sass-official/assets/javascripts/bootstrap/tab.js',
    '<%= config.vendors %>/bootstrap-sass-official/assets/javascripts/bootstrap/affix.js',
    '<%= config.vendors %>/gsap/src/minified/TweenMax.min.js',
    '<%= config.vendors %>/gsap/src/minified/TimelineMax.min.js',
    '<%= config.vendors %>/masonry/dist/masonry.pkgd.js',
    '<%= config.vendors %>/modernizr/modernizr.js',
    appConfig.app+'/js/lib/*.js'
  ];
  // What we coded
  var jsAppList = [
    appConfig.app+'/js/partials/config.js',
    appConfig.app+'/js/partials/helpers.js',
    appConfig.app+'/js/partials/*.js',
    '!'+appConfig.app+'/js/partials/main.js',
    appConfig.app+'/js/partials/main.js',
    appConfig.app+'/js/_main.js'
  ];

  grunt.initConfig({
    config: appConfig,

    clean: {
      dev: ['<%= config.dev %>'],
      prod: ['<%= config.prod%>']
    },
    jshint: {
      options: {
        jshintrc: '.jshintrc'
      },
      all: [
        'Gruntfile.js',
        '<%= config.app %>/js/partials/*.js',
      ]
    },
    sass: {
      dev: {
        options: {
          style: 'expanded',
          compass: true,
        },
        files: {
          '<%= config.dev %>/css/main.css': '<%= config.app %>/sass/main.scss',
        }
      },
      prod: {
        options: {
          style: 'compressed',
          compass: true,
        },
        files: {
          '<%= config.prod %>/css/main.min.css': [
            '<%= config.app %>/sass/main.scss'
          ]
        }
      }
    },
    concat: {
      options: {
        separator: ';',
      },
      dev: {
        files: {
          '<%= config.dev %>/js/app.js': [jsAppList],
          '<%= config.dev %>/js/scripts.js': [vendorList]
        }
      },
    },
    uglify: {
      prod: {
        files: {
          '<%= config.prod %>/js/scripts.min.js': [
            vendorList,
            jsAppList
          ]
        }
      }
    },
    copy: {
      dev: {
        expand: true,
        cwd: '<%= config.app %>/fonts',
        src: '**/*',
        dest: '<%= config.dev %>/fonts'
      },
      prod: {
        expand: true,
        cwd: '<%= config.app %>/fonts',
        src: '**/*',
        dest: '<%= config.prod %>/fonts'
      },
    },
    autoprefixer: {
      options: {
        browsers: ['last 2 versions', 'ie 8', 'ie 9', 'android 2.3', 'android 4', 'opera 12']
      },
      dev: {
        options: {
          map: {
            prev: '<%= config.dev %>/css/'
          }
        },
        src: '<%= config.dev %>/css/main.css'
      },
      prod: {
        src: '<%= config.prod %>/css/main.min.css'
      }
    },
    version: {
      default: {
        options: {
          format: true,
          length: 32,
          manifest: 'assets/manifest.json',
          querystring: {
            style: 'roots_css',
            script: 'roots_js'
          }
        },
        files: {
          'lib/scripts.php': '<%= config.prod %>/{css,js}/{main,scripts,app}.min.{css,js}'
        }
      }
    },
    watch: {
      sass: {
        files: [
          '<%= config.app %>/sass/*.scss',
          '<%= config.app %>/sass/**/*.scss'
        ],
        tasks: ['sass:dev', 'autoprefixer:dev']
      },
      js: {
        files: [
          vendorList,
          jsAppList
        ],
        tasks: ['concat']
      },
      livereload: {
        // Browser live reloading
        // https://github.com/gruntjs/grunt-contrib-watch#live-reloading
        options: {
          livereload: false
        },
        files: [
          '<%= config.dev %>/css/main.css',
          '<%= config.dev %>/js/scripts.js',
          'templates/*.php',
          '*.php'
        ]
      }
    }
  });

  // Register tasks
  grunt.registerTask('default', [
    'dev'
  ]);
  grunt.registerTask('dev', [
    'clean:dev', // Delete old dev folder to prevent errors
    'sass:dev', // Compile Sass without minify || Dest: 'assets/dev/css/main.css'
    'autoprefixer:dev', // Parse CSS and add vendor-prefixed CSS properties || same dest as sass:dev
    'concat:dev', // Concat fils from jsFileList array
    'copy:dev'
  ]);
  grunt.registerTask('prod', [
    'clean:prod', // Delete old build folder to prevent errors
    'sass:prod', // Compile and minify Sass || Dest: 'assets/build/css/main.min.css'
    'autoprefixer:prod', // Parse CSS and add vendor-prefixed CSS properties || same dest as sass:build
    'uglify:prod', // Minify and concat vendorList array
    'copy:prod',
    'version'
  ]);
  grunt.registerTask('build', [
    'dev',
    'prod'
  ]);
  grunt.registerTask('serve', [
    'dev',
    'watch'
  ]);
};
