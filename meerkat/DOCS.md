Meerkat is a YAML-configurable [Grunt][grunt] setup for [Statamic][statamic] addon development, a
companion to [Mr. Pig][mr-pig].




# Features
- Copies addon files to Statamic site dir
- Notifies when copies are done
- Executes configured bash commands on save
- Allows you to override core Meerkat tasks w/o complicating version control




# Benefits
- Keep your addon files in a sensical location while you develop.
- Dress in drag and do the hula.
- Tastes like chicken.




# Installation
- [Install npm][npm-installation]
- [Install Grunt][grunt-installation]
- Install Meerkat

## Installing Meerkat
Download the latest version and drop the files in your project directory.

<aside>
In order to keep things organized, Meerkat is designed to be installed above the addon directory
by default.

```language-files
meerkat/
Addon/
Gruntfile.js
package.json
```

If you prefer a different structure, you can override the core `copy` tasks by creating a new
`copy.yaml` in `meerkat/tasks`. See `core/tasks/copy.yaml` if you need a template to follow.
</aside>


## Gitignore
Make sure you ignore `meerkat/preferences.yaml` and `node_modules`.

`preferences.yaml` contains developer-specific info so you shouldn't commit it to a repo that more
than one person works on.

You should never, ever, ever, ever, ever edit anything in `node_modules` and it's all installed by
simply running `grunt init`, so there's no reason to track it in your repo.




# Usage
## During development
In Terminal, navigate to your addon folder and run `grunt`.

```shell
cd ~/Sites/my-addon
grunt
```

This runs the default Grunt task which watches for file changes and copies everything over to the
configured site.




# Configuration
Open `meerkat/settings.yaml` and `meerkat/preferences.yaml` and take a look at the options. Find
each option documented in comments alongside the option itself.

## Overriding and adding tasks
To override or add a task, put a YAML file in `meerkat/tasks` named after the task. If you're adding
a task, you'll also have to install the node package.

For example, if you write a new fieldtype, you'll need to write some JavaScript. If you may want to
minify it, you could use [grunt-contrib-uglify][grunt-contrib-uglify]:

```sh
npm install grunt-contrib-uglify --save-dev
touch meerkat/tasks/uglify.yaml
```

Then open `meerkat/tasks/uglify.yaml` and add your config. The highest-level keys are the names of
your [targets][grunt-targets].

```yaml
fieldtype:
  files: '<%= m.addon.dir %>/js/fieldtype.min.js': ['<%= m.addon.dir %>/js/fieldtype.js']
```

You can access any of the values in `meerkat/preferences.yaml` and `meerkat/settings.yaml` by using
`<%= m.option %>`. You can even run JavaScript between `<% %>` (see
[Grunt Templates][grunt-templates]. However, this gets complicated
quickly. If you find it's getting hairy, let me know and I can add support for JavaScript task files.


## Files and paths
Grunt allows [globbing][grunt-globbing], to make specifying
files and paths more practical. You can find examples of this in `core/tasks/copy.yaml`.

```yaml
addon:
  files:
    - expand: true
      cwd: '<%= m.addon.dir %>/'
      src:
        - '*.{php,yaml}'
      dest: '<%= m.global.sites_path %>/<%= m.site.dir %>/<%= m.site.root %>/_add-ons/<%= m.addon.dir %>/'
```

- `*` matches any number of characters that aren't `/`.
- `**` works just like `*`, except recursively.
- `{}` matches anything contained inside separated by commas.
- `!` means not.

So `*.{php,yaml}` grabs any `php` or `yaml` file anywhere in the `addon:dir` folder (as specified
in your settings).

…but `!sample.{php,yaml}` would tell Grunt to ignore `sample.php` and `sample.yaml`.




# Thanks
Sponsored in part by [LionsMouth Digital][lmd].




[grunt]: http://gruntjs.com/
[grunt-contrib-uglify]: https://github.com/gruntjs/grunt-contrib-uglify
[grunt-globbing]: http://gruntjs.com/configuring-tasks#globbing-patterns
[grunt-installation]: http://gruntjs.com/getting-started
[grunt-targets]: http://gruntjs.com/creating-tasks#multi-tasks
[grunt-templates]: http://gruntjs.com/configuring-tasks#templates
[lmd]: http://lionsmouthdigital.com
[mr-pig]: https://github.com/thefriendlybeasts/mr_pig
[npm-installation]: https://docs.npmjs.com/getting-started/installing-node
[statamic]: http://statamic.com/
