<?php
get_header();
the_post();
global $post;
?>
<main class="page__default">
    <section>
        <div class="container">
            <div class="video">
                <div class="wistia_responsive_padding" style="padding:56.25% 0 0 0;position:relative;">
                    <div class="wistia_responsive_wrapper" style="height:100%;left:0;position:absolute;top:0;width:100%;"><iframe src="https://fast.wistia.net/embed/iframe/86xc4t7z04?seo=false&videoFoam=true" title=" [Example Video] Wistia Video Essentials" allow="autoplay; fullscreen" allowtransparency="true" frameborder="0" scrolling="no" class="wistia_embed" name="wistia_embed" msallowfullscreen width="100%" height="100%"></iframe></div>
                </div>
            </div>
        </div>


    </section>

</main>

<div class="modal">
    <div class="modal__inner">
        <div class="modal__form">
            <form id="login" action="login" method="post">
                <h1>Site Login</h1>
                <p class="status"></p>
                <label for="username">Username</label>
                <input id="username" type="text" name="username">
                <label for="password">Password</label>
                <input id="password" type="password" name="password">
                <a class="lost" href="<?php echo wp_lostpassword_url(); ?>">Lost your password?</a>
                <input class="submit_button" type="submit" value="Login" name="submit">
                <?php wp_nonce_field('ajax-login-nonce', 'ajax-login-nonce'); ?>
            </form>
        </div>
    </div>
</div>


<?php get_footer(); ?>



//iff not add modal with login in screen that blocks similar_text

//when logged in, remove modal and continue video