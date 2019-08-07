<?php
get_header();
$hook_show_sidebar=$prk_hook_options['woo_sidebar_display'];
if ($hook_show_sidebar=="1")
    $hook_show_sidebar=true;
else
    $hook_show_sidebar=false;
if (isset($_GET["sidebar"])) {
    if ($_GET["sidebar"]=="y") {
        $hook_show_sidebar=true;
    }
    if ($_GET["sidebar"]=="n") {
        $hook_show_sidebar=false;
    }
}
$sidebar_class="hk_sidebar";
if ($hook_show_sidebar==false) {
    $sidebar_class="hk_no_sidebar";
}
if (is_product()) {
    $woo_col_nr="3";
}
else {
    if ($prk_hook_options['woo_col_nr']!="") {
        $woo_col_nr=$prk_hook_options['woo_col_nr'];
    } else {
        $woo_col_nr="4";
    }
}
?>
<div id="hook_ajax_inner" class="hook_cols-<?php echo esc_attr($woo_col_nr).' '.$sidebar_class; ?> hook_forced_menu hook_woo_page woocommerce">
    <div id="hook_content">
<?php
$hook_uppercase="";
if (get_field('uppercase_title')=="1") {
    $hook_uppercase=" uppercased_title";
}
echo '<div id="classic_title_wrapper">';
echo '<div class="small-centered columns prk_inner_block'.esc_attr($hook_uppercase).'">';
hook_output_title();
echo '</div>';
echo '</div>';
if ($hook_show_sidebar) {
    ?>
    <div class="small-centered columns prk_inner_block small-12 row">
    <div class="row">
    <div class="small-9 columns">
    <?php
    woocommerce_content();
    }
    else
    {
    ?>
    <div id="s_sec_wp">
    <div id="hook_super_sections">
    <div id="s_sec_inner" class="row">
    <?php
    if (is_product()) {
        woocommerce_content();
    }
    else {
        ?>
        <div class="small-centered columns prk_inner_block small-12">
            <?php woocommerce_content(); ?>
        </div>
        <?php
    }
}
?>
    <div class="clearfix"></div>
    </div>
<?php
if ($hook_show_sidebar) {
    ?>
    <div id="hook_sidebar" class="<?php echo HOOK_SIDEBAR_CLASSES; ?>">
        <?php
        if (function_exists('dynamic_sidebar') && dynamic_sidebar('prk-woo-sidebar')) { }
        ?>
    </div>
    <div class="clearfix"></div>
    <?php
}
?>
    </div>
    </div>
    </div>
    </div>
<?php get_footer(); ?>