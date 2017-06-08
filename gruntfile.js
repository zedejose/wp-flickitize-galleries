module.exports = function( grunt ) {

      // Project configuration.
      grunt.initConfig({

        pkg: grunt.file.readJSON('package.json'),

        /**
         * Make readme.txt a markdown file
         */
        wp_readme_to_markdown: {
            flickitize: {
                files: {
                  'readme.MD': 'readme.txt'
                },
            },
        },

        /**
         * Populate .POT file and merge .PO files
         */
        makepot: {
            dist: {
                options: {
                    domainPath: 'languages',          // Where to save the POT file.
                    exclude: ['bower_components', 'node_modules', 'languages'], // List of files or directories to ignore.
                    potFilename: 'wp-flickitize-galleries.pot',  // Name of the POT file.
                    potHeaders: {
                        poedit: true,                 // Includes common Poedit headers.
                        'x-poedit-keywordslist': true // Include a list of all possible gettext functions.
                    },                                // Headers to add to the generated POT file.
                    type: 'wp-plugin',                // Type of project (wp-plugin or wp-theme).
                    updateTimestamp: true,            // Whether the POT-Creation-Date should be updated without other changes.
                    updatePoFiles: true,              // Whether to update PO files in the same directory as the POT file.
                }
            }
        }, // /i18n

        /**
         * Watch tasks
         */
        watch: {
            translations: {
                files: ['**.php'],
                tasks: ['makepot'],
            },
        } // /Watch
    });


    grunt.loadNpmTasks('grunt-wp-i18n');
    grunt.loadNpmTasks('grunt-wp-readme-to-markdown');

    grunt.registerTask('default', ['makepot','wp_readme_to_markdown']);

};
