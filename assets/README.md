<div class="wrap container" role="document">

<div class="content my-row">

## dgs CMS Starter

dgs CMS Starter helps front-end developers build websites based on advance technologies. Responsive templates including many frequently used UI elements based on HTML5 input types with ARIA roles, styles in SCSS files and JavaScript DOM-based Routing technique.

## Requirements

<div>

| Prerequisite | How to check | How to install |
| --- | --- | --- |
| Ruby | `ruby -v` | [ruby-lang.org](https://www.ruby-lang.org/en/downloads/) |
| Sass >= 3.4.x | `sass -v` | `gem install sass` |
| Node.js 0.12.x | `node -v` | [nodejs.org](l) |
| Grunt >= 0.4.x | `npm list --depth=0` | `sudo npm install -g grunt-cli` |
| Bower >= 1.3.12 | `bower -v` | `sudo npm install -g bower` |

</div>

## [](#features)Features

*   [silversite/HTML-Starter](https://github.com/silversite/HTML-Starter) Huge thanks as this is the base for the project
*   [Grunt](http://gruntjs.com/) build script that compiles Sass, checks for JavaScript errors, optimizes images, and concatenates and minifies files
*   [Bower](http://bower.io/) for front-end package management
*   [Bootstrap](http://getbootstrap.com/) the most popular HTML, CSS, and JS framework
*   [jQuery](http://jquery.com/) JavaScript library
*   [Font Awesome](http://fontawesome.io) Font Awesome

### Additional features:

*   [SASS](http://sass-lang.com/) CSS extension
*   JavaScript [DOM-based Routing](http://www.paulirish.com/2009/markup-based-unobtrusive-comprehensive-dom-ready-execution/) by Paul Irish
*   Google CDN jQuery snippet from [HTML5 Boilerplate](http://html5boilerplate.com/)
*   Google Analytics snippet from [HTML5 Boilerplate](http://html5boilerplate.com/)
*   [PHP Login and Registration Script with PDO and OOP](http://www.codingcage.com/2015/04/php-login-and-registration-script-with.html)
*   [Ajax Bootstrap Signup Form with jQuery PHP and MySQL](http://www.codingcage.com/2016/05/ajax-bootstrap-signup-form-with-jquery.html)
*   [Password Strength Plugin jQuery](https://www.sitepoint.com/developing-password-strength-plugin-jquery/)
*   [How to limit the number of login attempts in a login script?](http://stackoverflow.com/questions/37120328/how-to-limit-the-number-of-login-attempts-in-a-login-script)
*   [Bootstrap No more tables](http://bootsnipp.com/snippets/featured/no-more-tables-respsonsive-table)
*   [Css-Tricks Favicon](https://css-tricks.com/favicon-quiz/)
*   [Export Kit - Google Fonts Auto-loader](http://exportkit.com/plugin/environments/html5/add-google-fonts-to-html5)
*   [Material Icons](http://google.github.io/material-design-icons/#icon-font-for-the-web)
*   [Genericons](https://genericons.com/)

## Theme development

dgs CMS Starter uses [Grunt](http://gruntjs.com/) as its build system and [Bower](http://bower.io/) to manage front-end packages.

### Install tools you need

1.  [For mac people install Homebrew](http://brew.sh/) `/usr/bin/ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"`
2.  [Install node and npm](http://blog.teamtreehouse.com/install-node-js-npm-mac) `brew install node`
3.  [Install Git on Mac OS X](https://www.atlassian.com/git/tutorials/install-git/mac-os-x) `brew install git`
4.  Install [Grunt](http://gruntjs.com/) `sudo npm install -g grunt-cli`
5.  [Bower](http://bower.io/) `sudo npm install -g bower`
6.  Navigate to the template directory, then run `npm install`
7.  Run `bower install`
8.  Run `bower install font-awesome --save`

You now have all the necessary dependencies to run the build process.

### Available Grunt commands using my Gruntfile.js

*   `grunt both` — Compile and optimize the files in your assets directory
*   `grunt watch` — Compile assets when file changes are made
*   `grunt dev` — Compile assets for developing (with source maps, without minify).

## License

Code released under the [MIT license.](https://opensource.org/licenses/MIT)</div>

</div>