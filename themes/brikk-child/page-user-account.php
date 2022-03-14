<?php
/*
Template Name: Page User Account
Template Post Type: page
*/ 

 $user = wp_get_current_user();
  if ( !is_admin() && !current_user_can( 'administrator' ) && !get_the_author_meta('rz_role', $user->ID) == 'customer') {
    wp_redirect( home_url() );
    exit;
  } 
?>
<?php get_header(); ?>

<div class="about__main author">
    <div class="container color-w top__">
        <?php if (function_exists('kama_breadcrumbs')) kama_breadcrumbs(); ?>
    </div>
    <div class="container">
        <div class="about__main_info">
             <?php if (get_field('about_us_head')): ?>
                <div class="about__main_info-head">
                     <h1><?php the_field('about_us_head'); ?></h1>
                </div>
            <?php endif; ?>
            <?php if (get_field('about_us_slag')): ?>
                <div class="about__main_info-text">
                    <?php the_field('about_us_slag'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>


<div class="container mi-conteiner">
      <div class="rz-grid rz-align-start">
        <div class="rz-col-lg-12 rz-col-4">
          <div class="box__width">
            <div class="box__img"><img src="http://bthost2.uh-vpn.org/wp-content/themes/brikk-child/images/logo-color.png" alt="user"></div>
            <h3 class="name">Darlene Robertson</h3><a class="addres" href="#">7510 Pecan Acres Ln., 38901</a><a class="link_site" href="#">rasmusabel.dk</a><a class="phone" href="#">0555 0117</a>
          </div>
        </div>
        <div class="rz-col-lg-12 rz-col-8 box__cont">
          <div class="box__title">
            <h3>Favorit behandlere</h3>
          </div>
          <div class="box__slider">
            <div>
              <div class="box__content pad-r">
                <div class="box__img">
                  <div class="top__">
                    <div class="reiting">4.7</div><a class="like" href="#"></a>
                  </div><img src="/wp-content/themes/brikk-child/img/slider.png" alt="user">
                </div>
                <div class="box__info">
                  <h3 class="title">Annette Black</h3>
                  <p class="disc">Kinesitherapist, Vertebrologist</p>
                  <p class="audint">Behandler af højeste kaliber</p>
                </div>
                <div class="bottom__"><a class="Kontakt" href="#">Kontakt</a><a class="Book-Nu" href="#">Book Nu</a></div>
              </div>
            </div>
            <div>
              <div class="box__content pad-l">
                <div class="box__img">
                  <div class="top__">
                    <div class="reiting">4.7</div><a class="like" href="#"></a>
                  </div><img src="/wp-content/themes/brikk-child/img/slider.png" alt="user">
                </div>
                <div class="box__info">
                  <h3 class="title">Annette Black</h3>
                  <p class="disc">Kinesitherapist, Vertebrologist</p>
                  <p class="audint">Behandler af højeste kaliber</p>
                </div>
                <div class="bottom__"><a class="Kontakt" href="#">Kontakt</a><a class="Book-Nu" href="#">Book Nu</a></div>
              </div>
            </div>
            <div>
              <div class="box__content pad-r">
                <div class="box__img">
                  <div class="top__">
                    <div class="reiting">4.7</div><a class="like" href="#"></a>
                  </div><img src="/wp-content/themes/brikk-child/img/slider.png" alt="user">
                </div>
                <div class="box__info">
                  <h3 class="title">Annette Black</h3>
                  <p class="disc">Kinesitherapist, Vertebrologist</p>
                  <p class="audint">Behandler af højeste kaliber</p>
                </div>
                <div class="bottom__"><a class="Kontakt" href="#">Kontakt</a><a class="Book-Nu" href="#">Book Nu</a></div>
              </div>
            </div>
            <div>
              <div class="box__content pad-l">
                <div class="box__img">
                  <div class="top__">
                    <div class="reiting">4.7</div><a class="like" href="#"></a>
                  </div><img src="/wp-content/themes/brikk-child/img/slider.png" alt="user">
                </div>
                <div class="box__info">
                  <h3 class="title">Annette Black</h3>
                  <p class="disc">Kinesitherapist, Vertebrologist</p>
                  <p class="audint">Behandler af højeste kaliber</p>
                </div>
                <div class="bottom__"><a class="Kontakt" href="#">Kontakt</a><a class="Book-Nu" href="#">Book Nu</a></div>
              </div>
            </div>
            <div>
              <div class="box__content pad-r">
                <div class="box__img">
                  <div class="top__">
                    <div class="reiting">4.7</div><a class="like" href="#"></a>
                  </div><img src="/wp-content/themes/brikk-child/img/slider.png" alt="user">
                </div>
                <div class="box__info">
                  <h3 class="title">Annette Black</h3>
                  <p class="disc">Kinesitherapist, Vertebrologist</p>
                  <p class="audint">Behandler af højeste kaliber</p>
                </div>
                <div class="bottom__"><a class="Kontakt" href="#">Kontakt</a><a class="Book-Nu" href="#">Book Nu</a></div>
              </div>
            </div>
          </div>
          <div class="box__bottom">      <a class="bottom__border" href="#">Se alle favoritter</a></div>
          <div class="tidligere-get">
            <h3 class="title">Tidligere besøg</h3>
            <div class="box__select">
              <select id="select_">
                <option value="Alle besøg">Alle bes&oslash;g</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
              </select>
            </div>
            <div class="box__post">
              <div class="box__img">
                <div class="reiting">4.7</div><img src="/wp-content/themes/brikk-child/img/user1.png" alt="user">
              </div>
              <div class="box__contents"><a class="bottom__orang" href="#">Anmeld</a>
                <h4 class="title">Rasmus Nørgaard Abel</h4>
                <p class="catygory">Androlog, Sexopatolog, Sexolog, Reproduktolog</p>
                <p class="audint">Kommende talent</p>
                <ul class="select">
                  <li><span class="top">Dato for besøg</span><span class="box__">02.13.2020</span></li>
                  <li><span class="top">Sessionens varighed</span><span class="box__">30 minutter</span></li>
                  <li><span class="top">Pris</span><span class="box__">KR 600.00</span></li>
                </ul>
                <div class="box__open">   <a class="open__title plus" href="#">Anbefal behandler</a>
                  <div class="desc">
                    <p>1500-tallet, er gengivet nedenfor for de, der er interesserede. Afsnittene 1.10.32 og 1.10.33 fra "de Finibus Bonorum et Malorum" af Cicero er også gengivet i deres nøjagtige udgave i selskab med den engels</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="box__post">
              <div class="box__img">
                <div class="reiting">4.7</div><img src="/wp-content/themes/brikk-child/img/user1.png" alt="user">
              </div>
              <div class="box__contents"><a class="bottom__orang" href="#">Anmeld</a>
                <h4 class="title">Rasmus Nørgaard Abel</h4>
                <p class="catygory">Androlog, Sexopatolog, Sexolog, Reproduktolog</p>
                <p class="audint">Kommende talent</p>
                <ul class="select">
                  <li><span class="top">Dato for besøg</span><span class="box__">02.13.2020</span></li>
                  <li><span class="top">Sessionens varighed</span><span class="box__">30 minutter</span></li>
                  <li><span class="top">Pris</span><span class="box__">KR 600.00</span></li>
                </ul>
                <div class="box__open">   <a class="open__title plus" href="#">Anbefal behandler</a>
                  <div class="desc">
                    <p>1500-tallet, er gengivet nedenfor for de, der er interesserede. Afsnittene 1.10.32 og 1.10.33 fra "de Finibus Bonorum et Malorum" af Cicero er også gengivet i deres nøjagtige udgave i selskab med den engels</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="box__post">
              <div class="box__img">
                <div class="reiting">4.7</div><img src="/wp-content/themes/brikk-child/img/user1.png" alt="user">
              </div>
              <div class="box__contents"><a class="bottom__orang" href="#">Anmeld</a>
                <h4 class="title">Rasmus Nørgaard Abel</h4>
                <p class="catygory">Androlog, Sexopatolog, Sexolog, Reproduktolog</p>
                <p class="audint">Kommende talent</p>
                <ul class="select">
                  <li><span class="top">Dato for besøg</span><span class="box__">02.13.2020</span></li>
                  <li><span class="top">Sessionens varighed</span><span class="box__">30 minutter</span></li>
                  <li><span class="top">Pris</span><span class="box__">KR 600.00</span></li>
                </ul>
                <div class="box__open">   <a class="open__title plus" href="#">Anbefal behandler</a>
                  <div class="desc">
                    <p>1500-tallet, er gengivet nedenfor for de, der er interesserede. Afsnittene 1.10.32 og 1.10.33 fra "de Finibus Bonorum et Malorum" af Cicero er også gengivet i deres nøjagtige udgave i selskab med den engels</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


<?php get_footer(); ?>
