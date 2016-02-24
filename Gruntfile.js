module.exports = function(grunt) {
  // Load required modules.
  expandHomeDir = require('expand-home-dir');


  // Load the config files.
  var meerkat = grunt.file.readYAML('meerkat/settings.yaml');

  if (grunt.file.exists('meerkat/preferences.yaml')) {
    var meerkatPrefs = grunt.file.readYAML('meerkat/preferences.yaml');
  } else {
    var meerkatPrefs = {};

    // Inform user that they can tweak some preferences.
    grunt.log.subhead('Meerkat');
    grunt.log.writeln('-------');
    grunt.log.writeln(
      'You can set personal preferences for things like which browser to use during development ' +
      'in `meerkat/preferences.yaml`. See `meerkat/preferences.sample.yaml`.'
    );
  }


  // Set default preferences.
  meerkat.global            = {};
  meerkat.global.sites_path = expandHomeDir('~/Sites');


  // Set vars for use in tasks.
  meerkat.settingsPath = 'site/settings/addons';


  // Overwrite defaults with user preferences.
  meerkat = mergeObjects(meerkat, meerkatPrefs);




  require('load-grunt-config')(grunt, {
    configPath: 'meerkat/core/tasks',
    overridePath: 'meerkat/tasks',
    config: {
      m: meerkat
    }
  });
};




// ---




// HELPERS
/**
 * Recursively merge the properties of two objects into the first, then return the object.
 * @param {object} obj1 The first object.
 * @param {object} obj2 The second object.
 */
function mergeObjects(obj1, obj2) {
  for (var p in obj2) {
    try {
      // Property in destination object set; update its value.
      obj1[p] = obj2[p].constructor == Object ? mergeObjects(obj1[p], obj2[p]) : obj2[p];

    } catch(e) {
      // Property in destination object not set; create it and set its value.
      obj1[p] = obj2[p];
    }
  }


  return obj1;
}
