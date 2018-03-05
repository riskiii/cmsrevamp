<?php
require_once( "admin/Classes/UserClass/class.user.php" );
$user = new USER();
?>
<!DOCTYPE html>
<html lang="en-US">
include "head.php"

<body id="biography" class="page biography bio">

include "ie-alert.php"
include "header.php"

<div class="wrap container" role="document">
   <div class="content row">
      <main class="main col-sm-12">
         include "menu.php"
         include "sidebar.php"

         <?php if ( $user->is_loggedin() == true ) { ?>
         <div class="col-sm-8 bio"> <?php } ?>
            <div class="biography-group">
               <h2> Biography </h2>

               <div class="group">
                  <figure class="my-figure"><img src="images/sh.jpg" alt="SCOTT HOYING"/>
                     <figcaption>SCOTT <br>HOYING</figcaption>
                  </figure>

                  <p>Scott is a songwriter and pianist who has been performing since the age of 8. Following
                     his
                     graduation from Martin High School in Arlington, TX, Scott enrolled at USC where he joined the SoCal
                     VoCals, a
                     popular and accomplished campus a cappella group. Involved with a variety of musical projects, Scott
                     has
                     been a
                     finalist on CBS&#39; Star Search and has performed the National Anthem and
                     "God Bless America"
                     at
                     numerous
                     professional and collegiate sporting events, including home games for the Texas Rangers, Dallas
                     Cowboys
                     and
                     Dallas Mavericks.
                  </p>
               </div>

               <div class="group">
                  <figure class="my-figure"><img src="images/mg.jpg" alt="MITCH GRASSI"/>
                     <figcaption>MITCH <br>GRASSI</figcaption>
                  </figure>

                  <p>Mitch is the youngest member of Pentatonix and a recent high school graduate (he was a
                     high
                     school
                     senior when taping of The Sing-Off commenced). In addition to immersing himself in music theater in
                     Arlington,
                     TX, Mitch&#39;s music tastes skew heavily toward underground club and electronic music. A veteran of
                     many
                     vocal
                     and talent competitions, Mitch took first place at the Teen Talent Follies for his rendition of Scott
                     Alan&#39;s
                     "Kiss the Air."
                     Mitch is honing his skills in production and DJ-ing while excelling as a lead
                     vocalist for
                     Pentatonix.
                  </p>
               </div>

               <div class="group">
                  <figure class="my-figure"><img src="images/ak.jpg" alt="AVI KAPLAN"/>
                     <figcaption>AVI <br>KAPLAN</figcaption>
                  </figure>

                  <p>Avi is a serious student of classical music who also plays guitar, composes and arranges
                     music for
                     both choral and a cappella. A Visalia, CA native, Avi moved to Walnut, CA in 2007 to attend Mt. San
                     Antonio
                     College, known worldwide for their strong choral and a cappella tradition. In 2008 he joined Fermata
                     Nowhere, a
                     high-energy male a cappella group that became the first community college a cappella entrants to win
                     the
                     prestigious ICCA. Avi won the competition&#39;s award for
                     "Best Rhythm Section,"
                     the first year that
                     this
                     award had ever included a vocal bass (the award was called
                     pBest Vocal Percussionist"
                     before Avi&#39;s
                     victory prompted the language change). In his third year at Mt. San Antonio, Avi joined Sincopation,
                     an
                     award-winning jazz ensemble that won the Monterey Jazz Festival Competition in his first year. He has
                     performed
                     at venues worldwide, including New York City&#39;s Lincoln Center and Carnegie Hall.
                  </p>
               </div>

               <div class="group">
                  <figure class="my-figure"><img src="images/ko.jpg" alt="KEVIN OLUSOLA"/>
                     <figcaption>KEVIN <br>OLUSOLA</figcaption>
                  </figure>

                  <p>Kevin grew up in the small town of Owensboro, Kentucky, the son of a Nigerian
                     psychiatrist
                     and a
                     Grenadian nurse. At an early age, Kevin began learning piano, cello and saxophone. He performed at
                     Carnegie
                     Hall twice as soloist on the cello and saxophone and has appeared on NPR&#39;s
                     pFrom The Top."
                     After
                     finishing high school at Phillips Academy Andover, Kevin enrolled in Yale University where he was
                     pre-med
                     and
                     majored in East Asian Studies. He spent 18 months in Beijing becoming fluent in Chinese as a part of
                     his
                     Yale
                     fellowship. While in college, Kevin began developing his
                     pcelloboxing"
                     skills and in 2009, he won
                     second
                     place in the
                     pCelebrate and Collaborate with Yo-Yo Ma"
                     international competition. Ma would call
                     Kevin&#39;s
                     celloboxing version of
                     pDona Nobis Pacem"
                     both
                     pinventive and unexpected."
                     In 2011, Kevin&#39;s
                     "Julie-O"
                     celloboxing YouTube video was featured by CBS, AOL, Huffington Post and Washington Post, among others.
                     Kevin
                     was also named one of 100
                     "History Makers in the Making”"
                     by NBC&#39;s TheGrio and was hand-chosen
                     by
                     Quincy Jones to represent him in concert at the 2012 Montreux Jazz Festival alongside Bobby McFerrin
                     and
                     Chick
                     Corea. On March 10th 2015, Kevin released his first solo album, The Renegade EP. courtesy of RCA
                     Records.
                     The
                     album debuted #1 on Billboard Traditional Classical and Classical Crossover charts, in addition to
                     staying #1
                     on iTunes classical albums for weeks as it featured classically reimagined versions of popular songs
                     like
                     "All
                        of Me,
                     "
                     "Stay With Me,"
                     and
                     "Heart Attack,"
                     as well as Kevin&#39;s original composition
                     "Renegade."
                  </p>
               </div>

               <div class="group">
                  <figure class="my-figure"><img src="images/km.jpg" alt="KIRSTIN MALDONADO"/>
                     <figcaption>KIRSTIN <br>MALDONADO</figcaption>
                  </figure>

                  <p>Kirstin is a National Hispanic Scholar and was a sophomore Music Theater major at The
                     University
                     of Oklahoma before joining Pentatonix. She developed her vocal and performance skills during her eight
                     years as
                     a touring member at Theatre Arlington where she&#39;d learned to sing eight-part harmonies. She began
                     her
                     classical training during high school and was a member of the Texas All State Choir for three years. A
                     four-year show choir member and dance captain, Kirstin held numerous roles in local stage productions,
                     performing at shows around the Metroplex, including Casa Manana and Bass Hall.
                  </p>
               </div>
            </div>
            <?php if ( $user->is_loggedin() == true ) { ?>
         </div> <?php } ?>

      </main><!-- /.main -->
   </div>
</div>

include "footer.php"
include "scripts-footer.php"
</body>
</html>
