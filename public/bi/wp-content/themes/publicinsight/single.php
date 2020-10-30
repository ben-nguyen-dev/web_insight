<?php get_header(); ?>
<?php
global $post;
$post_type    = get_post_meta($post->ID, 'post_type', true);
$fact_title   = get_post_meta($post->ID, 'fact_title', true);
$fact_content = get_post_meta($post->ID, 'fact_content', true);
$company_info = get_post_meta($post->ID, 'company_info', true);
$thumbnail_id    = get_post_thumbnail_id($post->ID);
$thumbnail_image = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'))[0];
$author_id    = $post->post_author;
?>
<div class="body-content">
    <?php if ($post_type == ANALYSIS) : ?>
        <div class="analysis-top" style="background-image: url('<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($post->id), 'single-post-thumbnail')[0]; ?>');">
            <div class="container">
                <div class="row">
                    <div class="analysis-content">
                        <div class="analysis-cat">
                            <h5 class="analysis-fa"><?php echo $post_type; ?> </h5>
                        </div>
                        <div class="analysis-title">
                            <h2 class="box2-posttitle"><?php echo $post->post_title; ?></h2>
                        </div>
                        <div class="analysis-time">
                            <p>
                                by <?php echo get_the_author_meta('display_name', $author_id); ?>, Public Insight
                                <span>Updated: <?php echo get_the_date('F j,Y') ?></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="container">
        <div class="row no-gutters">
            <?php
            if ($post_type == EXPERT) {
            ?>
                <div class="box-1 col-12">
                    <img src="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($post->id), 'single-post-thumbnail')[0]; ?>" alt="">
                    <p><?php echo $thumbnail_image->post_content; ?></p>
                </div>
            <?php } ?>
            <?php if (($post_type == EXPERT) || ($post_type == SPONSOR)) :  ?>
                <div class="box-2 col-12 <?php echo ($post_type == EXPERT) ? 'blue' : 'peach'; ?>">
                    <div class="box2-title">
                        <div class="box2-top">
                            <ul class="box2-type">
                                <li>
                                    <a class="list-postype" href=""><?php echo $post_type; ?></a>
                                </li>
                            </ul>
                            <h2 class="box2-posttitle"><?php echo $post->post_title; ?></h2>
                            <div class="clearfix">
                                <p class="box2-author float-left">by <?php echo get_the_author_meta('display_name', $author_id); ?>, Public Insight <span><?php echo date("m.d.y", strtotime($post->post_date)); ?></span></p>
                                <?php
                                if ($post_type == EXPERT) {
                                ?>
                                    <ul class="box-social float-right">
                                        <li>
                                            <a>
                                                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/image/fb.png'; ?>" />
                                            </a>
                                        </li>
                                        <li>
                                            <a>
                                                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/image/tw.png'; ?>" />
                                            </a>
                                        </li>
                                        <li>
                                            <a>
                                                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/image/li.png'; ?>" />
                                            </a>
                                        </li>
                                    </ul>
                                <?php } elseif ($post_type == SPONSOR) { ?>
                                    <ul class="box-social float-right">
                                        <li>
                                            <a>
                                                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/image/fb-sponsor.png'; ?>" />
                                            </a>
                                        </li>
                                        <li>
                                            <a>
                                                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/image/tw-sponsor.png'; ?>" />
                                            </a>
                                        </li>
                                        <li>
                                            <a>
                                                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/image/li-sponsor.png'; ?>" />
                                            </a>
                                        </li>
                                    </ul>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="box-3 col-12 ">
                <div class="row">
                    <?php if ($post_type == SPONSOR) : ?>
                        <div class="box3-left box3-sponsor">
                            <div class="btn-sponsor">
                                <p> <span id="sponsor"><?php echo $post_type; ?></span> This article is written by one of our experts, <span id="svensson"><?php echo get_the_author_meta('display_name', $author_id); ?></span></p>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="col-md-8">
                        <div class="box3-left <?php echo ($post_type == ANALYSIS) ? 'analysis-left' : ''; ?>">
                            <?php if ($post_type == EXPERT) { ?>
                                <div class="btn-expert">
                                    <p> <span id="expert"><?php echo $post_type; ?></span> This article is written by one of our experts, <span id="svensson"><?php echo get_the_author_meta('display_name', $author_id); ?></span></p>
                                </div>
                            <?php } elseif ($post_type == ANALYSIS) { ?>
                                <div class="btn-analysis">
                                    <p> <span id="analysis"><?php echo $post_type; ?></span> This article is written by one of our experts, <span id="svensson"><?php echo get_the_author_meta('display_name', $author_id); ?></span></p>
                                </div>
                            <?php } ?>
                            <div class="article-content">
                                <div class="content-box <?php echo ($post_type == SPONSOR) ? 'sponsor-content' : ''; ?>">
                                    <h4 class="article-except"><?php echo the_excerpt(); ?></h4>
                                    <?php if ($post_type == SPONSOR) { ?>
                                        <div class="box-1 col-12">
                                            <img src="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($post->id), 'single-post-thumbnail')[0]; ?>" alt="">
                                            <p><?php echo $thumbnail_image->post_content; ?></p>
                                        </div>
                                    <?php } ?>
                                    <?php echo $post->post_content; ?>
                                </div>
                                <!-- <h5>There’s no one-size-fits-all solution to alternative business financing. Here are the five sources we are backing. With growing businesses in particular, there will be a need for a mix of finance, term loans and cash-flow.</h5>
                                <div class="article-page-teaser-content content-first">With growing businesses in particular, there will be a need for a mix of finance, which may include commercial mortgage, term loans and cash-flow finance. Equity or angel investment may be more suitable for high-growth, higher-risk opportunities,” says Jeff Long, SME consultant with national network Business Doctors. With growing businesses in particular, there will be a need for a mix of finance, which may include commercial mortgage, term loans and cash-flow finance. Equity or angel investment may be more suitable for high-growth, higher-risk opportunities,” says Jeff Long, SME consultant with national Business Doctors.Crowdfunding might be all the rage at the moment but is it right for you? Seedrs is the first regulated investment platform in the world and to date more than £160m has been invested on the platform.</div> -->
                                <!-- <h3 class="expert-borderleft <?php echo ($post_type == SPONSOR) ? 'sponsor' : ''; ?>">”Five ways to source alternative financing for your business”</h3> -->
                            </div>
                            <?php if ($post_type == EXPERT || $post_type == SPONSOR) { ?>
                                <?php if ($fact_title || $fact_content) { ?>
                                    <div class="article-fact">
                                        <?php if ($post_type == EXPERT) { ?>
                                            <h3 class="title-facts">FACTS</h3>
                                        <?php } else { ?>
                                            <h3 class="title-facts facts-sponsor">FACTS</h3>
                                        <?php } ?>
                                        <h2 class="article-title"><?php echo $fact_title; ?></h2>
                                        <p class="article-content">
                                            <?php echo $fact_content; ?>
                                        </p>
                                    </div>
                                <?php  } ?>
                            <?php } ?>
                            <?php 
                                wpse_get_template_part('template-parts/request-depth-analysis', null, array('post' => $post, 'post_type' => $post_type));
                            ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <?php if ($post_type == ANALYSIS) : ?>
                            <div class="social-analysis clearfix">
                                <h6 class="share-analysis float-left">Share with:</h6>
                                <ul class="box-social float-left">
                                    <li>
                                        <a>
                                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/image/facebook.png'; ?>">
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/image/twitter.png'; ?>">
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/image/linkedin.png'; ?>">
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <?php if ($company_info) : ?>
                            <div class="box3-right float-right">
                                <?php the_field('company_info', $post->ID, true) ?>
                                <!-- <img src="<?php echo get_avatar_url($author_id); ?>" />
                            <div class="box3-content">
                                <h4 class="author-name"><?php echo get_the_author_meta('display_name', $author_id); ?></h4>
                                <p classs="author-description"><?php echo get_the_author_meta('description', $author_id); ?></p>
                                <a href="" class="author-readmore">Read more</a>
                            </div> -->
                            </div>
                        <?php endif; ?>
                        <div class="function-for-article">
                            <?php
                            wpse_get_template_part('template-parts/function-for-article-template', null, array('post' => $post, 'post_type' => $post_type));
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-12 mx-auto">
                    <div class="box-register text-center">
                        <h3 class="registrera-title">Registrera dig hos oss</h3>
                        <h5 class="registrera-excerpt">Och få förslag om passande affärer för ditt företag.</h5>
                        <form action="">
                            <input type="text" class="form-control" id="input-register" placeholder="Fyll i din e-mail adress och skapa konto i nästa steg">
                            <button class="btn submit-register">SKAPA KONTO</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="box5-title">
                        <h3 class="title-expert">Mer från våra <?php echo $post_type; ?></h3>
                    </div>
                </div>
                <div class="col-12">
                    <div class="box5-body slider multiple-items">
                        <?php
                        $args = array(
                            'post_status' => 'publish',
                            'meta_key'   => 'post_type',
                            'meta_value' => $post_type,
                            'post_type'  => 'post'
                        );
                        $postslist = get_posts($args);
                        foreach ($postslist as $post) :  setup_postdata($post);
                        ?>
                            <div class="box5-slider">
                                <a href="<?php the_permalink();  ?>">
                                    <img src="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($post->id), 'single-post-thumbnail')[0]; ?>" alt="">
                                </a>
                                <div class="box5-text">
                                    <h5 class="postype-expert"><?php echo $post_type; ?></h5>
                                    <a class="expert-link" href="<?php the_permalink(); ?>"><?php echo $post->post_title; ?></a>
                                    <p class="expert-time"> <?php echo date("m.d.y, g:ia", strtotime($post->post_date)); ?><br />
                                        by <?php echo get_the_author_meta('display_name', $post->post_author); ?>, Public Insight</p>
                                </div>
                            </div>
                        <?php
                        endforeach
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box-6">
        <div class="container">
            <div class="row">
                <div class="box6-title col-12">
                    <h3 class="title-expert">Mer från Public Insight</h3>
                </div>
            </div>
            <?php
            $args = array(
                'post_status'    => 'publish',
                'post_type'      => 'post',
                'orderby'        => 'post_date',
                'order'          => 'DESC',
                'posts_per_page' => '4'
            );
            $news_post = new WP_Query($args);
            if ($news_post->have_posts()) :
                while ($news_post->have_posts()) : $news_post->the_post();
            ?>
                    <div class="row">
                        <div class="col-md-9">
                            <div class="box6-body">
                                <div class="box6-block">
                                    <h5 class="postype-expert"><?php echo get_post_meta(get_the_ID(), 'post_type')[0]; ?></h5>
                                    <a class="postnew-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    <p class="postnew-time"><?php echo get_the_date('m.d.y') ?><br />
                                        By <?php echo get_the_author_meta('display_name', $news_post->post_author); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="box6-right">
                                <img src="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail')[0]; ?>" />
                            </div>
                        </div>
                    </div>
            <?php
                endwhile;
            endif;
            ?>
        </div>
    </div>
    <?php if (($post_type == EXPERT) || ($post_type == SPONSOR)) : ?>
        <div class="box-7">
            <div class="container">
                <div class="row">
                    <div class="col-md-9 col-12">
                        <?php
                        $args = array(
                            'post_status'    => 'publish',
                            'post_type'      => 'post',
                            'orderby'        => 'post_date',
                            'meta_key'       => 'post_type',
                            'meta_value'     =>  SPONSOR,
                            'order'          => 'DESC',
                            'posts_per_page' => '1'
                        );
                        $post_sponsor = new WP_Query($args);
                        if ($post_sponsor->have_posts()) :
                            while ($post_sponsor->have_posts()) : $post_sponsor->the_post();
                        ?>
                                <div class="article-page web">
                                    <div class="color-fill color-fill-first">
                                        <div class="green max-size"></div>
                                        <div class="light-blue medium-size margin"></div>
                                        <div class="blue medium-size margin"></div>
                                        <div class="navy medium-size margin"></div>
                                    </div>
                                    <div class="article-page-header">
                                        <div class="article-page-teaser-tag"><?php echo get_post_meta(get_the_ID(), 'post_type')[0]; ?></div>
                                        <div class="article-page-teaser-title"><?php the_title(); ?></div>
                                        <div class="block-social clearfix">
                                            <div class="article-page-teaser-author-date float-left"><span>by <?php echo get_the_author_meta('display_name', $post->post_author); ?>, Public Insight </span><br><span><?php echo get_the_date('m.d.y, H:ia') ?></span></div>
                                            <div class="socials float-right">
                                                <ul class="box-social">
                                                    <li>
                                                        <a>
                                                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/image/fb.png'; ?>" />
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a>
                                                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/image/tw.png'; ?>" />
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a>
                                                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/image/li.png'; ?>" />
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="article-page-description">
                                        <div class="article-page-teaser-preamble"><?php the_excerpt(); ?></div>
                                        <img class="article-page-teaser-main-image" src="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail')[0]; ?>">
                                        <div class="article-page-teaser-image-description">
                                            <?php echo $thumbnail_image->post_content; ?>
                                        </div>
                                    </div>
                                    <div class="article-page-content">
                                        <div class="article-page-teaser-content content-first"><?php echo get_the_content(); ?></div>
                                    </div>
                                </div>
                                <div class="box7-keep">
                                    <div class="keep-reading">
                                        <a href="<?php the_permalink(); ?>" target="_blank">Keep reading</a>
                                    </div>
                                    <div class="color-fill color-fill-first col-fill-2">
                                        <div class="navy medium-size margin"></div>
                                        <div class="blue medium-size margin"></div>
                                        <div class="light-blue medium-size margin"></div>
                                        <div class="green max-size"></div>
                                    </div>
                                </div>
                        <?php
                            endwhile;
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php get_footer(); ?>