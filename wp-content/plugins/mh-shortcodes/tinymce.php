<?php

if ( ! defined( 'ABSPATH' ) )
    exit;

if ( ! class_exists( '_WP_Editors', false ) )
    require( ABSPATH . WPINC . '/class-wp-editor.php' );

function mhsc_shortcodes_tiny_translation() {
    $strings = array(
				'mhsc-title' => 'الأكواد السريعة',
				'button' => 'زر',
				'addbutton' => 'أضف زر',
				'href' => 'الرابط',
				'button_text'  => 'النص الظاهر على الزر',
				'exabtn' => 'أنا زر اضغطني',
				'btntitle' => 'عنوان الزر',
				'tip-btntitle' => 'العنوان الخاص بالـ HTML title',
				'color' => 'اللون',
				'txcolor' => 'لون النص',
				'target' => 'حالة الرابط',
				'self' => 'فتح في نفس النافذة',
				'blank' => 'فتح في نافذة جديدة',
				'shape' => 'شكل الزر',
				'fullcolor' => 'لون كامل',
				'transparent' => 'شفاف',
				'size' => 'الحجم',
				'regular' => 'متوسط',
				'small' => 'صغير',
				'large' => 'كبير',
				'fwidth' => 'عرض كامل',
				'true' => 'نعم',
				'false' => 'لا',
				'marker' => 'نص محدد',
				'text' => 'النص',
				'exa' => 'اكتب النص هنا',
				'yellow' => 'أصفر',
				'green' => 'أخضر',
				'pink' => 'فوشي',
				'orange' => 'برتقالي',
				'dark' => 'غامق',
				'light' => 'فاتح',
				'alert' => 'مربع نصي',
				'title' => 'العنوان',
				'blue' => 'أزرق',
				'gray' => 'رمادي',
				'red' => 'أحمر',
				'showclose' => 'إظهار زر الإغلاق',
				'separator' => 'فاصل',
				'tip-separator01' => 'ضع القيمة الرقمية فقط لسماكة الخط الفاصل- القيمة ستكون بالبكسل',			
				'tip-separator02' => 'إن كنت ترغب بفاصل شفاف اترك هذه الخانة فارغة، أو ضع كود اللون المرغوب مثل #333333',	
				'link' => 'رابط',
				'addlink' => 'أضف رابط',
				'link_text'  => 'نص الرابط',
				'linktitle' => 'عنوان الرابط',
				'clearfix' => 'أداة clearfix',
    );

    $locale = _WP_Editors::$mce_locale;
    $translated = 'tinyMCE.addI18n("' . $locale . '.mhtinylang", ' . json_encode( $strings ) . ");\n";

    return $translated;
}

$strings = mhsc_shortcodes_tiny_translation();