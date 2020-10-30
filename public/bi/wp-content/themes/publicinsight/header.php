<?php

/**
 * Header file for the Twenty Twenty WordPress default theme.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

?>
<!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="header">
		<div class="header-menu">
			<div class="header-navbar">
				<div class="container">
					<div class="row no-gutters">
						<div class="header-content col-12">
							<nav class="navbar">
								<a href="" class="navbar-brand header-logo">
									<img src="<?php echo get_stylesheet_directory_uri() . '/assets/image/logo.png' ?>" />
								</a>
								<div class="form-inline navbar-nav">
									<ul class="navbar-nav nav-list">
										<li>
											<a class="btn btn-primary btn-loggin" href="/bi/login" >logga in </a>
										</li>
										<li id="menu-open">
											<a href="">meny</a>
										</li>
									</ul>
								</div>
							</nav>
						</div>
					</div>
				</div>
			</div>
			<div class="menu-top">
				<div class="block-right">
					<div class="btn-menu">
						<a href="/bi/login" class="btn btn-menu-mb btn-loggin-mb">Logga in</a>
						<a href="" class="btn btn-menu-mb btn-back-mb">Bli kund</a>
					</div>
					<div class="name-description">
						<h4 class="name-login">Mitt konto</h4>
						<h3 class="text-desc"> <span>Logga in!</span> <br />
							Vi hjälper dig att göra bättre offentliga affärer</h3>
					</div>
				</div>
				<div class="block-loggin">
					<div class="block-loggin clearfix">
						<div class="loggin-img float-left">
						<img src="<?php echo get_stylesheet_directory_uri() . '/assets/image/avatar.png' ?>" />
						</div>
						<div class="loggin-info float-left">
							<h4 class="user-title">Förnamn</h4>
							<h4 class="user-title">Efternamn</h4>
							<p>Titel, företag</p>
						</div>
					</div>
					<h4 class="name-login">Mitt konto</h4>
					<div class="list-block">
						<ul class="list-item">
							<li>
								<p>
									Lorem ipsum <br />
									Xxx
								</p>
							</li>
							<li>
								<p>
									Lorem ipsum <br />
									Xxx
								</p>
							</li>
						</ul>
					</div>	
				</div>
				<div class="menu-block">
					<div class="block-1">
						<a href="#">
							<img src="<?php echo get_stylesheet_directory_uri(). '/assets/image/back-menu.png'; ?>" />
							<h3 class="text-desc"> <span>Erbjudande</span> <br />
							Mixtape hot <br/> chicken etsy <br /> photo</h3>
						</a>
					</div>
				</div>
			</div>
			<div class="menu-bottom-mb">
				<div class="container">
					<div class="row">
						<div class="col-md-4 col-12">
							<div class="menu-list">
								<h4 class="menu-title">För Leverantörer</h4>
								<ul class="list-item">
									<li>
										<a href="">Bi</a>
									</li>
									<li>
										<a href="">Match</a>
									</li>
									<li>
										<a href="">Works</a>
									</li>
									<li>
										<a href="">Trade</a>
									</li>
									<li>
										<a href="">Forum</a>
									</li>
								</ul>
								<div class="post-menu">
									<a href="">
										<img src="<?php echo get_stylesheet_directory_uri(). '/assets/image/back-menu.png'; ?>" />
										<h3 class="post-menu-text">
											<span>Works.</span>	
											Mixtape hot chicken etsy photo
										</h3>
									</a>
								</div>
							</div>
						</div>
						<div class="col-md-4 col-12">
							<div class="menu-list">
								<h4 class="menu-title">För Leverantörer</h4>
								<ul class="list-item">
									<li>
										<a href="">BI</a>
									</li>
									<li>
										<a href="">Call</a>
									</li>
									<li>
										<a href="">Forum</a>
									</li>
									<li>
										<a href="">trade</a>
									</li>
									<li>
										<a href="">Qualify</a>
									</li>
								</ul>
								<div class="post-menu">
									<a href="">
										<img src="<?php echo get_stylesheet_directory_uri(). '/assets/image/back-menu.png'; ?>" />
										<h3 class="post-menu-text">
											<span>Call.</span>	
											Mixtape hot chicken etsy photo
										</h3>
									</a>
								</div>
							</div>
						</div>
						<div class="col-md-4 col-12">
							<div class="menu-list">
								<h4 class="menu-title">För Leverantörer</h4>
								<ul class="list-item">
									<li>
										<a href="">Seriositetskontroll</a>
									</li>
									<li>
										<a href="">Market</a>
									</li>
									<li>
										<a href="">Om Oss</a>
									</li>
									<li>
										<a href="">Kontakt</a>
									</li>
								</ul>
								<div class="post-menu">
									<a href="">
										<img src="<?php echo get_stylesheet_directory_uri(). '/assets/image/back-menu.png'; ?>" />
										<h3 class="post-menu-text">
											<span>Forum.</span>	
											Mixtape hot chicken etsy photo
										</h3>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>