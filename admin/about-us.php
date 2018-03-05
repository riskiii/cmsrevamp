<?php
require_once( "Classes/UserClass/session.php" );
require_once( "Classes/UserClass/class.user.php" );
$user_is_me = new USER();

if ( $user_is_me->is_loggedin() == false ) {
   $user_is_me->redirect( '/login.php' );
}

?>
<!DOCTYPE html>
<html lang="en-US">
<?php include_once "includes/head.php"; ?>

<body id="about-us" class="page about-us">

<?php include_once "includes/ie-alert.php"; ?>
<?php include_once "includes/header.php"; ?>

<div class="wrap container" role="document">
   <div class="content my-row">
      <h2 id="html-starter">dgs CMS Starter</h2>
      dgs CMS Starter helps front-end developers build websites based on advance technologies. Responsive templates
      including many frequently used UI elements based on HTML5 input types with ARIA roles, styles in SCSS files and
      JavaScript DOM-based Routing technique.

      <h2>Requirements</h2>

      <div>
         <table class="col-md-12 table table-hover table-striped table-condensed cf">
            <thead class="cf">
            <tr>
               <th>Prerequisite</th>
               <th>How to check</th>
               <th>How to install</th>
            </tr>
            </thead>
            <tbody>
            <tr>
               <td data-title="Prerequisite">Ruby</td>
               <td data-title="How to check"><code>ruby -v</code></td>
               <td data-title="How to install"><a
                     href="https://www.ruby-lang.org/en/downloads/">ruby-lang.org</a></td>
            </tr>
            <tr>
               <td data-title="Prerequisite">Sass &gt;= 3.4.x</td>
               <td data-title="How to check"><code>sass -v</code></td>
               <td data-title="How to install"><code>gem install sass</code></td>
            </tr>
            <tr>
               <td data-title="Prerequisite">Node.js 0.12.x</td>
               <td data-title="How to check"><code>node -v</code></td>
               <td data-title="How to install"><a href="http://nodejs.org/">nodejs.org</a></td>
            </tr>
            <tr>
               <td data-title="Prerequisite">Grunt &gt;= 0.4.x</td>
               <td data-title="How to check"><code>npm list --depth=0</code></td>
               <td data-title="How to install"><code>sudo npm install -g grunt-cli</code></td>
            </tr>
            <tr>
               <td data-title="Prerequisite">Bower &gt;= 1.3.12</td>
               <td data-title="How to check"><code>bower -v</code></td>
               <td data-title="How to install"><code>sudo npm install -g bower</code></td>
            </tr>
            </tbody>
         </table>
      </div>

      <h2><a id="features" class="anchor" href="#features"></a>Features</h2>
      <ul>
         <li><a href="https://github.com/silversite/HTML-Starter">silversite/HTML-Starter</a> Huge thanks as this is the base for the project</li>
         <li><a href="http://gruntjs.com/">Grunt</a> build script that compiles Sass, checks for JavaScript
            errors,
            optimizes images, and concatenates and minifies files
         </li>
         <li><a href="http://bower.io/">Bower</a> for front-end package management</li>
         <li><a href="http://getbootstrap.com/">Bootstrap</a> the most popular HTML, CSS, and JS framework</li>
         <li><a href="http://jquery.com/">jQuery</a> JavaScript library</li>
         <li><a href="http://fontawesome.io">Font Awesome</a> Font Awesome</li>
      </ul>
      <h3>Additional features:</h3>
      <ul>
         <li><a href="http://sass-lang.com/">SASS</a> CSS extension</li>
         <li>JavaScript <a
               href="http://www.paulirish.com/2009/markup-based-unobtrusive-comprehensive-dom-ready-execution/">DOM-based
               Routing</a> by Paul Irish
         </li>
         <li>Google CDN jQuery snippet from <a href="http://html5boilerplate.com/">HTML5 Boilerplate</a></li>
         <li>Google Analytics snippet from <a href="http://html5boilerplate.com/">HTML5 Boilerplate</a></li>
         <li><a href="http://www.codingcage.com/2015/04/php-login-and-registration-script-with.html">PHP Login and
               Registration Script with PDO and OOP</a></li>
         <li><a href="http://www.codingcage.com/2016/05/ajax-bootstrap-signup-form-with-jquery.html">Ajax Bootstrap
               Signup Form with jQuery PHP and MySQL</a></li>
         <li><a href="https://www.sitepoint.com/developing-password-strength-plugin-jquery/">Password Strength Plugin
               jQuery</a></li>
         <li><a href="http://stackoverflow.com/questions/37120328/how-to-limit-the-number-of-login-attempts-in-a-login-script">
               How to limit the number of login attempts in a login script?</a></li>
         <li><a href="http://bootsnipp.com/snippets/featured/no-more-tables-respsonsive-table">Bootstrap No more
               tables</a></li>
         <li><a href="https://css-tricks.com/favicon-quiz/">Css-Tricks Favicon</a></li>
         <li><a href="http://exportkit.com/plugin/environments/html5/add-google-fonts-to-html5">Export Kit - Google
               Fonts Auto-loader</a></li>
         <li><a href="http://google.github.io/material-design-icons/#icon-font-for-the-web">Material Icons</a></li>
         <li><a href="https://genericons.com/">Genericons</a></li>
      </ul>
      <h2>Theme development</h2>
      dgs CMS Starter uses <a href="http://gruntjs.com/">Grunt</a> as its build system and <a
         href="http://bower.io/">Bower</a> to manage front-end packages.
      <h3 id="install-grunt-and-bower">Install tools you need</h3>
      <ol>
         <li><a href="http://brew.sh/">For mac people install Homebrew</a> <br><code>/usr/bin/ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"</code> </li>
         <li><a href="http://blog.teamtreehouse.com/install-node-js-npm-mac">Install node and npm</a> <code>brew install node</code> </li>
         <li><a href="https://www.atlassian.com/git/tutorials/install-git/mac-os-x">Install Git on Mac OS X</a> <code>brew install git</code> </li>
         <li>Install <a href="http://gruntjs.com/">Grunt</a> <code>sudo npm install -g grunt-cli</code></li>
         <li>Install <a href="http://bower.io/">Bower</a> <code>sudo npm install -g bower</code></li>
         <li>Navigate to the template directory, then run <code>npm install</code></li>
         <li>Run <code>bower install</code></li>
         <li>Run <code>bower install font-awesome --save</code></li>
      </ol>
      You now have all the necessary dependencies to run the build process.
      <h3 id="available-grunt-commands">Available Grunt commands using my Gruntfile.js</h3>
      <ul>
         <li><code>grunt both</code> — Compile and optimize the files in your assets directory</li>
         <li><code>grunt watch</code> — Compile assets when file changes are made</li>
         <li><code>grunt dev</code> — Compile assets for developing (with source maps, without minify).</li>
      </ul>
      <h2>License</h2>
      Code released under the <a href="https://opensource.org/licenses/MIT">MIT license.</a>
   </div><!-- /.my-row -->
</div><!-- /.container -->

<?php include_once "includes/footer.php"; ?>
<?php include_once "includes/scripts-footer.php"; ?>
</body>
</html>
