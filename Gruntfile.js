module.exports = function(grunt) {

  grunt.initConfig({

    // Watches for changes and runs tasks
    // Livereload is setup for the 35729 port by default
    watch: {
      css: {
        files: ['css/**/*.css'],
        options: {
          livereload: 35729
        }
      },
      js: {
        files: ['js/**/*.js'],
        options: {
          livereload: 35729
        }
      },
      php: {
        files: ['*.php'],
        options: {
          livereload: 35729
        }
      }
    },
    install: {
      command: [
        'npm install',
        'bower install',
        'php composer.phar install',
        'cp -r ./vendor/opauth/facebook ./vendor/opauth/opauth/lib/Opauth/Strategy/facebook',
        'cp -r ./vendor/opauth/twitter ./vendor/opauth/opauth/lib/Opauth/Strategy/twitter'
      ].join('&&')
    },
    start: {
      command: 'php -S localhost:8000'
    }
  });

    // Default task
    grunt.registerTask('default', ['watch']);

    // Shell tasks
    grunt.registerTask('install', ['install']);

    // Load up tasks
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-shell');
};