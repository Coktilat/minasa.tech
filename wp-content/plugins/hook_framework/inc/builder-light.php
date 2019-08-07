<?php
/** @noinspection PhpMissingDocCommentInspection */
if (!function_exists('hook_integrateWithVC')) {
    function hook_integrateWithVC() {
        if (function_exists('vc_set_as_theme')) {
            vc_set_as_theme(true);
        }
        add_filter( 'vc_iconpicker-type-material_icons', 'vc_iconpicker_type_material_icons' );
        /**
         * Linecons icons from fontello.com
         *
         * @param $icons - taken from filter - vc_map param field settings['source'] provided icons (default empty array).
         * If array categorized it will auto-enable category dropdown
         *
         * @since 4.4
         * @return array - of icons for iconpicker, can be categorized, or not.
         */
        function vc_iconpicker_type_material_icons( $icons ) {
            $material_icons_icons = array(
                array( "mdi-account" => esc_html__( "Account", "js_composer" ) ),
                array( "mdi-account-alert" => esc_html__( "Account alert", "js_composer" ) ),
                array( "mdi-account-box" => esc_html__( "Account box", "js_composer" ) ),
                array( "mdi-account-box-outline" => esc_html__( "Account box outline", "js_composer" ) ),
                array( "mdi-account-check" => esc_html__( "Account check", "js_composer" ) ),
                array( "mdi-account-circle" => esc_html__( "Account circle", "js_composer" ) ),
                array( "mdi-account-key" => esc_html__( "Account key", "js_composer" ) ),
                array( "mdi-account-location" => esc_html__( "Account location", "js_composer" ) ),
                array( "mdi-account-minus" => esc_html__( "Account minus", "js_composer" ) ),
                array( "mdi-account-multiple" => esc_html__( "Account multiple", "js_composer" ) ),
                array( "mdi-account-multiple-outline" => esc_html__( "Account multiple outline", "js_composer" ) ),
                array( "mdi-account-multiple-plus" => esc_html__( "Account multiple plus", "js_composer" ) ),
                array( "mdi-account-network" => esc_html__( "Account network", "js_composer" ) ),
                array( "mdi-account-outline" => esc_html__( "Account outline", "js_composer" ) ),
                array( "mdi-account-plus" => esc_html__( "Account plus", "js_composer" ) ),
                array( "mdi-account-remove" => esc_html__( "Account remove", "js_composer" ) ),
                array( "mdi-account-search" => esc_html__( "Account search", "js_composer" ) ),
                array( "mdi-account-star" => esc_html__( "Account star", "js_composer" ) ),
                array( "mdi-account-star-variant" => esc_html__( "Account star variant", "js_composer" ) ),
                array( "mdi-account-switch" => esc_html__( "Account switch", "js_composer" ) ),
                array( "mdi-airballoon" => esc_html__( "Airballon", "js_composer" ) ),
                array( "mdi-airplane" => esc_html__( "Airplane", "js_composer" ) ),
                array( "mdi-airplane-off" => esc_html__( "Airplane off", "js_composer" ) ),
                array( "mdi-alarm" => esc_html__( "Alarm", "js_composer" ) ),
                array( "mdi-alarm-check" => esc_html__( "Alarm check", "js_composer" ) ),
                array( "mdi-alarm-multiple" => esc_html__( "Alarm multiple", "js_composer" ) ),
                array( "mdi-alarm-off" => esc_html__( "Alarm off", "js_composer" ) ),
                array( "mdi-alarm-plus" => esc_html__( "Alarm plus", "js_composer" ) ),
                array( "mdi-album" => esc_html__( "Album", "js_composer" ) ),
                array( "mdi-alert" => esc_html__( "Alert", "js_composer" ) ),
                array( "mdi-alert-box" => esc_html__( "Alert box", "js_composer" ) ),
                array( "mdi-alert-circle" => esc_html__( "Alert circle", "js_composer" ) ),
                array( "mdi-alert-octagon" => esc_html__( "Alert octagon", "js_composer" ) ),
                array( "mdi-alpha" => esc_html__( "Alpha", "js_composer" ) ),
                array( "mdi-alphabetical" => esc_html__( "Alphabetical", "js_composer" ) ),
                array( "mdi-amazon" => esc_html__( "Amazon", "js_composer" ) ),
                array( "mdi-amazon-clouddrive" => esc_html__( "Amazon clouddrive", "js_composer" ) ),
                array( "mdi-ambulance" => esc_html__( "Ambulance", "js_composer" ) ),
                array( "mdi-android" => esc_html__( "Android", "js_composer" ) ),
                array( "mdi-android-debug-bridge" => esc_html__( "Android debug bridge", "js_composer" ) ),
                array( "mdi-android-studio" => esc_html__( "Android studio", "js_composer" ) ),
                array( "mdi-apple" => esc_html__( "Apple", "js_composer" ) ),
                array( "mdi-apple-finder" => esc_html__( "Apple finder", "js_composer" ) ),
                array( "mdi-apple-mobileme" => esc_html__( "Apple mobile me", "js_composer" ) ),
                array( "mdi-apple-safari" => esc_html__( "Apple safari", "js_composer" ) ),
                array( "mdi-appnet" => esc_html__( "Appnet", "js_composer" ) ),
                array( "mdi-apps" => esc_html__( "Apps", "js_composer" ) ),
                array( "mdi-archive" => esc_html__( "Archive", "js_composer" ) ),
                array( "mdi-arrange-bring-forward" => esc_html__( "Arrange bring forward", "js_composer" ) ),
                array( "mdi-arrange-bring-to-front" => esc_html__( "Arrange bring to front", "js_composer" ) ),
                array( "mdi-arrange-send-backward" => esc_html__( "Arrange send backward", "js_composer" ) ),
                array( "mdi-arrange-send-to-back" => esc_html__( "Arrange send to back", "js_composer" ) ),
                array( "mdi-arrow-collapse" => esc_html__( "Arrow collapse", "js_composer" ) ),
                array( "mdi-arrow-down" => esc_html__( "Arrow down", "js_composer" ) ),
                array( "mdi-arrow-down-bold" => esc_html__( "Arrow down bold", "js_composer" ) ),
                array( "mdi-arrow-down-bold-circle" => esc_html__( "Arrow down bold circle", "js_composer" ) ),
                array( "mdi-arrow-down-bold-circle-outline" => esc_html__( "Arrow down bold circle outline", "js_composer" ) ),
                array( "mdi-arrow-down-bold-hexagon-outline" => esc_html__( "Arrow down bold hexagon outline", "js_composer" ) ),
                array( "mdi-arrow-expand" => esc_html__( "Arrow expand", "js_composer" ) ),
                array( "mdi-arrow-left" => esc_html__( "Arrow left", "js_composer" ) ),
                array( "mdi-arrow-left-bold" => esc_html__( "Arrow left bold", "js_composer" ) ),
                array( "mdi-arrow-left-bold-circle" => esc_html__( "Arrow left bold circle", "js_composer" ) ),
                array( "mdi-arrow-left-bold-circle-outline" => esc_html__( "Arrow left bold circle outline", "js_composer" ) ),
                array( "mdi-arrow-left-bold-hexagon-outline" => esc_html__( "Arrow left bold hexagon outline", "js_composer" ) ),
                array( "mdi-arrow-right" => esc_html__( "Arrow right", "js_composer" ) ),
                array( "mdi-arrow-right-bold" => esc_html__( "Arrow right bold", "js_composer" ) ),
                array( "mdi-arrow-right-bold-circle" => esc_html__( "AArrow right bold circle", "js_composer" ) ),
                array( "mdi-arrow-right-bold-circle-outline" => esc_html__( "Arrow right bold circle outline", "js_composer" ) ),
                array( "mdi-arrow-right-bold-hexagon-outline" => esc_html__( "Arrow right bold hexagon outline", "js_composer" ) ),
                array( "mdi-arrow-up" => esc_html__( "Arrow up", "js_composer" ) ),
                array( "mdi-arrow-up-bold" => esc_html__( "Arrow up bold", "js_composer" ) ),
                array( "mdi-arrow-up-bold-circle" => esc_html__( "Arrow up bold circle", "js_composer" ) ),
                array( "mdi-arrow-up-bold-circle-outline" => esc_html__( "Arrow up bold circle outline", "js_composer" ) ),
                array( "mdi-arrow-up-bold-hexagon-outline" => esc_html__( "Arrow up bold circle hexagon outline", "js_composer" ) ),
                array( "mdi-attachment" => esc_html__( "Attachment", "js_composer" ) ),
                array( "mdi-auto-fix" => esc_html__( "Auto fix", "js_composer" ) ),
                array( "mdi-auto-upload" => esc_html__( "Auto upload", "js_composer" ) ),
                array( "mdi-backup-restore" => esc_html__( "Backup restore", "js_composer" ) ),
                array( "mdi-bank" => esc_html__( "Bank", "js_composer" ) ),
                array( "mdi-barcode" => esc_html__( "Barcode", "js_composer" ) ),
                array( "mdi-barley" => esc_html__( "Barley", "js_composer" ) ),
                array( "mdi-barrel" => esc_html__( "Barrel", "js_composer" ) ),
                array( "mdi-basecamp" => esc_html__( "Basecamp", "js_composer" ) ),
                array( "mdi-basket" => esc_html__( "Basket", "js_composer" ) ),
                array( "mdi-basket-fill" => esc_html__( "Basket fill", "js_composer" ) ),
                array( "mdi-basket-unfill" => esc_html__( "Basket unfill", "js_composer" ) ),
                array( "mdi-battery" => esc_html__( "Battery", "js_composer" ) ),
                array( "mdi-battery-20" => esc_html__( "Battery 20", "js_composer" ) ),
                array( "mdi-battery-30" => esc_html__( "Battery 30", "js_composer" ) ),
                array( "mdi-battery-40" => esc_html__( "Battery 40", "js_composer" ) ),
                array( "mdi-battery-60" => esc_html__( "Battery 60", "js_composer" ) ),
                array( "mdi-battery-80" => esc_html__( "Battery 80", "js_composer" ) ),
                array( "mdi-battery-90" => esc_html__( "Battery 90", "js_composer" ) ),
                array( "mdi-battery-alert" => esc_html__( "Battery alert", "js_composer" ) ),
                array( "mdi-battery-charging-100" => esc_html__( "Battery charging 100", "js_composer" ) ),
                array( "mdi-battery-charging-20" => esc_html__( "Battery charging 20", "js_composer" ) ),
                array( "mdi-battery-charging-30" => esc_html__( "Battery charging 30", "js_composer" ) ),
                array( "mdi-battery-charging-40" => esc_html__( "Battery charging 40", "js_composer" ) ),
                array( "mdi-battery-charging-60" => esc_html__( "Battery charging 60", "js_composer" ) ),
                array( "mdi-battery-charging-80" => esc_html__( "Battery charging 80", "js_composer" ) ),
                array( "mdi-battery-charging-90" => esc_html__( "Battery charging 90", "js_composer" ) ),
                array( "mdi-battery-minus" => esc_html__( "Battery minus", "js_composer" ) ),
                array( "mdi-battery-negative" => esc_html__( "Battery negative", "js_composer" ) ),
                array( "mdi-battery-outline" => esc_html__( "Battery outline", "js_composer" ) ),
                array( "mdi-battery-plus" => esc_html__( "Battery plus", "js_composer" ) ),
                array( "mdi-battery-positive" => esc_html__( "Battery positive", "js_composer" ) ),
                array( "mdi-battery-unknown" => esc_html__( "Battery unknown", "js_composer" ) ),
                array( "mdi-beaker" => esc_html__( "Beaker", "js_composer" ) ),
                array( "mdi-beaker-empty" => esc_html__( "Beaker empty", "js_composer" ) ),
                array( "mdi-beaker-empty-outline" => esc_html__( "Beaker empty outline", "js_composer" ) ),
                array( "mdi-beaker-outline" => esc_html__( "Beaker outline", "js_composer" ) ),
                array( "mdi-beats" => esc_html__( "Beats", "js_composer" ) ),
                array( "mdi-beer" => esc_html__( "Beer", "js_composer" ) ),
                array( "mdi-behance" => esc_html__( "Behance", "js_composer" ) ),
                array( "mdi-bell" => esc_html__( "Bell", "js_composer" ) ),
                array( "mdi-bell-off" => esc_html__( "Bell off", "js_composer" ) ),
                array( "mdi-bell-outline" => esc_html__( "Bell outline", "js_composer" ) ),
                array( "mdi-bell-ring" => esc_html__( "Bell ring", "js_composer" ) ),
                array( "mdi-bell-ring-outline" => esc_html__( "Bell ring outline", "js_composer" ) ),
                array( "mdi-bell-sleep" => esc_html__( "Bell sleep", "js_composer" ) ),
                array( "mdi-beta" => esc_html__( "Beta", "js_composer" ) ),
                array( "mdi-bike" => esc_html__( "Bike", "js_composer" ) ),
                array( "mdi-bing" => esc_html__( "Bing", "js_composer" ) ),
                array( "mdi-bio" => esc_html__( "Bio", "js_composer" ) ),
                array( "mdi-biohazard" => esc_html__( "Biohazard", "js_composer" ) ),
                array( "mdi-blackberry" => esc_html__( "Blackberry", "js_composer" ) ),
                array( "mdi-blinds" => esc_html__( "Blinds", "js_composer" ) ),
                array( "mdi-block-helper" => esc_html__( "Block helper", "js_composer" ) ),
                array( "mdi-blogger" => esc_html__( "Blogger", "js_composer" ) ),
                array( "mdi-bluetooth" => esc_html__( "Bluetooth", "js_composer" ) ),
                array( "mdi-bluetooth-audio" => esc_html__( "Bluetooth audio", "js_composer" ) ),
                array( "mdi-bluetooth-connect" => esc_html__( "Bluetooth connect", "js_composer" ) ),
                array( "mdi-bluetooth-settings" => esc_html__( "Bluetooth settings", "js_composer" ) ),
                array( "mdi-blur" => esc_html__( "Blur", "js_composer" ) ),
                array( "mdi-blur-linear" => esc_html__( "Blur linear", "js_composer" ) ),
                array( "mdi-blur-off" => esc_html__( "Blur off", "js_composer" ) ),
                array( "mdi-blur-radial" => esc_html__( "Blur radial", "js_composer" ) ),
                array( "mdi-book" => esc_html__( "Book", "js_composer" ) ),
                array( "mdi-book-multiple" => esc_html__( "Book multiple", "js_composer" ) ),
                array( "mdi-book-multiple-variant" => esc_html__( "Book multiple variant", "js_composer" ) ),
                array( "mdi-book-open" => esc_html__( "Book open", "js_composer" ) ),
                array( "mdi-book-variant" => esc_html__( "Book variant", "js_composer" ) ),
                array( "mdi-bookmark" => esc_html__( "Bookmark", "js_composer" ) ),
                array( "mdi-bookmark-outline" => esc_html__( "Bookmark outline", "js_composer" ) ),
                array( "mdi-border-all" => esc_html__( "Border all", "js_composer" ) ),
                array( "mdi-border-bottom" => esc_html__( "Border bottom", "js_composer" ) ),
                array( "mdi-border-color" => esc_html__( "Border color", "js_composer" ) ),
                array( "mdi-border-horizontal" => esc_html__( "Border horizontal", "js_composer" ) ),
                array( "mdi-border-inside" => esc_html__( "Border inside", "js_composer" ) ),
                array( "mdi-border-left" => esc_html__( "Border left", "js_composer" ) ),
                array( "mdi-border-none" => esc_html__( "Border none", "js_composer" ) ),
                array( "mdi-border-outside" => esc_html__( "Border outside", "js_composer" ) ),
                array( "mdi-border-right" => esc_html__( "Border right", "js_composer" ) ),
                array( "mdi-border-top" => esc_html__( "Border top", "js_composer" ) ),
                array( "mdi-border-vertical" => esc_html__( "Border vertical", "js_composer" ) ),
                array( "mdi-bowling" => esc_html__( "Bowling", "js_composer" ) ),
                array( "mdi-box" => esc_html__( "Box", "js_composer" ) ),
                array( "mdi-briefcase" => esc_html__( "Briefcase", "js_composer" ) ),
                array( "mdi-briefcase-check" => esc_html__( "Briefcase check", "js_composer" ) ),
                array( "mdi-briefcase-download" => esc_html__( "Briefcase download", "js_composer" ) ),
                array( "mdi-briefcase-upload" => esc_html__( "Briefcase upload", "js_composer" ) ),
                array( "mdi-brightness-1" => esc_html__( "Brightness 1", "js_composer" ) ),
                array( "mdi-brightness-2" => esc_html__( "Brightness 2", "js_composer" ) ),
                array( "mdi-brightness-3" => esc_html__( "Brightness 3", "js_composer" ) ),
                array( "mdi-brightness-4" => esc_html__( "Brightness 4", "js_composer" ) ),
                array( "mdi-brightness-5" => esc_html__( "Brightness 5", "js_composer" ) ),
                array( "mdi-brightness-6" => esc_html__( "Brightness 6", "js_composer" ) ),
                array( "mdi-brightness-7" => esc_html__( "Brightness 7", "js_composer" ) ),
                array( "mdi-brightness-auto" => esc_html__( "Brightness auto", "js_composer" ) ),
                array( "mdi-broom" => esc_html__( "Broom", "js_composer" ) ),
                array( "mdi-brush" => esc_html__( "Brush", "js_composer" ) ),
                array( "mdi-bug" => esc_html__( "Bug", "js_composer" ) ),
                array( "mdi-bullhorn" => esc_html__( "Bullhorn", "js_composer" ) ),
                array( "mdi-bus" => esc_html__( "Bus", "js_composer" ) ),
                array( "mdi-cake" => esc_html__( "Cake", "js_composer" ) ),
                array( "mdi-cake-variant" => esc_html__( "Cake variant", "js_composer" ) ),
                array( "mdi-calculator" => esc_html__( "Calculator", "js_composer" ) ),
                array( "mdi-calendar" => esc_html__( "Calendar", "js_composer" ) ),
                array( "mdi-calendar-blank" => esc_html__( "Calendar blank", "js_composer" ) ),
                array( "mdi-calendar-check" => esc_html__( "Calendar check", "js_composer" ) ),
                array( "mdi-calendar-multiple" => esc_html__( "Calendar multiple", "js_composer" ) ),
                array( "mdi-calendar-multiple-check" => esc_html__( "Calendar multiple check", "js_composer" ) ),
                array( "mdi-calendar-remove" => esc_html__( "Calendar remove", "js_composer" ) ),
                array( "mdi-calendar-text" => esc_html__( "Calendar text", "js_composer" ) ),
                array( "mdi-calendar-today" => esc_html__( "Calendar today", "js_composer" ) ),
                array( "mdi-camcorder" => esc_html__( "Camcorder", "js_composer" ) ),
                array( "mdi-camcorder-box" => esc_html__( "Camcorder box", "js_composer" ) ),
                array( "mdi-camcorder-box-off" => esc_html__( "Camcorder box off", "js_composer" ) ),
                array( "mdi-camcorder-off" => esc_html__( "Camcorder off", "js_composer" ) ),
                array( "mdi-camera" => esc_html__( "Camera", "js_composer" ) ),
                array( "mdi-camera-iris" => esc_html__( "Camera iris", "js_composer" ) ),
                array( "mdi-camera-party-mode" => esc_html__( "Camera party mode", "js_composer" ) ),
                array( "mdi-camera-switch" => esc_html__( "Camera switch", "js_composer" ) ),
                array( "mdi-camera-timer" => esc_html__( "Camera timer", "js_composer" ) ),
                array( "mdi-candycane" => esc_html__( "Candycane", "js_composer" ) ),
                array( "mdi-car" => esc_html__( "Car", "js_composer" ) ),
                array( "mdi-car-wash" => esc_html__( "Car wash", "js_composer" ) ),
                array( "mdi-carrot" => esc_html__( "Carrot", "js_composer" ) ),
                array( "mdi-cart" => esc_html__( "Cart", "js_composer" ) ),
                array( "mdi-cart-outline" => esc_html__( "Cart outline", "js_composer" ) ),
                array( "mdi-cash" => esc_html__( "Cash", "js_composer" ) ),
                array( "mdi-cast" => esc_html__( "Cast", "js_composer" ) ),
                array( "mdi-cast-connected" => esc_html__( "Cast connected", "js_composer" ) ),
                array( "mdi-castle" => esc_html__( "Castle", "js_composer" ) ),
                array( "mdi-cellphone" => esc_html__( "Cellphone", "js_composer" ) ),
                array( "mdi-cellphone-android" => esc_html__( "Cellphone android", "js_composer" ) ),
                array( "mdi-cellphone-dock" => esc_html__( "Cellphone dock", "js_composer" ) ),
                array( "mdi-cellphone-iphone" => esc_html__( "Cellphone iphone", "js_composer" ) ),
                array( "mdi-cellphone-link" => esc_html__( "Cellphone link", "js_composer" ) ),
                array( "mdi-cellphone-link-off" => esc_html__( "Cellphone link off", "js_composer" ) ),
                array( "mdi-cellphone-settings" => esc_html__( "Cellphone settings", "js_composer" ) ),
                array( "mdi-chair-school" => esc_html__( "Chair school", "js_composer" ) ),
                array( "mdi-chart-arc" => esc_html__( "Chart arc", "js_composer" ) ),
                array( "mdi-chart-bar" => esc_html__( "Chart bar", "js_composer" ) ),
                array( "mdi-chart-histogram" => esc_html__( "Chart histogram", "js_composer" ) ),
                array( "mdi-chart-line" => esc_html__( "Chart line", "js_composer" ) ),
                array( "mdi-chart-pie" => esc_html__( "Chart pie", "js_composer" ) ),
                array( "mdi-check" => esc_html__( "Check", "js_composer" ) ),
                array( "mdi-check-all" => esc_html__( "Check all", "js_composer" ) ),
                array( "mdi-checkbox-blank" => esc_html__( "Checkbox blank", "js_composer" ) ),
                array( "mdi-checkbox-blank-circle" => esc_html__( "Checkbox blank circle", "js_composer" ) ),
                array( "mdi-checkbox-blank-circle-outline" => esc_html__( "Checkbox blank circle outline", "js_composer" ) ),
                array( "mdi-checkbox-blank-outline" => esc_html__( "Checkbox blank outline", "js_composer" ) ),
                array( "mdi-checkbox-marked" => esc_html__( "Checkbox marked", "js_composer" ) ),
                array( "mdi-checkbox-marked-circle" => esc_html__( "Checkbox marked circle", "js_composer" ) ),
                array( "mdi-checkbox-marked-circle-outline" => esc_html__( "Checkbox marked outline", "js_composer" ) ),
                array( "mdi-checkbox-marked-outline" => esc_html__( "Checkbox marked outline", "js_composer" ) ),
                array( "mdi-checkbox-multiple-blank" => esc_html__( "Checkbox multiple blank", "js_composer" ) ),
                array( "mdi-checkbox-multiple-blank-outline" => esc_html__( "Checkbox multiple blank outline", "js_composer" ) ),
                array( "mdi-checkbox-multiple-marked" => esc_html__( "Checkbox multiple marked", "js_composer" ) ),
                array( "mdi-checkbox-multiple-marked-outline" => esc_html__( "Checkbox multiple marked outline", "js_composer" ) ),
                array( "mdi-checkerboard" => esc_html__( "Checkerboard", "js_composer" ) ),
                array( "mdi-chevron-double-down" => esc_html__( "Chevron double down", "js_composer" ) ),
                array( "mdi-chevron-double-left" => esc_html__( "Chevron double left", "js_composer" ) ),
                array( "mdi-chevron-double-right" => esc_html__( "Chevron double right", "js_composer" ) ),
                array( "mdi-chevron-double-up" => esc_html__( "Chevron double up", "js_composer" ) ),
                array( "mdi-chevron-down" => esc_html__( "Chevron down", "js_composer" ) ),
                array( "mdi-chevron-left" => esc_html__( "Chevron left", "js_composer" ) ),
                array( "mdi-chevron-right" => esc_html__( "Chevron right", "js_composer" ) ),
                array( "mdi-chevron-up" => esc_html__( "Chevron up", "js_composer" ) ),
                array( "mdi-church" => esc_html__( "Church", "js_composer" ) ),
                array( "mdi-city" => esc_html__( "City", "js_composer" ) ),
                array( "mdi-clipboard" => esc_html__( "Clipboard", "js_composer" ) ),
                array( "mdi-clipboard-account" => esc_html__( "Clipboard account", "js_composer" ) ),
                array( "mdi-clipboard-alert" => esc_html__( "Clipboard alert", "js_composer" ) ),
                array( "mdi-clipboard-arrow-down" => esc_html__( "Clipboard arrow down", "js_composer" ) ),
                array( "mdi-clipboard-arrow-left" => esc_html__( "Clipboard arrow left", "js_composer" ) ),
                array( "mdi-clipboard-check" => esc_html__( "Clipboard check", "js_composer" ) ),
                array( "mdi-clipboard-outline" => esc_html__( "Clipboard outline", "js_composer" ) ),
                array( "mdi-clipboard-text" => esc_html__( "Clipboard text", "js_composer" ) ),
                array( "mdi-clippy" => esc_html__( "Clippy", "js_composer" ) ),
                array( "mdi-clock" => esc_html__( "Clock", "js_composer" ) ),
                array( "mdi-clock-fast" => esc_html__( "Clock fast", "js_composer" ) ),
                array( "mdi-close" => esc_html__( "Close", "js_composer" ) ),
                array( "mdi-close-box" => esc_html__( "Close box", "js_composer" ) ),
                array( "mdi-close-box-outline" => esc_html__( "Close box outline", "js_composer" ) ),
                array( "mdi-close-circle" => esc_html__( "Close circle", "js_composer" ) ),
                array( "mdi-close-circle-outline" => esc_html__( "Close circle outline", "js_composer" ) ),
                array( "mdi-close-network" => esc_html__( "Close network", "js_composer" ) ),
                array( "mdi-closed-caption" => esc_html__( "Close caption", "js_composer" ) ),
                array( "mdi-cloud" => esc_html__( "Cloud", "js_composer" ) ),
                array( "mdi-cloud-check" => esc_html__( "Cloud check", "js_composer" ) ),
                array( "mdi-cloud-circle" => esc_html__( "Cloud circle", "js_composer" ) ),
                array( "mdi-cloud-download" => esc_html__( "Cloud download", "js_composer" ) ),
                array( "mdi-cloud-outline" => esc_html__( "Cloud outline", "js_composer" ) ),
                array( "mdi-cloud-outline-off" => esc_html__( "Cloud outline off", "js_composer" ) ),
                array( "mdi-cloud-upload" => esc_html__( "Cloud upload", "js_composer" ) ),
                array( "mdi-code-array" => esc_html__( "Code array", "js_composer" ) ),
                array( "mdi-code-string" => esc_html__( "Code string", "js_composer" ) ),
                array( "mdi-coffee" => esc_html__( "Coffee", "js_composer" ) ),
                array( "mdi-coffee-to-go" => esc_html__( "Coffee to go", "js_composer" ) ),
                array( "mdi-coin" => esc_html__( "Coin", "js_composer" ) ),
                array( "mdi-color-helper" => esc_html__( "Color help", "js_composer" ) ),
                array( "mdi-comment" => esc_html__( "Comment", "js_composer" ) ),
                array( "mdi-comment-account" => esc_html__( "Comment account", "js_composer" ) ),
                array( "mdi-comment-account-outline" => esc_html__( "Comment account outline", "js_composer" ) ),
                array( "mdi-comment-alert" => esc_html__( "Comment alert", "js_composer" ) ),
                array( "mdi-comment-alert-outline" => esc_html__( "Comment alert outline", "js_composer" ) ),
                array( "mdi-comment-check" => esc_html__( "Comment check", "js_composer" ) ),
                array( "mdi-comment-check-outline" => esc_html__( "Comment check outline", "js_composer" ) ),
                array( "mdi-comment-multiple-outline" => esc_html__( "Comment multiple outline", "js_composer" ) ),
                array( "mdi-comment-outline" => esc_html__( "Comment outline", "js_composer" ) ),
                array( "mdi-comment-plus-outline" => esc_html__( "Comment plus outline", "js_composer" ) ),
                array( "mdi-comment-processing" => esc_html__( "Comment processing", "js_composer" ) ),
                array( "mdi-comment-processing-outline" => esc_html__( "Comment processing outline", "js_composer" ) ),
                array( "mdi-comment-remove-outline" => esc_html__( "Comment remove outline", "js_composer" ) ),
                array( "mdi-comment-text" => esc_html__( "Comment text", "js_composer" ) ),
                array( "mdi-comment-text-outline" => esc_html__( "Comment text outline", "js_composer" ) ),
                array( "mdi-compare" => esc_html__( "Compare", "js_composer" ) ),
                array( "mdi-compass" => esc_html__( "Compass", "js_composer" ) ),
                array( "mdi-compass-outline" => esc_html__( "Compass outline", "js_composer" ) ),
                array( "mdi-console" => esc_html__( "Console", "js_composer" ) ),
                array( "mdi-content-copy" => esc_html__( "Content copy", "js_composer" ) ),
                array( "mdi-content-cut" => esc_html__( "Content cut", "js_composer" ) ),
                array( "mdi-content-paste" => esc_html__( "Content paste", "js_composer" ) ),
                array( "mdi-content-save" => esc_html__( "Content save", "js_composer" ) ),
                array( "mdi-content-save-all" => esc_html__( "Content save all", "js_composer" ) ),
                array( "mdi-contrast" => esc_html__( "Contrast", "js_composer" ) ),
                array( "mdi-contrast-box" => esc_html__( "Contrast box", "js_composer" ) ),
                array( "mdi-contrast-circle" => esc_html__( "Contrast circle", "js_composer" ) ),
                array( "mdi-cow" => esc_html__( "Cow", "js_composer" ) ),
                array( "mdi-credit-card" => esc_html__( "Credit card", "js_composer" ) ),
                array( "mdi-credit-card-multiple" => esc_html__( "Credit card multiple", "js_composer" ) ),
                array( "mdi-crop" => esc_html__( "Crop", "js_composer" ) ),
                array( "mdi-crop-free" => esc_html__( "Crop free", "js_composer" ) ),
                array( "mdi-crop-landscape" => esc_html__( "Crop landscape", "js_composer" ) ),
                array( "mdi-crop-portrait" => esc_html__( "Crop portrait", "js_composer" ) ),
                array( "mdi-crop-square" => esc_html__( "Crop square", "js_composer" ) ),
                array( "mdi-crosshairs" => esc_html__( "Crosshairs", "js_composer" ) ),
                array( "mdi-crosshairs-gps" => esc_html__( "Crosshairs gps", "js_composer" ) ),
                array( "mdi-cube" => esc_html__( "Cube", "js_composer" ) ),
                array( "mdi-cube-outline" => esc_html__( "Cube outline", "js_composer" ) ),
                array( "mdi-cube-unfolded" => esc_html__( "Cube unfolded", "js_composer" ) ),
                array( "mdi-cup" => esc_html__( "Cup", "js_composer" ) ),
                array( "mdi-cup-water" => esc_html__( "Cup water", "js_composer" ) ),
                array( "mdi-currency-btc" => esc_html__( "Currency btc", "js_composer" ) ),
                array( "mdi-currency-eur" => esc_html__( "Currency eur", "js_composer" ) ),
                array( "mdi-currency-gbp" => esc_html__( "Currency gbp", "js_composer" ) ),
                array( "mdi-currency-usd" => esc_html__( "Currency usd", "js_composer" ) ),
                array( "mdi-cursor-default" => esc_html__( "Cursor default", "js_composer" ) ),
                array( "mdi-cursor-default-outline" => esc_html__( "Cursor default outline", "js_composer" ) ),
                array( "mdi-cursor-pointer" => esc_html__( "Cursor pointer", "js_composer" ) ),
                array( "mdi-database" => esc_html__( "Database", "js_composer" ) ),
                array( "mdi-database-minus" => esc_html__( "Database minus", "js_composer" ) ),
                array( "mdi-database-outline" => esc_html__( "Database outline", "js_composer" ) ),
                array( "mdi-database-plus" => esc_html__( "Database plus", "js_composer" ) ),
                array( "mdi-debug-step-into" => esc_html__( "Debug step into", "js_composer" ) ),
                array( "mdi-debug-step-out" => esc_html__( "Debug step  out", "js_composer" ) ),
                array( "mdi-debug-step-over" => esc_html__( "Debug step over", "js_composer" ) ),
                array( "mdi-delete" => esc_html__( "Delete", "js_composer" ) ),
                array( "mdi-delete-variant" => esc_html__( "Delete variant", "js_composer" ) ),
                array( "mdi-deskphone" => esc_html__( "Deskphone", "js_composer" ) ),
                array( "mdi-desktop-mac" => esc_html__( "Desktop mac", "js_composer" ) ),
                array( "mdi-desktop-tower" => esc_html__( "Desktop tower", "js_composer" ) ),
                array( "mdi-details" => esc_html__( "Desktop details", "js_composer" ) ),
                array( "mdi-deviantart" => esc_html__( "Deviantart", "js_composer" ) ),
                array( "mdi-dice" => esc_html__( "Dice", "js_composer" ) ),
                array( "mdi-dice-1" => esc_html__( "Dice 1", "js_composer" ) ),
                array( "mdi-dice-2" => esc_html__( "Dice 2", "js_composer" ) ),
                array( "mdi-dice-3" => esc_html__( "Dice 3", "js_composer" ) ),
                array( "mdi-dice-4" => esc_html__( "Dice 4", "js_composer" ) ),
                array( "mdi-dice-5" => esc_html__( "Dice 5", "js_composer" ) ),
                array( "mdi-dice-6" => esc_html__( "Dice 6", "js_composer" ) ),
                array( "mdi-directions" => esc_html__( "Directions", "js_composer" ) ),
                array( "mdi-disk-alert" => esc_html__( "Disk alert", "js_composer" ) ),
                array( "mdi-disqus" => esc_html__( "Disqus", "js_composer" ) ),
                array( "mdi-disqus-outline" => esc_html__( "Disqus outline", "js_composer" ) ),
                array( "mdi-division" => esc_html__( "Division", "js_composer" ) ),
                array( "mdi-division-box" => esc_html__( "Division box", "js_composer" ) ),
                array( "mdi-dns" => esc_html__( "DNS", "js_composer" ) ),
                array( "mdi-domain" => esc_html__( "Domain", "js_composer" ) ),
                array( "mdi-dots-horizontal" => esc_html__( "Dots horizontal", "js_composer" ) ),
                array( "mdi-dots-vertical" => esc_html__( "Dots-vertical", "js_composer" ) ),
                array( "mdi-download" => esc_html__( "Download", "js_composer" ) ),
                array( "mdi-drawing" => esc_html__( "Drawing", "js_composer" ) ),
                array( "mdi-drawing-box" => esc_html__( "Drawing box", "js_composer" ) ),
                array( "mdi-dribbble" => esc_html__( "Dribbble box", "js_composer" ) ),
                array( "mdi-dribbble-box" => esc_html__( "Dribbble-box", "js_composer" ) ),
                array( "mdi-drone" => esc_html__( "Drone", "js_composer" ) ),
                array( "mdi-dropbox" => esc_html__( "Dropbox", "js_composer" ) ),
                array( "mdi-duck" => esc_html__( "Duck", "js_composer" ) ),
                array( "mdi-dumbbell" => esc_html__( "Dumbbell", "js_composer" ) ),
                array( "mdi-earth" => esc_html__( "Earth", "js_composer" ) ),
                array( "mdi-earth-off" => esc_html__( "Earth off", "js_composer" ) ),
                array( "mdi-elevation-decline" => esc_html__( "Elevation decline", "js_composer" ) ),
                array( "mdi-elevation-rise" => esc_html__( "Elevation rise", "js_composer" ) ),
                array( "mdi-email" => esc_html__( "Email", "js_composer" ) ),
                array( "mdi-email-open" => esc_html__( "Email open", "js_composer" ) ),
                array( "mdi-email-outline" => esc_html__( "Email outline", "js_composer" ) ),
                array( "mdi-emoticon" => esc_html__( "Emoticon", "js_composer" ) ),
                array( "mdi-emoticon-cool" => esc_html__( "Emoticon cool", "js_composer" ) ),
                array( "mdi-emoticon-devil" => esc_html__( "Emoticon devil", "js_composer" ) ),
                array( "mdi-emoticon-happy" => esc_html__( "Emoticon happy", "js_composer" ) ),
                array( "mdi-emoticon-neutral" => esc_html__( "Emoticon neutral", "js_composer" ) ),
                array( "mdi-emoticon-poop" => esc_html__( "Emoticon poop", "js_composer" ) ),
                array( "mdi-emoticon-sad" => esc_html__( "Emoticon sad", "js_composer" ) ),
                array( "mdi-emoticon-tongue" => esc_html__( "Emoticon tongue", "js_composer" ) ),
                array( "mdi-equal" => esc_html__( "Equal", "js_composer" ) ),
                array( "mdi-equal-box" => esc_html__( "Equal box", "js_composer" ) ),
                array( "mdi-eraser" => esc_html__( "Eraser", "js_composer" ) ),
                array( "mdi-escalator" => esc_html__( "Escalator", "js_composer" ) ),
                array( "mdi-etsy" => esc_html__( "Etsy", "js_composer" ) ),
                array( "mdi-evernote" => esc_html__( "Evernote", "js_composer" ) ),
                array( "mdi-exit-to-app" => esc_html__( "Exit to app", "js_composer" ) ),
                array( "mdi-eye" => esc_html__( "Eye", "js_composer" ) ),
                array( "mdi-eye-off" => esc_html__( "Eye off", "js_composer" ) ),
                array( "mdi-eyedropper" => esc_html__( "Eyedropper", "js_composer" ) ),
                array( "mdi-eyedropper-variant" => esc_html__( "Eyedropper variant", "js_composer" ) ),
                array( "mdi-facebook" => esc_html__( "Facebook", "js_composer" ) ),
                array( "mdi-facebook-box" => esc_html__( "Facebook box", "js_composer" ) ),
                array( "mdi-facebook-messenger" => esc_html__( "Facebook messenger", "js_composer" ) ),
                array( "mdi-factory" => esc_html__( "Factory", "js_composer" ) ),
                array( "mdi-fan" => esc_html__( "Fan", "js_composer" ) ),
                array( "mdi-fast-forward" => esc_html__( "Fast-forward", "js_composer" ) ),
                array( "mdi-ferry" => esc_html__( "Ferry", "js_composer" ) ),
                array( "mdi-file" => esc_html__( "File", "js_composer" ) ),
                array( "mdi-file-cloud" => esc_html__( "File cloud", "js_composer" ) ),
                array( "mdi-file-delimited" => esc_html__( "File delimited", "js_composer" ) ),
                array( "mdi-file-document" => esc_html__( "File document", "js_composer" ) ),
                array( "mdi-file-document-box" => esc_html__( "File document box", "js_composer" ) ),
                array( "mdi-file-excel" => esc_html__( "File excel", "js_composer" ) ),
                array( "mdi-file-excel-box" => esc_html__( "File excel box", "js_composer" ) ),
                array( "mdi-file-find" => esc_html__( "File find", "js_composer" ) ),
                array( "mdi-file-image" => esc_html__( "File image", "js_composer" ) ),
                array( "mdi-file-image-box" => esc_html__( "File image box", "js_composer" ) ),
                array( "mdi-file-music" => esc_html__( "File music", "js_composer" ) ),
                array( "mdi-file-outline" => esc_html__( "File outline", "js_composer" ) ),
                array( "mdi-file-pdf" => esc_html__( "File pdf", "js_composer" ) ),
                array( "mdi-file-pdf-box" => esc_html__( "File pdf box", "js_composer" ) ),
                array( "mdi-file-powerpoint" => esc_html__( "File powerpoint", "js_composer" ) ),
                array( "mdi-file-powerpoint-box" => esc_html__( "File powerpoint box", "js_composer" ) ),
                array( "mdi-file-presentation-box" => esc_html__( "File presentation box", "js_composer" ) ),
                array( "mdi-file-video" => esc_html__( "File video", "js_composer" ) ),
                array( "mdi-file-word" => esc_html__( "File word", "js_composer" ) ),
                array( "mdi-file-word-box" => esc_html__( "File word box", "js_composer" ) ),
                array( "mdi-film" => esc_html__( "Film", "js_composer" ) ),
                array( "mdi-filmstrip" => esc_html__( "Filmstrip", "js_composer" ) ),
                array( "mdi-filmstrip-off" => esc_html__( "Filmstrip Off", "js_composer" ) ),
                array( "mdi-filter" => esc_html__( "Filter", "js_composer" ) ),
                array( "mdi-filter-outline" => esc_html__( "Filter outline", "js_composer" ) ),
                array( "mdi-filter-remove" => esc_html__( "Filter remove", "js_composer" ) ),
                array( "mdi-filter-remove-outline" => esc_html__( "Filter remove outline", "js_composer" ) ),
                array( "mdi-filter-variant" => esc_html__( "Filter variant", "js_composer" ) ),
                array( "mdi-fire" => esc_html__( "Fire", "js_composer" ) ),
                array( "mdi-firefox" => esc_html__( "Firefox", "js_composer" ) ),
                array( "mdi-fish" => esc_html__( "Fish", "js_composer" ) ),
                array( "mdi-flag" => esc_html__( "Flag", "js_composer" ) ),
                array( "mdi-flag-checkered" => esc_html__( "Flag checkered", "js_composer" ) ),
                array( "mdi-flag-outline" => esc_html__( "Flag outline", "js_composer" ) ),
                array( "mdi-flag-outline-variant" => esc_html__( "Flag outline variant", "js_composer" ) ),
                array( "mdi-flag-variant" => esc_html__( "Flag variant", "js_composer" ) ),
                array( "mdi-flash" => esc_html__( "Flash", "js_composer" ) ),
                array( "mdi-flash-auto" => esc_html__( "Flash auto", "js_composer" ) ),
                array( "mdi-flash-off" => esc_html__( "Flash off", "js_composer" ) ),
                array( "mdi-flashlight" => esc_html__( "Flashlight", "js_composer" ) ),
                array( "mdi-flashlight-off" => esc_html__( "Flashlight off", "js_composer" ) ),
                array( "mdi-flip-to-back" => esc_html__( "Flip-to-back", "js_composer" ) ),
                array( "mdi-flip-to-front" => esc_html__( "Flip-to-front", "js_composer" ) ),
                array( "mdi-floppy" => esc_html__( "Floppy", "js_composer" ) ),
                array( "mdi-flower" => esc_html__( "Flower", "js_composer" ) ),
                array( "mdi-folder" => esc_html__( "Folder", "js_composer" ) ),
                array( "mdi-folder-account" => esc_html__( "Folder account", "js_composer" ) ),
                array( "mdi-folder-google-drive" => esc_html__( "Folder google-drive", "js_composer" ) ),
                array( "mdi-folder-image" => esc_html__( "Folder image", "js_composer" ) ),
                array( "mdi-folder-move" => esc_html__( "Folder move", "js_composer" ) ),
                array( "mdi-folder-multiple" => esc_html__( "Folder multiple", "js_composer" ) ),
                array( "mdi-folder-multiple-image" => esc_html__( "Folder multiple image", "js_composer" ) ),
                array( "mdi-folder-multiple-outline" => esc_html__( "Folder multiple outline", "js_composer" ) ),
                array( "mdi-folder-outline" => esc_html__( "Folder outline", "js_composer" ) ),
                array( "mdi-folder-plus" => esc_html__( "Folder plus", "js_composer" ) ),
                array( "mdi-folder-remove" => esc_html__( "Folder remove", "js_composer" ) ),
                array( "mdi-food" => esc_html__( "Food", "js_composer" ) ),
                array( "mdi-food-apple" => esc_html__( "Food apple", "js_composer" ) ),
                array( "mdi-food-variant" => esc_html__( "Food variant", "js_composer" ) ),
                array( "mdi-format-align-center" => esc_html__( "Format align center", "js_composer" ) ),
                array( "mdi-format-align-justify" => esc_html__( "Format align justify", "js_composer" ) ),
                array( "mdi-format-align-left" => esc_html__( "Format align left", "js_composer" ) ),
                array( "mdi-format-align-right" => esc_html__( "Format align right", "js_composer" ) ),
                array( "mdi-format-bold" => esc_html__( "Format bold", "js_composer" ) ),
                array( "mdi-format-clear" => esc_html__( "Format clear", "js_composer" ) ),
                array( "mdi-format-color-fill" => esc_html__( "Format color fill", "js_composer" ) ),
                array( "mdi-format-header-1" => esc_html__( "Format header 1", "js_composer" ) ),
                array( "mdi-format-header-2" => esc_html__( "Format header 2", "js_composer" ) ),
                array( "mdi-format-header-3" => esc_html__( "Format header 3", "js_composer" ) ),
                array( "mdi-format-header-4" => esc_html__( "Format header 4", "js_composer" ) ),
                array( "mdi-format-header-5" => esc_html__( "Format header 5", "js_composer" ) ),
                array( "mdi-format-header-6" => esc_html__( "Format header 6", "js_composer" ) ),
                array( "mdi-format-header-pound" => esc_html__( "Format header pound", "js_composer" ) ),
                array( "mdi-format-indent-decrease" => esc_html__( "Format indent decrease", "js_composer" ) ),
                array( "mdi-format-indent-increase" => esc_html__( "Format indent increase", "js_composer" ) ),
                array( "mdi-format-italic" => esc_html__( "Format italic", "js_composer" ) ),
                array( "mdi-format-line-spacing" => esc_html__( "Format line spacing", "js_composer" ) ),
                array( "mdi-format-list-bulleted" => esc_html__( "Format list bulleted", "js_composer" ) ),
                array( "mdi-format-list-numbers" => esc_html__( "Format list numbers", "js_composer" ) ),
                array( "mdi-format-paint" => esc_html__( "Format paint", "js_composer" ) ),
                array( "mdi-format-paragraph" => esc_html__( "Format paragraph", "js_composer" ) ),
                array( "mdi-format-quote" => esc_html__( "Format-quote", "js_composer" ) ),
                array( "mdi-format-size" => esc_html__( "Format size", "js_composer" ) ),
                array( "mdi-format-strikethrough" => esc_html__( "Format strikethrough", "js_composer" ) ),
                array( "mdi-format-subscript" => esc_html__( "Format subscript", "js_composer" ) ),
                array( "mdi-format-superscript" => esc_html__( "Format superscript", "js_composer" ) ),
                array( "mdi-format-textdirection-l-to-r" => esc_html__( "Format textdirection l-to-r", "js_composer" ) ),
                array( "mdi-format-textdirection-r-to-l" => esc_html__( "Format textdirection r-to-l", "js_composer" ) ),
                array( "mdi-format-underline" => esc_html__( "Format underline", "js_composer" ) ),
                array( "mdi-forum" => esc_html__( "Forum", "js_composer" ) ),
                array( "mdi-forward" => esc_html__( "Forward", "js_composer" ) ),
                array( "mdi-foursquare" => esc_html__( "Foursquare", "js_composer" ) ),
                array( "mdi-fridge" => esc_html__( "Fridge", "js_composer" ) ),
                array( "mdi-fullscreen" => esc_html__( "Fullscreen", "js_composer" ) ),
                array( "mdi-fullscreen-exit" => esc_html__( "Fullscreen-exit", "js_composer" ) ),
                array( "mdi-function" => esc_html__( "Function", "js_composer" ) ),
                array( "mdi-gamepad" => esc_html__( "Gamepad", "js_composer" ) ),
                array( "mdi-gamepad-variant" => esc_html__( "Gamepad variant", "js_composer" ) ),
                array( "mdi-gas-station" => esc_html__( "Gas station", "js_composer" ) ),
                array( "mdi-gavel" => esc_html__( "Gavel", "js_composer" ) ),
                array( "mdi-gender-female" => esc_html__( "Gender female", "js_composer" ) ),
                array( "mdi-gender-male" => esc_html__( "Gender male", "js_composer" ) ),
                array( "mdi-gender-transgender" => esc_html__( "Gender transgender", "js_composer" ) ),
                array( "mdi-gift" => esc_html__( "Gift", "js_composer" ) ),
                array( "mdi-github-box" => esc_html__( "Github box", "js_composer" ) ),
                array( "mdi-github-circle" => esc_html__( "Github circle", "js_composer" ) ),
                array( "mdi-glass-flute" => esc_html__( "Glass flute", "js_composer" ) ),
                array( "mdi-glass-mug" => esc_html__( "Glass mug", "js_composer" ) ),
                array( "mdi-glass-stange" => esc_html__( "Glass stange", "js_composer" ) ),
                array( "mdi-glass-tulip" => esc_html__( "Glass tulip", "js_composer" ) ),
                array( "mdi-gmail" => esc_html__( "Gmail", "js_composer" ) ),
                array( "mdi-google" => esc_html__( "Google", "js_composer" ) ),
                array( "mdi-google-chrome" => esc_html__( "Google-chrome", "js_composer" ) ),
                array( "mdi-google-circles" => esc_html__( "Google circles", "js_composer" ) ),
                array( "mdi-google-circles-communities" => esc_html__( "Google circles communities", "js_composer" ) ),
                array( "mdi-google-circles-extended" => esc_html__( "Google circles extended", "js_composer" ) ),
                array( "mdi-google-circles-group" => esc_html__( "Google circles group", "js_composer" ) ),
                array( "mdi-google-controller" => esc_html__( "Google controller", "js_composer" ) ),
                array( "mdi-google-controller-off" => esc_html__( "Google controller off", "js_composer" ) ),
                array( "mdi-google-drive" => esc_html__( "Google drive", "js_composer" ) ),
                array( "mdi-google-earth" => esc_html__( "Google earth", "js_composer" ) ),
                array( "mdi-google-glass" => esc_html__( "Google glass", "js_composer" ) ),
                array( "mdi-google-maps" => esc_html__( "Google maps", "js_composer" ) ),
                array( "mdi-google-pages" => esc_html__( "Google pages", "js_composer" ) ),
                array( "mdi-google-play" => esc_html__( "Google play", "js_composer" ) ),
                array( "mdi-google-plus" => esc_html__( "Google plus", "js_composer" ) ),
                array( "mdi-google-plus-box" => esc_html__( "Google plus box", "js_composer" ) ),
                array( "mdi-guitar-pick" => esc_html__( "Guitar pick", "js_composer" ) ),
                array( "mdi-guitar-pick-outline" => esc_html__( "Guitar pick outline", "js_composer" ) ),
                array( "mdi-hand-pointing-right" => esc_html__( "Hand pointing right", "js_composer" ) ),
                array( "mdi-hanger" => esc_html__( "Hanger", "js_composer" ) ),
                array( "mdi-hangouts" => esc_html__( "Hangouts", "js_composer" ) ),
                array( "mdi-harddisk" => esc_html__( "Harddisk", "js_composer" ) ),
                array( "mdi-headphones" => esc_html__( "Headphones", "js_composer" ) ),
                array( "mdi-headphones-box" => esc_html__( "Headphones box", "js_composer" ) ),
                array( "mdi-headphones-settings" => esc_html__( "Headphones settings", "js_composer" ) ),
                array( "mdi-headset" => esc_html__( "Headset", "js_composer" ) ),
                array( "mdi-headset-dock" => esc_html__( "Headset dock", "js_composer" ) ),
                array( "mdi-heart" => esc_html__( "Heart", "js_composer" ) ),
                array( "mdi-heart-box" => esc_html__( "Heart box", "js_composer" ) ),
                array( "mdi-heart-box-outline" => esc_html__( "Heart outline", "js_composer" ) ),
                array( "mdi-heart-broken" => esc_html__( "Heart broken", "js_composer" ) ),
                array( "mdi-heart-outline" => esc_html__( "Heart outline", "js_composer" ) ),
                array( "mdi-help" => esc_html__( "Help", "js_composer" ) ),
                array( "mdi-help-circle" => esc_html__( "Help circle", "js_composer" ) ),
                array( "mdi-hexagon" => esc_html__( "Hexagon", "js_composer" ) ),
                array( "mdi-hexagon-outline" => esc_html__( "Hexagon outline", "js_composer" ) ),
                array( "mdi-history" => esc_html__( "History", "js_composer" ) ),
                array( "mdi-home" => esc_html__( "Home", "js_composer" ) ),
                array( "mdi-home-modern" => esc_html__( "Home modern", "js_composer" ) ),
                array( "mdi-home-variant" => esc_html__( "Home variant", "js_composer" ) ),
                array( "mdi-hops" => esc_html__( "Hops", "js_composer" ) ),
                array( "mdi-hospital" => esc_html__( "Hospital", "js_composer" ) ),
                array( "mdi-hospital-building" => esc_html__( "Hospital-building", "js_composer" ) ),
                array( "mdi-hospital-marker" => esc_html__( "Hospital marker", "js_composer" ) ),
                array( "mdi-hotel" => esc_html__( "Hotel", "js_composer" ) ),
                array( "mdi-houzz" => esc_html__( "Houzz", "js_composer" ) ),
                array( "mdi-houzz-box" => esc_html__( "Houzz box", "js_composer" ) ),
                array( "mdi-human" => esc_html__( "Human", "js_composer" ) ),
                array( "mdi-human-child" => esc_html__( "Human child", "js_composer" ) ),
                array( "mdi-human-male-female" => esc_html__( "Human male female", "js_composer" ) ),
                array( "mdi-image-album" => esc_html__( "Image album", "js_composer" ) ),
                array( "mdi-image-area" => esc_html__( "Image area", "js_composer" ) ),
                array( "mdi-image-area-close" => esc_html__( "Image area close", "js_composer" ) ),
                array( "mdi-image-filter" => esc_html__( "Image filter", "js_composer" ) ),
                array( "mdi-image-filter-black-white" => esc_html__( "Image filter black white", "js_composer" ) ),
                array( "mdi-image-filter-center-focus" => esc_html__( "Image filter center focus", "js_composer" ) ),
                array( "mdi-image-filter-drama" => esc_html__( "Image filter drama", "js_composer" ) ),
                array( "mdi-image-filter-frames" => esc_html__( "Image filter frames", "js_composer" ) ),
                array( "mdi-image-filter-hdr" => esc_html__( "Image filter hdr", "js_composer" ) ),
                array( "mdi-image-filter-none" => esc_html__( "Image filter none", "js_composer" ) ),
                array( "mdi-image-filter-tilt-shift" => esc_html__( "Image filter tilt shift", "js_composer" ) ),
                array( "mdi-image-filter-vintage" => esc_html__( "Image filter vintage", "js_composer" ) ),
                array( "mdi-information" => esc_html__( "Information", "js_composer" ) ),
                array( "mdi-information-outline" => esc_html__( "Information outline", "js_composer" ) ),
                array( "mdi-instagram" => esc_html__( "Instagram", "js_composer" ) ),
                array( "mdi-instapaper" => esc_html__( "Instapaper", "js_composer" ) ),
                array( "mdi-internet-explorer" => esc_html__( "Internet-explorer", "js_composer" ) ),
                array( "mdi-invert-colors" => esc_html__( "Invert colors", "js_composer" ) ),
                array( "mdi-jira" => esc_html__( "Jira", "js_composer" ) ),
                array( "mdi-keg" => esc_html__( "Keg", "js_composer" ) ),
                array( "mdi-key" => esc_html__( "Key", "js_composer" ) ),
                array( "mdi-key-change" => esc_html__( "Key change", "js_composer" ) ),
                array( "mdi-key-minus" => esc_html__( "Key minus", "js_composer" ) ),
                array( "mdi-key-plus" => esc_html__( "Key plus", "js_composer" ) ),
                array( "mdi-key-remove" => esc_html__( "Key remove", "js_composer" ) ),
                array( "mdi-key-variant" => esc_html__( "Key variant", "js_composer" ) ),
                array( "mdi-keyboard" => esc_html__( "Keyboard", "js_composer" ) ),
                array( "mdi-keyboard-backspace" => esc_html__( "Keyboard backspace", "js_composer" ) ),
                array( "mdi-keyboard-caps" => esc_html__( "Keyboard caps", "js_composer" ) ),
                array( "mdi-keyboard-close" => esc_html__( "Keyboard close", "js_composer" ) ),
                array( "mdi-keyboard-off" => esc_html__( "Keyboard off", "js_composer" ) ),
                array( "mdi-keyboard-return" => esc_html__( "Keyboard return", "js_composer" ) ),
                array( "mdi-keyboard-tab" => esc_html__( "Keyboard tab", "js_composer" ) ),
                array( "mdi-label" => esc_html__( "Label", "js_composer" ) ),
                array( "mdi-label-outline" => esc_html__( "Label outline", "js_composer" ) ),
                array( "mdi-language-csharp" => esc_html__( "Language csharp", "js_composer" ) ),
                array( "mdi-language-css3" => esc_html__( "Language css3", "js_composer" ) ),
                array( "mdi-language-html5" => esc_html__( "Language html5", "js_composer" ) ),
                array( "mdi-language-javascript" => esc_html__( "Language javascript", "js_composer" ) ),
                array( "mdi-language-python" => esc_html__( "Language python", "js_composer" ) ),
                array( "mdi-language-python-text" => esc_html__( "Language python text", "js_composer" ) ),
                array( "mdi-laptop" => esc_html__( "Laptop", "js_composer" ) ),
                array( "mdi-laptop-chromebook" => esc_html__( "Laptop chromebook", "js_composer" ) ),
                array( "mdi-laptop-mac" => esc_html__( "Laptop mac", "js_composer" ) ),
                array( "mdi-laptop-windows" => esc_html__( "Laptop windows", "js_composer" ) ),
                array( "mdi-lastfm" => esc_html__( "Lastfm", "js_composer" ) ),
                array( "mdi-launch" => esc_html__( "Launch", "js_composer" ) ),
                array( "mdi-layers" => esc_html__( "Layers", "js_composer" ) ),
                array( "mdi-layers-off" => esc_html__( "Layers off", "js_composer" ) ),
                array( "mdi-leaf" => esc_html__( "Leaf", "js_composer" ) ),
                array( "mdi-library" => esc_html__( "Library", "js_composer" ) ),
                array( "mdi-library-books" => esc_html__( "Library books", "js_composer" ) ),
                array( "mdi-library-music" => esc_html__( "Library music", "js_composer" ) ),
                array( "mdi-library-plus" => esc_html__( "Library plus", "js_composer" ) ),
                array( "mdi-lightbulb" => esc_html__( "Lightbulb", "js_composer" ) ),
                array( "mdi-link" => esc_html__( "Link", "js_composer" ) ),
                array( "mdi-link-variant" => esc_html__( "Link variant", "js_composer" ) ),
                array( "mdi-linkedin" => esc_html__( "Linkedin", "js_composer" ) ),
                array( "mdi-linux" => esc_html__( "Linux", "js_composer" ) ),
                array( "mdi-lock" => esc_html__( "Lock", "js_composer" ) ),
                array( "mdi-lock-open" => esc_html__( "Lock open", "js_composer" ) ),
                array( "mdi-lock-open-outline" => esc_html__( "Lock open outline", "js_composer" ) ),
                array( "mdi-lock-outline" => esc_html__( "Lock outline", "js_composer" ) ),
                array( "mdi-login" => esc_html__( "Login", "js_composer" ) ),
                array( "mdi-logout" => esc_html__( "Logout", "js_composer" ) ),
                array( "mdi-looks" => esc_html__( "Looks", "js_composer" ) ),
                array( "mdi-loupe" => esc_html__( "Loupe", "js_composer" ) ),
                array( "mdi-lumx" => esc_html__( "Lumx", "js_composer" ) ),
                array( "mdi-magnify" => esc_html__( "Magnify", "js_composer" ) ),
                array( "mdi-magnify-minus" => esc_html__( "Magnify minus", "js_composer" ) ),
                array( "mdi-magnify-plus" => esc_html__( "Magnify plus", "js_composer" ) ),
                array( "mdi-map" => esc_html__( "Map", "js_composer" ) ),
                array( "mdi-map-marker" => esc_html__( "Map marker", "js_composer" ) ),
                array( "mdi-map-marker-circle" => esc_html__( "Map marker circle", "js_composer" ) ),
                array( "mdi-map-marker-multiple" => esc_html__( "Map marker multiple", "js_composer" ) ),
                array( "mdi-map-marker-off" => esc_html__( "Map marker off", "js_composer" ) ),
                array( "mdi-map-marker-radius" => esc_html__( "Map marker radius", "js_composer" ) ),
                array( "mdi-markdown" => esc_html__( "Markdown", "js_composer" ) ),
                array( "mdi-marker-check" => esc_html__( "Marker check", "js_composer" ) ),
                array( "mdi-martini" => esc_html__( "Martini", "js_composer" ) ),
                array( "mdi-material-ui" => esc_html__( "Material ui", "js_composer" ) ),
                array( "mdi-math-compass" => esc_html__( "Math compass", "js_composer" ) ),
                array( "mdi-memory" => esc_html__( "Memory", "js_composer" ) ),
                array( "mdi-menu" => esc_html__( "Menu", "js_composer" ) ),
                array( "mdi-menu-down" => esc_html__( "Menu down", "js_composer" ) ),
                array( "mdi-menu-left" => esc_html__( "Menu left", "js_composer" ) ),
                array( "mdi-menu-right" => esc_html__( "Menu right", "js_composer" ) ),
                array( "mdi-menu-up" => esc_html__( "Menu up", "js_composer" ) ),
                array( "mdi-message" => esc_html__( "Message", "js_composer" ) ),
                array( "mdi-message-alert" => esc_html__( "Message-alert", "js_composer" ) ),
                array( "mdi-message-draw" => esc_html__( "Message draw", "js_composer" ) ),
                array( "mdi-message-image" => esc_html__( "Message image", "js_composer" ) ),
                array( "mdi-message-processing" => esc_html__( "Message processing", "js_composer" ) ),
                array( "mdi-message-reply" => esc_html__( "Message-reply", "js_composer" ) ),
                array( "mdi-message-video" => esc_html__( "Message-video", "js_composer" ) ),
                array( "mdi-microphone" => esc_html__( "Microphone", "js_composer" ) ),
                array( "mdi-microphone-off" => esc_html__( "Microphone off", "js_composer" ) ),
                array( "mdi-microphone-outline" => esc_html__( "Microphone outline", "js_composer" ) ),
                array( "mdi-microphone-settings" => esc_html__( "Microphone settings", "js_composer" ) ),
                array( "mdi-microphone-variant" => esc_html__( "Microphone variant", "js_composer" ) ),
                array( "mdi-microphone-variant-off" => esc_html__( "Microphone variant off", "js_composer" ) ),
                array( "mdi-minus" => esc_html__( "Minus", "js_composer" ) ),
                array( "mdi-minus-box" => esc_html__( "Minus box", "js_composer" ) ),
                array( "mdi-minus-circle" => esc_html__( "Minus circle", "js_composer" ) ),
                array( "mdi-minus-circle-outline" => esc_html__( "Minus circle outline", "js_composer" ) ),
                array( "mdi-minus-network" => esc_html__( "Minus network", "js_composer" ) ),
                array( "mdi-monitor" => esc_html__( "Monitor", "js_composer" ) ),
                array( "mdi-monitor-multiple" => esc_html__( "Monitor multiple", "js_composer" ) ),
                array( "mdi-more" => esc_html__( "More", "js_composer" ) ),
                array( "mdi-motorbike" => esc_html__( "Motorbike", "js_composer" ) ),
                array( "mdi-mouse" => esc_html__( "Mouse", "js_composer" ) ),
                array( "mdi-mouse-off" => esc_html__( "Mouse off", "js_composer" ) ),
                array( "mdi-mouse-variant" => esc_html__( "Mouse variant", "js_composer" ) ),
                array( "mdi-mouse-variant-off" => esc_html__( "Mouse variant off", "js_composer" ) ),
                array( "mdi-movie" => esc_html__( "Movie", "js_composer" ) ),
                array( "mdi-multiplication" => esc_html__( "Multiplication", "js_composer" ) ),
                array( "mdi-multiplication-box" => esc_html__( "Multiplication box", "js_composer" ) ),
                array( "mdi-music-box" => esc_html__( "Music box", "js_composer" ) ),
                array( "mdi-music-box-outline" => esc_html__( "Music box outline", "js_composer" ) ),
                array( "mdi-music-circle" => esc_html__( "Music circle", "js_composer" ) ),
                array( "mdi-music-note" => esc_html__( "Music note", "js_composer" ) ),
                array( "mdi-music-note-eighth" => esc_html__( "Music note eighth", "js_composer" ) ),
                array( "mdi-music-note-half" => esc_html__( "Music note half", "js_composer" ) ),
                array( "mdi-music-note-off" => esc_html__( "Music note off", "js_composer" ) ),
                array( "mdi-music-note-quarter" => esc_html__( "Music note quarter", "js_composer" ) ),
                array( "mdi-music-note-sixteenth" => esc_html__( "Music note sixteenth", "js_composer" ) ),
                array( "mdi-music-note-whole" => esc_html__( "Music note whole", "js_composer" ) ),
                array( "mdi-nature" => esc_html__( "Nature", "js_composer" ) ),
                array( "mdi-nature-people" => esc_html__( "Nature people", "js_composer" ) ),
                array( "mdi-navigation" => esc_html__( "Navigation", "js_composer" ) ),
                array( "mdi-needle" => esc_html__( "Needle", "js_composer" ) ),
                array( "mdi-nest-protect" => esc_html__( "Nest protect", "js_composer" ) ),
                array( "mdi-nest-thermostat" => esc_html__( "Nest thermostat", "js_composer" ) ),
                array( "mdi-newspaper" => esc_html__( "Newspaper", "js_composer" ) ),
                array( "mdi-nfc" => esc_html__( "Nfc", "js_composer" ) ),
                array( "mdi-nfc-tap" => esc_html__( "Nfc tap", "js_composer" ) ),
                array( "mdi-nfc-variant" => esc_html__( "Nfc variant", "js_composer" ) ),
                array( "mdi-numeric" => esc_html__( "Numeric", "js_composer" ) ),
                array( "mdi-numeric-0-box" => esc_html__( "Numeric 0 box", "js_composer" ) ),
                array( "mdi-numeric-0-box-multiple-outline" => esc_html__( "Numeric 0 box multiple outline", "js_composer" ) ),
                array( "mdi-numeric-0-box-outline" => esc_html__( "Numeric 0 box outline", "js_composer" ) ),
                array( "mdi-numeric-1-box" => esc_html__( "Numeric 1 box", "js_composer" ) ),
                array( "mdi-numeric-1-box-multiple-outline" => esc_html__( "Numeric 1 box multiple outline", "js_composer" ) ),
                array( "mdi-numeric-1-box-outline" => esc_html__( "Numeric 1 box outline", "js_composer" ) ),
                array( "mdi-numeric-2-box" => esc_html__( "Numeric 2 box", "js_composer" ) ),
                array( "mdi-numeric-2-box-multiple-outline" => esc_html__( "Numeric 2 box multiple outline", "js_composer" ) ),
                array( "mdi-numeric-2-box-outline" => esc_html__( "Numeric 2 box outline", "js_composer" ) ),
                array( "mdi-numeric-3-box" => esc_html__( "Numeric 3 box", "js_composer" ) ),
                array( "mdi-numeric-3-box-multiple-outline" => esc_html__( "Numeric 3 box multiple outline", "js_composer" ) ),
                array( "mdi-numeric-3-box-outline" => esc_html__( "Numeric 3 box outline", "js_composer" ) ),
                array( "mdi-numeric-4-box" => esc_html__( "Numeric 4 box", "js_composer" ) ),
                array( "mdi-numeric-4-box-multiple-outline" => esc_html__( "Numeric 4 box multiple outline", "js_composer" ) ),
                array( "mdi-numeric-4-box-outline" => esc_html__( "Numeric 4 box outline", "js_composer" ) ),
                array( "mdi-numeric-5-box" => esc_html__( "Numeric 5 box", "js_composer" ) ),
                array( "mdi-numeric-5-box-multiple-outline" => esc_html__( "Numeric 5 box multiple outline", "js_composer" ) ),
                array( "mdi-numeric-5-box-outline" => esc_html__( "Numeric 5 box outline", "js_composer" ) ),
                array( "mdi-numeric-6-box" => esc_html__( "Numeric 6 box", "js_composer" ) ),
                array( "mdi-numeric-6-box-multiple-outline" => esc_html__( "Numeric 6 box multiple outline", "js_composer" ) ),
                array( "mdi-numeric-6-box-outline" => esc_html__( "Numeric 6 box outline", "js_composer" ) ),
                array( "mdi-numeric-7-box" => esc_html__( "Numeric 7 box", "js_composer" ) ),
                array( "mdi-numeric-7-box-multiple-outline" => esc_html__( "Numeric 7 box multiple outline", "js_composer" ) ),
                array( "mdi-numeric-7-box-outline" => esc_html__( "Numeric 7 box outline", "js_composer" ) ),
                array( "mdi-numeric-8-box" => esc_html__( "Numeric 8 box", "js_composer" ) ),
                array( "mdi-numeric-8-box-multiple-outline" => esc_html__( "Numeric 8 box multiple outline", "js_composer" ) ),
                array( "mdi-numeric-8-box-outline" => esc_html__( "Numeric 8 box outline", "js_composer" ) ),
                array( "mdi-numeric-9-box" => esc_html__( "Numeric 9 box", "js_composer" ) ),
                array( "mdi-numeric-9-box-multiple-outline" => esc_html__( "Numeric 9 box multiple outline", "js_composer" ) ),
                array( "mdi-nutriton" => esc_html__( "Nutriton", "js_composer" ) ),
                array( "mdi-office" => esc_html__( "Office", "js_composer" ) ),
                array( "mdi-oil" => esc_html__( "Oil", "js_composer" ) ),
                array( "mdi-omega" => esc_html__( "Omega", "js_composer" ) ),
                array( "mdi-onedrive" => esc_html__( "Onedrive", "js_composer" ) ),
                array( "mdi-open-in-app" => esc_html__( "Open in app", "js_composer" ) ),
                array( "mdi-ornament" => esc_html__( "Ornament", "js_composer" ) ),
                array( "mdi-ornament-variant" => esc_html__( "Ornament variant", "js_composer" ) ),
                array( "mdi-package" => esc_html__( "Package", "js_composer" ) ),
                array( "mdi-package-down" => esc_html__( "Package down", "js_composer" ) ),
                array( "mdi-package-up" => esc_html__( "Package up", "js_composer" ) ),
                array( "mdi-package-variant" => esc_html__( "Package variant", "js_composer" ) ),
                array( "mdi-palette" => esc_html__( "Palette", "js_composer" ) ),
                array( "mdi-palette-advanced" => esc_html__( "Palette advanced", "js_composer" ) ),
                array( "mdi-panda" => esc_html__( "Panda", "js_composer" ) ),
                array( "mdi-pandora" => esc_html__( "Pandora", "js_composer" ) ),
                array( "mdi-panorama" => esc_html__( "Panorama", "js_composer" ) ),
                array( "mdi-panorama-fisheye" => esc_html__( "Panorama fisheye", "js_composer" ) ),
                array( "mdi-panorama-horizontal" => esc_html__( "Panorama horizontal", "js_composer" ) ),
                array( "mdi-panorama-vertical" => esc_html__( "Panorama vertical", "js_composer" ) ),
                array( "mdi-panorama-wide-angle" => esc_html__( "Panorama wide angle", "js_composer" ) ),
                array( "mdi-paper-cut-vertical" => esc_html__( "Paper cut vertical", "js_composer" ) ),
                array( "mdi-paperclip" => esc_html__( "Paperclip", "js_composer" ) ),
                array( "mdi-parking" => esc_html__( "Parking", "js_composer" ) ),
                array( "mdi-pause" => esc_html__( "Pause", "js_composer" ) ),
                array( "mdi-pause-circle" => esc_html__( "Pause circle", "js_composer" ) ),
                array( "mdi-pause-circle-outline" => esc_html__( "Pause circle outline", "js_composer" ) ),
                array( "mdi-pause-octagon" => esc_html__( "Pause octagon", "js_composer" ) ),
                array( "mdi-pause-octagon-outline" => esc_html__( "Pause octagon outline", "js_composer" ) ),
                array( "mdi-pencil" => esc_html__( "Pencil", "js_composer" ) ),
                array( "mdi-pencil-box" => esc_html__( "Pencil box", "js_composer" ) ),
                array( "mdi-pencil-box-outline" => esc_html__( "Pencil box outline", "js_composer" ) ),
                array( "mdi-pharmacy" => esc_html__( "Pharmacy", "js_composer" ) ),
                array( "mdi-phone" => esc_html__( "Phone", "js_composer" ) ),
                array( "mdi-phone-bluetooth" => esc_html__( "Phone bluetooth", "js_composer" ) ),
                array( "mdi-phone-forward" => esc_html__( "Phone forward", "js_composer" ) ),
                array( "mdi-phone-hangup" => esc_html__( "Phone hangup", "js_composer" ) ),
                array( "mdi-phone-in-talk" => esc_html__( "Phone in talk", "js_composer" ) ),
                array( "mdi-phone-locked" => esc_html__( "Phone locked", "js_composer" ) ),
                array( "mdi-phone-missed" => esc_html__( "Phone missed", "js_composer" ) ),
                array( "mdi-phone-paused" => esc_html__( "Phone paused", "js_composer" ) ),
                array( "mdi-phone-settings" => esc_html__( "Phone settings", "js_composer" ) ),
                array( "mdi-pig" => esc_html__( "Pig", "js_composer" ) ),
                array( "mdi-pill" => esc_html__( "Pill", "js_composer" ) ),
                array( "mdi-pin" => esc_html__( "Pin", "js_composer" ) ),
                array( "mdi-pin-off" => esc_html__( "Pin off", "js_composer" ) ),
                array( "mdi-pine-tree" => esc_html__( "Pine tree", "js_composer" ) ),
                array( "mdi-pine-tree-box" => esc_html__( "Pine tree box", "js_composer" ) ),
                array( "mdi-pinterest" => esc_html__( "Pinterest", "js_composer" ) ),
                array( "mdi-pizza" => esc_html__( "Pizza", "js_composer" ) ),
                array( "mdi-play" => esc_html__( "Play", "js_composer" ) ),
                array( "mdi-play-box-outline" => esc_html__( "Play box outline", "js_composer" ) ),
                array( "mdi-play-circle" => esc_html__( "Play circle", "js_composer" ) ),
                array( "mdi-play-circle-outline" => esc_html__( "Play circle outline", "js_composer" ) ),
                array( "mdi-playlist-plus" => esc_html__( "Playlist plus", "js_composer" ) ),
                array( "mdi-plus" => esc_html__( "Plus", "js_composer" ) ),
                array( "mdi-plus-box" => esc_html__( "Plus box", "js_composer" ) ),
                array( "mdi-plus-circle" => esc_html__( "Plus circle", "js_composer" ) ),
                array( "mdi-plus-circle-outline" => esc_html__( "Plus circle outline", "js_composer" ) ),
                array( "mdi-plus-network" => esc_html__( "Plus network", "js_composer" ) ),
                array( "mdi-plus-one" => esc_html__( "Plus one", "js_composer" ) ),
                array( "mdi-pocket" => esc_html__( "Pocket", "js_composer" ) ),
                array( "mdi-poll" => esc_html__( "Poll", "js_composer" ) ),
                array( "mdi-poll-box" => esc_html__( "Poll box", "js_composer" ) ),
                array( "mdi-polymer" => esc_html__( "Polymer", "js_composer" ) ),
                array( "mdi-popcorn" => esc_html__( "Popcorn", "js_composer" ) ),
                array( "mdi-pound" => esc_html__( "Pound", "js_composer" ) ),
                array( "mdi-pound-box" => esc_html__( "Pound box", "js_composer" ) ),
                array( "mdi-power" => esc_html__( "Power", "js_composer" ) ),
                array( "mdi-power-settings" => esc_html__( "Power settings", "js_composer" ) ),
                array( "mdi-presentation" => esc_html__( "Presentation", "js_composer" ) ),
                array( "mdi-presentation-play" => esc_html__( "Presentation play", "js_composer" ) ),
                array( "mdi-printer" => esc_html__( "Printer", "js_composer" ) ),
                array( "mdi-puzzle" => esc_html__( "Puzzle", "js_composer" ) ),
                array( "mdi-qrcode" => esc_html__( "Qrcode", "js_composer" ) ),
                array( "mdi-quadcopter" => esc_html__( "Quadcopter", "js_composer" ) ),
                array( "mdi-quality-high" => esc_html__( "Quality high", "js_composer" ) ),
                array( "mdi-quicktime" => esc_html__( "Quicktime", "js_composer" ) ),
                array( "mdi-radiator" => esc_html__( "Radiator", "js_composer" ) ),
                array( "mdi-radioactive" => esc_html__( "Radioactive", "js_composer" ) ),
                array( "mdi-radiobox-blank" => esc_html__( "Radiobox blank", "js_composer" ) ),
                array( "mdi-radiobox-marked" => esc_html__( "Radiobox marked", "js_composer" ) ),
                array( "mdi-rdio" => esc_html__( "Rdio", "js_composer" ) ),
                array( "mdi-read" => esc_html__( "Read", "js_composer" ) ),
                array( "mdi-readability" => esc_html__( "Readability", "js_composer" ) ),
                array( "mdi-receipt" => esc_html__( "Receipt", "js_composer" ) ),
                array( "mdi-recycle" => esc_html__( "Recycle", "js_composer" ) ),
                array( "mdi-redo" => esc_html__( "Redo", "js_composer" ) ),
                array( "mdi-redo-variant" => esc_html__( "Redo variant", "js_composer" ) ),
                array( "mdi-refresh" => esc_html__( "Refresh", "js_composer" ) ),
                array( "mdi-relative-scale" => esc_html__( "Relative scale", "js_composer" ) ),
                array( "mdi-reload" => esc_html__( "Reload", "js_composer" ) ),
                array( "mdi-remote" => esc_html__( "Remote", "js_composer" ) ),
                array( "mdi-rename-box" => esc_html__( "Rename box", "js_composer" ) ),
                array( "mdi-repeat" => esc_html__( "Repeat", "js_composer" ) ),
                array( "mdi-repeat-off" => esc_html__( "Repeat off", "js_composer" ) ),
                array( "mdi-repeat-once" => esc_html__( "Repeat once", "js_composer" ) ),
                array( "mdi-replay" => esc_html__( "Replay", "js_composer" ) ),
                array( "mdi-reply" => esc_html__( "Reply", "js_composer" ) ),
                array( "mdi-reply-all" => esc_html__( "Reply all", "js_composer" ) ),
                array( "mdi-responsive" => esc_html__( "Responsive", "js_composer" ) ),
                array( "mdi-rewind" => esc_html__( "Rewind", "js_composer" ) ),
                array( "mdi-ribbon" => esc_html__( "Ribbon", "js_composer" ) ),
                array( "mdi-rocket" => esc_html__( "Rocket", "js_composer" ) ),
                array( "mdi-rotate-3d" => esc_html__( "Rotate left", "js_composer" ) ),
                array( "mdi-rotate-left" => esc_html__( "Rotate left", "js_composer" ) ),
                array( "mdi-rotate-left-variant" => esc_html__( "Rotate left variant", "js_composer" ) ),
                array( "mdi-rotate-right" => esc_html__( "Rotate right", "js_composer" ) ),
                array( "mdi-rotate-right-variant" => esc_html__( "Rotate right variant", "js_composer" ) ),
                array( "mdi-routes" => esc_html__( "Routes", "js_composer" ) ),
                array( "mdi-rss" => esc_html__( "Rss", "js_composer" ) ),
                array( "mdi-rss-box" => esc_html__( "Rss box", "js_composer" ) ),
                array( "mdi-ruler" => esc_html__( "Ruler", "js_composer" ) ),
                array( "mdi-run" => esc_html__( "Run", "js_composer" ) ),
                array( "mdi-satellite" => esc_html__( "Satellite", "js_composer" ) ),
                array( "mdi-satellite-variant" => esc_html__( "Satellite variant", "js_composer" ) ),
                array( "mdi-scale" => esc_html__( "Scale", "js_composer" ) ),
                array( "mdi-scale-bathroom" => esc_html__( "Scale bathroom", "js_composer" ) ),
                array( "mdi-school" => esc_html__( "School", "js_composer" ) ),
                array( "mdi-screen-rotation" => esc_html__( "Screen rotation", "js_composer" ) ),
                array( "mdi-screen-rotation-lock" => esc_html__( "Screen rotation lock", "js_composer" ) ),
                array( "mdi-script" => esc_html__( "Script", "js_composer" ) ),
                array( "mdi-sd" => esc_html__( "Sd", "js_composer" ) ),
                array( "mdi-security" => esc_html__( "Security", "js_composer" ) ),
                array( "mdi-security-network" => esc_html__( "Security network", "js_composer" ) ),
                array( "mdi-select" => esc_html__( "Select", "js_composer" ) ),
                array( "mdi-select-inverse" => esc_html__( "Select inverse", "js_composer" ) ),
                array( "mdi-select-off" => esc_html__( "Select off", "js_composer" ) ),
                array( "mdi-send" => esc_html__( "Send", "js_composer" ) ),
                array( "mdi-server" => esc_html__( "Server", "js_composer" ) ),
                array( "mdi-server-minus" => esc_html__( "Server minus", "js_composer" ) ),
                array( "mdi-server-network" => esc_html__( "Server network", "js_composer" ) ),
                array( "mdi-server-network-off" => esc_html__( "Server network off", "js_composer" ) ),
                array( "mdi-server-off" => esc_html__( "Server off", "js_composer" ) ),
                array( "mdi-server-plus" => esc_html__( "Server plus", "js_composer" ) ),
                array( "mdi-server-remove" => esc_html__( "Server remove", "js_composer" ) ),
                array( "mdi-server-security" => esc_html__( "Server security", "js_composer" ) ),
                array( "mdi-settings" => esc_html__( "Settings", "js_composer" ) ),
                array( "mdi-settings-box" => esc_html__( "Settings box", "js_composer" ) ),
                array( "mdi-shape-plus" => esc_html__( "Shape plus", "js_composer" ) ),
                array( "mdi-share" => esc_html__( "Share", "js_composer" ) ),
                array( "mdi-share-variant" => esc_html__( "Share variant", "js_composer" ) ),
                array( "mdi-shopping" => esc_html__( "Shopping", "js_composer" ) ),
                array( "mdi-shopping-music" => esc_html__( "Shopping music", "js_composer" ) ),
                array( "mdi-shuffle" => esc_html__( "Shuffle", "js_composer" ) ),
                array( "mdi-sigma" => esc_html__( "Sigma", "js_composer" ) ),
                array( "mdi-sign-caution" => esc_html__( "Sign caution", "js_composer" ) ),
                array( "mdi-silverware" => esc_html__( "Silverware", "js_composer" ) ),
                array( "mdi-silverware-fork" => esc_html__( "Silverware fork", "js_composer" ) ),
                array( "mdi-silverware-spoon" => esc_html__( "Silverware spoon", "js_composer" ) ),
                array( "mdi-silverware-variant" => esc_html__( "Silverware variant", "js_composer" ) ),
                array( "mdi-sim-alert" => esc_html__( "Sim alert", "js_composer" ) ),
                array( "mdi-skip-next" => esc_html__( "Skip next", "js_composer" ) ),
                array( "mdi-skip-previous" => esc_html__( "Skip previous", "js_composer" ) ),
                array( "mdi-snowman" => esc_html__( "Snowman", "js_composer" ) ),
                array( "mdi-sort" => esc_html__( "Sort", "js_composer" ) ),
                array( "mdi-sort-alphabetical" => esc_html__( "Sort alphabetical", "js_composer" ) ),
                array( "mdi-sort-ascending" => esc_html__( "Sort ascending", "js_composer" ) ),
                array( "mdi-sort-descending" => esc_html__( "Sort descending", "js_composer" ) ),
                array( "mdi-sort-numeric" => esc_html__( "Sort numeric", "js_composer" ) ),
                array( "mdi-sort-variant" => esc_html__( "Sort variant", "js_composer" ) ),
                array( "mdi-soundcloud" => esc_html__( "Soundcloud", "js_composer" ) ),
                array( "mdi-source-fork" => esc_html__( "Source fork", "js_composer" ) ),
                array( "mdi-source-pull" => esc_html__( "Source pull", "js_composer" ) ),
                array( "mdi-speaker" => esc_html__( "Speaker", "js_composer" ) ),
                array( "mdi-speaker-off" => esc_html__( "Speaker off", "js_composer" ) ),
                array( "mdi-speedometer" => esc_html__( "Speedometer", "js_composer" ) ),
                array( "mdi-spellcheck" => esc_html__( "Spellcheck", "js_composer" ) ),
                array( "mdi-spotify" => esc_html__( "Spotify", "js_composer" ) ),
                array( "mdi-spotlight" => esc_html__( "Spotlight", "js_composer" ) ),
                array( "mdi-spotlight-beam" => esc_html__( "Spotlight beam", "js_composer" ) ),
                array( "mdi-stackoverflow" => esc_html__( "Stackoverflow", "js_composer" ) ),
                array( "mdi-star" => esc_html__( "Star", "js_composer" ) ),
                array( "mdi-star-circle" => esc_html__( "Star circle", "js_composer" ) ),
                array( "mdi-star-half" => esc_html__( "Star half", "js_composer" ) ),
                array( "mdi-star-outline" => esc_html__( "Star outline", "js_composer" ) ),
                array( "mdi-stocking" => esc_html__( "Stocking", "js_composer" ) ),
                array( "mdi-stop" => esc_html__( "Stop", "js_composer" ) ),
                array( "mdi-store" => esc_html__( "Store", "js_composer" ) ),
                array( "mdi-store-24-hour" => esc_html__( "Store 24-hour", "js_composer" ) ),
                array( "mdi-stove" => esc_html__( "Stove", "js_composer" ) ),
                array( "mdi-subway" => esc_html__( "Subway", "js_composer" ) ),
                array( "mdi-swap-horizontal" => esc_html__( "Swap horizontal", "js_composer" ) ),
                array( "mdi-swap-vertical" => esc_html__( "Swap vertical", "js_composer" ) ),
                array( "mdi-swim" => esc_html__( "Swim", "js_composer" ) ),
                array( "mdi-sword" => esc_html__( "Sword", "js_composer" ) ),
                array( "mdi-sync" => esc_html__( "Sync", "js_composer" ) ),
                array( "mdi-sync-alert" => esc_html__( "Sync alert", "js_composer" ) ),
                array( "mdi-sync-off" => esc_html__( "Sync off", "js_composer" ) ),
                array( "mdi-tab" => esc_html__( "Tab", "js_composer" ) ),
                array( "mdi-tab-unselected" => esc_html__( "Tab unselected", "js_composer" ) ),
                array( "mdi-table" => esc_html__( "Table", "js_composer" ) ),
                array( "mdi-table-large" => esc_html__( "Table large", "js_composer" ) ),
                array( "mdi-tablet" => esc_html__( "Tablet", "js_composer" ) ),
                array( "mdi-tablet-android" => esc_html__( "Tablet android", "js_composer" ) ),
                array( "mdi-tablet-ipad" => esc_html__( "Tablet ipad", "js_composer" ) ),
                array( "mdi-tag" => esc_html__( "Tag", "js_composer" ) ),
                array( "mdi-tag-faces" => esc_html__( "Tag faces", "js_composer" ) ),
                array( "mdi-tag-outline" => esc_html__( "Tag outline", "js_composer" ) ),
                array( "mdi-tag-text-outline" => esc_html__( "Tag text outline", "js_composer" ) ),
                array( "mdi-taxi" => esc_html__( "Taxi", "js_composer" ) ),
                array( "mdi-television" => esc_html__( "Television", "js_composer" ) ),
                array( "mdi-television-guide" => esc_html__( "Television guide", "js_composer" ) ),
                array( "mdi-temperature-celsius" => esc_html__( "Temperature celsius", "js_composer" ) ),
                array( "mdi-temperature-fahrenheit" => esc_html__( "Temperature fahrenheit", "js_composer" ) ),
                array( "mdi-temperature-kelvin" => esc_html__( "Temperature kelvin", "js_composer" ) ),
                array( "mdi-tent" => esc_html__( "Tent", "js_composer" ) ),
                array( "mdi-terrain" => esc_html__( "Terrain", "js_composer" ) ),
                array( "mdi-text-to-speech" => esc_html__( "Text to speech", "js_composer" ) ),
                array( "mdi-text-to-speech-off" => esc_html__( "Text to speech off", "js_composer" ) ),
                array( "mdi-texture" => esc_html__( "Texture", "js_composer" ) ),
                array( "mdi-theater" => esc_html__( "Theater", "js_composer" ) ),
                array( "mdi-theme-light-dark" => esc_html__( "Theme light dark", "js_composer" ) ),
                array( "mdi-thermometer" => esc_html__( "Thermometer", "js_composer" ) ),
                array( "mdi-thermometer-lines" => esc_html__( "Thermometer lines", "js_composer" ) ),
                array( "mdi-thumb-down" => esc_html__( "Thumb down", "js_composer" ) ),
                array( "mdi-thumb-up" => esc_html__( "Thumb up", "js_composer" ) ),
                array( "mdi-thumbs-up-down" => esc_html__( "Thumbs up down", "js_composer" ) ),
                array( "mdi-ticket" => esc_html__( "Ticket", "js_composer" ) ),
                array( "mdi-ticket-account" => esc_html__( "Ticket account", "js_composer" ) ),
                array( "mdi-tie" => esc_html__( "Tie", "js_composer" ) ),
                array( "mdi-timelapse" => esc_html__( "Timelapse", "js_composer" ) ),
                array( "mdi-timer" => esc_html__( "Timer", "js_composer" ) ),
                array( "mdi-timer-10" => esc_html__( "Timer 10", "js_composer" ) ),
                array( "mdi-timer-3" => esc_html__( "Timer 3", "js_composer" ) ),
                array( "mdi-timer-off" => esc_html__( "Timer off", "js_composer" ) ),
                array( "mdi-timer-sand" => esc_html__( "Timer sand", "js_composer" ) ),
                array( "mdi-timetable" => esc_html__( "Timetable", "js_composer" ) ),
                array( "mdi-toggle-switch" => esc_html__( "Toggle switch", "js_composer" ) ),
                array( "mdi-toggle-switch-off" => esc_html__( "Toggle switch off", "js_composer" ) ),
                array( "mdi-tooltip" => esc_html__( "Tooltip", "js_composer" ) ),
                array( "mdi-tooltip-edit" => esc_html__( "Tooltip edit", "js_composer" ) ),
                array( "mdi-tooltip-image" => esc_html__( "Tooltip image", "js_composer" ) ),
                array( "mdi-tooltip-outline" => esc_html__( "Tooltip outline", "js_composer" ) ),
                array( "mdi-tooltip-text" => esc_html__( "Tooltip text", "js_composer" ) ),
                array( "mdi-tor" => esc_html__( "Tor", "js_composer" ) ),
                array( "mdi-traffic-light" => esc_html__( "Traffic light", "js_composer" ) ),
                array( "mdi-train" => esc_html__( "Train", "js_composer" ) ),
                array( "mdi-tram" => esc_html__( "Tram", "js_composer" ) ),
                array( "mdi-transcribe" => esc_html__( "Transcribe", "js_composer" ) ),
                array( "mdi-transcribe-close" => esc_html__( "Transcribe close", "js_composer" ) ),
                array( "mdi-trello" => esc_html__( "Trello", "js_composer" ) ),
                array( "mdi-trending-down" => esc_html__( "Trending down", "js_composer" ) ),
                array( "mdi-trending-neutral" => esc_html__( "Trending neutral", "js_composer" ) ),
                array( "mdi-trending-up" => esc_html__( "Trending up", "js_composer" ) ),
                array( "mdi-trophy" => esc_html__( "Trophy", "js_composer" ) ),
                array( "mdi-trophy-award" => esc_html__( "Trophy award", "js_composer" ) ),
                array( "mdi-trophy-variant" => esc_html__( "Trophy variant", "js_composer" ) ),
                array( "mdi-truck" => esc_html__( "Truck", "js_composer" ) ),
                array( "mdi-tshirt-crew" => esc_html__( "Tshirt crew", "js_composer" ) ),
                array( "mdi-tshirt-v" => esc_html__( "Tshirt v", "js_composer" ) ),
                array( "mdi-tumblr" => esc_html__( "Tumblr", "js_composer" ) ),
                array( "mdi-tumblr-reblog" => esc_html__( "Tumblr reblog", "js_composer" ) ),
                array( "mdi-twitch" => esc_html__( "Twitch", "js_composer" ) ),
                array( "mdi-twitter" => esc_html__( "Twitter", "js_composer" ) ),
                array( "mdi-twitter-box" => esc_html__( "Twitter box", "js_composer" ) ),
                array( "mdi-twitter-retweet" => esc_html__( "Twitter retweet", "js_composer" ) ),
                array( "mdi-ubuntu" => esc_html__( "Ubuntu", "js_composer" ) ),
                array( "mdi-undo" => esc_html__( "Undo", "js_composer" ) ),
                array( "mdi-undo-variant" => esc_html__( "Undo variant", "js_composer" ) ),
                array( "mdi-unfold-less" => esc_html__( "Unfold less", "js_composer" ) ),
                array( "mdi-unfold-more" => esc_html__( "Unfold more", "js_composer" ) ),
                array( "mdi-upload" => esc_html__( "Upload", "js_composer" ) ),
                array( "mdi-usb" => esc_html__( "Usb", "js_composer" ) ),
                array( "mdi-vector-curve" => esc_html__( "Vector curve", "js_composer" ) ),
                array( "mdi-vector-point" => esc_html__( "Vector point", "js_composer" ) ),
                array( "mdi-vector-square" => esc_html__( "Vector square", "js_composer" ) ),
                array( "mdi-verified" => esc_html__( "Verified", "js_composer" ) ),
                array( "mdi-vibrate" => esc_html__( "Vibrate", "js_composer" ) ),
                array( "mdi-video" => esc_html__( "Video", "js_composer" ) ),
                array( "mdi-video-off" => esc_html__( "Video off", "js_composer" ) ),
                array( "mdi-video-switch" => esc_html__( "Video switch", "js_composer" ) ),
                array( "mdi-view-agenda" => esc_html__( "View agenda", "js_composer" ) ),
                array( "mdi-view-array" => esc_html__( "View array", "js_composer" ) ),
                array( "mdi-view-carousel" => esc_html__( "View carousel", "js_composer" ) ),
                array( "mdi-view-column" => esc_html__( "View column", "js_composer" ) ),
                array( "mdi-view-dashboard" => esc_html__( "View dashboard", "js_composer" ) ),
                array( "mdi-view-day" => esc_html__( "View day", "js_composer" ) ),
                array( "mdi-view-headline" => esc_html__( "View headline", "js_composer" ) ),
                array( "mdi-view-list" => esc_html__( "View list", "js_composer" ) ),
                array( "mdi-view-module" => esc_html__( "View module", "js_composer" ) ),
                array( "mdi-view-quilt" => esc_html__( "View quilt", "js_composer" ) ),
                array( "mdi-view-stream" => esc_html__( "View stream", "js_composer" ) ),
                array( "mdi-view-week" => esc_html__( "View week", "js_composer" ) ),
                array( "mdi-vimeo" => esc_html__( "Vimeo", "js_composer" ) ),
                array( "mdi-voicemail" => esc_html__( "Voicemail", "js_composer" ) ),
                array( "mdi-volume-high" => esc_html__( "Volume high", "js_composer" ) ),
                array( "mdi-volume-low" => esc_html__( "Volume low", "js_composer" ) ),
                array( "mdi-volume-medium" => esc_html__( "Volume medium", "js_composer" ) ),
                array( "mdi-volume-off" => esc_html__( "Volume off", "js_composer" ) ),
                array( "mdi-walk" => esc_html__( "Walk", "js_composer" ) ),
                array( "mdi-wallet" => esc_html__( "Wallet", "js_composer" ) ),
                array( "mdi-wallet-giftcard" => esc_html__( "Wallet giftcard", "js_composer" ) ),
                array( "mdi-wallet-membership" => esc_html__( "Wallet membership", "js_composer" ) ),
                array( "mdi-wallet-travel" => esc_html__( "Wallet travel", "js_composer" ) ),
                array( "mdi-watch" => esc_html__( "Watch", "js_composer" ) ),
                array( "mdi-water" => esc_html__( "Water", "js_composer" ) ),
                array( "mdi-water-off" => esc_html__( "Water off", "js_composer" ) ),
                array( "mdi-water-pump" => esc_html__( "Water pump", "js_composer" ) ),
                array( "mdi-weather-cloudy" => esc_html__( "Weather cloudy", "js_composer" ) ),
                array( "mdi-weather-hail" => esc_html__( "Weather hail", "js_composer" ) ),
                array( "mdi-weather-lightning" => esc_html__( "Weather lightning", "js_composer" ) ),
                array( "mdi-weather-night" => esc_html__( "Weather night", "js_composer" ) ),
                array( "mdi-weather-partlycloudy" => esc_html__( "Weather partlycloudy", "js_composer" ) ),
                array( "mdi-weather-pouring" => esc_html__( "Weather pouring", "js_composer" ) ),
                array( "mdi-weather-rainy" => esc_html__( "Weather rainy", "js_composer" ) ),
                array( "mdi-weather-snowy" => esc_html__( "Weather snowy", "js_composer" ) ),
                array( "mdi-weather-sunny" => esc_html__( "Weather sunny", "js_composer" ) ),
                array( "mdi-weather-sunset" => esc_html__( "Weather sunset", "js_composer" ) ),
                array( "mdi-weather-sunset-down" => esc_html__( "Weather sunset down", "js_composer" ) ),
                array( "mdi-weather-sunset-up" => esc_html__( "Weather sunset up", "js_composer" ) ),
                array( "mdi-weather-windy" => esc_html__( "Weather windy", "js_composer" ) ),
                array( "mdi-weather-windy-variant" => esc_html__( "Weather windy variant", "js_composer" ) ),
                array( "mdi-web" => esc_html__( "Web", "js_composer" ) ),
                array( "mdi-webcam" => esc_html__( "Webcam", "js_composer" ) ),
                array( "mdi-whatsapp" => esc_html__( "Whatsapp", "js_composer" ) ),
                array( "mdi-wheelchair-accessibility" => esc_html__( "Wheelchair accessibility", "js_composer" ) ),
                array( "mdi-white-balance-auto" => esc_html__( "Balance auto", "js_composer" ) ),
                array( "mdi-white-balance-incandescent" => esc_html__( "Balance incandescent", "js_composer" ) ),
                array( "mdi-white-balance-irradescent" => esc_html__( "Balance irradescent", "js_composer" ) ),
                array( "mdi-white-balance-sunny" => esc_html__( "Balance sunny", "js_composer" ) ),
                array( "mdi-wifi" => esc_html__( "WI-FI", "js_composer" ) ),
                array( "mdi-wikipedia" => esc_html__( "Wikipedia", "js_composer" ) ),
                array( "mdi-window-closed" => esc_html__( "Windows close", "js_composer" ) ),
                array( "mdi-window-open" => esc_html__( "Windows open", "js_composer" ) ),
                array( "mdi-windows" => esc_html__( "Windows", "js_composer" ) ),
                array( "mdi-wordpress" => esc_html__( "WordPress", "js_composer" ) ),
                array( "mdi-xbox" => esc_html__( "XBOX", "js_composer" ) ),
                array( "mdi-xbox-controller" => esc_html__( "XBOX controller", "js_composer" ) ),
                array( "mdi-xbox-controller-off" => esc_html__( "XBOX controller OFF", "js_composer" ) ),
                array( "mdi-xda" => esc_html__( "XDA", "js_composer" ) ),
                array( "mdi-xml" => esc_html__( "XML", "js_composer" ) ),
                array( "mdi-yeast" => esc_html__( "Yeast", "js_composer" ) ),
                array( "mdi-youtube-play" => esc_html__( "Youtube play", "js_composer" ) ),
                array( "mdi-zip-box" => esc_html__( "Zip box", "js_composer" ) ),
            );

            return array_merge( $icons, $material_icons_icons );
        }

        /* Custom Options Arrays ----------------------------------------------------- */

        $nets_array = array (
            'None' => 'none',
            'Behance' => 'behance',
            'Delicious' => 'delicious',
            'Dribbble' => 'dribbble',
            'Email' => 'send',
            'Facebook' => 'facebook',
            'Flickr' => 'flickr',
            'Google Plus' => 'google_plus',
            'Instagram' => 'instagram',
            'Linkedin' => 'linkedin',
            'Pinterest' => 'pinterest',
            'RSS' => 'rss',
            'Soundcloud' => 'soundcloud',
            'Skype' => 'skype',
            'Twitter' => 'twitter',
            'Tumblr' => 'tumblr',
            'vCard' => 'book',
            'Vimeo' => 'vimeo',
            'VK' => 'vk',
            'Wechat' => 'wechat',
            'WordPress' => 'wordpress',
            'Xing' => 'xing',
            'Yahoo' => 'yahoo',
            'Youtube' => 'youtube',
        );
        $nets_array_single = array (
            'behance',
            'delicious',
            'dribbble',
            'send',
            'facebook',
            'flickr',
            'google_plus',
            'instagram',
            'linkedin',
            'pinterest',
            'rss',
            'soundcloud',
            'skype',
            'twitter',
            'tumblr',
            'book',
            'vimeo',
            'vk',
            'wechat',
            'wordpress',
            'xing',
            'yahoo',
            'youtube',
        );

        $yes_no_arr = array(esc_html__('Yes', "js_composer") => "yes",esc_html__('No', "js_composer") => "no");
        $no_yes_arr = array(esc_html__('No', "js_composer") => "no",esc_html__('Yes', "js_composer") => "yes");
        // Used in "Button", "Call esc_html__( 'Blue', 'js_composer' )to Action", "Pie chart" blocks
        $colors_arr = array(
            esc_html__( 'Grey', 'js_composer' ) => 'wpb_button',
            esc_html__( 'Blue', 'js_composer' ) => 'btn-primary',
            esc_html__( 'Turquoise', 'js_composer' ) => 'btn-info',
            esc_html__( 'Green', 'js_composer' ) => 'btn-success',
            esc_html__( 'Orange', 'js_composer' ) => 'btn-warning',
            esc_html__( 'Red', 'js_composer' ) => 'btn-danger',
            esc_html__( 'Black', 'js_composer' ) => "btn-inverse"
        );
        $pirenko_colors_arr = array(esc_html__("Theme Button", "js_composer") => "theme_button",esc_html__("Theme Button - Inverted Colors", "js_composer") => "colored_theme_button",esc_html__("Grey", "js_composer") => "wpb_button", esc_html__("Blue", "js_composer") => "btn-primary", esc_html__("Turquoise", "js_composer") => "btn-info", esc_html__("Green", "js_composer") => "btn-success", esc_html__("Orange", "js_composer") => "btn-warning", esc_html__("Red", "js_composer") => "btn-danger", esc_html__("Black", "js_composer") => "btn-inverse");
        // Used in "Button" and "Call to Action" blocks
        $size_arr = array(
            esc_html__( 'Regular size', 'js_composer' ) => 'wpb_regularsize',
            esc_html__( 'Large', 'js_composer' ) => 'btn-large',
            esc_html__( 'Small', 'js_composer' ) => 'btn-small',
            esc_html__( 'Mini', 'js_composer' ) => "btn-mini"
        );
        $add_css_animation = array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'CSS Animation', 'js_composer' ),
            'param_name' => 'css_animation',
            'admin_label' => true,
            'value' => array(
                esc_html__( 'No', 'js_composer' ) => '',
                esc_html__("Simple fade", "js_composer") => 'hook_fade_waypoint',
                esc_html__( 'Zoom in', 'js_composer' ) => "appear",
                esc_html__( 'Flash', 'js_composer' ) => "hook_flash",
                esc_html__( 'Shake', 'js_composer' ) => "hook_shake",
                esc_html__( 'Pulse', 'js_composer' ) => "hook_pulse",
                esc_html__( 'Flip in - vertical', 'js_composer' ) => "flipin_x",
                esc_html__( 'Flip in - horizontal', 'js_composer' ) => "flipin_y",
                esc_html__( 'Move down', 'js_composer' ) => 'top-to-bottom',
                esc_html__( 'Move down faster', 'js_composer' ) => 'top-to-bottom-faster',
                esc_html__( 'Bounce down', 'js_composer' ) => 'hook_fadeInDownBig',
                esc_html__( 'Move up', 'js_composer' ) => 'bottom-to-top',
                esc_html__( 'Move up faster', 'js_composer' ) => 'bottom-to-top-faster',
                esc_html__( 'Bounce up', 'js_composer' ) => 'hook_fadeInUpBig',
                esc_html__( 'Move right', 'js_composer' ) => 'left-to-right',
                esc_html__( 'Move right faster', 'js_composer' ) => 'left-to-right-faster',
                esc_html__( 'Bounce in from left', 'js_composer' ) => 'hook_fadeInLeftBig',
                esc_html__( 'Move left', 'js_composer' ) => 'right-to-left',
                esc_html__( 'Move left faster', 'js_composer' ) => 'right-to-left-faster',
                esc_html__( 'Bounce in from right', 'js_composer' ) => 'hook_fadeInRightBig',
            ),
            'description' => esc_html__( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'js_composer' ),
            "weight" => "-60",
        );
        $add_css_delay = array(
            "type" => "textfield",
            "heading" => esc_html__("Animation delay", "js_composer"),
            "param_name" => "css_delay",
            "value" => '0',
            "description" => "Animation delay (in miliseconds).",
            "weight" => "-65",
            "dependency" => Array('element' => "css_animation", 'not_empty' => true)
        );
        $target_arr = array(
            esc_html__( 'No', 'js_composer' ) => "_self",
            esc_html__( 'Yes', 'js_composer' ) => "_blank"
        );
        $rotator_arr = array(
            esc_html__( 'Smooth shift', 'js_composer' ) => "old_timey",
            esc_html__( '3D effect', 'js_composer' ) => "rotate-1",
            esc_html__( 'Fast character rotation', 'js_composer' ) => "rotate-2 letters",
            esc_html__( 'Slide', 'js_composer' ) => "slide",
            esc_html__( 'Zoom', 'js_composer' ) => "rotate-3 letters",
            esc_html__( 'Character shift', 'js_composer' ) => "scale letters",
            esc_html__( 'Scale', 'js_composer' ) => "scale letters"
        );
        $add_css_hide = array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Hide on certain screens:', 'js_composer' ),
            'param_name' => 'hide_with_css',
            'admin_label' => true,
            'group' => esc_html__( 'Viewports', 'js_composer' ),
            'value' => array(
                esc_html__("Large screens - Over 768px wide", "js_composer") => 'show_later',
                esc_html__("Small screens - Under 768px wide", "js_composer") => 'hide_later',
                esc_html__("Smaller screens - Under 480px wide", "js_composer") => 'hide_much_later',
            ),
            'description' => esc_html__( 'Tick the screen sizes on wich this element should be hidden.', 'js_composer' )
        );
        $add_mobile_mode = array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Activate mobile mode', 'js_composer' ),
            'param_name' => 'mobile_mode',
            'admin_label' => true,
            'group' => esc_html__( 'Responsiveness', 'js_composer' ),
            'value' => array(
                esc_html__("Screens under 768px wide", "js_composer") => '',
                esc_html__("Screens under 1024px wide", "js_composer") => 'hook_sooner',
            ),
            'description' => esc_html__( 'Default value is 768px.', 'js_composer' )
        );
        $add_custom_css = array(
            "type" => "textfield",
            "heading" => esc_html__("Apply custom CSS to this element", "js_composer"),
            "param_name" => "custom_css",
            "value" => '',
            "description" => "Example: margin-left:90px;",
            "weight" => "-90",
        );
        $add_el_class= array(
            "type" => "textfield",
            'heading' => __( 'Extra CSS class name', 'js_composer' ),
            "param_name" => "el_class",
            "value"=> "",
            "description" => __('If you wish to customize this element you can use this field to add CSS class name.', 'js_composer'),
            "weight" => "-70",
        );

        /* Page Elements Removal ----------------------------------------------------- */
        $prk_hook_options=hook_options();

        vc_remove_element("vc_empty_space");
        if (!function_exists('prk_church_integrateWithVC')) {
            vc_remove_element("vc_basic_grid");
            vc_remove_element("vc_media_grid");
            vc_remove_element("vc_masonry_grid");
            vc_remove_element("vc_masonry_media_grid");
            vc_remove_element("vc_posts_grid");
        }
        vc_remove_element("vc_separator");
        vc_remove_element("vc_posts_slider");
        vc_remove_element("vc_images_carousel");
        vc_remove_element("vc_carousel");
        vc_remove_element("vc_toggle");
        vc_remove_element("vc_cta_button");
        vc_remove_element("vc_gallery");

        vc_remove_element("vc_pie");
        vc_remove_element("vc_icon");
        vc_remove_element("vc_round_chart");
        vc_remove_element("vc_line_chart");
        vc_remove_element("vc_button2");
        vc_remove_element("vc_btn");
        vc_remove_element("vc_tta_pageable");
        vc_remove_element("vc_zigzag");
        vc_remove_element("vc_hoverbox");


        /* Row Overrides ----------------------------------------------------- */
        vc_remove_param('vc_row', 'parallax_speed_video');
        vc_remove_param('vc_row', 'parallax_speed_bg');
        vc_remove_param('vc_row', 'columns_placement');
        vc_remove_param('vc_row', 'gap');
        vc_remove_param('vc_row', 'equal_height');
        vc_remove_param('vc_row', 'full_height');
        vc_remove_param('vc_row', 'video_bg');
        vc_remove_param('vc_row', 'content_placement');
        vc_remove_param('vc_row', 'video_bg_url');
        vc_remove_param('vc_row', 'video_bg_parallax');
        vc_remove_param('vc_row', 'full_width');
        vc_remove_param('vc_row', 'parallax');
        vc_remove_param('vc_row', 'parallax_image');
        vc_remove_param('vc_row', 'font_color');
        vc_remove_param('vc_row', 'el_class');
        vc_remove_param('vc_row', 'css');

        vc_add_param("vc_row", array(
            "type" => "dropdown",
            "heading" => esc_html__("Row width", "js_composer"),
            "param_name" => "bk_type",
            "value" => array(
                esc_html__("Regular size", "js_composer") => "hook_boxed_row",
                esc_html__("Full width (content is displayed with no horizontal size restrictions)", "js_composer") => "hook_full_row"),
            "description" => esc_html__("This option determines the general size of the whole row section.", "js_composer")
        ));
        vc_add_param("vc_row", array(
            "type" => "dropdown",
            "heading" => esc_html__("Row Height", "js_composer"),
            "param_name" => "row_height",
            "value" => array(
                esc_html__("Regular", 'js_composer') => '',
                esc_html__("Specify height", 'js_composer') => 'hook_fixed_height',
                esc_html__("Force 100%", 'js_composer') => 'forced_row',
                esc_html__('Force 100% - content vertically centered', 'js_composer') => 'forced_row vertical_forced_row',
                esc_html__('Force 100% - content vertically aligned with bottom', 'js_composer') => 'forced_row bottom_forced_row',
            ),
            "description" => esc_html__("", "js_composer"),
        ));
        vc_add_param("vc_row", array(
            "type" => "textfield",
            "heading" => esc_html__("Row height", "js_composer"),
            "param_name" => "row_fixed",
            "value" => '',
            "description" => "Example: 500.",
            "dependency" => Array('element' => "row_height", 'value' => array('hook_fixed_height'))
        ));
        vc_add_param("vc_row", array(
            "type" => "textfield",
            "heading" => esc_html__("Height correction?", "js_composer"),
            "param_name" => "height_adjust",
            "value" => '',
            "description" => "Example: 60. The row forced height will be reduced in this amount. Useful to eventually compensate the menu height.",
            "dependency" => Array('element' => "row_height", 'value' => array('forced_row','forced_row vertical_forced_row','forced_row bottom_forced_row'))
        ));
        vc_add_param("vc_row", array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Equal height columns', 'js_composer' ),
            'param_name' => 'equal_height',
            'description' => esc_html__( 'If checked columns will be set to equal height.', 'js_composer' ),
            'value' => array( esc_html__( 'Yes', 'js_composer' ) => 'yes' )
        ));
        vc_add_param("vc_row", array(
            "type" => "textfield",
            "heading" => esc_html__('Top padding', 'js_composer'),
            "param_name" => "top_padding",
            "value" => "0px",
            "description" => esc_html__("Value must be in px.", "wpb")
        ));
        vc_add_param("vc_row", array(
            "type" => "textfield",
            "heading" => esc_html__('Bottom padding', 'js_composer'),
            "param_name" => "bottom_padding",
            "value" => "0px",
            "description" => esc_html__("Value must be in px.", "wpb")
        ));
        vc_add_param("vc_row", array(
            "type" => "textfield",
            "heading" => esc_html__('Bottom margin', 'js_composer'),
            "param_name" => "margin_bottom",
            "value" => "0px",
            "description" => esc_html__("You can use px, em, or %.", "wpb")
        ));
        vc_add_param("vc_row", array(
            "type" => "colorpicker",
            "holder" => "div",
            "class" => "",
            "heading" => esc_html__("Text color", 'js_composer'),
            "param_name" => "font_color",
            "value" => esc_html__("", 'js_composer'),
            "description" => esc_html__("Optional", 'js_composer')
        ));
        vc_add_param("vc_row", array(
            "type" => "colorpicker",
            "heading" => esc_html__("Row Background Color", "wpb"),
            "param_name" => "bg_color",
            "description" => esc_html__("Select backgound color for this row", "wpb")
        ));
        vc_add_param("vc_row", array(
            "type" => "dropdown",
            "heading" => esc_html__("Background type", "js_composer"),
            "param_name" => "bk_element",
            "value" => array(
                esc_html__("Default", 'js_composer') => '',
                esc_html__('Image', 'js_composer') => 'image',
                esc_html__('Video', 'js_composer') => 'video',
            ),
            "description" => esc_html__("", "js_composer"),
        ));
        vc_add_param("vc_row", array(
            "type" => "attach_image",
            "heading" => esc_html__('Row Background Image', 'js_composer'),
            "param_name" => "bg_image",
            "description" => esc_html__("Select background image for this row", "wpb"),
            "dependency" => Array('element' => "bk_element", 'value' => 'image')
        ));
        vc_add_param("vc_row", array(
            "type" => "dropdown",
            "heading" => esc_html__("Preload background image?", "js_composer"),
            "param_name" => "preload_bk",
            "value" => $no_yes_arr,
            "description" => "If yes page content will not be shown until background image is loaded",
            "dependency" => Array('element' => "bk_element", 'value' => 'image')
        ));
        vc_add_param("vc_row", array(
            "type" => "dropdown",
            "heading" => esc_html__('Background Image behavior', 'js_composer'),
            "param_name" => "bg_image_repeat",
            "value" => array(
                esc_html__("Default", 'js_composer') => '',
                esc_html__('Parallax effect - Fixed background image', 'js_composer') => 'hook_with_parallax hook_attached',
                esc_html__('Parallax effect - Without background image resize', 'js_composer') => 'hook_with_parallax',
                esc_html__('Parallax effect - Force background image to cover row', 'js_composer') => 'hook_with_parallax hook_cover',
                esc_html__("Fixed position", 'js_composer') => 'hook_fixed_bk',
                esc_html__("Cover - background image aligned with top", 'js_composer') => 'hook_cover_top',
                esc_html__("Cover - background image centered", 'js_composer') => 'hook_cover',
                esc_html__("Cover - background image aligned with bottom", 'js_composer') => 'hook_cover_bottom',
                esc_html__('Contain', 'js_composer') => 'contain'
            ),
            "description" => esc_html__("Select how a background image will be repeated", "wpb"),
            "dependency" => Array('element' => "bk_element", 'value' => 'image')
        ));
        vc_add_param("vc_row", array(
            "type" => "textfield",
            "heading" => esc_html__("Video MP4 file path", "js_composer"),
            "param_name" => "vid_mp4",
            "description" => esc_html__("", "js_composer"),
            "dependency" => Array('element' => "bk_element", 'value' => 'video')
        ));
        vc_add_param("vc_row", array(
            "type" => "textfield",
            "heading" => esc_html__("Video webm file path", "js_composer"),
            "param_name" => "vid_webm",
            "description" => esc_html__("", "js_composer"),
            "dependency" => Array('element' => "bk_element", 'value' => 'video')
        ));
        vc_add_param("vc_row", array(
            "type" => "attach_image",
            "heading" => esc_html__('Video image fallback', 'js_composer'),
            "param_name" => "vid_image",
            "description" => esc_html__("Will be shown if the browser does not support video (optional)", "wpb"),
            "dependency" => Array('element' => "bk_element", 'value' => 'video')
        ));
        vc_add_param("vc_row", array(
            "type" => "dropdown",
            "heading" => esc_html__("Video parallax effect?", "js_composer"),
            "param_name" => "vid_parallax",
            "value" => $no_yes_arr,
            "description" => "",
            "dependency" => Array('element' => "bk_element", 'value' => 'video')
        ));
        vc_add_param("vc_row",array(
            "type" => "dropdown",
            "heading" => esc_html__('Background overlay', 'js_composer'),
            "param_name" => "bk_overlay",
            "value" => array(
                esc_html__("None", 'js_composer') => '',
                esc_html__("Plain", 'js_composer') => 'plain.png',
                esc_html__("Dots", 'js_composer') => 'dots.png',
                esc_html__("Vertical lines", 'js_composer') => 'vertical-line.png',
                esc_html__("Horizontal lines", 'js_composer') => 'horizontal-line.png',
                esc_html__("Oblique lines", 'js_composer') => 'oblique.png',
            ),
            "description" => esc_html__("Useful to darken backgrounds", "wpb")
        ));
        vc_add_param("vc_row",array(
            "type" => "textfield",
            "holder" => "div",
            "class" => "",
            "heading" => esc_html__("Overlay opacity","hook"),
            "param_name" => "overlay_alpha",
            "value" => "100",
            "description" => esc_html__("Acceptable values: [1,100]","hook"),
            "dependency" => Array('element' => "bk_overlay", 'value' => array('dots.png','vertical-line.png','horizontal-line.png','oblique.png')),
        ));
        vc_add_param("vc_row", array(
            "type" => "dropdown",
            "heading" => esc_html__("Text alignment", "js_composer"),
            "param_name" => "align",
            "value" => array(
                esc_html__("Left", 'js_composer') => 'hook_left_align',
                esc_html__("Centered", 'js_composer') => 'hook_center_align',
                esc_html__('Right', 'js_composer') => 'hook_right_align',
            ),
            "description" => esc_html__("Can be overriden by individual elements settings", "js_composer")
        ));
        vc_add_param("vc_row", array(
            "type" => "dropdown",
            "heading" => esc_html__("Append scroll down arrow on bottom of this row?", "js_composer"),
            "param_name" => "append_arrow",
            "value" => $no_yes_arr,
            "description" => "On click will make the browser scroll to the next row",
        ));
        vc_add_param("vc_row", array(
            "type" => "colorpicker",
            "heading" => esc_html__('Scroll down arrow color', 'js_composer'),
            "param_name" => "append_arrow_color",
            "description" => esc_html__("", "wpb"),
            "dependency" => Array('element' => "append_arrow", 'value' => 'yes')
        ));
        vc_add_param("vc_row", array(
            "type" => "textfield",
            "heading" => esc_html__('Scroll down arrow link', 'js_composer'),
            "param_name" => "in_link",
            "description" => esc_html__("Optional - by default it scrolls to the next row", "wpb"),
            "dependency" => Array('element' => "append_arrow", 'value' => 'yes')
        ));
        vc_add_param("vc_row", $add_css_animation);
        vc_add_param("vc_row", $add_css_delay);
        vc_add_param("vc_row", $add_el_class);
        vc_add_param("vc_row", $add_custom_css);
        vc_add_param("vc_row", $add_css_hide);
        vc_add_param("vc_row", array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Invert columns order on smaller screens', 'js_composer' ),
            'param_name' => 'hook_inv_cols',
            'group' => esc_html__( 'Responsiveness', 'js_composer' ),
            'description' => esc_html__( 'If turned ON columns will displayed from left to right', 'js_composer' ),
            'value' => array(
                esc_html__( 'Yes', 'js_composer' ) => 'yes'
            )
        ));
        vc_add_param("vc_row", $add_mobile_mode);


        /* Inner Row Overrides ----------------------------------------------------- */
        vc_remove_param('vc_row_inner', 'content_placement');
        vc_remove_param('vc_row_inner', 'columns_placement');
        vc_remove_param('vc_row_inner', 'gap');
        vc_remove_param('vc_row_inner', 'equal_height');
        vc_remove_param('vc_row_inner', 'css');
        vc_remove_param('vc_row_inner', 'el_class');
        vc_add_param("vc_row_inner", array(
            "type" => "textfield",
            "heading" => esc_html__('Top padding', 'js_composer'),
            "param_name" => "top_padding",
            "value" => "0px",
            "description" => esc_html__("Value must be in px.", "wpb")
        ));
        vc_add_param("vc_row_inner", array(
            "type" => "textfield",
            "heading" => esc_html__('Bottom padding', 'js_composer'),
            "param_name" => "bottom_padding",
            "value" => "0px",
            "description" => esc_html__("Value must be in px.", "wpb")
        ));
        vc_add_param("vc_row", array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Equal height columns', 'js_composer' ),
            'param_name' => 'equal_height',
            'description' => esc_html__( 'If checked columns will be set to equal height.', 'js_composer' ),
            'value' => array( esc_html__( 'Yes', 'js_composer' ) => 'yes' )
        ));
        vc_add_param("vc_row_inner", $add_custom_css);
        vc_add_param("vc_row_inner", $add_css_animation);
        vc_add_param("vc_row_inner", $add_css_delay);
        vc_add_param("vc_row_inner", $add_el_class);
        vc_add_param("vc_row_inner", $add_css_hide);
        vc_add_param("vc_row_inner", array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Invert columns on smaller screens', 'js_composer' ),
            'param_name' => 'hook_inv_cols',
            'group' => esc_html__( 'Responsiveness', 'js_composer' ),
            'description' => esc_html__( 'If turned ON columns will displayed from left to right', 'js_composer' ),
            'value' => array(
                esc_html__( 'Yes', 'js_composer' ) => 'yes'
            )
        ));

        /* Column Overrides ----------------------------------------------------- */
        vc_remove_param('vc_column', 'font_color');
        vc_remove_param('vc_column', 'css');
        vc_remove_param('vc_column', 'el_class');
        //vc_remove_param('vc_column', 'width');
        //vc_remove_param('vc_column', 'offset');
        vc_remove_param('vc_column', 'video_bg');
        vc_remove_param('vc_column', 'video_bg_url');
        vc_remove_param('vc_column', 'video_bg_parallax');
        vc_remove_param('vc_column', 'parallax');
        vc_remove_param('vc_column', 'parallax_image');
        vc_remove_param('vc_column', 'video_bg_parallax');
        vc_remove_param('vc_column', 'parallax_speed_video');
        vc_remove_param('vc_column', 'parallax_speed_bg');

        vc_add_param("vc_column", array(
            "type" => "dropdown",
            "heading" => esc_html__("Text alignment", "js_composer"),
            "param_name" => "align",
            "value" => array(
                esc_html__("Inherit from row", 'js_composer') => 'hook_inherit_align',
                esc_html__("Left", 'js_composer') => 'hook_left_align',
                esc_html__("Centered", 'js_composer') => 'hook_center_align',
                esc_html__('Right', 'js_composer') => 'hook_right_align',
            ),
            "description" => esc_html__("Can be overriden by individual elements settings", "js_composer")
        ));
        /*vc_add_param("vc_column", array(
                "type" => "dropdown",
                "heading" => esc_html__("Column Height", "js_composer"),
                "param_name" => "column_height",
                "value" => array(
                    esc_html__("Regular", 'js_composer') => '',
                    esc_html__("Force 100%", 'js_composer') => 'hook_forced_clm',
                    esc_html__('Force 100% - content vertically centered', 'js_composer') => 'hook_forced_clm hook_vertical_clm',
                    esc_html__('Force 100% - content vertically aligned with bottom', 'js_composer') => 'hook_forced_clm bottom_forced_clm',
                ),
                "description" => esc_html__("", "js_composer"),
            ));*/
        vc_add_param("vc_column", array(
            "type" => "colorpicker",
            "heading" => esc_html__("Column Background Color", "wpb"),
            "param_name" => "bg_color",
            "description" => esc_html__("Select backgound color for your column", "wpb"),
        ));
        vc_add_param("vc_column", array(
            "type" => "attach_image",
            "heading" => esc_html__('Column Background Image', 'js_composer'),
            "param_name" => "bg_image",
            "description" => esc_html__("Select background image for your column", "wpb")
        ));
        vc_add_param("vc_column", array(
            "type" => "dropdown",
            "heading" => esc_html__('Column Background Image Horizontal Alignment', 'js_composer'),
            "param_name" => "bg_image_hz_align",
            "value" => array(
                esc_html__("Center", 'js_composer') => 'hook_hz_center',
                esc_html__("Left", 'js_composer') => 'hook_hz_left',
                esc_html__("Right", 'js_composer') => 'hook_hz_right'
            ),
            "description" => esc_html__("", "wpb"),
        ));
        vc_add_param("vc_column", array(
            "type" => "dropdown",
            "heading" => esc_html__('Column Background Image Vertical Alignment', 'js_composer'),
            "param_name" => "bg_image_vt_align",
            "value" => array(
                esc_html__("Center", 'js_composer') => 'hook_vt_center',
                esc_html__("Top", 'js_composer') => 'hook_vt_top',
                esc_html__("Bottom", 'js_composer') => 'hook_vt_bottom'
            ),
            "description" => esc_html__("", "wpb"),
        ));
        vc_add_param("vc_column", array(
            "type" => "textfield",
            "heading" => esc_html__('Inner Content Maximum Width', 'js_composer'),
            "param_name" => "col_width",
            "description" => esc_html__("Use % values [1,100]. Default is 100.", "wpb"),
            "value" => "100",
        ));
        vc_add_param("vc_column", array(
            "type" => "textfield",
            "heading" => esc_html__('Caption', 'js_composer'),
            "param_name" => "caption",
            "description" => esc_html__("Will be displayed at the bottom", "wpb"),
            "value" => "",
        ));
        vc_add_param("vc_column", array(
            "type" => "dropdown",
            "heading" => esc_html__('Caption Horizontal Alignment', 'js_composer'),
            "param_name" => "caption_position",
            "value" => array(
                esc_html__("Left", 'js_composer') => 'prk_caption_left',
                esc_html__("Right", 'js_composer') => 'prk_caption_right'
            ),
            "description" => esc_html__("", "wpb"),
            "dependency" => Array('element' => "caption", 'not_empty' => true)
        ));
        vc_add_param("vc_column", array(
            "type" => "colorpicker",
            "heading" => esc_html__("Caption Text Color", "wpb"),
            "param_name" => "caption_color",
            "description" => esc_html__("Optional", "wpb"),
            "dependency" => Array('element' => "caption", 'not_empty' => true)
        ));
        vc_add_param("vc_column", $add_css_animation);
        vc_add_param("vc_column", $add_css_delay);
        vc_add_param("vc_column", $add_el_class);
        vc_add_param("vc_column", $add_custom_css);
        vc_add_param("vc_column", $add_css_hide);

        /* Inner Column Overrides ----------------------------------------------------- */
        vc_remove_param('vc_column_inner', 'font_color');
        vc_remove_param('vc_column_inner', 'css');
        vc_remove_param('vc_column_inner', 'el_class');
        vc_remove_param('vc_column_inner', 'offset');
        $vc_column_width_list = array(
            esc_html__( '1 column - 1/12', 'js_composer' ) => '1/12',
            esc_html__( '2 columns - 1/6', 'js_composer' ) => '1/6',
            esc_html__( '3 columns - 1/4', 'js_composer' ) => '1/4',
            esc_html__( '4 columns - 1/3', 'js_composer' ) => '1/3',
            esc_html__( '5 columns - 5/12', 'js_composer' ) => '5/12',
            esc_html__( '6 columns - 1/2', 'js_composer' ) => '1/2',
            esc_html__( '7 columns - 7/12', 'js_composer' ) => '7/12',
            esc_html__( '8 columns - 2/3', 'js_composer' ) => '2/3',
            esc_html__( '9 columns - 3/4', 'js_composer' ) => '3/4',
            esc_html__( '10 columns - 5/6', 'js_composer' ) => '5/6',
            esc_html__( '11 columns - 11/12', 'js_composer' ) => '11/12',
            esc_html__( '12 columns - 1/1', 'js_composer' ) => '1/1'
        );
        vc_add_param("vc_column_inner",array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Width', 'js_composer' ),
            'param_name' => 'width',
            'value' => $vc_column_width_list,
            'description' => esc_html__( 'Select column width.', 'js_composer' ),
            'std' => '1/1'
        ));
        vc_add_param("vc_column_inner", array(
            "type" => "dropdown",
            "heading" => esc_html__("Text alignment", "js_composer"),
            "param_name" => "align",
            "value" => array(
                esc_html__("Inherit from row", 'js_composer') => 'hook_inherit_align',
                esc_html__("Left", 'js_composer') => 'hook_left_align',
                esc_html__("Centered", 'js_composer') => 'hook_center_align',
                esc_html__('Right', 'js_composer') => 'hook_right_align',
            ),
            "description" => esc_html__("Can be overriden by individual elements settings", "js_composer")
        ));
        vc_add_param("vc_column_inner", array(
            "type" => "attach_image",
            "heading" => esc_html__('Column Background Image', 'js_composer'),
            "param_name" => "bg_image",
            "description" => esc_html__("Select background image for your column", "wpb")
        ));
        vc_add_param("vc_column_inner", array(
            "type" => "dropdown",
            "heading" => esc_html__('Column Background Image Horizontal Alignment', 'js_composer'),
            "param_name" => "bg_image_hz_align",
            "value" => array(
                esc_html__("Center", 'js_composer') => 'hook_hz_center',
                esc_html__("Left", 'js_composer') => 'hook_hz_left',
                esc_html__("Right", 'js_composer') => 'hook_hz_right'
            ),
            "description" => esc_html__("", "wpb"),
        ));
        vc_add_param("vc_column_inner", array(
            "type" => "dropdown",
            "heading" => esc_html__('Column Background Image Vertical Alignment', 'js_composer'),
            "param_name" => "bg_image_vt_align",
            "value" => array(
                esc_html__("Center", 'js_composer') => 'hook_vt_center',
                esc_html__("Top", 'js_composer') => 'hook_vt_top',
                esc_html__("Bottom", 'js_composer') => 'hook_vt_bottom'
            ),
            "description" => esc_html__("", "wpb"),
        ));
        vc_add_param("vc_column_inner", $add_css_animation);
        vc_add_param("vc_column_inner", $add_css_delay);
        vc_add_param("vc_column_inner", $add_el_class);
        vc_add_param("vc_column_inner", $add_custom_css);
        vc_add_param("vc_column_inner", $add_css_hide);

        /* Text Block Overrides ----------------------------------------------------- */
        vc_remove_param('vc_column_text', 'css');
        vc_add_param("vc_column_text", array(
                "type" => "dropdown",
                "heading" => esc_html__("Use drop cap effect?", "js_composer"),
                "param_name" => "drop_cap",
                "value" => $no_yes_arr,
                "description" => "The first character will be capitalized")
        );
        vc_add_param("vc_column_text", $add_css_animation);
        vc_add_param("vc_column_text", $add_css_delay);
        vc_add_param("vc_column_text", $add_el_class);
        vc_add_param("vc_column_text", $add_custom_css);

        /* Message Box Overrides ----------------------------------------------------- */
        vc_remove_param('vc_message', 'el_class');
        vc_remove_param('vc_message', 'css');
        vc_remove_param('vc_message', 'message_box_style');
        vc_remove_param('vc_message', 'message_box_color');
        vc_remove_param('vc_message', 'color');
        vc_remove_param('vc_message', 'icon_type');
        vc_remove_param('vc_message', 'icon_fontawesome');
        vc_remove_param('vc_message', 'icon_openiconic');
        vc_remove_param('vc_message', 'icon_typicons');
        vc_remove_param('vc_message', 'icon_entypo');
        vc_remove_param('vc_message', 'icon_linecons');
        vc_remove_param('vc_message', 'icon_pixelicons');
        vc_remove_param('vc_message', 'style');


        vc_add_param("vc_message", array(
            "type" => "dropdown",
            "class" => "",
            "heading" => esc_html__("Style","hook"),
            "param_name" => "message_box_color",
            "value" => array(
                esc_html__('Info', "js_composer") => "info",
                esc_html__('Warning', "js_composer") => "warning",
                esc_html__('Danger', "js_composer") => "danger",
                esc_html__('Success', "js_composer") => "success",
            ),
            "description" => esc_html__("Set up a font face according to the theme options","hook")
        ));
        vc_add_param("vc_message", array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Shape', 'js_composer' ),
            'param_name' => 'style', // due to backward compatibility message_box_shape
            'std' => 'rounded',
            'value' => array(
                esc_html__( 'Square', 'js_composer' ) => 'square',
                esc_html__( 'Rounded', 'js_composer' ) => 'rounded',
                esc_html__( 'Round', 'js_composer' ) => 'round',
            ),
            'description' => esc_html__( 'Select message box shape.', 'js_composer' ),
        ));

        vc_add_param("vc_message", array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'CSS Animation', 'js_composer' ),
            'param_name' => 'css_animation',
            'value' => array(
                esc_html__( 'No', 'js_composer' ) => '',
                esc_html__("Simple fade", "js_composer") => 'hook_fade_waypoint',
                esc_html__( 'Zoom in', 'js_composer' ) => "appear",
                esc_html__( 'Flash', 'js_composer' ) => "hook_flash",
                esc_html__( 'Shake', 'js_composer' ) => "hook_shake",
                esc_html__( 'Hook', 'js_composer' ) => "hook_hook",
                esc_html__( 'Flip in - vertical', 'js_composer' ) => "flipin_x",
                esc_html__( 'Flip in - horizontal', 'js_composer' ) => "flipin_y",
                esc_html__( 'Flip in - horizontal', 'js_composer' ) => "flipin_y",
                esc_html__( 'Top to bottom - Move Down', 'js_composer' ) => 'top-to-bottom',
                esc_html__( 'Top to bottom - Bounce Down', 'js_composer' ) => 'hook_fadeInDownBig',
                esc_html__( 'Bottom to top - Move Up', 'js_composer' ) => 'bottom-to-top',
                esc_html__( 'Bottom to top - Bounce Up', 'js_composer' ) => 'hook_fadeInUpBig',
                esc_html__( 'Left to right', 'js_composer' ) => 'left-to-right',
                esc_html__( 'Left to right - Bounce in from left', 'js_composer' ) => 'hook_fadeInLeftBig',
                esc_html__( 'Right to left', 'js_composer' ) => 'right-to-left',
                esc_html__( 'Right to left - Bounce in from right', 'js_composer' ) => 'hook_fadeInRightBig',
            ),
            'description' => esc_html__( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'js_composer' )
        ));
        vc_add_param("vc_message", $add_el_class);
        /* Separator With Text Overrides ----------------------------------------------------- */
        vc_remove_param('vc_text_separator', 'el_class');
        vc_remove_param('vc_text_separator', 'css');
        vc_add_param("vc_text_separator", array(
            "type" => "dropdown",
            "holder" => "div",
            "class" => "",
            "heading" => esc_html__("Font face","hook"),
            "param_name" => "font_type",
            "value" => array(
                esc_html__('Headings font', "js_composer") => "header_font",
                esc_html__('Body font', "js_composer") => "body_font",
                esc_html__('Extra font', "js_composer") => "custom_font"),
            "description" => esc_html__("Set up a font face according to the theme options","hook")
        ));
        vc_add_param("vc_text_separator", $add_css_animation);
        vc_add_param("vc_text_separator", $add_css_delay);
        vc_add_param("vc_text_separator", $add_el_class);

        /* Single Image Overrides ----------------------------------------------------- */
        vc_remove_param('vc_single_image', 'onclick');
        vc_remove_param('vc_single_image', 'img_link_target');
        vc_remove_param('vc_single_image', 'link');
        vc_remove_param('vc_single_image', 'style');
        vc_remove_param('vc_single_image', 'add_caption');
        vc_remove_param('vc_single_image', 'el_class');
        vc_remove_param('vc_single_image', 'css');
        vc_add_param("vc_single_image", array(
            "type" => "dropdown",
            "heading" => esc_html__("Retina image?", "js_composer"),
            "param_name" => "retina_image",
            "value" => $no_yes_arr,
            "description" => "If yes image will be scaled to 50% of the original size",
            "weight" => "-3",
        ));
        vc_add_param("vc_single_image", array(
            "type" => "dropdown",
            "holder" => "div",
            "class" => "",
            "heading" => esc_html__("Style","hook"),
            "param_name" => "style",
            "weight" => "-5",
            "value" => array(
                esc_html__('Default', "js_composer") => "",
                esc_html__('Rounded edges', "js_composer") => "vc_box_rounded",
                esc_html__('Round', "js_composer") => "vc_box_circle",
            ),
            "description" => esc_html__("","hook")
        ));
        vc_add_param("vc_single_image", array(
            'type' => 'checkbox',
            'heading' => __( 'Add caption?', 'hook' ),
            'param_name' => 'add_caption',
            'description' => __( 'Add image caption.', 'hook' ),
            'value' => array( __( 'Yes', 'hook' ) => 'yes' ),
            'dependency' => array(
                'element' => 'source',
                'value' => array(
                    'media_library',
                    'featured_image',
                ),
            ),
            'weight' => "-6",
        ));
        vc_add_param("vc_single_image", array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Caption style', 'hook' ),
            'param_name' => 'caption_style', // due to backward compatibility message_box_shape
            'value' => array(
                esc_html__( 'Regular text below image', 'hook' ) => '',
                esc_html__( 'Featured text on top of image image - transparent background', 'hook' ) => ' hook_caption_in',
                esc_html__( 'Featured text on top of image image - colored background', 'hook' ) => ' hook_caption_box',
            ),
            'description' => esc_html__( '', 'hook' ),
            'dependency' => array(
                'element' => 'add_caption',
                'value' => 'yes',
            ),
            'weight' => "-7",
        ));
        vc_add_param("vc_single_image", array(
            "type" => "dropdown",
            "heading" => esc_html__("Add border around caption?", "js_composer"),
            "param_name" => "add_border",
            "value" => $yes_no_arr,
            'dependency' => array(
                'element' => 'caption_style',
                'value' => ' hook_caption_in',
            ),
            "description" => esc_html__("", "js_composer"),
            'weight' => "-8",
        ));
        vc_add_param("vc_single_image", array(
            "type" => "dropdown",
            "heading" => esc_html__("Font face",'hook'),
            "param_name" => "font_type",
            "value" => array(
                esc_html__('Headings font', 'hook') => "header_font",
                esc_html__('Body font', 'hook') => "body_font",
                esc_html__('Extra font', 'hook') => "custom_font",
            ),
            "description" => esc_html__("Select a font face according to the theme options",'hook'),
            'dependency' => array(
                'element' => 'add_caption',
                'value' => 'yes',
            ),
            'weight' => "-9",
        ));
        vc_add_param("vc_single_image", array(
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Caption text color', 'hook' ),
            'param_name' => 'custom_color',
            'description' => esc_html__( 'Select custom color.', 'hook' ),
            "value" => '',
            'dependency' => array(
                'element' => 'add_caption',
                'value' => 'yes',
            ),
            'weight' => "-10",
        ));
        vc_add_param("vc_single_image", array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'On click action', 'js_composer' ),
            'param_name' => 'onclick', // due to backward compatibility message_box_shape
            'value' => array(
                esc_html__( 'None', 'js_composer' ) => '',
                esc_html__( 'Link to large image', 'js_composer' ) => 'img_link_large',
                esc_html__( 'Open custom link', 'js_composer' ) => 'custom_link',
            ),
            'description' => esc_html__( '', 'js_composer' ),
            'weight' => "-13",
        ));
        vc_add_param("vc_single_image", array(
            'type' => 'href',
            'heading' => esc_html__( 'Image link', 'js_composer' ),
            'param_name' => 'link',
            'description' => esc_html__( 'Enter URL if you want this image to have a link (Note: parameters like "mailto:" are also accepted).', 'js_composer' ),
            'dependency' => array(
                'element' => 'onclick',
                'value' => 'custom_link',
            ),
            'weight' => "-15",
        ));
        vc_add_param("vc_single_image", array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Open link in new window?', 'js_composer' ),
            'param_name' => 'img_link_target',
            'value' => $target_arr,
            'dependency' => array(
                'element' => 'onclick',
                'value' => array( 'custom_link', 'img_link_large' ),
            ),
            'weight' => "-20",
        ));
        vc_add_param("vc_single_image", $add_css_animation);
        vc_add_param("vc_single_image", $add_css_delay);
        vc_add_param("vc_single_image", $add_el_class);
        vc_add_param("vc_single_image", $add_custom_css);

        /* Call to Action Overrides ----------------------------------------------------- */
        vc_remove_param('vc_cta', 'use_custom_fonts_h2');
        vc_remove_param('vc_cta', 'use_custom_fonts_h4');
        vc_remove_param('vc_cta', 'style');
        vc_remove_param('vc_cta', 'color');
        vc_remove_param('vc_cta', 'shape');
        vc_remove_param('vc_cta', 'el_width');
        vc_remove_param('vc_cta', 'add_icon');
        vc_remove_param('vc_cta', 'h2_font_container');
        vc_remove_param('vc_cta', 'h2_link');
        vc_remove_param('vc_cta', 'h2_use_theme_fonts');
        vc_remove_param('vc_cta', 'h2_google_fonts');
        vc_remove_param('vc_cta', 'h4_font_container');
        vc_remove_param('vc_cta', 'h4_link');
        vc_remove_param('vc_cta', 'h4_use_theme_fonts');
        vc_remove_param('vc_cta', 'h4_google_fonts');

        vc_remove_param('vc_cta', 'btn_style');
        vc_remove_param('vc_cta', 'btn_custom_background');
        vc_remove_param('vc_cta', 'btn_custom_text');
        vc_remove_param('vc_cta', 'btn_outline_custom_color');
        vc_remove_param('vc_cta', 'btn_outline_custom_hover_background');
        vc_remove_param('vc_cta', 'btn_outline_custom_hover_text');
        vc_remove_param('vc_cta', 'btn_shape');
        vc_remove_param('vc_cta', 'btn_color');
        vc_remove_param('vc_cta', 'btn_size');
        vc_remove_param('vc_cta', 'btn_button_block');
        vc_remove_param('vc_cta', 'btn_add_icon');
        vc_remove_param('vc_cta', 'btn_i_align');
        vc_remove_param('vc_cta', 'btn_i_type');
        vc_remove_param('vc_cta', 'btn_i_icon_fontawesome');
        vc_remove_param('vc_cta', 'btn_i_icon_openiconic');
        vc_remove_param('vc_cta', 'btn_i_icon_typicons');
        vc_remove_param('vc_cta', 'btn_i_icon_entypo');
        vc_remove_param('vc_cta', 'btn_i_icon_linecons');
        vc_remove_param('vc_cta', 'btn_i_icon_pixelicons');


        vc_remove_param('vc_cta', 'i_on_border');
        vc_remove_param('vc_cta', 'i_type');
        vc_remove_param('vc_cta', 'i_icon_fontawesome');
        vc_remove_param('vc_cta', 'i_icon_openiconic');
        vc_remove_param('vc_cta', 'i_icon_typicons');
        vc_remove_param('vc_cta', 'i_icon_entypo');
        vc_remove_param('vc_cta', 'i_icon_linecons');
        vc_remove_param('vc_cta', 'i_color');
        vc_remove_param('vc_cta', 'i_custom_color');
        vc_remove_param('vc_cta', 'i_background_style');
        vc_remove_param('vc_cta', 'i_background_color');
        vc_remove_param('vc_cta', 'i_custom_background_color');
        vc_remove_param('vc_cta', 'i_size');
        vc_remove_param('vc_cta', 'i_link');
        vc_remove_param('vc_cta', 'i_el_class');
        vc_remove_param('vc_cta', 'i_css_animation');

        vc_remove_param('vc_cta', 'custom_background');
        vc_remove_param('vc_cta', 'custom_text');
        vc_remove_param('vc_cta', 'content');
        vc_remove_param('vc_cta', 'add_button');
        vc_remove_param('vc_cta', 'css_animation');
        vc_remove_param('vc_cta', 'el_class');


        /* Call to Action Button
            ---------------------------------------------------------- */
        vc_add_param("vc_cta",array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Shape', 'js_composer' ),
            'param_name' => 'shape',
            'std' => 'rounded',
            'value' => array(
                esc_html__( 'Square', 'js_composer' ) => 'square',
                esc_html__( 'Rounded', 'js_composer' ) => 'rounded',
            ),
            'description' => esc_html__( 'Select call to action shape.', 'js_composer' ),
        ));

        vc_add_param("vc_cta",array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Style', 'js_composer' ),
            'param_name' => 'style',
            'value' => array(
                esc_html__( 'Default', 'js_composer' ) => 'classic',
                esc_html__( 'Custom', 'js_composer' ) => 'custom',
            ),
            'std' => 'classic',
            'description' => esc_html__( 'Select call to action display style.', 'js_composer' ),
        ));
        vc_add_param("vc_cta", array(
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Background color', 'js_composer' ),
            'param_name' => 'custom_background',
            'description' => esc_html__( 'Select custom background color.', 'js_composer' ),
            'dependency' => array(
                'element' => 'style',
                'value' => array( 'custom' )
            ),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
        ));
        vc_add_param("vc_cta", array(
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Headings color', 'js_composer' ),
            'param_name' => 'custom_text',
            'description' => esc_html__( 'Select custom text color.', 'js_composer' ),
            'dependency' => array(
                'element' => 'style',
                'value' => array( 'custom' )
            ),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
        ));
        vc_add_param("vc_cta", array(
            'type' => 'textarea_html',
            'heading' => esc_html__( 'Text', 'js_composer' ),
            'param_name' => 'content',
            'value' => esc_html__( 'I am promo text. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'js_composer' )
        ));
        vc_add_param("vc_cta", array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Add button', 'js_composer' ).'?',
            'description' => esc_html__( 'Add button for call to action.', 'js_composer' ),
            'param_name' => 'add_button',
            'value' => array(
                esc_html__( 'No', 'js_composer' ) => '',
                esc_html__( 'Top', 'js_composer' ) => 'top',
                esc_html__( 'Bottom', 'js_composer' ) => 'bottom',
                esc_html__( 'Left', 'js_composer' ) => 'left',
                esc_html__( 'Right', 'js_composer' ) => 'right',
            ),
        ));
        vc_add_param("vc_cta", $add_css_animation);
        vc_add_param("vc_cta", $add_css_delay);
        vc_add_param("vc_cta", $add_el_class);


        /* Custom Heading Overrides ----------------------------------------------------- */
        vc_remove_param('vc_custom_heading', 'css_animation');
        vc_add_param("vc_custom_heading", $add_css_animation);

        /* Google Maps Overrides ----------------------------------------------------- */
        vc_remove_param('vc_gmaps', 'link');
        vc_remove_param('vc_gmaps', 'size');
        vc_remove_param('vc_gmaps', 'css');
        vc_remove_param('vc_gmaps', 'el_class');
        vc_remove_param('vc_gmaps', 'css_animation');

        vc_add_param("vc_gmaps", array(
            "type" => "textfield",
            "heading" => esc_html__("Google map latitude", "js_composer"),
            "param_name" => "map_latitude",
            "admin_label" => true,
            "description" => esc_html__("", "js_composer")
        ));
        vc_add_param("vc_gmaps", array(
            "type" => "textfield",
            "heading" => esc_html__("Google map longitude", "js_composer"),
            "param_name" => "map_longitude",
            "admin_label" => true,
            "description" => esc_html__("", "js_composer")
        ));
        vc_add_param("vc_gmaps", array(
            "type" => "dropdown",
            "heading" => esc_html__("Map Style", "js_composer"),
            "param_name" => "map_style",
            "value" => array(
                esc_html__("Default", "js_composer") => "default",
                esc_html__("Theme: Light and water with theme active color", "js_composer") => "theme_special",
                esc_html__("Theme: Dark and water with theme active color", "js_composer") => "theme_special_dk",
                esc_html__("Almost Gray", "js_composer") => "almost_gray",
                esc_html__("Blue Essence", "js_composer") => "blue_essence",
                esc_html__("Cobalt (dark)", "js_composer") => "cobalt",
                esc_html__("Greenish", "js_composer") => "green",
                esc_html__("Midnight Commander (dark)", "js_composer") => "midnight",
                esc_html__("Old Timey", "js_composer") => "old_timey",
                esc_html__("Subtle Grayscale", "js_composer") => "subtle_grayscale",
            ),
            "description" => esc_html__("", "js_composer")
        ));
        vc_add_param("vc_gmaps", array(
            "type" => "textfield",
            "heading" => esc_html__("Map height", "js_composer"),
            "param_name" => "size",
            "description" => esc_html__('Enter map height in pixels. Example: 200.', "js_composer")
        ));
        vc_add_param("vc_gmaps", array(
            "type" => "dropdown",
            "heading" => esc_html__("Map Zoom", "js_composer"),
            "param_name" => "zoom",
            "value" => array(esc_html__("14 - Default", "js_composer") => 14, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15, 16, 17, 18, 19, 20)
        ));
        vc_add_param("vc_gmaps", array(
            "type" => "attach_image",
            "heading" => esc_html__("Marker Image", "js_composer"),
            "param_name" => "marker_image",
            "value" => "",
            "description" => esc_html__("Optional", "js_composer")
        ));
        vc_add_param("vc_gmaps", array(
            "type" => "textfield",
            "heading" => esc_html__("Marker image latitude", "js_composer"),
            "param_name" => "marker_image_lat",
            "description" => esc_html__("Optional", "js_composer")
        ));
        vc_add_param("vc_gmaps", array(
            "type" => "textfield",
            "heading" => esc_html__("Marker image longitude", "js_composer"),
            "param_name" => "marker_image_long",
            "description" => esc_html__("Optional", "js_composer")
        ));
        vc_add_param("vc_gmaps", $add_el_class);

        /* Tabs Overrides ---------------------------------------------------------- */
        vc_remove_param('vc_tta_tabs', 'style');
        vc_remove_param('vc_tta_tabs', 'shape');
        vc_remove_param('vc_tta_tabs', 'color');
        vc_remove_param('vc_tta_tabs', 'gap');
        vc_remove_param('vc_tta_tabs', 'spacing');
        vc_remove_param('vc_tta_tabs', 'pagination_style');
        vc_remove_param('vc_tta_tabs', 'pagination_color');

        vc_remove_param('vc_tta_section', 'i_type');
        vc_add_param("vc_tta_section", array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Icon library', 'js_composer' ),
            'value' => array(
                esc_html__( 'Font Awesome', 'js_composer' ) => 'fontawesome',
            ),
            'admin_label' => false,
            'param_name' => 'i_type',
            'description' => esc_html__( 'Select icon library.', 'js_composer' ),
        ));

        /* Tour Overrides ---------------------------------------------------------- */
        vc_remove_param('vc_tta_tour', 'style');
        vc_remove_param('vc_tta_tour', 'shape');
        vc_remove_param('vc_tta_tour', 'color');
        vc_remove_param('vc_tta_tour', 'gap');
        vc_remove_param('vc_tta_tour', 'spacing');
        vc_remove_param('vc_tta_tour', 'pagination_style');
        vc_remove_param('vc_tta_tour', 'pagination_color');

        /* Accordion Overrides ---------------------------------------------------------- */
        vc_remove_param('vc_tta_accordion', 'style');
        vc_remove_param('vc_tta_accordion', 'shape');
        vc_remove_param('vc_tta_accordion', 'color');
        vc_remove_param('vc_tta_accordion', 'gap');
        vc_remove_param('vc_tta_accordion', 'c_icon');
        vc_remove_param('vc_tta_accordion', 'c_position');
        vc_remove_param('vc_tta_accordion', 'spacing');
        vc_remove_param('vc_tta_accordion', 'pagination_style');
        vc_remove_param('vc_tta_accordion', 'pagination_color');
        vc_remove_param('vc_tta_accordion', 'el_class');
        vc_add_param("vc_tta_accordion", array(
            'type' => 'dropdown',
            'param_name' => 'c_icon',
            'value' => array(
                esc_html__( 'None', 'js_composer' ) => '',
                esc_html__( 'Chevron', 'js_composer' ) => 'chevron',
            ),
            'std' => 'chevron',
            'heading' => esc_html__( 'Icon', 'js_composer' ),
            'description' => esc_html__( 'Select accordion navigation icon.', 'js_composer' ),
        ));
        vc_add_param("vc_tta_accordion", array(
            'type' => 'dropdown',
            'param_name' => 'c_position',
            'value' => array(
                esc_html__( 'Left', 'js_composer' ) => 'left',
                esc_html__( 'Right', 'js_composer' ) => 'right',
            ),
            'dependency' => array(
                'element' => 'c_icon',
                'not_empty' => true,
            ),
            'heading' => esc_html__( 'Position', 'js_composer' ),
            'description' => esc_html__( 'Select accordion navigation icon position.', 'js_composer' ),
        ));
        vc_add_param("vc_tta_accordion", array(
            "type" => "dropdown",
            "heading" => esc_html__("Use numbers instead of icons?", "js_composer"),
            "param_name" => "numbers_acc",
            "value" => array(
                esc_html__("No", 'js_composer') => '',
                esc_html__("Yes", 'js_composer') => ' hook_numbered',
            ),
            "description" => esc_html__("", "js_composer"),
        ));
        vc_add_param("vc_tta_accordion", $add_el_class);
        vc_add_param("vc_tta_accordion", $add_custom_css);

        /* Progress Bar Overrides ---------------------------------------------------------- */
        vc_remove_param('vc_progress_bar', 'options');
        vc_remove_param('vc_progress_bar', 'el_class');
        vc_add_param("vc_progress_bar", array(
            "type" => "dropdown",
            "heading" => esc_html__("Text size", "js_composer"),
            "param_name" => "bar_txt_size",
            "value" => array(
                esc_html__("Small", 'js_composer') => '',
                esc_html__("Regular", 'js_composer') => ' hook_bigger',
            ),
            "description" => esc_html__("", "js_composer"),
        ));
        vc_add_param("vc_progress_bar", array(
            "type" => "colorpicker",
            "heading" => esc_html__("Bars custom background color", "js_composer"),
            "param_name" => "custombgcolor_back",
            "description" => esc_html__("Select custom background color for bars - leave blank for theme default value", "js_composer"),
        ));
        vc_add_param("vc_progress_bar", array(
            "type" => "textfield",
            "heading" => esc_html__('Bars bottom margin', 'js_composer'),
            "param_name" => "margin_bottom_barra",
            "value" => "27px",
            "description" => esc_html__("Value in px.", "js_composer")
        ));
        vc_add_param("vc_progress_bar", $add_css_animation);
        vc_add_param("vc_progress_bar", $add_css_delay);
        vc_add_param("vc_progress_bar", $add_el_class);

        /* WP Custom Menu ---------------------------------------------------------- */
        vc_add_param("vc_wp_custommenu", array(
            "type" => "dropdown",
            "heading" => esc_html__("Text alignment", "js_composer"),
            "param_name" => "align",
            "value" => array(
                esc_html__("Left", 'js_composer') => 'hook_left_align',
                esc_html__("Centered", 'js_composer') => 'hook_center_align',
                esc_html__('Right', 'js_composer') => 'hook_right_align',
            ),
            "description" => esc_html__("Can be overriden by individual elements settings", "js_composer")
        ));

        /* WP Custom Menu ---------------------------------------------------------- */
        vc_add_param("vc_wp_search", array(
            "type" => "dropdown",
            "heading" => esc_html__("Display search icon?", "js_composer"),
            "param_name" => "align",
            "weight" => "1",
            "value" => array(
                esc_html__("Left", 'js_composer') => 'hook_left_icon',
                esc_html__("Hide icon", 'js_composer') => 'hook_no_icon',
            ),
            "description" => esc_html__("", "js_composer")
        ));

        /* Extra Elements - Hook Theme ----------------------------------------------------- */

        $posts_terms=get_terms('category','hide_empty=0');
        $posts_terms_array=array();
        if (count($posts_terms)) {
            foreach ($posts_terms as $inner_term) {
                $posts_terms_array[$inner_term->name] = $inner_term->slug;
            }
        }
        $portfolio_terms=get_terms('pirenko_skills','hide_empty=0');
        $portfolio_terms_array=array();
        if (count($portfolio_terms)) {
            foreach ($portfolio_terms as $inner_term) {
                $portfolio_terms_array[$inner_term->name] = $inner_term->slug;
            }
        }

        $portfolio_terms_array_plus=$portfolio_terms_array;
        array_unshift($portfolio_terms_array_plus,'--');

        $slides_terms=get_terms('pirenko_slide_set','hide_empty=0');
        $slides_terms_array=array();
        if (count($slides_terms)) {
            foreach ($slides_terms as $inner_term) {
                $slides_terms_array[$inner_term->name] = $inner_term->slug;
            }
        }
        $member_terms=get_terms('pirenko_member_group','hide_empty=0');
        $member_terms_array=array();
        if (count($member_terms)) {
            foreach ($member_terms as $inner_term) {
                $member_terms_array[$inner_term->name] = $inner_term->slug;
            }
        }
        $authors_terms=get_users();
        $authors_terms_array=array();
        if (count($authors_terms)) {
            foreach ($authors_terms as $inner_term) {
                $authors_terms_array[$inner_term->user_nicename] = $inner_term->ID;
            }
        }
        $testimonials_terms=get_terms('pirenko_testimonial_set','hide_empty=0');
        $testimonials_terms_array=array();
        if (count($testimonials_terms)) {
            foreach ($testimonials_terms as $inner_term) {
                $testimonials_terms_array[$inner_term->name] = $inner_term->slug;
            }
        }

        /* Vertical Spacer ----------------------------------------------------- */
        /**
         * @param $atts
         * @return string
         */
        function prkwp_spacer_func($atts) {
            $atts=shortcode_atts( array(
                'size' => '18',
                'size_767' => '',
                'size_480' => '',
                'el_class' => '',
                'hide_with_css' => '',
            ),$atts);

            return do_shortcode('[pirenko_spacer size="'.$atts['size'].'" size_767="'.$atts['size_767'].'" size_480="'.$atts['size_480'].'" el_class="'.$atts['el_class'].'" hide_with_css="'.$atts['hide_with_css'].'"][/pirenko_spacer]');

        }
        add_shortcode('prkwp_spacer','prkwp_spacer_func');

        vc_map(array(
            "name" => esc_html__("Vertical Spacer","hook"),
            "base" => "prkwp_spacer",
            "class" => "hook_scodes_editor",
            "description" => esc_html__('Control vertical space between elements', 'js_composer'),
            "icon" => "icon-wpb-ui-empty_space",
            "category" => esc_html__('Theme: Special',"hook"),
            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Vertical size in pixels - All screens","hook"),
                    "param_name" => "size",
                    "value" => "18",
                    "description" => "This element creates a vertical space between adjacent elements. Use negative values to pull elements up.",
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Vertical size in pixels - Screens under 768 pixels wide","hook"),
                    "param_name" => "size_767",
                    "value" => "",
                    "description" => "Leave blank for 'Large Screens' value",
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Vertical size in pixels - Screens under 480 pixels wide","hook"),
                    "param_name" => "size_480",
                    "value" => "",
                    "description" => "Leave blank for 'Large Screens' value",
                ),
                $add_el_class,
                //$add_css_hide,
            )
        ));

        /* Styled Title ----------------------------------------------------- */
        /**
         * @param $atts
         * @return string
         */
        function prkwp_styled_title_func($atts ) {
            $atts=shortcode_atts( array(
                'prk_in' => '',
                'align' => 'left',
                'width' => '70px',
                'text_color' => '',
                'title_size' => 'h1',
                'use_italic' => '',
                'show_lines' => '',
                'font_type' => 'header_font',
                'hook_show_line' => '',
                'underlined' => '',
                'css_animation' => '',
                'line_color' => '',
                'font_weight' => '',
                'margin_bottom' => '',
                'custom_css' => '',
                'css_delay' => '',
                'el_class' => ''
            ), $atts );

            return do_shortcode('[prk_styled_title align="'.strtolower($atts['align']).'" line_color="'.$atts['line_color'].'" font_weight="'.$atts['font_weight'].'" text_color="'.$atts['text_color'].'" font_type="'.strtolower($atts['font_type']).'" underlined="'.strtolower($atts['underlined']).'" title_size="'.strtolower($atts['title_size']).'" hook_show_line="'.strtolower($atts['hook_show_line']).'" use_italic="'.strtolower($atts['use_italic']).'" width="'.$atts['width'].'" css_animation="'.$atts['css_animation'].'" css_delay="'.$atts['css_delay'].'" margin_bottom="'.$atts['margin_bottom'].'" custom_css="'.$atts['custom_css'].'" el_class="'.$atts['el_class'].'"]'.$atts['prk_in'].'[/prk_styled_title]');
        }
        add_shortcode('prkwp_styled_title','prkwp_styled_title_func');

        vc_map(array(
            "name" => esc_html__("Styled title","hook"),
            "base" => "prkwp_styled_title",
            "class" => "hook_scodes_editor",
            "icon" => "icon-wpb-ui-custom_heading",
            "description" => esc_html__('Display theme like titles', 'js_composer'),
            "category" => esc_html__('Theme: Special',"hook"),
            "params" => array(
                array(
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Text","hook"),
                    "param_name" => "prk_in",
                    "value" => "",
                    "description" => ""
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Alignment", "js_composer"),
                    "param_name" => "align",
                    "value" => array("Left","Center","Right"),
                    "description" => ""
                ),
                array(
                    "type" => "dropdown",
                    //"holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Font face","hook"),
                    "param_name" => "font_type",
                    "value" => array(
                        esc_html__('Headings font', "js_composer") => "header_font",
                        esc_html__('Body font', "js_composer") => "body_font",
                        esc_html__('Extra font', "js_composer") => "custom_font"),
                    "description" => esc_html__("Set up a font face according to the theme options","hook")
                ),
                array(
                    "type" => "dropdown",
                    //"holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Font weight","hook"),
                    "param_name" => "font_weight",
                    "value" => array(
                        'Normal' => '400',
                        '100' => '100',
                        '200' => '200',
                        '300' => '300',
                        '500' => '500',
                        '600' => '600',
                        esc_html__('Bold','hook') => '700',
                        '800' => '800',
                        esc_html__('Bolder','hook') => '900'
                    ),
                    "description" => esc_html__("","hook")
                ),
                array(
                    "type" => "colorpicker",
                    //"holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Color","hook"),
                    "param_name" => "text_color",
                    "value" => "",
                    "description" => esc_html__("Optional - If blank the theme default headings color will be used","hook")
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Title size", "js_composer"),
                    "param_name" => "title_size",
                    "value" => array(
                        esc_html__('Default', "js_composer") => "",
                        esc_html__('Huge', "js_composer") => "h1_bigger",
                        esc_html__('Extra Large', "js_composer") => "h1",
                        esc_html__('Large', "js_composer") => "h2",
                        esc_html__('Medium', "js_composer") => "h3",
                        esc_html__('Small', "js_composer") => "h4",
                        esc_html__('Extra Small', "js_composer") => "h5"
                    ),
                    "description" => ""
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Italic font style?", "js_composer"),
                    "param_name" => "use_italic",
                    "value" => array("No","Yes"),
                    "description" => ""
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__('Bottom margin', 'js_composer'),
                    "param_name" => "margin_bottom",
                    "value" => "0px",
                    "description" => esc_html__("Value in px.", "wpb")
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Append line to title?", "js_composer"),
                    "param_name" => "hook_show_line",
                    "value" => array(
                        esc_html__('No', "js_composer") => "no",
                        esc_html__('Yes, same style as main sidebar', "js_composer") => "like_sidebar",
                        esc_html__('Yes, a thin line above', "js_composer") => "above thin",
                        esc_html__('Yes, a thick line above', "js_composer") => "above thick",
                        esc_html__('Yes, a thicker line above', "js_composer") => "above thicker",
                        esc_html__('Yes, a thin line under', "js_composer") => "thin",
                        esc_html__('Yes, a thick line under', "js_composer") => "thick",
                        esc_html__('Yes, a thicker line under', "js_composer") => "thicker",
                        esc_html__('Yes, two lines on the sides', "js_composer") => "double_lined"),
                    "description" => ""
                ),
                array(
                    "type" => "colorpicker",
                    //"holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Appended line color","hook"),
                    "param_name" => "line_color",
                    "value" => "",
                    "dependency" => Array('element' => "hook_show_line", 'value' => array('above thin','above thick','above thicker','thin','thick','thicker')),
                    "description" => esc_html__("Optional - If blank the theme default headings color will be used","hook")
                ),
                array(
                    "type" => "textfield",
                    //"holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Width in px or %","hook"),
                    "param_name" => "width",
                    "value" => "70px",
                    "dependency" => Array('element' => "hook_show_line", 'value' => array('above thin','above thick','above thicker','thin','thick','thicker')),
                    "description" => "Default is 70px."
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Underline title?", "js_composer"),
                    "param_name" => "underlined",
                    "value" => array(esc_html__('No', "js_composer") => "",esc_html__('Yes, thin line', "js_composer") => "small_underline",esc_html__('Yes, thick line', "js_composer") => "large_underline"),
                    "description" => esc_html__("", "js_composer")
                ),
                $add_css_animation,
                $add_css_delay,
                $add_el_class,
                $add_custom_css,
            )
        ));

        /* Separator ----------------------------------------------------- */
        vc_map( array(
            "name"    => esc_html__("Separator", "js_composer"),
            "base"    => "prk_line",
            'icon'    => 'icon-wpb-ui-separator',
            "show_settings_on_create" => true,
            "category"  => esc_html__('Theme: Special', 'js_composer'),
            "description" => esc_html__('Horizontal separator line with optional icon', 'js_composer'),
            "params" => array(
                array(
                    "type" => "colorpicker",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Divider color","hook"),
                    "param_name" => "color",
                    "value" => "",
                    "description" => esc_html__("Optional - If blank the theme default headings color will be used","hook")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Width in px or %","hook"),
                    "param_name" => "width",
                    "value" => "100%",
                    "description" => "Default is 100%."
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Height in px","hook"),
                    "param_name" => "height",
                    "value" => "1px",
                    "description" => "Default is 1px."
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Alignment", "js_composer"),
                    "param_name" => "align",
                    "value" => array(
                        esc_html__('Inherit', "js_composer") => "inherit",
                        esc_html__('Left', "js_composer") => "left",
                        esc_html__('Center', "js_composer") => "center",
                        esc_html__('Right', "js_composer") => "right",
                    ),
                    "description" => esc_html__("", "js_composer")
                ),
                $add_css_animation,
                $add_css_delay,
                $add_el_class,
            )
        ));


        /* Blockquote ----------------------------------------------------- */
        /**
         * @param $atts
         * @return string
         */
        function bquote_func($atts ) {
            extract( shortcode_atts( array(
                'prk_in' => '',
                'author' => '',
                'after_author' => '',
                'type' => '',
                'css_animation' => '',
                'el_class' => '',
                'css_delay' => '',
            ), $atts ) );

            return do_shortcode("[pirenko_blockquote author='{$author}' after_author='{$after_author}' type='{$type}' css_animation='{$css_animation}' css_delay='{$css_delay}' el_class='{$el_class}']{$prk_in}[/pirenko_blockquote]");
        }
        add_shortcode( 'bquote', 'bquote_func' );

        vc_map( array(
            "name" => esc_html__("Blockquote","hook"),
            "base" => "bquote",
            "class" => "hook_scodes_editor",
            "icon" => "vc_icon-vc-gitem-post-title",
            "description" => esc_html__('Stylish quotes that stand out', 'js_composer'),
            "category" => esc_html__('Theme: Special',"hook"),
            "params" => array(
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Blockquote type", "js_composer"),
                    "param_name" => "type",
                    "value" => array(
                        esc_html__('Plain', "js_composer") => "plain",
                        esc_html__('Tagline', "js_composer") => "tagline",
                        esc_html__('Bordered', "js_composer") => "cropped_corners",
                        esc_html__('Colored background', "js_composer") => "site_background_colored hook_active_colored"
                    ),
                    "description" => ""
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Author","hook"),
                    "param_name" => "author",
                    "value" => esc_html__("","hook"),
                    "description" => esc_html__("","hook")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("After author text","hook"),
                    "param_name" => "after_author",
                    "value" => esc_html__("","hook"),
                    "description" => esc_html__("Optional","hook")
                ),
                array(
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Content","hook"),
                    "param_name" => "prk_in",
                    "value" => esc_html__("","hook"),
                    "description" => esc_html__("","hook")
                ),
                $add_css_animation,
                $add_css_delay,
                $add_el_class,
            )
        ));

        /* Animated Counter ----------------------------------------------------- */
        /**
         * @param $atts
         * @return string
         */
        function prkwp_counter_func($atts ) {
            extract( shortcode_atts( array(
                'prefix' =>"",
                'suffix' =>"",
                'counter_origin' => '0',
                'counter_number' => '',
                'prk_in' => '',
                'align' => '',
                'image' => '',
                'icon_material' => '',
                'serv_image' => '',
                'custom_css' => '',
                'text_color' => '',
                'icon_type' => '',
                'thousands_separator' =>'',
                'css_animation' => '',
                'el_class' => '',
                'css_delay' => '',
            ), $atts ));
            if ($align=="center_smaller") {
                $align="prk_counter_center hook_smaller_counter";
            }
            else {
                $align="prk_counter_center";
            }
            $image_attributes = wp_get_attachment_image_src( $serv_image,'full' );
            return do_shortcode('[prk_counter prefix="'.$prefix.'" suffix="'.$suffix.'" counter_origin="'.$counter_origin.'"  thousands_separator="'.$thousands_separator.'" icon_type="'.$icon_type.'" counter_number="'.$counter_number.'" align="'.$align.'" text_color="'.$text_color.'"  image="'.$image.'" serv_image="'.$image_attributes[0].'" icon_material="'.$icon_material.'" css_delay="'.$css_delay.'" css_animation="'.$css_animation.'" el_class="'.$el_class.'" custom_css="'.$custom_css.'"]'.$prk_in.'[/prk_counter]');
        }
        add_shortcode( 'prkwp_counter', 'prkwp_counter_func' );
        vc_map( array(
            "name" => esc_html__("Animated Counter","hook"),
            "base" => "prkwp_counter",
            "class" => "hook_scodes_editor",
            "icon" => "icon-wpb-call-to-action",
            "description" => esc_html__('Easy animated counter', 'js_composer'),
            "category" => esc_html__('Theme: Special',"hook"),
            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Counter origin number","hook"),
                    "param_name" => "counter_origin",
                    "value" => "0",
                    "description" => "The value that will be displayed when the animation starts"
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Counter final number","hook"),
                    "param_name" => "counter_number",
                    "value" => "1000",
                    "description" => "The value that will be displayed after the animation ends"
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Thousands separator","hook"),
                    "param_name" => "thousands_separator",
                    "value" => "",
                    "description" => "Optional"
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Prefix","hook"),
                    "param_name" => "prefix",
                    "value" => "",
                    "description" => "Will be displayed before the counter"
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Suffix","hook"),
                    "param_name" => "suffix",
                    "value" => "",
                    "description" => "Will be displayed after the counter"
                ),
                array(
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Content","hook"),
                    "param_name" => "prk_in",
                    "value" => "",
                    "description" => "Will be displayed under the animated counter"
                ),
                array(
                    "type" => "colorpicker",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Counter color","js_composer"),
                    "param_name" => "text_color",
                    "value" => "",
                    "description" => esc_html__("Optional - If blank the theme default color will be used","js_composer")
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Size", "js_composer"),
                    "param_name" => "align",
                    "value" => array(
                        esc_html__('Regular', "js_composer") => "center",
                        esc_html__('Smaller', "js_composer") => "center_smaller"
                    ),
                    "description" => ""
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Media type", "js_composer"),
                    "param_name" => "icon_type",
                    "value" => array(
                        esc_html__('Google Material Design Icon', "js_composer") => "material_icons",
                        esc_html__('Font Awesome Icon', "js_composer") => "awesome_icons",
                        esc_html__('Custom Image', "js_composer") => "custom_image",
                    ),
                    "description" => ""
                ),
                array(
                    "type" => "attach_image",
                    "heading" => esc_html__("Custom image", "js_composer"),
                    "param_name" => "serv_image",
                    "value" => "",
                    "description" => esc_html__("Select image from media library.", "js_composer"),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'custom_image',
                    ),
                ),
                array(
                    "type" => "iconpicker",
                    "heading" => esc_html__("Font Awesome icon selector", "js_composer"),
                    "param_name" => "image",
                    'settings' => array(
                        'emptyIcon' => false, // default true, display an "EMPTY" icon?
                        'iconsPerPage' => 200, // default 100, how many icons per/page to display
                    ),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'awesome_icons',
                    ),
                ),
                array(
                    'type' => 'iconpicker',
                    'heading' => esc_html__( 'Google Material Design icon selector', 'js_composer' ),
                    'param_name' => 'icon_material',
                    'settings' => array(
                        'emptyIcon' => false, // default true, display an "EMPTY" icon?
                        'type' => 'material_icons',
                        'iconsPerPage' => 200, // default 100, how many icons per/page to display
                    ),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'material_icons',
                    ),
                    'description' => esc_html__( 'Select icon from library.', 'js_composer' ),
                ),
                $add_css_animation,
                $add_css_delay,
                $add_el_class,
                $add_custom_css,
            )
        ) );

        //TEXT ROTATOR
        /**
         * @param $atts
         * @return string
         */
        function prk_text_rotator_func($atts ) {
            $atts=shortcode_atts( array(
                'prk_in' => '',
                'text_color' => '',
                'title_size' => 'h1_big',
                'effect' => 'old_timey',
                'speed' => '2500',
                'css_animation' => '',
                'el_class' => '',
                'css_delay' => '',
            ), $atts);
            return do_shortcode('[prk_text_rotator text_color="'.strtolower($atts['text_color']).'" effect="'.strtolower($atts['effect']).'" title_size="'.strtolower($atts['title_size']).'" css_animation="'.$atts['css_animation'].'" css_delay="'.$atts['css_delay'].'" speed="'.$atts['speed'].'" el_class="'.$atts['el_class'].'"]'.$atts['prk_in'].'[/prk_text_rotator]');
        }
        add_shortcode( 'prk_wptext_rotator', 'prk_text_rotator_func' );

        vc_map( array(
            "name" => esc_html__("Text Rotator", "js_composer"),
            "base" => "prk_wptext_rotator",
            "icon" => "icon-wpb-ui-custom_heading",
            "category" => esc_html__('Theme: Special',"hook"),
            "description" => esc_html__('Animated titles with custom effects', 'js_composer'),
            "params" => array(
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Text size", "js_composer"),
                    "param_name" => "title_size",
                    "value" => array(
                        esc_html__('Huge', "js_composer") => "h1_big",
                        esc_html__('Extra Large', "js_composer") => "h1",
                        esc_html__('Large', "js_composer") => "h2",
                        esc_html__('Medium', "js_composer") => "h3",
                        esc_html__('Small', "js_composer") => "h4"),
                    "description" => ""
                ),
                array(
                    "type" => "colorpicker",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Text color","js_composer"),
                    "param_name" => "text_color",
                    "value" => "",
                    "description" => esc_html__("Optional - If blank the theme default color will be used","js_composer")
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Text rotator effect", "js_composer"),
                    "param_name" => "effect",
                    "value" => $rotator_arr,
                    "description" => esc_html__("", "js_composer")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Text rotator delay","hook"),
                    "param_name" => "speed",
                    "value" => "2500",
                    "description" => esc_html__("In miliseconds","hook")
                ),
                array(
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Content","js_composer"),
                    "param_name" => "prk_in",
                    "value" => "",
                    "description" => "Separate strings with a plus (+) sign."
                ),
                $add_el_class,
            ),
            "js_view" => 'VcButtonView'
        ) );

        //CONTDOWN TIMER
        /**
         * @param $atts
         * @return string
         */
        function prk_countdown_func($atts ) {
            extract( shortcode_atts( array(
                'text_color' => '',
                'year' => '2030',
                'month' => '1',
                'day' => '1',
                'css_animation' => '',
                'css_delay' => '',
                'el_class' => ''
            ), $atts ) );
            return do_shortcode('[prk_countdown text_color="'.strtolower($text_color).'" year="'.$year.'" month="'.$month.'" day="'.$day.'" css_animation="'.$css_animation.'" css_delay="'.$css_delay.'" el_class="'.$el_class.'"][/prk_countdown]');
        }
        add_shortcode( 'prk_wpcountdown', 'prk_countdown_func' );
        vc_map( array(
            "name" => esc_html__("Countdown Timer", "js_composer"),
            "base" => "prk_wpcountdown",
            "icon" => "icon-wpb-call-to-action",
            "category" => esc_html__('Content', 'js_composer'),
            "description" => esc_html__('Animated titles with custom effects', 'js_composer'),
            "params" => array(
                array(
                    "type" => "colorpicker",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Text color","hook"),
                    "param_name" => "text_color",
                    "value" => "",
                    "description" => esc_html__("Optional - If blank the row default color will be used","hook")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Year","hook"),
                    "param_name" => "year",
                    "value" => "2030",
                    "description" => ""
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Month","hook"),
                    "param_name" => "month",
                    "value" => "1",
                    "description" => ""
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Day","hook"),
                    "param_name" => "day",
                    "value" => "1",
                    "description" => ""
                ),
                $add_css_animation,
                $add_css_delay,
                $add_el_class,
            ),
            "js_view" => 'VcButtonView'
        ) );

        /* Service ----------------------------------------------------- */
        /**
         * @param $atts
         * @return string
         */
        function prkwp_service_func($atts ) {
            extract( shortcode_atts( array(
                'prk_in' => '',
                'name' => '',
                'align' => '',
                'text_align' => 'hook_center_align',
                'image' => '',
                'bk_color' => '',
                'link' => '',
                'serv_image' => '',
                'link_text' => '',
                'window' => '',
                'text_color' => '',
                'icon_color' => '',
                'icon_up_color' => '',
                'icon_type' => '',
                'icon' => '',
                'icon_material' => '',
                'css_animation' => '',
                'el_class' => '',
                'css_delay' => '',
                'hook_link' => '',
                'id' => '',
            ), $atts ) );
            if ($align=="center")
            {
                $align="prk_service_center";
            }
            else if ($align=="center_smaller")
            {
                $align="prk_service_center hook_smaller_service";
            }
            else if ($align=="right_bigger")
            {
                $align="prk_service_right hook_bigger_service";
            }
            else if ($align=="right")
            {
                $align="prk_service_right hook_smaller_service";
            }
            else if ($align=="left")
            {
                $align="prk_service_left hook_smaller_service";
            }
            else
            {
                $align="prk_service_left hook_bigger_service";
            }
            if ($hook_link!="hook_linked_service")
                $hook_link="hook_default_service";
            if ($window=="Yes")
                $window="_blank";
            else
                $window="_self";
            $image_attributes = wp_get_attachment_image_src( $serv_image,'full' );
            return do_shortcode('[prk_service name="'.$name.'" align="'.$align.'" text_align="'.$text_align.'" text_color="'.$text_color.'" icon_up_color="'.$icon_up_color.'" icon_color="'.$icon_color.'" icon_type="'.$icon_type.'" icon="'.$icon.'" icon_material="'.$icon_material.'" serv_image="'.$image_attributes[0].'" link="'.$link.'" bk_color="'.$bk_color.'" link_text="'.$link_text.'" hook_link="'.$hook_link.'" id='.$id.' window="'.$window.'" css_animation="'.$css_animation.'" css_delay="'.$css_delay.'" el_class="'.$el_class.'"]'.$prk_in.'[/prk_service]');
        }
        add_shortcode( 'prkwp_service', 'prkwp_service_func' );
        vc_map( array(
            "name" => esc_html__("Service","hook"),
            "base" => "prkwp_service",
            "class" => "hook_scodes_editor",
            "icon" => "icon-wpb-call-to-action",
            "description" => esc_html__('Easy information blocks with images', 'js_composer'),
            "category" => esc_html__('Theme: Special',"hook"),
            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Title","hook"),
                    "param_name" => "name",
                    "value" => "",
                    "description" => ""
                ),
                array(
                    "type" => "colorpicker",
                    "class" => "",
                    "heading" => esc_html__("Title color","hook"),
                    "param_name" => "text_color",
                    "value" => "",
                    "description" => esc_html__("Optional","hook")
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Media type", "js_composer"),
                    "param_name" => "icon_type",
                    "value" => array(
                        esc_html__('Google Material Design Icon', "js_composer") => "material_icons",
                        esc_html__('Font Awesome Icon', "js_composer") => "awesome_icons",
                        esc_html__('Custom Image', "js_composer") => "custom_image",
                    ),
                    "description" => ""
                ),
                array(
                    "type" => "attach_image",
                    "heading" => esc_html__("Service image", "js_composer"),
                    "param_name" => "serv_image",
                    "value" => "",
                    "description" => esc_html__("Select image from media library.", "js_composer"),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'custom_image',
                    ),
                ),
                array(
                    "type" => "iconpicker",
                    "heading" => esc_html__("Font Awesome icon selector", "js_composer"),
                    "param_name" => "icon",
                    'settings' => array(
                        'emptyIcon' => false, // default true, display an "EMPTY" icon?
                        'iconsPerPage' => 200, // default 100, how many icons per/page to display
                    ),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'awesome_icons',
                    ),
                ),
                array(
                    'type' => 'iconpicker',
                    'heading' => esc_html__( 'Google Material Design icon selector', 'js_composer' ),
                    'param_name' => 'icon_material',
                    'settings' => array(
                        'emptyIcon' => false, // default true, display an "EMPTY" icon?
                        'type' => 'material_icons',
                        'iconsPerPage' => 200, // default 100, how many icons per/page to display
                    ),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'material_icons',
                    ),
                    'description' => esc_html__( 'Select icon from library.', 'js_composer' ),
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Icon/image position", "js_composer"),
                    "param_name" => "align",
                    "value" => array(
                        esc_html__('Left', "js_composer") => "left_bigger",
                        esc_html__('Left with smaller icon/image', "js_composer") => "left",
                        esc_html__('Above', "js_composer") => "center",
                        esc_html__('Above with smaller icon/image', "js_composer") => "center_smaller",
                        esc_html__('Right', "js_composer") => "right_bigger",
                        esc_html__('Right with smaller icon/image', "js_composer") => "right",
                    ),
                    "description" => ""
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Content alignment", "js_composer"),
                    "param_name" => "text_align",
                    "value" => array(
                        esc_html__("Centered", 'js_composer') => 'hook_center_align',
                        esc_html__("Left", 'js_composer') => 'hook_left_align',
                        esc_html__('Right', 'js_composer') => 'hook_right_align',
                    ),
                    "description" => "",
                    "dependency" => Array('element' => "align", 'value' => array('center','center_smaller')),
                ),
                array(
                    "type" => "textarea",
                    "class" => "",
                    "heading" => esc_html__("Content","hook"),
                    "param_name" => "prk_in",
                    "value" => "",
                    "description" => ""
                ),
                array(
                    "type" => "colorpicker",
                    "class" => "",
                    "heading" => esc_html__("Icon up color","hook"),
                    "param_name" => "icon_up_color",
                    "value" => "",
                    "description" => esc_html__("Optional","hook"),
                ),
                array(
                    "type" => "colorpicker",
                    "class" => "",
                    "heading" => esc_html__("Icon rollover color","hook"),
                    "param_name" => "icon_color",
                    "value" => "",
                    "description" => esc_html__("Optional","hook"),
                ),
                array(
                    "type" => "colorpicker",
                    "class" => "",
                    "heading" => esc_html__("Background color","hook"),
                    "param_name" => "bk_color",
                    "value" => "",
                    "description" => esc_html__("Optional","hook")
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => esc_html__("Enable service linking: link URL","hook"),
                    "param_name" => "link",
                    "value" => "",
                    "description" => esc_html__("Optional","hook")
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => esc_html__("Service link text","hook"),
                    "param_name" => "link_text",
                    "value" => "",
                    "description" => esc_html__("Leave blank for theme default Read More text.","hook"),
                    "dependency" => Array('element' => "link", 'not_empty' => true),
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Open link in a new window?", "js_composer"),
                    "param_name" => "window",
                    "value" => array("No","Yes"),
                    "description" => esc_html__("", "js_composer"),
                    "dependency" => Array('element' => "link", 'not_empty' => true),
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Link display", "js_composer"),
                    "param_name" => "hook_link",
                    "value" => array(
                        esc_html__("Show text button under content", 'js_composer') => 'hook_default_service',
                        esc_html__("Make all service clickable - no text button is displayed under content", 'js_composer') => 'hook_linked_service',
                    ),
                    "description" => esc_html__("", "js_composer"),
                    "dependency" => Array('element' => "link", 'not_empty' => true),
                ),
                $add_css_animation,
                $add_css_delay,
                $add_el_class,
            )
        ) );

        /* Service ----------------------------------------------------- */
        /**
         * @param $atts
         * @return string
         */
        function prkwp_hover_box_func($atts ) {
            extract( shortcode_atts( array(
                'prk_in' => '',
                'name' => '',
                'align' => '',
                'text_align' => 'hook_center_align',
                'image' => '',
                'bk_color' => '',
                'link' => '',
                'serv_image' => '',
                'link_text' => '',
                'window' => '',
                'text_color' => '',
                'desc_color' => '',
                'icon_color' => '',
                'icon_up_color' => '',
                'icon_type' => '',
                'icon' => '',
                'icon_material' => '',
                'css_animation' => '',
                'el_class' => '',
                'css_delay' => '',
                'hook_link' => '',
            ), $atts ) );
            if ($align=="center")
            {
                $align="prk_service_center";
            }
            else if ($align=="center_smaller")
            {
                $align="prk_service_center hook_smaller_service";
            }
            else if ($align=="right_bigger")
            {
                $align="prk_service_right hook_bigger_service";
            }
            else if ($align=="right")
            {
                $align="prk_service_right hook_smaller_service";
            }
            else if ($align=="left")
            {
                $align="prk_service_left hook_smaller_service";
            }
            else
            {
                $align="prk_service_left hook_bigger_service";
            }
            $hook_link="hook_linked_service";
            if ($window=="Yes")
                $window="_blank";
            else
                $window="_self";
            $image_attributes = wp_get_attachment_image_src( $serv_image,'full' );
            return do_shortcode('[prk_hover_box name="'.$name.'" align="'.$align.'" text_align="'.$text_align.'" text_color="'.$text_color.'" desc_color="'.$desc_color.'" icon_up_color="'.$icon_up_color.'" icon_color="'.$icon_color.'" icon_type="'.$icon_type.'" icon="'.$icon.'" icon_material="'.$icon_material.'" serv_image="'.$image_attributes[0].'" link="'.$link.'" bk_color="'.$bk_color.'" link_text="'.$link_text.'" hook_link="'.$hook_link.'" window="'.$window.'" css_animation="'.$css_animation.'" css_delay="'.$css_delay.'" el_class="'.$el_class.'"]'.$prk_in.'[/prk_hover_box]');
        }
        add_shortcode( 'prkwp_hover_box', 'prkwp_hover_box_func' );

        vc_map( array(
            "name" => esc_html__("Hover Box","hook"),
            "base" => "prkwp_hover_box",
            "class" => "hook_scodes_editor",
            "icon" => "icon-wpb-toggle-small-expand",
            "description" => esc_html__('Easy information blocks with images', 'js_composer'),
            "category" => esc_html__('Theme: Special',"hook"),
            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Title","hook"),
                    "param_name" => "name",
                    "value" => "",
                    "description" => ""
                ),
                array(
                    "type" => "colorpicker",
                    "class" => "",
                    "heading" => esc_html__("Title color","hook"),
                    "param_name" => "text_color",
                    "value" => "",
                    "description" => esc_html__("Optional","hook")
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Media type", "js_composer"),
                    "param_name" => "icon_type",
                    "value" => array(
                        esc_html__('Google Material Design Icon', "js_composer") => "material_icons",
                        esc_html__('Font Awesome Icon', "js_composer") => "awesome_icons",
                        esc_html__('Custom Image', "js_composer") => "custom_image",
                    ),
                    "description" => ""
                ),
                array(
                    "type" => "attach_image",
                    "heading" => esc_html__("Service image", "js_composer"),
                    "param_name" => "serv_image",
                    "value" => "",
                    "description" => esc_html__("Select image from media library.", "js_composer"),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'custom_image',
                    ),
                ),
                array(
                    "type" => "iconpicker",
                    "heading" => esc_html__("Font Awesome icon selector", "js_composer"),
                    "param_name" => "icon",
                    'settings' => array(
                        'emptyIcon' => false, // default true, display an "EMPTY" icon?
                        'iconsPerPage' => 200, // default 100, how many icons per/page to display
                    ),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'awesome_icons',
                    ),
                ),
                array(
                    'type' => 'iconpicker',
                    'heading' => esc_html__( 'Google Material Design icon selector', 'js_composer' ),
                    'param_name' => 'icon_material',
                    'settings' => array(
                        'emptyIcon' => false, // default true, display an "EMPTY" icon?
                        'type' => 'material_icons',
                        'iconsPerPage' => 200, // default 100, how many icons per/page to display
                    ),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'material_icons',
                    ),
                    'description' => esc_html__( 'Select icon from library.', 'js_composer' ),
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Icon/image position", "js_composer"),
                    "param_name" => "align",
                    "value" => array(
                        esc_html__('Left', "js_composer") => "left_bigger",
                        esc_html__('Left with smaller icon/image', "js_composer") => "left",
                        esc_html__('Above', "js_composer") => "center",
                        esc_html__('Above with smaller icon/image', "js_composer") => "center_smaller",
                        esc_html__('Right', "js_composer") => "right_bigger",
                        esc_html__('Right with smaller icon/image', "js_composer") => "right",
                    ),
                    "description" => ""
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Content alignment", "js_composer"),
                    "param_name" => "text_align",
                    "value" => array(
                        esc_html__("Centered", 'js_composer') => 'hook_center_align',
                        esc_html__("Left", 'js_composer') => 'hook_left_align',
                        esc_html__('Right', 'js_composer') => 'hook_right_align',
                    ),
                    "description" => "",
                    "dependency" => Array('element' => "align", 'value' => array('center','center_smaller')),
                ),
                array(
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Description","hook"),
                    "param_name" => "prk_in",
                    "value" => "",
                    "description" => ""
                ),
                array(
                    "type" => "colorpicker",
                    "class" => "",
                    "heading" => esc_html__("Description text color","hook"),
                    "param_name" => "desc_color",
                    "value" => "",
                    "description" => esc_html__("Optional","hook"),
                ),
                array(
                    "type" => "colorpicker",
                    "class" => "",
                    "heading" => esc_html__("Icon up color","hook"),
                    "param_name" => "icon_up_color",
                    "value" => "",
                    "description" => esc_html__("Optional","hook"),
                ),
                array(
                    "type" => "colorpicker",
                    "class" => "",
                    "heading" => esc_html__("Hover Box Background color","hook"),
                    "param_name" => "bk_color",
                    "value" => "",
                    "description" => esc_html__("Optional","hook")
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => esc_html__("Enable linking: link URL","hook"),
                    "param_name" => "link",
                    "value" => "",
                    "description" => esc_html__("Optional","hook")
                ),
                /*array(
              "type" => "textfield",
              "class" => "",
              "heading" => esc_html__("Service link text","hook"),
              "param_name" => "link_text",
              "value" => "",
              "description" => esc_html__("Leave blank for theme default Read More text.","hook"),
              "dependency" => Array('element' => "link", 'not_empty' => true),
           ),*/
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Open link in a new window?", "js_composer"),
                    "param_name" => "window",
                    "value" => array("No","Yes"),
                    "description" => esc_html__("", "js_composer"),
                    "dependency" => Array('element' => "link", 'not_empty' => true),
                ),
                /*array(
               "type" => "dropdown",
               "heading" => esc_html__("Link display", "js_composer"),
               "param_name" => "hook_link",
               "value" => array(
                   esc_html__("Show text button under content", 'js_composer') => 'hook_default_service',
                   esc_html__("Make all service clickable - no text button is displayed under content", 'js_composer') => 'hook_linked_service',
               ),
               "description" => esc_html__("", "js_composer"),
               "dependency" => Array('element' => "link", 'not_empty' => true),
           ),*/
                $add_css_animation,
                $add_css_delay,
                $add_el_class,
            )
        ) );

        /* Informational Board ----------------------------------------------------- */
        /**
         * @param $atts
         * @return string
         */
        function prkwp_board_func($atts ) {
            extract( shortcode_atts( array(
                'values' => '',
                'cols_width' => '20%|50%|30%',
                'board_header' => '',
                'link_text' => 'Link text',
                'css_animation' => '',
                'el_class' => '',
                'css_delay' => '',
            ), $atts ) );
            return do_shortcode('[prk_board values="'.$values.'" cols_width="'.$cols_width.'" link_text="'.$link_text.'" board_header="'.$board_header.'" css_animation="'.$css_animation.'" css_delay="'.$css_delay.'" el_class="'.$el_class.'"][/prk_board]');
        }
        add_shortcode( 'prkwp_board', 'prkwp_board_func' );
        vc_map( array(
            "name" => esc_html__("Informational Board","hook"),
            "base" => "prkwp_board",
            "class" => "hook_scodes_editor",
            "icon" => "icon-wpb-toggle-small-expand",
            "description" => esc_html__('Display info - table style', 'js_composer'),
            "category" => esc_html__('Theme: Special',"hook"),
            "params" => array(
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Columns width", "js_composer"),
                    "param_name" => "cols_width",
                    "description" => esc_html__('Separate columns with "|". Example:20%|50%|30%', "js_composer"),
                    'value' => "20%|50%|30%"
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Board header titles", "js_composer"),
                    "param_name" => "board_header",
                    "description" => esc_html__('Separate strings with "|". Example:Title|Description|Date', "js_composer"),
                    'value' => "Title|Description|Date"
                ),
                array(
                    'type' => 'exploded_textarea',
                    'heading' => esc_html__( 'Values', 'js_composer' ),
                    'param_name' => 'values',
                    'description' => esc_html__( 'Separate strings with "|".Enter values for each line according to the numbers of columns defined above. Divide value sets with linebreak "Enter".', 'js_composer' ),
                    'value' => "First entry column A|First entry column B|First entry column C,Second entry column A|Second entry column B|Second entry column C"
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Link text", "js_composer"),
                    "param_name" => "link_text",
                    "description" => esc_html__('If a link is detected this text will appear as the button label.', "js_composer"),
                    'value' => "Link text"
                ),
                $add_css_animation,
                $add_css_delay,
                $add_el_class,
            )
        ) );

        /* Timeline ----------------------------------------------------- */
        /**
         * @param $atts
         * @return string
         */
        function prkwp_timeline_func($atts ) {
            extract( shortcode_atts( array(
                'values' => '',
                'text_color' => '',
                'css_animation' => '',
                'el_class' => '',
                'css_delay' => '',
            ), $atts ) );
            return do_shortcode('[prk_timeline values="'.$values.'" text_color="'.$text_color.'" css_animation="'.$css_animation.'" css_delay="'.$css_delay.'" el_class="'.$el_class.'"][/prk_timeline]');
        }
        add_shortcode( 'prkwp_timeline', 'prkwp_timeline_func' );
        vc_map( array(
            "name" => esc_html__("Timeline","hook"),
            "base" => "prkwp_timeline",
            "class" => "hook_scodes_editor",
            "icon" => "icon-wpb-toggle-small-expand",
            "description" => esc_html__('Sequential Organized Text', 'js_composer'),
            "category" => esc_html__('Theme: Special',"hook"),
            "params" => array(
                array(
                    'type' => 'exploded_textarea',
                    'heading' => esc_html__( 'Values', 'js_composer' ),
                    'param_name' => 'values',
                    'description' => esc_html__( 'Enter values for each line - date and description. Divide value sets with linebreak "Enter".', 'js_composer' ),
                    'value' => "2000|Started working at company A,2010|Started working at company B,2015|Started working at company C"
                ),
                array(
                    "type" => "colorpicker",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Text color","hook"),
                    "param_name" => "text_color",
                    "value" => "",
                    "description" => esc_html__("Optional - Will force content to have this color","hook")
                ),
                $add_css_animation,
                $add_css_delay,
                $add_el_class,
            )
        ) );
        /* Theme Icon ----------------------------------------------------- */
        /**
         * @param $atts
         * @return string
         */
        function prk_wp_icon_func($atts ) {
            extract( shortcode_atts( array(
                'icon_size' => '',
                'text_color' => '',
                'align' => '',
                'icon_type' => '',
                'css_animation' => '',
                'el_class' => '',
                'icon_material' => '',
                'icon' => '',
                'css_delay' => '',
            ), $atts ) );

            return do_shortcode('[pirenko_theme_icon icon_size="'.$icon_size.'" align="'.$align.'" icon_type="'.$icon_type.'" icon_material="'.$icon_material.'" icon="'.$icon.'" text_color="'.$text_color.'" css_animation="'.$css_animation.'" css_delay="'.$css_delay.'" el_class="'.$el_class.'"][/pirenko_theme_icon]');
        }
        add_shortcode( 'prk_wp_icon', 'prk_wp_icon_func' );
        vc_map( array(
            "name" => esc_html__("Theme Icon", "js_composer"),
            "base" => "prk_wp_icon",
            "icon" => "icon-wpb-information-white",
            "category" => esc_html__('Theme: Special', 'js_composer'),
            "description" => esc_html__('Awesome icons in any size.', 'js_composer'),
            "params" => array(
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Icon size", "js_composer"),
                    "param_name" => "icon_size",
                    "description" => esc_html__("Enter icon size. Default is 14px. Examples: 32px or 2em", "js_composer")
                ),
                array(
                    "type" => "colorpicker",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Icon color","hook"),
                    "param_name" => "text_color",
                    "value" => "",
                    "description" => esc_html__("Optional - If blank the theme default color will be used","hook")
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Icon alignment", "js_composer"),
                    "param_name" => "align",
                    "value" => array("Left","Center","Right"),
                    "description" => esc_html__("", "js_composer")
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Icon set", "js_composer"),
                    "param_name" => "icon_type",
                    "value" => array(
                        esc_html__('Google Material Design', "js_composer") => "material_icons",
                        esc_html__('Font Awesome', "js_composer") => "awesome_icons",
                    ),
                    "description" => ""
                ),
                array(
                    "type" => "iconpicker",
                    "heading" => esc_html__("Font Awesome icon selector", "js_composer"),
                    "param_name" => "icon",
                    'settings' => array(
                        'emptyIcon' => false, // default true, display an "EMPTY" icon?
                        'iconsPerPage' => 200, // default 100, how many icons per/page to display
                    ),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'awesome_icons',
                    ),
                ),
                array(
                    'type' => 'iconpicker',
                    'heading' => esc_html__( 'Google Material Design icon selector', 'js_composer' ),
                    'param_name' => 'icon_material',
                    'settings' => array(
                        'emptyIcon' => false, // default true, display an "EMPTY" icon?
                        'type' => 'material_icons',
                        'iconsPerPage' => 200, // default 100, how many icons per/page to display
                    ),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'material_icons',
                    ),
                    'description' => esc_html__( 'Select icon from library.', 'js_composer' ),
                ),
                $add_css_animation,
                $add_css_delay,
                $add_el_class,
            ),
        ));

        /* Theme Button ----------------------------------------------------- */
        /**
         * @param $atts
         * @return string
         */
        function theme_button_func($atts ) {
            extract( shortcode_atts( array(
                'prk_in' => '',
                'button_size' => 'prk_large',
                'type' => 'theme_button',
                'window' => '',
                'link' => '',
                'el_class' => '',
                'css_animation' => '',
                'button_icon' => '',
                'custom_css' => '',
                'button_bk_color' =>'',
                'css_delay' => '',
            ), $atts ) );
            if ($window=="Yes")
                $window="_blank";
            else
                $window="_self";

            return do_shortcode('[theme_button type="'.$type.'" button_size="'.$button_size.'" button_icon="'.$button_icon.'" link="'.$link.'" window="'.$window.'" css_animation="'.$css_animation.'" css_delay="'.$css_delay.'" el_class="'.$el_class.'" custom_css="'.$custom_css.'" button_bk_color="'.$button_bk_color.'"]'.$prk_in.'[/theme_button]');
        }
        add_shortcode( 'prk_wp_theme_button', 'theme_button_func' );

        vc_map( array(
            "name" => esc_html__("Theme Button","hook"),
            "base" => "prk_wp_theme_button",
            "class" => "hook_scodes_editor",
            "icon" => "icon-wpb-ui-button",
            "description" => esc_html__('Buttons with the theme default styling', 'js_composer'),
            "category" => esc_html__('Theme: Special',"hook"),
            "params" => array(
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Button type", "js_composer"),
                    "param_name" => "type",
                    "value" => array(
                        esc_html__('Theme Button', "js_composer") => "theme_button",
                        esc_html__('Theme Button - Inverted Colors', "js_composer") => "colored_theme_button",
                        esc_html__('Ghost Button', "js_composer") => "ghost_theme_button",
                        esc_html__('Ghost Button - Inverted Colors', "js_composer") => "ghost_theme_button colored",
                    ),
                    "description" => ""
                ),
                array(
                    "type" => "colorpicker",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Forced button color","stamp_lang"),
                    "param_name" => "button_bk_color",
                    "value" => "",
                    'dependency' => array(
                        'element' => 'type',
                        'value' => 'ghost_theme_button',
                    ),
                    "description" => esc_html__("Optional - will override the button up color","stamp_lang")
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Button type", "js_composer"),
                    "param_name" => "button_size",
                    "value" => array(
                        esc_html__('Large', "js_composer") => "prk_large",
                        esc_html__('Medium', "js_composer") => "prk_medium",
                        esc_html__('Small', "js_composer") => "prk_small",
                        esc_html__('Tiny', "js_composer") => "prk_tiny",
                    ),
                    "description" => ""
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Button text","hook"),
                    "param_name" => "prk_in",
                    "value" => esc_html__("","hook"),
                    "description" => esc_html__("","hook")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Link","hook"),
                    "param_name" => "link",
                    "value" => esc_html__("","hook"),
                    "description" => esc_html__("","hook")
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Open link in a new window?", "js_composer"),
                    "param_name" => "window",
                    "value" => array("No","Yes"),
                    "description" => esc_html__("", "js_composer","hook")
                ),
                $add_css_animation,
                $add_css_delay,
                $add_el_class,
                $add_custom_css
            )
        ));

        /* Image Gallery ----------------------------------------------------- */
        vc_map( array(
            "name" => esc_html__("Image Gallery", "js_composer"),
            "description" => esc_html__('Multiple images from Media Library', 'js_composer'),
            "base" => "pirenko_gallery",
            "icon" => "icon-wpb-images-stack",
            "category" => esc_html__('Theme: Special', 'js_composer'),
            "params" => array(
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Gallery type", "js_composer"),
                    "param_name" => "type",
                    "value" => array(esc_html__("Masonry", "js_composer") => "masonry", esc_html__("Grid (rectangles)", "js_composer") => "grid", esc_html__("Grid (squares)", "js_composer") => "squares"),
                    "description" => esc_html__("Select grid type.", "js_composer")
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Number of columns", "js_composer"),
                    "param_name" => "cols_number",
                    "value" => array(
                        esc_html__("Two", "js_composer") => "iso_doubles",
                        esc_html__("Three", "js_composer") => "iso_thirds",
                        esc_html__("Four", "js_composer") => "iso_fourths",
                        esc_html__("Five", "js_composer") => "iso_fifths",
                        esc_html__("Six", "js_composer") => "iso_sixths"),
                    "description" => esc_html__("Select grid type.", "js_composer")
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Show image Alt text on rollover?", "js_composer"),
                    "param_name" => "show_titles",
                    "value" => $yes_no_arr,
                    "description" => esc_html__("Titles can be changed on the Media Library (attribute to edit is the Alt Text). If Alt text is empty the image filename will be used.", "js_composer")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Thumbnails margin","astro_lang"),
                    "param_name" => "thumbs_mg",
                    "value" => "",
                    "description" => esc_html__("Default value is 10","astro_lang")
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Thumbnails click behavior", "js_composer"),
                    "param_name" => "on_click",
                    "value" => array(
                        esc_html__("Open lightbox", "js_composer") => "default",
                        esc_html__("Do nothing", "js_composer") => "nothing",
                    ),
                    "description" => esc_html__("", "js_composer")
                ),
                array(
                    "type" => "attach_images",
                    "heading" => esc_html__("Images", "js_composer"),
                    "param_name" => "images",
                    "value" => "",
                    "description" => esc_html__("Select images from media library.", "js_composer")
                ),
                $add_el_class,
            )
        ));

        /* Image Gallery ----------------------------------------------------- */
        vc_map( array(
            "name" => esc_html__("Theme Carousel", "js_composer"),
            "description" => esc_html__('Good for logo showcases', 'js_composer'),
            "base" => "pirenko_carousel",
            "icon" => "icon-wpb-images-stack",
            "category" => esc_html__('Theme: Special', 'js_composer'),
            "params" => array(
                array(
                    "type" => "attach_images",
                    "heading" => esc_html__("Images", "js_composer"),
                    "param_name" => "images",
                    "value" => "",
                    "description" => esc_html__("Select images from media library.", "js_composer")
                ),
                $add_el_class,
            )
        ));

        /* Theme Slider ----------------------------------------------------- */
        vc_map( array(
            "name" => esc_html__("Theme Slider","hook"),
            "base" => "prk_slider",
            "class" => "hook_scodes_editor",
            "icon" => "icon-wpb-slideshow",
            "category" => esc_html__('Theme: Special',"hook"),
            "description" => esc_html__('Display theme slides using Owl Slider', 'js_composer'),
            "params" => array(
                array(
                    "type" => "checkbox",
                    "heading" => esc_html__("Groups filter","hook"),
                    "param_name" => "category",
                    "value" => $slides_terms_array,
                    "description" => esc_html__("Optional - leave blank for all","hook")
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Autoplay slideshow?", "js_composer"),
                    "param_name" => "autoplay",
                    "value" => $yes_no_arr,
                    "description" => ""
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Slider delay","hook"),
                    "param_name" => "delay",
                    "value" => "",
                    "description" => esc_html__("In miliseconds - If blank the theme default value will be used","hook")
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Append navigation arrows to slider?", "js_composer"),
                    "param_name" => "navigation",
                    "value" => array(
                        esc_html__("No", "js_composer") => "false",
                        esc_html__("Yes", "js_composer") => "true"),
                    "description" => ""
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Append navigation dots to slider?", "js_composer"),
                    "param_name" => "pagination",
                    "value" => array(
                        esc_html__("No", "js_composer") => "false",
                        esc_html__("Yes", "js_composer") => "true"),
                    "description" => ""
                ),
                $add_el_class,
            )
        ));

        /* Schedule ----------------------------------------------------- */
        vc_map( array(
            "name" => esc_html__("Schedule","hook"),
            "base" => "pirenko_schedule",
            "class" => "hook_scodes_editor",
            "icon" => "icon-wpb-toggle-small-expand",
            "description" => esc_html__('Good For Events', 'js_composer'),
            "category" => esc_html__('Theme: Special',"hook"),
            "params" => array(
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Element", "js_composer"),
                    "holder" => "div",
                    "param_name" => "element_type",
                    "value" => array(
                        esc_html__("Title/Heading", "js_composer") => "title",
                        esc_html__("Event", "js_composer") => "event",
                    ),
                    "description" => ""
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Title text - left side","hook"),
                    "param_name" => "head_title_left",
                    "value" => "",
                    "description" => "Example: Monday",
                    "dependency" => Array('element' => "element_type", 'value' => 'title')
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => esc_html__("Title text - right side","hook"),
                    "param_name" => "head_title_right",
                    "value" => "",
                    "description" => "Example: January 1st",
                    "dependency" => Array('element' => "element_type", 'value' => 'title')
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "holder" => "div",
                    "heading" => esc_html__("Event time text","hook"),
                    "param_name" => "event_time",
                    "value" => "",
                    "description" => "",
                    "dependency" => Array('element' => "element_type", 'value' => 'event')
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => esc_html__("Event subheading text","hook"),
                    "param_name" => "event_subtitle",
                    "value" => "",
                    "description" => "Will be displayed under the time",
                    "dependency" => Array('element' => "element_type", 'value' => 'event')
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Event title text","hook"),
                    "param_name" => "event_title",
                    "value" => "",
                    "description" => "",
                    "dependency" => Array('element' => "element_type", 'value' => 'event')
                ),
                array(
                    "type" => "textarea_html",
                    "class" => "event_description",
                    "heading" => esc_html__("Event description", "js_composer"),
                    "param_name" => "content",
                    "value" => esc_html__("", "js_composer"),
                    "description" => "Will be displayed under the title",
                    "dependency" => Array('element' => "element_type", 'value' => 'event')
                ),
                $add_css_animation,
                $add_css_delay,
                $add_el_class,
            )
        ));


        /* Pricing Tables ----------------------------------------------------- */
        /**
         * @param $atts
         * @return string
         */
        function prkwp_price_table_func($atts ) {
            extract( shortcode_atts( array(
                'prk_in' => '',
                'table_align' => 'hook_center_align',
                'header' => '',
                'color' => '',
                'price' => '',
                'under_price' => '',
                'after_price' => '',
                'button_label' => '',
                'button_link' => '',
                'serv_image' => '',
                'featured_text' =>'',
                'css_animation' => '',
                'el_class' => '',
                'css_delay' => '',
                'img_link_target' => '_self'
            ), $atts ) );
            $lines_output='<ul class="unstyled prk_bordered_top">';
            $prk_edited = str_replace(", ", "prkwrdoff", $prk_in);
            $arr=explode(",",$prk_edited);
            if (count($arr)>0)
            {
                foreach ($arr as $single) {
                    $lines_output.='<li>'.str_replace("prkwrdoff", ", ",$single).'</li>';
                }
            }
            $lines_output.='</ul>';
            return do_shortcode('[prk_price_table header="'.$header.'" serv_image="'.$serv_image.'" el_class="'.$el_class.'" css_animation="'.$css_animation.'" css_delay="'.$css_delay.'" featured_text="'.$featured_text.'" color="'.$color.'" price="'.$price.'" table_align="'.$table_align.'" after_price="'.$after_price.'" under_price="'.$under_price.'" button_label="'.$button_label.'" button_link="'.$button_link.'" img_link_target="'.$img_link_target.'"]'.$lines_output.'[/prk_price_table]');
        }
        add_shortcode( 'prkwp_price_table', 'prkwp_price_table_func' );

        vc_map( array(
            "name" => esc_html__("Pricing table","hook"),
            "base" => "prkwp_price_table",
            "class" => "hook_scodes_editor",
            "icon" => "vc_icon-vc-gitem-post-date",
            "description" => esc_html__('Informational tables with multiple content fields', 'hook'),
            "category" => esc_html__('Theme: Special',"hook"),
            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Title","hook"),
                    "param_name" => "header",
                    "value" => "",
                    "description" => ""
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Text alignment", "js_composer"),
                    "param_name" => "table_align",
                    "value" => array(
                        esc_html__("Centered", 'js_composer') => 'hook_center_align',
                        esc_html__("Left", 'js_composer') => 'hook_left_align',
                        esc_html__('Right', 'js_composer') => 'hook_right_align',
                    ),
                    "description" => ""
                ),
                array(
                    "type" => "colorpicker",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Background color","hook"),
                    "param_name" => "color",
                    "value" => "",
                    "description" => esc_html__("Optional - If blank the theme active color will be used","hook")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Plan name text","hook"),
                    "param_name" => "under_price",
                    "value" => "",
                    "description" => esc_html__("Example: BIG PLAN","hook")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Price text","hook"),
                    "param_name" => "price",
                    "value" => "",
                    "description" => ""
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("After price text","hook"),
                    "param_name" => "after_price",
                    "value" => "",
                    "description" => "Optional - Example: / per month"
                ),
                array(
                    "type" => "attach_image",
                    "heading" => esc_html__("Featured image", "js_composer"),
                    "param_name" => "serv_image",
                    "value" => "",
                    "description" => esc_html__("Optional - Select image from media library.", "js_composer"),
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Featured text","hook"),
                    "param_name" => "featured_text",
                    "value" => "",
                    "description" => esc_html__("Optional - Will be displayed on a ribbon on the right side","hook")
                ),
                array(
                    "type" => "exploded_textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Description text","hook"),
                    "param_name" => "prk_in",
                    "value" => "",
                    "description" => esc_html__("Enter descriptions for this table here. Divide them with linebreaks (Enter).","hook")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Button text","hook"),
                    "param_name" => "button_label",
                    "value" => "",
                    "description" => esc_html__("Leave blank if no button is needed","hook")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Button URL","hook"),
                    "param_name" => "button_link",
                    "value" => "",
                    "description" => esc_html__("Leave blank if no button is needed","hook")
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Open link in new window?', 'js_composer' ),
                    'param_name' => 'img_link_target',
                    'value' => $target_arr,
                    'dependency' => Array('element' => 'button_link', 'not_empty' => true)
                ),
                $add_css_animation,
                $add_css_delay,
                $add_el_class,
            )
        ));

        /* Latest Posts ----------------------------------------------------- */
        vc_map( array(
            "name" => esc_html__("Latest Posts","hook"),
            "base" => "pirenko_last_posts",
            "class" => "hook_scodes_editor",
            "icon" => "icon-wpb-atm",
            "description" => esc_html__('Show blog entries', 'js_composer'),
            "category" => esc_html__('Theme: Feeds',"hook"),
            "params" => array(
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Appearance", "js_composer"),
                    "param_name" => "general_style",
                    "value" => array(
                        esc_html__("Classic style - show all posts in multiple rows", "js_composer") => "classic",
                        esc_html__("Classic style with slider - show all posts in a single row with navigation arrows", "js_composer") => "slider",
                        esc_html__("List/plain - simple list with links to posts", "js_composer") => "hook_list",
                    ),
                    "description" => ""
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Show date?", "js_composer"),
                    "param_name" => "show_date",
                    "value" => $no_yes_arr,
                    "description" => "",
                    "dependency" => Array('element' => "general_style", 'value' => 'hook_list'),
                ),
                array(
                    "type" => "checkbox",
                    "heading" => esc_html__("Category filter","hook"),
                    "holder" => "div",
                    "param_name" => "cat_filter",
                    "value" => $posts_terms_array,
                    "description" => esc_html__("Optional - leave blank for all","hook")
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => esc_html__("Posts number","hook"),
                    "param_name" => "items_number",
                    "value" => "",
                    "description" => esc_html__("Optional - Default is three","hook")
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => esc_html__("Rows number","hook"),
                    "param_name" => "rows_number",
                    "value" => "1",
                    "description" => "",
                    "dependency" => Array('element' => "general_style", 'value' => 'classic')
                ),
                $add_css_animation,
                $add_css_delay,
                $add_el_class,
            )
        ));

        /* Latest Portfolio ----------------------------------------------------- */
        vc_map( array(
            "name" => esc_html__("Latest Portfolio","hook"),
            "base" => "pirenko_last_portfolios",
            "class" => "hook_scodes_editor",
            "icon" => "icon-wpb-atm",
            "description" => esc_html__('Show portfolio entries', 'js_composer'),
            "category" => esc_html__('Theme: Feeds',"hook"),
            "params" => array(
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Layout type?", "js_composer"),
                    "param_name" => "layout_type_folio",
                    "value" => array(
                        esc_html__("Grid - Multi-width", "js_composer") => "packery",
                        esc_html__("Grid with horizontal rectangular images", "js_composer") => "grid",
                        esc_html__("Grid with vertical rectangular images", "js_composer") => "grid_vertical",
                        esc_html__("Grid with squared images", "js_composer") => "squares",
                        esc_html__("Grid without image crop - Masonry", "js_composer") => "masonry",
                        esc_html__('Showcase Mode - 1 Project Per Screen', 'hook') => 'featured',
                        esc_html__('Carousel Mode', 'hook') => 'panels',
                        esc_html__('Vertical display - Stacked', 'hook') => 'vertical',
                        esc_html__("Info Board", "js_composer") => "info_board",
                    ),
                    "description" => ""
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => esc_html__("Columns number","hook"),
                    "param_name" => "cols_number",
                    "value" => "3",
                    "description" => "Use 0 for variable number",
                    "dependency" => Array('element' => "layout_type_folio", 'value' => array('packery','grid','grid_vertical','squares','masonry')),
                ),
                array(
                    "type" => "dropdown",
                    "class" => "",
                    "heading" => esc_html__("Carousel columns number","hook"),
                    "param_name" => "panels_number",
                    "value" => array (
                        '1' => '1',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                    ),
                    "description" => "",
                    "dependency" => Array('element' => "layout_type_folio", 'value' => array('panels')),
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => esc_html__("Carousel column divider line opacity","hook"),
                    "param_name" => "panel_alpha",
                    "value" => "50",
                    "description" => esc_html__("Acceptable values: [1,100]","hook"),
                    "dependency" => Array('element' => "layout_type_folio", 'value' => array('panels')),
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => esc_html__("Items number","hook"),
                    "param_name" => "items_number",
                    "value" => "",
                    "description" => esc_html__("Optional - default value is 9","hook"),
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Text vertical position", "js_composer"),
                    "param_name" => "text_align",
                    "value" => array(
                        esc_html__("Bottom", "js_composer") => "hook_lf",
                        esc_html__("Middle", "js_composer") => "hook_ct",
                    ),
                    "description" => "",
                    "dependency" => Array('element' => "layout_type_folio", 'value' => array('featured','vertical','panels')),
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Autoplay slideshow?", "js_composer"),
                    "param_name" => "autoplay",
                    "value" => array(
                        esc_html__("No", "js_composer") => "0",
                        esc_html__("Yes", "js_composer") => "1",
                    ),
                    "description" => "",
                    "dependency" => Array('element' => "layout_type_folio", 'value' => array('featured')),
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Slideshow delay in miliseconds", "js_composer"),
                    "param_name" => "autoplay_delay",
                    "value" => "7000",
                    "description" => "",
                    "dependency" => Array('element' => "layout_type_folio", 'value' => array('featured')),
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Text horizontal position", "js_composer"),
                    "param_name" => "text_swap",
                    "value" => array(
                        esc_html__("Centered", 'js_composer') => 'hook_center_align',
                        esc_html__("Left", 'js_composer') => 'hook_left_align',
                        esc_html__('Right', 'js_composer') => 'hook_right_align',
                        esc_html__('Alternate - left and right', 'js_composer') => 'hook_swap',
                    ),
                    "description" => "",
                    "dependency" => Array('element' => "layout_type_folio", 'value' => array('vertical')),
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Make text color have the post featured color?", "js_composer"),
                    "param_name" => "special_text_color",
                    "value" => array(
                        esc_html__("No", "js_composer") => "0",
                        esc_html__("Yes", "js_composer") => "1",
                    ),
                    "description" => "",
                    "dependency" => Array('element' => "layout_type_folio", 'value' => array('featured')),
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Background videos behavior", "js_composer"),
                    "param_name" => "videos_behavior",
                    "value" => array(
                        esc_html__("Resume and play on rollover", "js_composer") => "resume",
                        esc_html__("Loop And autoplay (sound OFF)", "js_composer") => "default",
                        esc_html__("Restart and play on rollover", "js_composer") => "restart",
                    ),
                    "description" => "",
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Show mute videos button","hook"),
                    "param_name" => "mute_button",
                    "value" => array(
                        esc_html__("No", "js_composer") => "0",
                        esc_html__("Yes", "js_composer") => "1",
                    ),
                    "description" => "",
                    "dependency" => Array('element' => "layout_type_folio", 'value' => array('panels')),
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Videos default volume state - ON/OFF","hook"),
                    "param_name" => "vol_state",
                    "value" => array(
                        esc_html__("Sound is ON", "js_composer") => "sound_on",
                        esc_html__("Sound is OFF", "js_composer") => "sound_off",
                    ),
                    "description" => "",
                    "dependency" => Array('element' => "mute_button", 'value' => array('1')),
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Show load more button?", "js_composer"),
                    "param_name" => "show_load_more",
                    "value" => $yes_no_arr,
                    "description" => "Will be displayed if there are more posts to be displayed",
                    "dependency" => Array('element' => "layout_type_folio", 'value' => array('packery','grid','grid_vertical','squares','masonry')),
                ),
                array(
                    "type" => "checkbox",
                    "heading" => esc_html__("Skills filter","hook"),
                    "holder" => "div",
                    "param_name" => "cat_filter",
                    "value" => $portfolio_terms_array,
                    "description" => esc_html__("Optional - leave blank for all","hook"),
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Show filter above thumbnails?", "js_composer"),
                    "param_name" => "show_filter",
                    "value" => $yes_no_arr,
                    "description" => "",
                    "dependency" => Array('element' => "layout_type_folio", 'value' => array('packery','grid','grid_vertical','squares','masonry')),
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Default filter","hook"),
                    "param_name" => "active_filter",
                    "value" => $portfolio_terms_array_plus,
                    "description" => esc_html__("Optional - Use this option to select a filter when the page loads","hook"),
                    "dependency" => Array('element' => "layout_type_folio", 'value' => array('packery','grid','grid_vertical','squares','masonry')),
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Thumbnails click behavior?", "js_composer"),
                    "param_name" => "thumbs_type_folio",
                    "value" => array(
                        esc_html__("Show project with an overlay and hide page content", "js_composer") => "overlayed",
                        esc_html__("Open lightbox", "js_composer") => "lightboxed",
                        esc_html__("Open project on a different page", "js_composer") => "classiqued",
                        esc_html__("Do nothing", "js_composer") => "hook_unlinked",
                    ),
                    "description" => ""
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Lightbox content?", "js_composer"),
                    "param_name" => "lightbox_type",
                    "value" => array(
                        esc_html__("Single - one lightbox shows all portfolio thumbs", "js_composer") => "singled",
                        esc_html__("Multiple - each lightbox shows all images from each portfolio", "js_composer") => "multipled",
                    ),
                    "description" => "Image description will be the image Alt Text (can be edited on the Media Library)",
                    "dependency" => Array('element' => "thumbs_type_folio", 'value' => array('lightboxed')),
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Thumbnails margin","hook"),
                    "param_name" => "thumbs_mg",
                    "value" => "",
                    "description" => esc_html__("Default value is 10","hook"),
                    "dependency" => Array('element' => "layout_type_folio", 'value' => array('packery','grid','grid_vertical','squares','masonry')),
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Multi-colored thumbs on rollover?", "js_composer"),
                    "param_name" => "multicolored_thumbs",
                    "value" => $yes_no_arr,
                    "description" => "If YES the portfolio featured color will be applied to each thumb.",
                    "dependency" => Array('element' => "layout_type_folio", 'value' => array('packery','grid','grid_vertical','squares','masonry')),
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Project information display", "js_composer"),
                    "param_name" => "hook_show_skills",
                    "value" => array(
                        esc_html__("On rollover - Title and skills", "js_composer") => "folio_title_and_skills",
                        esc_html__("On rollover - Title only", "js_composer") => "folio_title_only",
                        esc_html__("Always show under thumb - Title and skills", "js_composer") => "folio_always_title_and_skills",
                        esc_html__("Always show under thumb - Title only", "js_composer") => "folio_always_title_only",
                        esc_html__("Do not show anything", "js_composer") => "folio_noinfo",
                    ),
                    "description" => "",
                    "dependency" => Array('element' => "layout_type_folio", 'value' => array('packery','grid','grid_vertical','squares','masonry','panels')),
                ),
                $add_css_animation,
                $add_css_delay,
                $add_el_class,
            )
        ));

        //TEAM MEMBERS
        vc_map( array(
            "name" => esc_html__("Team members","hook"),
            "base" => "prk_members",
            "class" => "hook_scodes_editor",
            "icon" => "icon-wpb-atm",
            "description" => esc_html__('Display team members info', 'js_composer'),
            "category" => esc_html__('Theme: Feeds',"hook"),
            "params" => array(
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Appearance", "js_composer"),
                    "param_name" => "general_style",
                    "value" => array(
                        esc_html__("Classic style - show members across multiple rows and columns", "js_composer") => "classic",
                        esc_html__("Slider style - show all members in a single row with navigation arrows", "js_composer") => "slider"),
                    "description" => ""
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Member spacing","hook"),
                    "param_name" => "member_spacing",
                    "value" => array(
                        esc_html__("Default spacing - 18 pixels", "js_composer") => "cl_mode",
                        esc_html__("Without spacing - 0 pixels", "js_composer") => "ft_mode"),
                    "description" => "",
                    "dependency" => Array('element' => "general_style", 'value' => 'classic')
                ),
                array(
                    "type" => "checkbox",
                    "heading" => esc_html__("Team filter","hook"),
                    "param_name" => "category",
                    "value" => $member_terms_array,
                    "description" => esc_html__("Optional - leave blank for all","hook")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Number of members to be displayed","hook"),
                    "param_name" => "items_number",
                    "value" => "",
                    "description" => esc_html__("Optional - If empty all members will be shown","hook")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Number of members per row","hook"),
                    "param_name" => "columns",
                    "value" => "3",
                    "description" => "",
                    "dependency" => Array('element' => "general_style", 'value' => 'classic')
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Text alignment", "js_composer"),
                    "param_name" => "text_align",
                    "value" => array(
                        esc_html__("Centered", 'js_composer') => 'hook_center_align',
                        esc_html__("Left", 'js_composer') => 'hook_left_align',
                        esc_html__('Right', 'js_composer') => 'hook_right_align',
                    ),
                    "description" => esc_html__("", "js_composer")
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Member information display", "js_composer"),
                    "param_name" => "content_amount",
                    "value" => array(
                        esc_html__("Show excerpt only", "js_composer") => "compressed",
                        esc_html__("Show all content", "js_composer") => "everything"),
                    "description" => ""
                ),
                $add_css_animation,
                $add_css_delay,
                $add_el_class,
            )
        ));

        /* Authors Spotlight ---------------------------------------------------------- */
        vc_map( array(
            "name" => esc_html__("Authors Spotlight","hook"),
            "base" => "prk_authors",
            "class" => "hook_scodes_editor",
            "icon" => "icon-wpb-atm",
            "description" => esc_html__('Display WordPress Authors Info', 'js_composer'),
            "category" => esc_html__('Theme: Feeds',"hook"),
            "params" => array(
                array(
                    "type" => "checkbox",
                    "heading" => esc_html__("Authors to be displayed","hook"),
                    "param_name" => "category",
                    "value" => $authors_terms_array,
                    "description" => esc_html__("Optional - leave blank for all","hook")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Number of authors per row","hook"),
                    "param_name" => "columns",
                    "value" => "3",
                    "description" => "",
                    "dependency" => Array('element' => "general_style", 'value' => 'classic')
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Text alignment", "js_composer"),
                    "param_name" => "text_align",
                    "value" => array(
                        esc_html__("Center", "js_composer") => "text_center",
                        esc_html__("Left", "js_composer") => "text_left",
                        esc_html__("Right", "js_composer") => "text_right"
                    ),
                    "description" => esc_html__("", "js_composer")
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Author information display", "js_composer"),
                    "param_name" => "content_amount",
                    "value" => array(
                        esc_html__("Show subheading only", "js_composer") => "compressed",
                        esc_html__("Show all information", "js_composer") => "everything"),
                    "description" => ""
                ),
                $add_css_animation,
                $add_css_delay,
                $add_el_class,
            )
        ));

        /* Testimonials ---------------------------------------------------------- */
        vc_map( array(
            "name" => esc_html__("Testimonials","hook"),
            "base" => "prk_testimonials",
            "class" => "hook_scodes_editor",
            "icon" => "icon-wpb-atm",
            "description" => esc_html__('Display Testimonials', 'js_composer'),
            "category" => esc_html__('Theme: Feeds',"hook"),
            "params" => array(
                array(
                    "type" => "checkbox",
                    "heading" => esc_html__("Testimonials group filter","hook"),
                    "param_name" => "category",
                    "value" => $testimonials_terms_array,
                    "description" => esc_html__("Optional - leave blank for all","hook")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Maximum number of testimonials","hook"),
                    "param_name" => "items_number",
                    "value" => "",
                    "description" => "Optional - leave blank for all"
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Display mode?", "js_composer"),
                    "param_name" => "layout",
                    "value" => array(
                        esc_html__("Slider", "js_composer") => "testimonials_slider",
                        esc_html__("Stacked", "js_composer") => "testimonials_stack",
                    ),
                    "description" => ""
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("General elements size", "js_composer"),
                    "param_name" => "size",
                    "value" => array(
                        esc_html__("Medium", 'js_composer') => '',
                        esc_html__("Big", 'js_composer') => ' hook_bigger',
                        esc_html__("Small", 'js_composer') => ' hook_smaller',
                    ),
                    "description" => ""
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Text and buttons alignment", "js_composer"),
                    "param_name" => "align",
                    "value" => array(
                        esc_html__("Centered", 'js_composer') => 'hook_center_align',
                        esc_html__("Left", 'js_composer') => 'hook_left_align',
                        esc_html__('Right', 'js_composer') => 'hook_right_align',
                    ),
                    "description" => ""
                ),
                array(
                    "type" => "colorpicker",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Title color","hook"),
                    "param_name" => "title_color",
                    "value" => "",
                    "description" => esc_html__("Optional - If blank the theme active color will be used","hook")
                ),
                array(
                    "type" => "colorpicker",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Text color","hook"),
                    "param_name" => "color",
                    "value" => "",
                    "description" => esc_html__("Optional - If blank the theme active color will be used","hook")
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Show navigation buttons?", "js_composer"),
                    "param_name" => "show_controls",
                    "value" => array(
                        esc_html__('Yes, with colored rectangles', "js_composer") => "yes",
                        esc_html__('Yes, with testimonial featured images/thumbs', "js_composer") => "thumbs",
                        esc_html__('Yes, with arrows', "js_composer") => "arrows",
                        esc_html__('No', "js_composer") => "no"
                    ),
                    "description" => "",
                    "dependency" => Array('element' => "layout", 'value' => 'testimonials_slider')
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Navigation up color", "js_composer"),
                    "param_name" => "nav_color",
                    "value" => array(
                        esc_html__("Site background color", 'js_composer') => '',
                        esc_html__("Buttons background color", 'js_composer') => ' hook_btn_like',
                        esc_html__("Buttons text color", 'js_composer') => ' hook_btn_like hook_texty',
                    ),
                    "description" => "",
                    "dependency" => Array('element' => "show_controls", 'value' => 'yes')
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Autoplay slideshow?", "js_composer"),
                    "param_name" => "autoplay",
                    "value" => $yes_no_arr,
                    "description" => "",
                    "dependency" => Array('element' => "layout", 'value' => 'testimonials_slider')
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Slider delay","hook"),
                    "param_name" => "delay",
                    "value" => "",
                    "description" => esc_html__("In miliseconds - If blank the theme default value will be used","hook"),
                    "dependency" => Array('element' => "layout", 'value' => 'testimonials_slider')
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Slider transition style?", "js_composer"),
                    "param_name" => "transition_style",
                    "value" => array(
                        esc_html__('Scale up/down', "js_composer") => "backSlide",
                        esc_html__('Fade', "js_composer") => "fade",
                    ),
                    "description" => "",
                    "dependency" => Array('element' => "layout", 'value' => 'testimonials_slider')
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Slider height?", "js_composer"),
                    "param_name" => "slider_height",
                    "value" => array(
                        esc_html__('Fixed', "js_composer") => "fixed",
                        esc_html__('Variable', "js_composer") => "variable",
                    ),
                    "description" => "",
                    "dependency" => Array('element' => "layout", 'value' => 'testimonials_slider')
                ),
                $add_css_animation,
                $add_css_delay,
                $add_el_class,
            )
        ));
        /* Comments ---------------------------------------------------------- */
        vc_map( array(
            "name" => esc_html__("Comments","hook"),
            "base" => "pirenko_comments",
            "class" => "hook_scodes_editor",
            "icon" => "icon-wpb-atm",
            "description" => esc_html__('Display comments from users', 'js_composer'),
            "category" => esc_html__('Theme: Feeds',"hook"),
            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Title","hook"),
                    "param_name" => "title",
                    "value" => "",
                    "description" => ""
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Number of comments","hook"),
                    "param_name" => "items_number",
                    "value" => "",
                    "description" => ""
                ),
                $add_css_animation,
                $add_css_delay,
                $add_el_class,
            )
        ));

        /* Contact Information ---------------------------------------------------------- */
        vc_map( array(
            "name" => esc_html__("Contact Information","hook"),
            "base" => "pirenko_contact_info",
            "class" => "hook_scodes_editor",
            "icon" => "vc_icon-vc-gitem-post-author",
            "description" => esc_html__('Display general contact info', 'js_composer'),
            "category" => esc_html__('Theme: Special',"hook"),
            "params" => array(
                array(
                    "type" => "attach_image",
                    "heading" => esc_html__("Logo Image", "js_composer"),
                    "param_name" => "image_path",
                    "value" => "",
                    "description" => esc_html__("Optional", "js_composer")
                ),
                array(
                    "type" => "textarea_html",
                    "holder" => "div",
                    "class" => "messagebox_text",
                    "heading" => esc_html__("Description (will be displayed above the address (optional)", "js_composer"),
                    "param_name" => "content",
                    "value" => esc_html__("", "js_composer"),
                    "description" => "Optional"
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Company Name/Title","hook"),
                    "param_name" => "company_name",
                    "value" => "",
                    "description" => "Optional"
                ),
                array(
                    "type" => "colorpicker",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Company Name/Title text color","hook"),
                    "param_name" => "company_text_color",
                    "value" => "",
                    "description" => esc_html__("Optional - If blank the theme default color scheme will be used","hook")
                ),
                array(
                    "type" => "colorpicker",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Forced text color","hook"),
                    "param_name" => "text_color",
                    "value" => "",
                    "description" => esc_html__("Optional - If blank the theme default color scheme will be used","hook")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Street Address","hook"),
                    "param_name" => "street_address",
                    "value" => "",
                    "description" => "Optional"
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("City","hook"),
                    "param_name" => "locality",
                    "value" => "",
                    "description" => "Optional"
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Zipcode","hook"),
                    "param_name" => "postal_code",
                    "value" => "",
                    "description" => "Optional"
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Telephone","hook"),
                    "param_name" => "tel",
                    "value" => "",
                    "description" => "Optional"
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Fax","hook"),
                    "param_name" => "fax",
                    "value" => "",
                    "description" => "Optional"
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Opening hours","hook"),
                    "param_name" => "hours",
                    "value" => "",
                    "description" => "Optional"
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Email","hook"),
                    "param_name" => "email",
                    "value" => "",
                    "description" => "Optional"
                ),
                $add_css_animation,
                $add_css_delay,
                $add_el_class,
            )
        ));

        /* Theme Contact Form ---------------------------------------------------------- */
        vc_map( array(
            "name"    => esc_html__("Theme Contact Form", "js_composer"),
            "base"    => "prk_contact_form",
            'icon'    => 'vc_icon-vc-gitem-post-categories',
            "category"  => esc_html__('Content', 'js_composer'),
            "description" => esc_html__('Regular contact form', 'js_composer'),
            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "admin_label" => true,
                    "heading" => esc_html__("Receiving email address","hook"),
                    "param_name" => "email_adr",
                    "value" => "your-email@something.com",
                    "description" => "The email that will receive messages through this form."
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Name, Email and Subject fields display", "js_composer"),
                    "param_name" => "fields_display",
                    "value" => array(
                        esc_html__("All in the same line (3 columns)", 'js_composer') => 'hook_reg_subject',
                        esc_html__("Name and Email above and subject under (2 columns + 1 row)", 'js_composer') => 'hook_big_subject',
                    ),
                    "description" => "",
                ),
                array(
                    "type" => "colorpicker",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Inputs background color","hook"),
                    "param_name" => "backs_color",
                    "value" => "",
                    "description" => esc_html__("Optional - If blank the theme default color scheme will be used","hook")
                ),
                $add_css_animation,
                $add_css_delay,
                $add_el_class,
            )
        ));

        /* Social Networks Links ---------------------------------------------------------- */
        vc_map( array(
            "name" => esc_html__("Social Networks Links","hook"),
            "base" => "pirenko_social_nets",
            "class" => "hook_scodes_editor",
            "icon" => "icon-wpb-atm",
            "description" => esc_html__('Display links to Social Networks', 'js_composer'),
            "category" => esc_html__('Theme: Special',"hook"),
            "params" => array(
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Icons style", "js_composer"),
                    "param_name" => "icons_style",
                    "value" => array(
                        esc_html__("Minimal icons", "js_composer") => "minimal_icons",
                        esc_html__("Squared icons", "js_composer") => "squared_icons",
                        esc_html__("Rounded icons", "js_composer") => "rounded_icons",
                    ),
                    "description" => ""
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Icons font size", "js_composer"),
                    "param_name" => "icons_size",
                    "value" => "14",
                    "description" => "In pixels.",
                    "dependency" => Array('element' => "icons_style", 'value' => array('minimal_icons'))
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Icons horizontal padding", "js_composer"),
                    "param_name" => "icons_padding",
                    "value" => "",
                    "description" => "In pixels.",
                ),
                array(
                    "type" => "colorpicker",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Icons custom up color","hook"),
                    "param_name" => "text_color",
                    "value" => "",
                    "description" => esc_html__("Optional","hook"),
                ),
                array(
                    "type" => "colorpicker",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Icons custom hover color","hook"),
                    "param_name" => "hover_color",
                    "value" => "",
                    "description" => esc_html__("Optional","hook"),
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Icons default opacity","hook"),
                    "param_name" => "custom_opacity",
                    "value" => "100",
                    "description" => esc_html__("Acceptable values: [1,100]","hook"),
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Social Network 1", "js_composer"),
                    "param_name" => "net_1",
                    "value" => $nets_array,
                    "description" => ""
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Social Network 1 link", "js_composer"),
                    "param_name" => "link_1",
                    "description" => esc_html__("", "js_composer"),
                    "dependency" => Array('element' => "net_1", 'value' => $nets_array_single)
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Social Network 2", "js_composer"),
                    "param_name" => "net_2",
                    "value" => $nets_array,
                    "description" => ""
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Social Network 2 link", "js_composer"),
                    "param_name" => "link_2",
                    "description" => esc_html__("", "js_composer"),
                    "dependency" => Array('element' => "net_2", 'value' => $nets_array_single)
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Social Network 3", "js_composer"),
                    "param_name" => "net_3",
                    "value" => $nets_array,
                    "description" => ""
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Social Network 3 link", "js_composer"),
                    "param_name" => "link_3",
                    "description" => esc_html__("", "js_composer"),
                    "dependency" => Array('element' => "net_3", 'value' => $nets_array_single)
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Social Network 4", "js_composer"),
                    "param_name" => "net_4",
                    "value" => $nets_array,
                    "description" => ""
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Social Network 4 link", "js_composer"),
                    "param_name" => "link_4",
                    "description" => esc_html__("", "js_composer"),
                    "dependency" => Array('element' => "net_4", 'value' => $nets_array_single)
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Social Network 5", "js_composer"),
                    "param_name" => "net_5",
                    "value" => $nets_array,
                    "description" => ""
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Social Network 5 link", "js_composer"),
                    "param_name" => "link_5",
                    "description" => esc_html__("", "js_composer"),
                    "dependency" => Array('element' => "net_5", 'value' => $nets_array_single)
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Social Network 6", "js_composer"),
                    "param_name" => "net_6",
                    "value" => $nets_array,
                    "description" => ""
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Social Network 6 link", "js_composer"),
                    "param_name" => "link_6",
                    "description" => esc_html__("", "js_composer"),
                    "dependency" => Array('element' => "net_6", 'value' => $nets_array_single)
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Social Network 7", "js_composer"),
                    "param_name" => "net_7",
                    "value" => $nets_array,
                    "description" => ""
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Social Network 7 link", "js_composer"),
                    "param_name" => "link_7",
                    "description" => esc_html__("", "js_composer"),
                    "dependency" => Array('element' => "net_7", 'value' => $nets_array_single)
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Social Network 8", "js_composer"),
                    "param_name" => "net_8",
                    "value" => $nets_array,
                    "description" => ""
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Social Network 8 link", "js_composer"),
                    "param_name" => "link_8",
                    "description" => esc_html__("", "js_composer"),
                    "dependency" => Array('element' => "net_8", 'value' => $nets_array_single)
                ),
                $add_css_animation,
                $add_css_delay,
                $add_el_class,
            )
        ));

        //TWITTER FEED
        vc_map( array(
            "name" => esc_html__("Twitter feed","hook"),
            "base" => "prk_twt",
            "class" => "hook_scodes_editor",
            "icon" => "icon-wpb-atm",
            "description" => esc_html__('Customized for the theme', 'js_composer'),
            "category" => esc_html__('Theme: Special',"hook"),
            "params" => array(
                array(
                    "type" => "textfield",
                    //"holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Title","hook"),
                    "param_name" => "title",
                    "value" => "",
                    "description" => esc_html__("Optional - will be shown above the feed","hook")
                ),
                array(
                    "type" => "colorpicker",
                    //"holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Title color","hook"),
                    "param_name" => "title_color",
                    "value" => "",
                    "description" => esc_html__("Optional","hook"),
                    "dependency" => Array('element' => "title", 'not_empty' => true)
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Username","hook"),
                    "param_name" => "username",
                    "value" => "",
                    "description" => esc_html__("","hook")
                ),
                array(
                    "type" => "textfield",
                    //"holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Consumer key","hook"),
                    "param_name" => "consumerkey",
                    "value" => "",
                    "description" => esc_html__("","hook")
                ),
                array(
                    "type" => "textfield",
                    //"holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Consumer Secret","hook"),
                    "param_name" => "consumersecret",
                    "value" => "",
                    "description" => esc_html__("","hook")
                ),
                array(
                    "type" => "textfield",
                    //"holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Access Token","hook"),
                    "param_name" => "accesstoken",
                    "value" => "",
                    "description" => esc_html__("","hook")
                ),
                array(
                    "type" => "textfield",
                    //"holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Access Token Secret","hook"),
                    "param_name" => "accesstokensecret",
                    "value" => "",
                    "description" => esc_html__("","hook")
                ),
                array(
                    "type" => "textfield",
                    //"holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Cache Tweets in every","hook"),
                    "param_name" => "cachetime",
                    "value" => "",
                    "description" => esc_html__("","hook")
                ),
                array(
                    "type" => "textfield",
                    //"holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Tweets to display","hook"),
                    "param_name" => "tweetstoshow",
                    "value" => "",
                    "description" => esc_html__("","hook")
                ),
                $add_css_animation,
                $add_css_delay,
                $add_el_class,
            )
        ));

        //INSTAGRAM FEED
        vc_map( array(
            "name" => esc_html__("Instagram feed","hook"),
            "base" => "prk_instagram",
            "class" => "hook_scodes_editor",
            "icon" => "icon-wpb-atm",
            "description" => esc_html__('Customized for the theme', 'js_composer'),
            "category" => esc_html__('Theme: Special',"hook"),
            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Title","hook"),
                    "param_name" => "title",
                    "value" => "",
                    "description" => esc_html__("Optional - will be shown above the images","hook")
                ),
                array(
                    "type" => "colorpicker",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Title color","hook"),
                    "param_name" => "title_color",
                    "value" => "",
                    "description" => esc_html__("Optional","hook"),
                    "dependency" => Array('element' => "title", 'not_empty' => true)
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Username","hook"),
                    "param_name" => "user",
                    "value" => "",
                    "description" => esc_html__("","hook")
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Display", "js_composer"),
                    "param_name" => "gen_display",
                    "value" => array(
                        esc_html__("Show images in grid", "js_composer") => "hook_insta_grid",
                        esc_html__("Show images with a slider", "js_composer") => "hook_insta_slider",
                    ),
                    "description" => ""
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Columns number", "js_composer"),
                    "param_name" => "items",
                    "value" => array(
                        esc_html__("One", "js_composer") => "1",
                        esc_html__("Two", "js_composer") => "2",
                        esc_html__("Three", "js_composer") => "3",
                        esc_html__("Four", "js_composer") => "4",
                        esc_html__("Six", "js_composer") => "6"
                    ),
                    "description" => "",
                    "dependency" => Array('element' => "gen_display", 'value' => 'hook_insta_grid')
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Rows number", "js_composer"),
                    "param_name" => "rows",
                    "value" => array(
                        esc_html__("One", "js_composer") => "1",
                        esc_html__("Two", "js_composer") => "2",
                        esc_html__("Three", "js_composer") => "3",
                        esc_html__("Four", "js_composer") => "4",
                    ),
                    "description" => "",
                    "dependency" => Array('element' => "gen_display", 'value' => 'hook_insta_grid')
                ),
                $add_css_animation,
                $add_css_delay,
                $add_el_class,
            )
        ));

        /* Sitemap ---------------------------------------------------------- */
        vc_map( array(
            "name" => esc_html__("Sitemap","hook"),
            "base" => "prk_sitemap",
            "class" => "hook_scodes_editor",
            "icon" => "icon-wpb-atm",
            "description" => esc_html__('Complete sitemap with all post types', 'js_composer'),
            "category" => esc_html__('Theme: Feeds',"hook"),
            "params" => array(
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Show Pages?", "js_composer"),
                    "param_name" => "show_pages",
                    "value" => $yes_no_arr,
                    "description" => ""
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Title for Pages","hook"),
                    "param_name" => "txt_pages",
                    "value" => "",
                    "description" => ""
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Show blog categories?", "js_composer"),
                    "param_name" => "show_blog_cats",
                    "value" => $yes_no_arr,
                    "description" => ""
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Title for blog categories","hook"),
                    "param_name" => "txt_blog_cats",
                    "value" => "",
                    "description" => ""
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Show blog posts?", "js_composer"),
                    "param_name" => "show_posts",
                    "value" => $yes_no_arr,
                    "description" => ""
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Title for blog posts","hook"),
                    "param_name" => "txt_posts",
                    "value" => "",
                    "description" => ""
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Show portfolio posts?", "js_composer"),
                    "param_name" => "show_port_posts",
                    "value" => $yes_no_arr,
                    "description" => ""
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Title for portfolio posts","hook"),
                    "param_name" => "txt_port_posts",
                    "value" => "",
                    "description" => ""
                ),
                $add_el_class,
            )
        ));
        if (class_exists('Easy_Custom_Facebook_Feed_Widget')) {
            //SAMPLE FEED SHORTCODE - VERSION 4.3.2
            //[efb_feed fanpage_url="YOUR_FB_FANPAGE_NAME_OR_URL" layout="CHOSE_LAYOUT(thumbnail/half/full)" image_size="CHOSE_IMAGE_SIZE(thumbnail/album/normal)" type="CHOSE_TYPE(page/group)" post_by="DISPLAY_POSTS_FROM(me/others/onlyothers)" show_logo="SHOW_HIDE_PAGE_LOGO(1/0)" show_image="SHOW_HIDE_IMAGES(1/0)" show_like_box="SHOW_HIDE_LIKEBOX(1/0)" links_new_tab="OPEN_LINKS_IN_EXTERNAL_TAB(1/0)" post_number="NUMBER_OF_POST_DISPALAY(10)" post_limit="NUMBER_OF_POST_RETRIEVE(10)" cache_unit="NUMMBER_OF_MINUTES_HOURS_DAYS(1)" cache_duration="SELECT_CACHE_DURATION(minutes/hours/days)"]

            vc_map( array(
                "name" => esc_html__("Facebook Custom Feed",'hook'),
                "base" => "prk_efb_feed",
                "class" => "hook_scodes_editor",
                "icon" => "icon-wpb-balloon-facebook-left",
                "description" => esc_html__('Easy Facebook Posts', 'hook'),
                "category" => esc_html__('Feeds','hook'),
                "params" => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __( 'Facebook Page URL', 'hook' ),
                        'param_name' => 'fanpage_url',
                        'description' => __( '', 'hook' ),
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__("Layout", 'hook'),
                        "param_name" => "layout",
                        "value" => array(
                            esc_html__("Grid", 'hook') => "thumbnail",
                            esc_html__("Half", 'hook') => "half",
                            esc_html__("Full", 'hook') => "full",
                        ),
                        "description" => ""
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__("Image size", 'hook'),
                        "param_name" => "image_size",
                        "value" => array(
                            esc_html__("Thumbnail", 'hook') => "thumbnail",
                            esc_html__("Album", 'hook') => "album",
                            esc_html__("Normal", 'hook') => "normal",
                        ),
                        "description" => ""
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__("Type", 'hook'),
                        "param_name" => "type",
                        "value" => array(
                            esc_html__("Page", 'hook') => "page",
                            esc_html__("Group", 'hook') => "group",
                        ),
                        "description" => ""
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__("Display posts from", 'hook'),
                        "param_name" => "post_by",
                        "value" => array(
                            esc_html__("Me", 'hook') => "me",
                            esc_html__("Others", 'hook') => "onlyothers",
                            esc_html__("Me and Others", 'hook') => "others",
                        ),
                        "description" => ""
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__("Show logo", 'hook'),
                        "param_name" => "show_logo",
                        "value" => array(
                            esc_html__("Yes", 'hook') => "1",
                            esc_html__("No", 'hook') => "0",
                        ),
                        "description" => ""
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__("Show images", 'hook'),
                        "param_name" => "show_image",
                        "value" => array(
                            esc_html__("Yes", 'hook') => "1",
                            esc_html__("No", 'hook') => "0",
                        ),
                        "description" => ""
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__("Show like box", 'hook'),
                        "param_name" => "show_like_box",
                        "value" => array(
                            esc_html__("Yes", 'hook') => "1",
                            esc_html__("No", 'hook') => "0",
                        ),
                        "description" => ""
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__("Links open in new tab", 'hook'),
                        "param_name" => "show_image",
                        "value" => array(
                            esc_html__("Yes", 'hook') => "1",
                            esc_html__("No", 'hook') => "0",
                        ),
                        "description" => ""
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Number of posts to display", 'hook'),
                        "param_name" => "post_number",
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __( 'Cache: number of minutes/hours/days', 'hook' ),
                        'param_name' => 'cache_unit',
                        'description' => __( '', 'hook' ),
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__("Cache unit", 'hook'),
                        "param_name" => "cache_duration",
                        "value" => array(
                            esc_html__("Minutes", 'hook') => "minutes",
                            esc_html__("Hours", 'hook') => "hours",
                            esc_html__("Days", 'hook') => "days",
                        ),
                        "description" => "",
                    ),
                    $add_css_animation,
                    $add_css_delay,
                    $add_el_class,
                )
            ));
        }
        if (defined('HOOK_WOO_ON')) {

        }
        else {
            if (is_plugin_active('woocommerce/woocommerce.php')) {
                define('HOOK_WOO_ON',true);
            }
            else {
                define('HOOK_WOO_ON',false);
            }
        }
        if (HOOK_WOO_ON=="true") {
            //SINGLE PRODUCT
            vc_map( array(
                "name" => esc_html__("WooCommerce Single Product","hook"),
                "base" => "prk_woo_single",
                "class" => "hook_scodes_editor",
                "icon" => "icon-wpb-woocommerce",
                "description" => esc_html__('Show a single product', 'js_composer'),
                "category" => esc_html__('Feeds',"hook"),
                "params" => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __( 'Product ID or SKU', 'js_composer' ),
                        'param_name' => 'id',
                        'description' => __( '', 'js_composer' ),
                    ),
                    $add_css_animation,
                    $add_css_delay,
                    $add_el_class,
                )
            ));
            //FEATURED PRODUCTS
            vc_map( array(
                "name" => esc_html__("WooCommerce Products Slider","hook"),
                "base" => "prk_woo_featured",
                "class" => "hook_scodes_editor",
                "icon" => "icon-wpb-woocommerce",
                "description" => esc_html__('Show featured products in style', 'js_composer'),
                "category" => esc_html__('Feeds',"hook"),
                "params" => array(
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__("Order", "js_composer"),
                        "param_name" => "order_by",
                        "value" => array(
                            esc_html__("Best selling", "js_composer") => "best_sellers",
                            esc_html__("Date added", "js_composer") => "date",
                            esc_html__("Rating", "js_composer") => "rating",
                            esc_html__("On sale only", "js_composer") => "sale_only"),
                        "description" => ""
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__("Appearance", "js_composer"),
                        "param_name" => "general_style",
                        "value" => array(
                            esc_html__("Classic style - show products across multiple rows and columns", "js_composer") => "classic",
                            esc_html__("Slider style - show all products in a single row with navigation arrows", "js_composer") => "slider"),
                        "description" => ""
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => esc_html__("Number of products to be displayed","hook"),
                        "param_name" => "items_number",
                        "value" => "",
                        "description" => esc_html__("Optional - default is 8","hook")
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => esc_html__("Number of columns","hook"),
                        "param_name" => "columns",
                        "value" => "3",
                        "description" => esc_html__("Optional - default is 4","hook")
                    ),
                    $add_css_animation,
                    $add_css_delay,
                    $add_el_class,
                )
            ));
            //WIDGET PRODUCTS
            vc_map(array(
                "name" => esc_html__("WooCommerce Products Widget","hook"),
                "base" => "prk_woo_widget",
                "class" => "hook_scodes_editor",
                "icon" => "icon-wpb-woocommerce",
                "description" => esc_html__('Show best selling products in style', 'js_composer'),
                "category" => esc_html__('Feeds',"hook"),
                "params" => array(
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__("Order", "js_composer"),
                        "param_name" => "order_by",
                        "value" => array(
                            esc_html__("Best selling", "js_composer") => "best_sellers",
                            esc_html__("Date added", "js_composer") => "date",
                            esc_html__("Rating", "js_composer") => "rating",
                            esc_html__("On sale only", "js_composer") => "sale_only"),
                        "description" => ""
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => esc_html__("Number of products to be displayed","hook"),
                        "param_name" => "items_number",
                        "value" => "",
                        "description" => esc_html__("Optional - default is 3","hook")
                    ),
                    $add_css_animation,
                    $add_css_delay,
                    $add_el_class,
                )
            ));
        }
    }
}


