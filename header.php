<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<?php
if (!defined('THEME_VERSION')) {
    define('THEME_VERSION', '1.0.2');
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php $this->archiveTitle(); ?> - <?php $this->options->title(); ?></title>

<?php
    $favicon = $this->options->websiteAvatar ? $this->options->websiteAvatar : '/usr/themes/rchizone/assets/img/icon.png';
?>

<link rel="icon" href="<?php echo $favicon; ?>" type="image/png">

<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/body.css'); ?>?v=<?php echo THEME_VERSION; ?>">
<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/icon.css'); ?>?v=<?php echo THEME_VERSION; ?>">

<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/index_hero.css'); ?>?v=<?php echo THEME_VERSION; ?>">
<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/index_card.css'); ?>?v=<?php echo THEME_VERSION; ?>">
<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/index_page.css'); ?>?v=<?php echo THEME_VERSION; ?>">
<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/index_module.css'); ?>?v=<?php echo THEME_VERSION; ?>">

<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/post_hero.css'); ?>?v=<?php echo THEME_VERSION; ?>">
<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/post_content.css'); ?>?v=<?php echo THEME_VERSION; ?>">
<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/links.css'); ?>?v=<?php echo THEME_VERSION; ?>">
<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/comments.css'); ?>?v=<?php echo THEME_VERSION; ?>">

<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/modal.css'); ?>?v=<?php echo THEME_VERSION; ?>">
<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/backtotop.css'); ?>?v=<?php echo THEME_VERSION; ?>">
<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/footer.css'); ?>?v=<?php echo THEME_VERSION; ?>">

</head>

<body>