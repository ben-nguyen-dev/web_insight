<?php /* Template Name: Subscription */ ?>
<?php get_header(); 
    $theme_url = get_template_directory_uri();
    ?>
<div class="container">
    <div class="row subscription_page">
        <h1>Välkomna till PI, välj den plan som passar er bäst</h1>
        <div class="subscription_content col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 ">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                    <div class="content_block block1">
                        <div class="logo_text"><img src="<?php echo $theme_url . '/assets/images/logo.png'; ?>"/></div>
                        <div class="logo_img"><img src="<?php echo $theme_url . '/assets/images/big_logo.png'; ?>"/></div>
                        <div class="title"><?php echo get_field('title_1'); ?></div>
                        <div class ="description"><?php echo get_field('description_1'); ?></div>
                        <a class="buy_btn" href="<?php echo esc_url(home_url('/login')); ?>">Skapa ditt konto</a>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                    <div class="content_block block2">
                        <div class="logo_text"><img src="<?php echo $theme_url . '/assets/images/logo.png'; ?>"/></div>
                        <div class="logo_img"><img src="<?php echo $theme_url . '/assets/images/big_logo.png'; ?>"/></div>
                        <div class="title"><?php echo get_field('title_2'); ?></div>
                        <div class ="description"><?php echo get_field('description_2'); ?></div>
                        <a class="buy_btn" href="<?php echo esc_url(home_url('/login')); ?>">Bli kund här</a>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                    <div class="content_block block3">
                        <div class="logo_text"><img src="<?php echo $theme_url . '/assets/images/logo_white.png'; ?>"/></div>
                        <div class="logo_img"><img src="<?php echo $theme_url . '/assets/images/big_logo.png'; ?>"/></div>
                        <div class="title"><?php echo get_field('title_3'); ?></div>
                        <div class ="description"><?php echo get_field('description_3'); ?></div>
                        <a class="buy_btn" href="<?php echo esc_url(home_url('/login')); ?>">Bli kund här</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>