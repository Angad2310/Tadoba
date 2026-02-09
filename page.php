<?php
/**
 * Default Page Template
 */
get_header(); ?>

<main class="site-main">

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1 class="page-title"><?php the_title(); ?></h1>
            <?php if (function_exists('yoast_breadcrumb')): ?>
                <?php yoast_breadcrumb('<p class="breadcrumbs">', '</p>'); ?>
            <?php endif; ?>
        </div>
    </section>

    <!-- Page Content -->
    <section class="page-content">
        <div class="container">
            <article class="page-article">
                <?php
                while (have_posts()): the_post();
                    the_content();
                endwhile;
                ?>
            </article>
        </div>
    </section>

</main>

<?php get_footer(); ?>