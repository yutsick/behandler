<main class="brk-main __content-page.php">
    <div class="brk-content">
        <article <?php post_class(); ?>>

            <?php $page_id = get_the_ID(); ?>

            <div class="brk-page-content">
                <?php the_content(); ?>
                <?php if (is_front_page()) { ?>
                <div class="s-steps brk-row">
                    <div class="s-steps-item">
                        <div class="s-steps__image">
                            <picture>
                                <source media="(max-width: 799px)" srcset="<?php echo get_stylesheet_directory_uri(); ?>/images/spine.svg">
                                <source media="(min-width: 800px)" srcset="<?php echo get_stylesheet_directory_uri(); ?>/images/spine.svg">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spine.svg" alt="Søg efter den type behandling eller problem, du har">
                            </picture>
                        </div>
                        <h3>Trin 1</h3>
                        <p>Søg efter den type behandling eller problem, du har</p>
                    </div>
                    <div class="s-steps-item">
                        <div class="s-steps__image">
                            <picture>
                                <source media="(max-width: 799px)" srcset="<?php echo get_stylesheet_directory_uri(); ?>/images/doctors.svg">
                                <source media="(min-width: 800px)" srcset="<?php echo get_stylesheet_directory_uri(); ?>/images/doctors.svg">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spine.svg"
                                     alt="Vælg fra listen over praktiserende læger. Du kan bruge filtre til at indsnævre din søgning">
                            </picture>
                        </div>
                        <h3>Trin 2</h3>
                        <p>Vælg fra listen over praktiserende læger. Du kan bruge filtre til at indsnævre din søgning</p>
                    </div>
                    <div class="s-steps-item">
                        <div class="s-steps__image">
                            <picture>
                                <source media="(max-width: 799px)" srcset="<?php echo get_stylesheet_directory_uri(); ?>/images/platform.svg">
                                <source media="(min-width: 800px)" srcset="<?php echo get_stylesheet_directory_uri(); ?>/images/platform.svg">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spine.svg" alt="Book og betal sikkert via vores platform">
                            </picture>
                        </div>
                        <h3>Trin 3</h3>
                        <p>Book og betal sikkert via vores platform</p>

                        <a href="" class="btn rz-button rz-large rz-button-accent rz-action-dynamic-explore">Udforsk
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20.3672 11.4328L16.5125 8.74766C16.4445 8.68906 16.3578 8.65625 16.2664 8.65625C16.2664 11.1484 16.2664 8.65625 16.2656 11.1094H3.5625C3.45937 11.1094 3.375 11.1937 3.375 11.2969V12.7031C3.375 12.8063 3.45937 12.8906 3.5625 12.8906L16.3344 12.9201C16.3344 15.3438 16.3344 12.9201 16.3344 15.3438C16.3789 15.3438 16.4234 15.3273 16.4562 15.2969L20.3672 12.5672C20.4483 12.4966 20.5134 12.4095 20.558 12.3116C20.6025 12.2138 20.6256 12.1075 20.6256 12C20.6256 11.8925 20.6025 11.7862 20.558 11.6884C20.5134 11.5905 20.4483 11.5034 20.3672 11.4328Z"
                                      fill="white"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="s-featured brk-row">
                    <div class="s-featured-heading">
                        <h2>Fremhævede behandlere i nærheden af dig</h2>
                        <p>Lorem Ipsum er ganske enkelt fyldtekst fra print- og typografiindustrien. Lorem Ipsum har været standard fyldtekst siden 1500-tallet</p>
                    </div>
                    <div class="s-featured-slider">
                        <div class="s-featured-item">
                            <div class="s-featured-item-inner">
                                <div class="s-featured__image" style="background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/f-1.jpg);">
                                    <div class="s-featured__rating">
                                        <i class="fas fa-star"></i><span class="count">4.4</span>
                                    </div>
                                    <div class="s-featured__favorite"><i class="far fa-heart"></i></div>
                                </div>
                                <div class="s-featured-content">
                                    <h3 class="s-featured__title">Rasmus Nørgaard Abel</h3>
                                    <div class="s-featured__position">
                                        Neurolog, Vertebrolog
                                    </div>
                                    <div class="bh-k">Behandler af højeste kaliber</div>
                                    <div class="bh-b">
                                        <a href="" class="btn-t btn-t-dark">Kontakt</a>
                                        <a href="" class="btn-t btn-t-main">Book tid</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="s-featured-item">
                            <div class="s-featured-item-inner">
                                <div class="s-featured__image" style="background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/f-2.jpg);">
                                    <div class="s-featured__rating">
                                        <i class="fas fa-star"></i><span class="count">4.4</span>
                                    </div>
                                    <div class="s-featured__favorite"><i class="far fa-heart"></i></div>
                                </div>
                                <div class="s-featured-content">
                                    <h3 class="s-featured__title">Rasmus Nørgaard Abel</h3>
                                    <div class="s-featured__position">
                                        Neurolog, Vertebrolog
                                    </div>
                                    <div class="bh-k">Behandler af højeste kaliber</div>
                                    <div class="bh-b">
                                        <a href="" class="btn-t btn-t-dark">Kontakt</a>
                                        <a href="" class="btn-t btn-t-main">Book tid</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="s-featured-item">
                            <div class="s-featured-item-inner">
                                <div class="s-featured__image" style="background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/f-3.jpg);">
                                    <div class="s-featured__rating">
                                        <i class="fas fa-star"></i><span class="count">4.4</span>
                                    </div>
                                    <div class="s-featured__favorite"><i class="far fa-heart"></i></div>
                                </div>
                                <div class="s-featured-content">
                                    <h3 class="s-featured__title">Rasmus Nørgaard Abel</h3>
                                    <div class="s-featured__position">
                                        Neurolog, Vertebrolog
                                    </div>
                                    <div class="bh-k">Behandler af højeste kaliber</div>
                                    <div class="bh-b">
                                        <a href="" class="btn-t btn-t-dark">Kontakt</a>
                                        <a href="" class="btn-t btn-t-main">Book tid</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="s-featured-item">
                            <div class="s-featured-item-inner">
                                <div class="s-featured__image" style="background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/f-1.jpg);">
                                    <div class="s-featured__rating">
                                        <i class="fas fa-star"></i><span class="count">4.4</span>
                                    </div>
                                    <div class="s-featured__favorite"><i class="far fa-heart"></i></div>
                                </div>
                                <div class="s-featured-content">
                                    <h3 class="s-featured__title">Rasmus Nørgaard Abel</h3>
                                    <div class="s-featured__position">
                                        Neurolog, Vertebrolog
                                    </div>
                                    <div class="bh-k">Behandler af højeste kaliber</div>
                                    <div class="bh-b">
                                        <a href="" class="btn-t btn-t-dark">Kontakt</a>
                                        <a href="" class="btn-t btn-t-main">Book tid</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="s-featured-item">
                            <div class="s-featured-item-inner">
                                <div class="s-featured__image" style="background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/f-2.jpg);">
                                    <div class="s-featured__rating">
                                        <i class="fas fa-star"></i><span class="count">4.4</span>
                                    </div>
                                    <div class="s-featured__favorite"><i class="far fa-heart"></i></div>
                                </div>
                                <div class="s-featured-content">
                                    <h3 class="s-featured__title">Rasmus Nørgaard Abel</h3>
                                    <div class="s-featured__position">
                                        Neurolog, Vertebrolog
                                    </div>
                                    <div class="bh-k">Behandler af højeste kaliber</div>
                                    <div class="bh-b">
                                        <a href="" class="btn-t btn-t-dark">Kontakt</a>
                                        <a href="" class="btn-t btn-t-main">Book tid</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="s-featured-item">
                            <div class="s-featured-item-inner">
                                <div class="s-featured__image" style="background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/f-3.jpg);">
                                    <div class="s-featured__rating">
                                        <i class="fas fa-star"></i><span class="count">4.4</span>
                                    </div>
                                    <div class="s-featured__favorite"><i class="far fa-heart"></i></div>
                                </div>
                                <div class="s-featured-content">
                                    <h3 class="s-featured__title">Rasmus Nørgaard Abel</h3>
                                    <div class="s-featured__position">
                                        Neurolog, Vertebrolog
                                    </div>
                                    <div class="bh-k">Behandler af højeste kaliber</div>
                                    <div class="bh-b">
                                        <a href="" class="btn-t btn-t-dark">Kontakt</a>
                                        <a href="" class="btn-t btn-t-main">Book tid</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="s-last-articles">
                <div class="brk-row">
                    <h2 class="h2">Vores seneste artikler</h2>
                </div>
                <div class="s-last-articles-container brk-row">
                    <div class="col">
                        <picture>
                            <source media="(max-width: 799px)" srcset="<?php echo get_stylesheet_directory_uri(); ?>/images/lN-left.jpg">
                            <source media="(min-width: 800px)" srcset="<?php echo get_stylesheet_directory_uri(); ?>/images/lN-left.jpg">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/lN-left.jpg" alt="">
                        </picture>
                    </div>
                    <div class="col">
                        <div class="last-article">
                            <time datetime="2001-05-15 19:00">10.10.2020</time>
                            <h3>A Beautiful Sunday Morning</h3>
                            <p>In mattis scelerisque magna, ut tincidunt ex. Quisque nibh urna, pretium in tristique in, bibendum sed libero. Pellentesque mauris nunc, pretium non erat non,
                                finibus tristique dui.</p>
                            <a href="" class="btn-s-arrow">Læs mere</a>
                        </div>
                        <div class="last-article">
                            <time datetime="2001-05-15 19:00">10.10.2020</time>
                            <h3>A Beautiful Sunday Morning</h3>
                            <p>In mattis scelerisque magna, ut tincidunt ex. Quisque nibh urna, pretium in tristique in, bibendum sed libero. Pellentesque mauris nunc, pretium non erat non,
                                finibus tristique dui.</p>
                            <a href="" class="btn-s-arrow">Læs mere</a>
                        </div>
                    </div>
                </div>
                <div class="brk-row">
                    <a href="" class="btn-centered btn-bordered btn-bordered--white">Udforsk vores videnscenter</a>
                </div>
            </div>

            <div class="s-form">
                <div class="brk-row s-form-container">
                    <div class="s-form-image"></div>
                    <div class="b-form">
                        <div class="">
                            Har du spørgsmål?
                        </div>
                        <div class="">
                            Vi har svarene!
                        </div>
                        <div class="">
                            Forlad din mobiltelefon, så kontaktes vores ledere
                        </div>
                        <?php echo do_shortcode('[contact-form-7 id="2716" title="Contact form 1"]'); ?>
                    </div>
                </div>
            </div>
        <?php } ?>
        </article>
    </div>

    <?php wp_link_pages(); ?>

    <?php if (comments_open($page_id)): ?>
        <?php comments_template(); ?>
    <?php endif; ?>
</main>