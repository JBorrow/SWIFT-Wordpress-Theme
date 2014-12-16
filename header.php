<!DOCTYPE html>

<html>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width">
        <title><?php bloginfo('title');?></title>
        <link rel="stylesheet" href="<?php bloginfo('stylesheet_url');?>" type="text/css" media="screen"/>
        <?php wp_head();?>
    </head>

<body>
    <div class="header">
        <h1><?php bloginfo('name') ?></h1>
        <h2><?php bloginfo('description') ?></h2>
    </div>
	<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'navbar' ) ); ?>

