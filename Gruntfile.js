module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    sass: {
      options: {
        includePaths: ['scss/partials', '../equity/foundation/scss']
      },
      dist: {
        options: {
          outputStyle: 'compressed'
        },
        files: {
          'style-editor.css': 'scss/style-editor.css.scss',
          'style.min.css': 'scss/style.css.scss'
        }
      }
    },

    wpcss: {
        target: {
            options: {
                commentSpacing: true, // Whether to clean up newlines around comments between CSS rules.
                config: 'default',    // Which CSSComb config to use for sorting properties.
            },
            files: [
              {
                src: 'style.min.css', dest: 'style.min.css'
              },
            ],
        }
    },

    makepot: {
        target: {
            options: {
                cwd: '',                          // Directory of files to internationalize.
                domainPath: '/languages',         // Where to save the POT file.
                potComments: '',                  // The copyright at the beginning of the POT file.
                potFilename: '',                  // Name of the POT file.
                potHeaders: {
                    poedit: true,                 // Includes common Poedit headers.
                    'x-poedit-keywordslist': true // Include a list of all possible gettext functions.
                },                                // Headers to add to the generated POT file.
                processPot: null,                 // A callback function for manipulating the POT file.
                type: 'wp-theme',                 // Type of project (wp-plugin or wp-theme).
                updateTimestamp: true             // Whether the POT-Creation-Date should be updated without other changes.
            }
        }
    },

    css_purge: {
      site: {
        options: {
          "trim": false,
          "trim_keep_non_standard_inline_comments": false,
          "trim_removed_rules_previous_comment": true,
          "trim_comments": false,
          "trim_whitespace": true,
          "trim_breaklines": false,
          "trim_last_semicolon": false,
        },
        src: 'style.min.css',
        dest: 'style-dedupe.min.css',
      },
    },


    watch: {
      grunt: { files: ['Gruntfile.js'] },

      sass: {
        files: 'scss/**/*.scss',
        tasks: ['sass']
      },
      // wpcss: {
      //   files: 'scss/**/*.scss',
      //   tasks: ['wpcss']
      // }
    }

  });

  grunt.loadNpmTasks('grunt-sass');
  //grunt.loadNpmTasks('grunt-wp-css');
  grunt.loadNpmTasks('grunt-wp-i18n');
  grunt.loadNpmTasks('grunt-css-purge');
  grunt.loadNpmTasks('grunt-contrib-watch');

  grunt.registerTask('build', ['sass', 'makepot']);
  grunt.registerTask('default', ['build','watch']);
};