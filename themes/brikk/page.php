<?php get_header(); ?>
<!-- Container brikk/page.php -->
 <?php $user = wp_get_current_user();

  if(get_the_author_meta('rz_role', $user->ID) == 'business'){

        $enable_page_modules = Brk()->get_meta('rz_enable_page_modules');

        $is_explore = false;
        if( function_exists('routiz') ) {
          $is_explore = Rz()->is_explore();
        }

        $is_account = ( function_exists('is_account_page') and is_account_page() );
        $is_in_row = ( ! $enable_page_modules and ! $is_explore );

        $show_title = true;
        if( $is_explore ) {
          $show_title = false;
        }

        if( $is_account and is_user_logged_in() ) {
          $show_title = false;
        }

        $is_nav = false;
        if( ! $is_explore ) {
          if( $is_account and is_user_logged_in() ) {
            $is_nav = true;
          }
        }

        if( Brk()->is_elementor() ) {
          $is_in_row = false;
        }

        ?>

        <?php if( $is_nav ): ?>
          <?php get_template_part('templates/account/dashboard/navigation'); ?>
        <?php endif; ?>

        <div class="brk-container brikk/page.php">
          <?php if( $show_title ): ?>
            <?php get_template_part('templates/title'); ?>
          <?php endif; ?>
          <?php if( $is_in_row ): ?><div class="brk-row"><?php endif; ?>
            <?php if( $is_nav ): ?>
              <?php get_template_part('templates/account/dashboard/mobile/navigation'); ?>
            <?php endif; ?>
            <?php
              while ( have_posts() ) : the_post();
                get_template_part( 'templates/content', 'page' );
              endwhile;
            ?>
          <?php if( $is_in_row ): ?></div><?php endif; ?>
        </div>

        <?php if( $is_account ): ?>
          <?php Brk()->the_template('account/footer'); ?>
        <?php endif; 

  }else if(get_the_author_meta('rz_role', $user->ID) == 'customer'){  ?>

    
   
    <div class="about__main author">
      <div class="container color-w top__">
        <div class="kama_breadcrumbs" itemscope="" itemtype="http://schema.org/BreadcrumbList"><span itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a href="http://bthost2.uh-vpn.org" itemprop="item"><span itemprop="name">Home</span></a></span><span class="kb_sep"><img src="http://bthost2.uh-vpn.org/wp-content/themes/brikk-child/images/breadcrumbs-arrow.svg" alt="img"></span><span class="kb_title">user-account</span></div>
      </div>
      <div class="container">
        <div class="about__main_info"></div>
      </div>
    </div>
    
    
    <div class="container mi-container">
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
                <div class="bottom__contents"><a class="contents_k" href="#">Kontakt</a><a class="contents_b" href="#">Bestil ny tid</a></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    

  <?php } ?>

<!-- END Container brikk/page.php -->
<?php get_footer();
