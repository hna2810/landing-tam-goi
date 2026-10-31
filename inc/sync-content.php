<?php
/**
 * Auto-sync Landing Page Content and Repeaters into ACF Options & WordPress Database
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Helper to sideload an external image into WordPress Media Library
 *
 * @param string $url  Image URL.
 * @param string $desc Image description/title.
 * @return int Attachment ID on success, 0 on failure.
 */
function lx_sideload_theme_image($url, $desc = '') {
    if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
        return 0;
    }

    if (!function_exists('media_sideload_image')) {
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';
    }

    global $wpdb;
    $existing = $wpdb->get_var($wpdb->prepare(
        "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_lx_source_url' AND meta_value = %s LIMIT 1",
        $url
    ));
    if ($existing && get_post($existing)) {
        return (int) $existing;
    }

    $id = media_sideload_image($url, 0, $desc, 'id');
    if (!is_wp_error($id) && $id > 0) {
        update_post_meta($id, '_lx_source_url', $url);
        return (int) $id;
    }

    return 0;
}

/**
 * Helper to import a local theme image into WordPress Media Library
 *
 * @param string $file_path Absolute path to local file.
 * @param string $desc      Description.
 * @return int Attachment ID on success, 0 on failure.
 */
function lx_import_local_theme_image($file_path, $desc = '') {
    if (!file_exists($file_path)) {
        return 0;
    }

    $filename = basename($file_path);
    global $wpdb;
    $existing = $wpdb->get_var($wpdb->prepare(
        "SELECT ID FROM $wpdb->posts WHERE post_type = 'attachment' AND post_title = %s LIMIT 1",
        pathinfo($filename, PATHINFO_FILENAME)
    ));
    if ($existing) {
        return (int) $existing;
    }

    $upload_dir = wp_upload_dir();
    $target_file = $upload_dir['path'] . '/' . $filename;
    copy($file_path, $target_file);

    $filetype = wp_check_filetype($filename, null);
    $attachment = array(
        'post_mime_type' => $filetype['type'],
        'post_title'     => sanitize_file_name(pathinfo($filename, PATHINFO_FILENAME)),
        'post_content'   => '',
        'post_status'    => 'inherit'
    );
    $attach_id = wp_insert_attachment($attachment, $target_file);
    if (!function_exists('wp_generate_attachment_metadata')) {
        require_once ABSPATH . 'wp-admin/includes/image.php';
    }
    $attach_data = wp_generate_attachment_metadata($attach_id, $target_file);
    wp_update_attachment_metadata($attach_id, $attach_data);
    return (int) $attach_id;
}

/**
 * Sync all landing page default content into ACF Options
 *
 * @param bool $force Whether to force rewrite all fields.
 * @return void
 */
function lx_sync_tam_goi_landing_content($force = false) {
    $current_version = get_option('lx_tam_goi_content_sync_ver', '');
    $target_version  = '1.3.4';

    if (!$force && $current_version === $target_version && !isset($_GET['lx_force_sync'])) {
        return;
    }

    $theme_dir = defined('LX_THEME_DIR') ? LX_THEME_DIR : get_template_directory();

    // 1. SCALAR TEXT & EMAIL FIELDS: name => array(val, key)
    $scalars = array(
        'topbar_text'              => array('🚚 <b>FREESHIP TOÀN QUỐC</b> · Ưu đãi kết thúc sau', 'field_topbar_text'),
        'header_logo_text'         => array('Home Care', 'field_header_logo_text'),
        'header_logo_sub'          => array('SINCE 2008 · MÂY MÂY', 'field_header_logo_sub'),
        'header_cta_text'          => array('Đặt hàng ngay', 'field_header_cta_text'),
        'header_cta_link'          => array('#dat-hang', 'field_header_cta_link'),
        'order_email'              => array('danghuy.homecare@gmail.com', 'field_order_email'),
        'hotline'                  => array('0962131515', 'field_sticky_phone'),

        'hero_title'               => array("Tóc mọc tua tủa,<br>da sạch mịn màng", 'field_hero_title'),
        'hero_subtitle'            => array('<b>Bộ đôi Sữa tắm &amp; Dầu gội Gừng Nghệ Mây Mây</b>', 'field_hero_subtitle'),
        'hero_callout'             => array('👉 Được sử dụng trong dịch vụ chăm sóc bầu, sau sinh của Home Care trên khắp 3 miền Bắc - Trung - Nam', 'field_hero_callout'),
        'hero_price_label'         => array('Combo dầu gội + sữa tắm', 'field_hero_price_label'),
        'hero_price'               => array('99K', 'field_hero_price'),
        'hero_price_note'          => array('Freeship toàn quốc', 'field_hero_price_note'),
        'hero_price_tag'           => array('FREE<br>SHIP', 'field_hero_price_tag'),
        'hero_cta_primary_text'    => array('FREESHIP TOÀN QUỐC - MUA NGAY!', 'field_hero_cta_primary_text'),
        'hero_cta_primary_link'    => array('#dat-hang', 'field_hero_cta_primary_link'),
        'hero_cta_secondary_text'  => array('Set quà 20/11', 'field_hero_cta_secondary_text'),
        'hero_cta_secondary_link'  => array('#qua-20-11', 'field_hero_cta_secondary_link'),

        'pain_title'               => array("Mái tóc & làn da đang làm bạn kém tự tin mỗi ngày?", 'field_pain_title'),
        'pain_lead'                => array("Tóc gãy rụng từng búi sau mỗi lần gội, da lưng lấm tấm mụn ngứa gây khó chịu?", 'field_pain_lead'),
        'pain_hair_h'              => array('Mái tóc', 'field_pain_hair_h'),
        'pain_skin_h'              => array('Làn da cơ thể', 'field_pain_skin_h'),
        'pain_cause_h'             => array('NGUYÊN NHÂN DO ĐÂU?', 'field_pain_cause_h'),
        'pain_cause_p'             => array('Làn da và da đầu tiếp xúc với bụi bẩn môi trường, sự thay đổi nội tiết tố hoặc do sử dụng các sản phẩm làm sạch có chất tẩy rửa quá mạnh, làm mất đi độ ẩm tự nhiên.', 'field_pain_cause_p'),
        'pain_cta_p'               => array('👉👉 Đừng để những lo âu kéo dài làm ảnh hưởng đến diện mạo và tâm trạng của bạn. Khám phá ngay <b>Bộ đôi chăm sóc chuyên sâu từ Gừng &amp; Nghệ</b> – Làm sạch dịu nhẹ, cân bằng độ ẩm và phục hồi sức sống tự nhiên cho mái tóc &amp; làn da.', 'field_pain_cta_p'),
        'pain_cta_link'            => array('#san-pham', 'field_pain_cta_link'),

        'ba_eyebrow'               => array('Hình ảnh trực quan (Trước & Sau khi sử dụng)', 'field_ba_eyebrow'),
        'ba_title'                 => array("Phục hồi mái tóc bồng bềnh, sạch gàu ngứa và nuôi dưỡng làn da cơ thể mịn màng cùng Bộ đôi Tắm Gội Gừng Nghệ Mây Mây", 'field_ba_title'),
        'ba_lead'                  => array('Công thức độc quyền từ tinh hoa thảo mộc Gừng, Nghệ', 'field_ba_lead'),
        'tab1_name'                => array('Dầu Gội Gừng Nghệ Mây Mây', 'field_tab1_name'),
        'tab1_quote'               => array('“Tóc mọc tua tủa – Kích mở nang tóc”', 'field_tab1_quote'),
        'tab2_name'                => array('Sữa Tắm Gừng Nghệ Mây Mây', 'field_tab2_name'),
        'tab2_quote'               => array('“Da sạch, mềm mịn, mờ thâm”', 'field_tab2_quote'),

        'story_eyebrow'            => array('Câu chuyện Mây Mây', 'field_story_eyebrow'),
        'story_title'              => array("Từ tinh hoa cỏ cây Việt<br>đến từng giọt gội", 'field_story_title'),
        'story_quote'              => array('“Mẹ bầu, mẹ sau sinh xứng đáng được chăm sóc bằng những gì dịu lành nhất – như cách bà, mẹ ta vẫn đun nồi nước gừng, nước bưởi ngày xưa.”', 'field_story_quote'),
        'story_lead'               => array('Hơn 15 năm đồng hành cùng mẹ và bé, Home Care chọn gừng, nghệ, bưởi – những thảo dược quen thuộc của người Việt – để làm nên bộ tắm gội Mây Mây: sạch dịu, an tâm cho cả gia đình.', 'field_story_lead'),

        'proc_eyebrow'             => array('Tận mắt quy trình', 'field_proc_eyebrow'),
        'proc_title'               => array('Từ nồi thảo dược đến tay bạn', 'field_proc_title'),
        'proc_lead'                => array('Không giấu giếm – xem trọn quy trình đun nấu, chiết lọc và đóng chai dầu gội, sữa tắm Gừng Nghệ Mây Mây.', 'field_proc_lead'),
        'proc_video'               => array('', 'field_proc_video'),
        'proc_video_title'         => array('Hành trình đun nấu Gừng Nghệ Mây Mây', 'field_proc_video_title'),
        'proc_video_desc'          => array('Từ chọn nguyên liệu, nấu chiết thảo dược đến khi thành chai dầu gội, sữa tắm.', 'field_proc_video_desc'),

        'steps_eyebrow'            => array('Cách dùng', 'field_steps_eyebrow'),
        'steps_title'              => array('3 Bước để tóc sạch, da thơm mỗi ngày cùng bộ đôi Tắm Gội Gừng Nghệ', 'field_steps_title'),

        'clear_eyebrow'            => array('Minh bạch – rõ nguồn gốc', 'field_clear_eyebrow'),
        'clear_title'              => array('An tâm sử dụng với thông tin minh bạch, rõ ràng', 'field_clear_title'),
        'clear_lead'               => array('Dầu gội và sữa tắm Gừng Nghệ Mây Mây đều có phiếu công bố sản phẩm mỹ phẩm, tem chống hàng giả Bộ Công An và thông tin trên hệ thống Mã số Mã vạch Quốc gia.', 'field_clear_lead'),
        'clear_cap'                => array('Đã được Sở Y tế tiếp nhận phiếu công bố mỹ phẩm', 'field_clear_cap'),

        'rev_eyebrow'              => array('Khách hàng nói gì', 'field_rev_eyebrow'),
        'rev_title'                => array('Thư viện hàng ngàn feedback chân thực', 'field_rev_title'),
        'rev_stat_1'               => array('⭐⭐⭐⭐⭐ 4.9/5 sao dựa trên hơn 2.500+ đánh giá thực tế.', 'field_rev_stat_1'),
        'rev_stat_2'               => array('📊 98% đánh giá phản hồi tóc bớt gãy rụng, kích thích mọc tóc và giảm thâm mụn lưng', 'field_rev_stat_2'),

        'shorts_eyebrow'           => array('Video ngắn', 'field_shorts_eyebrow'),
        'shorts_title'             => array("Khách hàng & hậu trường<br>trong 60 giây", 'field_shorts_title'),
        'shorts_tiktok'            => array('https://tiktok.com', 'field_shorts_tiktok'),
        'shorts_youtube'           => array('https://youtube.com', 'field_shorts_youtube'),

        'combo_title'              => array('Combo ưu đãi trải nghiệm', 'field_combo_title'),

        'gift_eyebrow'             => array('Mùa tri ân 20/11', 'field_gift_eyebrow'),
        'gift_title'               => array("Gửi thầy cô một món quà<br>chăm sóc từ thảo mộc", 'field_gift_title'),
        'gift_lead'                => array('Thay lời tri ân sâu sắc gửi đến những người lái đò thầm lặng bằng bộ quà tặng từ thảo mộc tự nhiên, gói trọn sự ấm áp và chân thành.', 'field_gift_lead'),
        'gift_count_note'          => array('Đặt trước <b>17/11</b> để nhận quà kịp ngày 20/11', 'field_gift_count_note'),

        'order_title'              => array('Lấy lại mái tóc bồng bềnh & làn da mịn màng ngay hôm nay!', 'field_order_title'),
        'order_lead'               => array('Điền thông tin – Home Care gọi xác nhận trong 15 phút (giờ hành chính). Thanh toán khi nhận hàng.', 'field_order_lead'),

        'faq_eyebrow'              => array('Hỏi đáp', 'field_faq_eyebrow'),
        'faq_title'                => array('Giải đáp câu hỏi thường gặp', 'field_faq_title'),

        'letter_title'             => array("MÂY MÂY -<br>TÓC SẠCH, DA THƠM", 'field_letter_title'),
        'letter_body'              => array("Trải qua ba lần sinh nở trước tuổi 30, chị Mai hiểu rằng, hành trình làm mẹ không chỉ có niềm vui đón con mà còn là những tháng ngày người mẹ cần được chăm sóc và nâng niu.\n\nTừ kiến thức chuyên môn và nhiều năm tháng đồng hành cùng các thai phụ & sản phụ, chị Mai tìm về những bí quyết chăm sóc bí truyền với các nguyên liệu thân thuộc từ gừng, nghệ và thảo mộc. Nhưng việc chuẩn bị cầu kỳ mỗi ngày khiến chị trăn trở về phương pháp chăm sóc mẹ thuận tiện hơn.\n\nTừ đó, chị Mai đã tạo nên Mây Mây – thương hiệu chăm sóc mẹ từ tinh hoa thảo mộc, mong muốn mang đến những sản phẩm gần gũi, giúp mẹ chăm sóc tóc và làn da dễ dàng hơn trong kỳ ở cữ.", 'field_letter_body'),
        'letter_hl'                => array('Bởi chị hiểu, sau những tháng ngày dành trọn yêu thương cho con, mẹ cũng xứng đáng được chăm sóc và yêu thương chính mình.', 'field_letter_hl'),
        'letter_voice'             => array('', 'field_letter_voice'),

        'footer_logo'              => array('Home Care', 'field_footer_logo'),
        'footer_text'              => array("Đẹp và Thật · Since 2008<br>Tổng đài 1900 0387 · Hotline 0962 131 515 – 0973 871 376", 'field_footer_text'),
        'sticky_phone'             => array('0962131515', 'field_sticky_phone'),
        'sticky_price'             => array('99K', 'field_sticky_price'),
        'sticky_desc'              => array('Combo dầu gội + sữa tắm · Freeship', 'field_sticky_desc'),
        'sticky_btn_text'          => array('Đặt ngay', 'field_sticky_btn_text'),
        'sticky_btn_link'          => array('#dat-hang', 'field_sticky_btn_link'),
        'ing_eyebrow'       => array('CÔNG THỨC ĐỘC QUYỀN HOME CARE', 'field_ing_eyebrow'),
        'ing_title'         => array('Sự kết hợp hoàn hảo của các thành phần thảo mộc và dưỡng chất vàng', 'field_ing_title'),
        'ing_lead'          => array('Sự giao thoa trọn vẹn giữa bí quyết thảo mộc cổ truyền và các dưỡng chất khoa học chuyên sâu, mang lại hiệu quả phục hồi tóc và nuôi dưỡng làn da tối ưu.', 'field_ing_lead'),
    );

    foreach ($scalars as $name => $data) {
        $val = $data[0];
        $key = $data[1];
        $opt_key = 'options_' . $name;
        $existing = get_option($opt_key, '__NOT_SET__');

        if ($force || $existing === '__NOT_SET__') {
            update_option($opt_key, $val);
            update_option('_' . $opt_key, $key);
            if (function_exists('update_field')) {
                update_field($key, $val, 'option');
            }
        }
    }

    // 2. IMAGE FIELDS: name => array(url_or_path, key)
    $images = array(
        'hero_image'        => array('https://cdn.hstatic.net/products/200001066686/combo-sua-tam-dau-goi-gung-nghe-may-may_37c9f5a7dbe9474d82a53a57c114c033.png', 'field_hero_image'),
        'pain_center_img'   => array($theme_dir . '/assets/images/skin-body.webp', 'field_pain_center_img'),
        'pain_badge_img'    => array('https://cdn.hstatic.net/products/200001066686/dau-goi-gung-nghe-may-may-300ml_976748158c9548e5a917d6f1037d2dbe.png', 'field_pain_badge_img'),
        'story_img_1'       => array('https://cdn.hstatic.net/products/200001066686/nuoc-u-toc-tu-gung_39ddc7514164454692cfd14d198b8458.jpg', 'field_story_img_1'),
        'story_img_2'       => array('https://cdn.hstatic.net/products/200001066686/nuoc-u-toc-bang-gung-tuoi-homecare_b083a03618e0411081b79ca35482e003.jpg', 'field_story_img_2'),
        'proc_video_thumb'  => array('https://cdn.hstatic.net/products/200001066686/nuoc-u-toc-tu-gung_39ddc7514164454692cfd14d198b8458.jpg', 'field_proc_video_thumb'),
        'clear_img_1'       => array('https://cdn.hstatic.net/products/200001066686/scb-dau-goi-gung-nghe_b1a448ecb88540ea96a76760844ae7f8.png', 'field_clear_img_1'),
        'clear_img_2'       => array('https://cdn.hstatic.net/products/200001066686/scb-sua-tam-gung-nghe_5328535177694ee6960a310a4cb94ac8.png', 'field_clear_img_2'),
        'letter_mascot'     => array('https://cdn.hstatic.net/products/200001066686/combo-sua-tam-dau-goi-gung-nghe-may-may_37c9f5a7dbe9474d82a53a57c114c033.png', 'field_letter_mascot'),
        'gift_mobile_img'   => array($theme_dir . '/assets/images/real/gift-box-mobile.jpg', 'field_gift_mobile_img'),
        'tab1_img'          => array($theme_dir . '/assets/images/real/prod-dau-goi.jpg', 'field_tab1_img'),
        'tab2_img'          => array($theme_dir . '/assets/images/real/prod-sua-tam.jpg', 'field_tab2_img'),
        'tab1_shot_1'       => array('https://tamgoigungnghe.homecarevietnam.com/wp-content/uploads/2026/10/feedback-dau-goi-gung-nghe-1.png', 'field_tab1_shot_1'),
        'tab1_shot_2'       => array('https://tamgoigungnghe.homecarevietnam.com/wp-content/uploads/2026/10/feedback-dau-goi-gung-nghe-2.jpg', 'field_tab1_shot_2'),
        'tab1_shot_3'       => array('https://tamgoigungnghe.homecarevietnam.com/wp-content/uploads/2026/10/feedback-dau-goi-gung-nghe-3.png', 'field_tab1_shot_3'),
        'tab2_shot_1'       => array('https://tamgoigungnghe.homecarevietnam.com/wp-content/uploads/2026/10/feedback-sua-tam-gung-nghe-1.png', 'field_tab2_shot_1'),
        'tab2_shot_2'       => array('https://tamgoigungnghe.homecarevietnam.com/wp-content/uploads/2026/10/feedback-sua-tam-gung-nghe-2.png', 'field_tab2_shot_2'),
        'tab2_shot_3'       => array('https://tamgoigungnghe.homecarevietnam.com/wp-content/uploads/2026/10/feedback-sua-tam-gung-nghe-3.png', 'field_tab2_shot_3'),
    );

    $attach_cache = array();

    foreach ($images as $img_name => $data) {
        $img_src = $data[0];
        $img_key = $data[1];
        $opt_key = 'options_' . $img_name;
        $existing = get_option($opt_key, '__NOT_SET__');

        if ($force || $existing === '__NOT_SET__' || empty($existing)) {
            $att_id = 0;
            if (isset($attach_cache[$img_src])) {
                $att_id = $attach_cache[$img_src];
            } else {
                if (file_exists($img_src)) {
                    $att_id = lx_import_local_theme_image($img_src, $img_name);
                } elseif (filter_var($img_src, FILTER_VALIDATE_URL)) {
                    $att_id = lx_sideload_theme_image($img_src, $img_name);
                }
                if ($att_id > 0) {
                    $attach_cache[$img_src] = $att_id;
                }
            }

            $final_val = ($att_id > 0) ? $att_id : $img_src;
            update_option($opt_key, $final_val);
            update_option('_' . $opt_key, $img_key);
            if (function_exists('update_field')) {
                update_field($img_key, $final_val, 'option');
            }
        }
    }

    // 3. REPEATER FIELDS WITH EXACT SUBFIELD KEYS
    $repeaters = array(
        'header_menu' => array(
            'key' => 'field_header_menu',
            'subs' => array('label' => 'field_menu_label', 'link' => 'field_menu_link'),
            'rows' => array(
                array('label' => 'Sản phẩm', 'link' => '#san-pham'),
                array('label' => 'Quy trình', 'link' => '#quy-trinh'),
                array('label' => 'Review', 'link' => '#review'),
                array('label' => 'Quà 20/11', 'link' => '#qua-20-11'),
                array('label' => 'Hỏi đáp', 'link' => '#hoi-dap'),
            ),
        ),
        'hero_benefits' => array(
            'key' => 'field_hero_benefits',
            'subs' => array('text' => 'field_benefit_text'),
            'rows' => array(
                array('text' => 'Giảm rụng, kích mọc tóc'),
                array('text' => 'Sạch gàu, hết ngứa'),
                array('text' => 'Hỗ trợ mờ mụn lưng'),
                array('text' => 'Dùng được cho mẹ bầu & mẹ sau sinh'),
            ),
        ),
        'hero_trust_items' => array(
            'key' => 'field_hero_trust_items',
            'subs' => array('icon' => 'field_trust_icon', 'text' => 'field_trust_text'),
            'rows' => array(
                array('icon' => 'i-hosp', 'text' => 'Có mặt tại nhà thuốc, bệnh viện, phòng khám'),
                array('icon' => 'i-bar', 'text' => 'Có trên hệ thống Mã số Mã vạch Quốc gia'),
                array('icon' => 'i-shield', 'text' => 'Tem chống hàng giả Bộ Công An'),
                array('icon' => 'i-pen', 'text' => 'Đã công bố mỹ phẩm – Sở Y tế cấp số'),
            ),
        ),
        'pain_hair_items' => array(
            'key' => 'field_pain_hair_items',
            'subs' => array('title' => 'field_pain_hair_item_title', 'desc' => 'field_pain_hair_item_desc'),
            'rows' => array(
                array('title' => 'Tóc gãy rụng', 'desc' => 'Mỗi lần chải hay gội đầu, tóc gãy rụng vón thành từng búi khiến mái tóc ngày càng thưa.'),
                array('title' => 'Gàu ngứa dai dẳng', 'desc' => 'Da đầu nhanh bết dính, xuất hiện vảy gàu kèm cơn ngứa ngáy dữ dội, đặc biệt là khi thời tiết thay đổi.'),
                array('title' => 'Tóc khô xơ, hư tổn', 'desc' => 'Sợi tóc xơ xác, chẻ ngọn, thiếu sức sống do tác động từ hóa chất, uốn nhuộm hoặc thay đổi nội tiết tố.'),
            ),
        ),
        'pain_skin_items' => array(
            'key' => 'field_pain_skin_items',
            'subs' => array('title' => 'field_pain_skin_item_title', 'desc' => 'field_pain_skin_item_desc'),
            'rows' => array(
                array('title' => 'Mụn lưng, mụn ngực', 'desc' => 'Lỗ chân lông bít tắc do bã nhờn và mồ hôi gây ngứa, sinh ra mụn đỏ, mụn viêm.'),
                array('title' => 'Da thô ráp, thiếu ẩm', 'desc' => 'Sau khi tắm, làn da bị khô căng, nứt nẻ và kém mịn màng.'),
                array('title' => 'Vết thâm kéo dài', 'desc' => 'Lưng, ngực chằng chịt thâm mụn khiến bạn mất đi sự tự tin khi diện những trang phục yêu thích.'),
            ),
        ),
        'tab1_bad_items' => array(
            'key' => 'field_tab1_bad_items',
            'subs' => array('text' => 'field_tab1_bad_text'),
            'rows' => array(
                array('text' => 'Tóc rụng từng nắm mỗi lần gội/chải, vuốt nhẹ cũng rụng.'),
                array('text' => 'Da đầu gàu ngứa, nhanh bết dính dù mới gội.'),
                array('text' => 'Mái tóc khô xơ, chẻ ngọn, lộ rõ da đầu mỏng.'),
            ),
        ),
        'tab1_good_items' => array(
            'key' => 'field_tab1_good_items',
            'subs' => array('text' => 'field_tab1_good_text'),
            'rows' => array(
                array('text' => 'Giảm rụng tóc, nang tóc chắc khỏe.'),
                array('text' => 'Da đầu sạch thoáng, hết ngứa.'),
                array('text' => 'Tóc con mọc tua tủa sau 2–4 tuần sử dụng.'),
            ),
        ),
        'tab2_bad_items' => array(
            'key' => 'field_tab2_bad_items',
            'subs' => array('text' => 'field_tab2_bad_text'),
            'rows' => array(
                array('text' => 'Mụn lưng, viêm nang lông sần sùi ngứa ngáy.'),
                array('text' => 'Vết thâm mụn chi chít khắp lưng và ngực.'),
                array('text' => 'Da khô ráp, bong tróc và thiếu ẩm.'),
            ),
        ),
        'tab2_good_items' => array(
            'key' => 'field_tab2_good_items',
            'subs' => array('text' => 'field_tab2_good_text'),
            'rows' => array(
                array('text' => 'Mụn lưng lặn dần, giảm viêm rõ rệt.'),
                array('text' => 'Mờ thâm mụn, da đều màu và sáng mịn.'),
                array('text' => 'Cấp ẩm sâu, da mềm mượt không còn khô căng.'),
            ),
        ),
        'story_stats' => array(
            'key' => 'field_story_stats',
            'subs' => array('num' => 'field_stat_num', 'suffix' => 'field_stat_suffix', 'text' => 'field_stat_text'),
            'rows' => array(
                array('num' => '2008', 'suffix' => '', 'text' => 'Thành lập Home Care'),
                array('num' => '3', 'suffix' => '', 'text' => 'Dung tích linh hoạt'),
                array('num' => '100', 'suffix' => '%', 'text' => 'Tem chính hãng'),
            ),
        ),
        'proc_flow_steps' => array(
            'key' => 'field_proc_flow_steps',
            'subs' => array('num' => 'field_pstep_num', 'title' => 'field_pstep_title', 'desc' => 'field_pstep_desc', 'img' => 'field_pstep_img'),
            'rows' => array(
                array('num' => '01', 'title' => 'Vùng nguyên liệu tuyển chọn', 'desc' => 'Gừng sẻ, nghệ vàng được thu hoạch từ vùng trồng đạt chuẩn, rửa sạch và phân loại kỹ càng.', 'img' => 'https://cdn.hstatic.net/products/200001066686/nguyen-lieu-gung-nghe_aa75eb4c00f54ed7bda0abe067db2800.jpg'),
                array('num' => '02', 'title' => 'Sơ chế & rửa sạch', 'desc' => 'Nấu chậm theo phương pháp truyền thống kết hợp công nghệ hiện đại, giữ trọn tinh chất quý.', 'img' => 'https://cdn.hstatic.net/products/200001066686/nuoc-u-toc-bang-gung-tuoi-homecare_b083a03618e0411081b79ca35482e003.jpg'),
                array('num' => '03', 'title' => 'Đun nấu chiết xuất', 'desc' => 'Màu nâu vàng tự nhiên của gừng nghệ, kết cấu sánh quyện giàu dưỡng chất nuôi tóc.', 'img' => 'https://cdn.hstatic.net/products/200001066686/nuoc-u-toc-tu-gung_39ddc7514164454692cfd14d198b8458.jpg'),
                array('num' => '04', 'title' => 'Lọc & đóng chai', 'desc' => 'Đóng gói vô trùng, dán tem chống hàng giả Bộ Công An, kiểm định an toàn trước khi xuất xưởng.', 'img' => 'https://cdn.hstatic.net/products/200001066686/ch_t_d_u_g_i_g_ng_ngh__m_y_m_y_homecare_98cc876517dc4d9bbb42e1528e91dc58.png'),
                array('num' => '05', 'title' => 'Công bố & tem', 'desc' => 'Sở Y tế tiếp nhận phiếu công bố sản phẩm mỹ phẩm, tem chính hãng.', 'img' => 'https://cdn.hstatic.net/products/200001066686/scb-dau-goi-gung-nghe_b1a448ecb88540ea96a76760844ae7f8.png'),
            ),
        ),
        'steps_items' => array(
            'key' => 'field_steps_items',
            'subs' => array('icon' => 'field_step_icon', 'title' => 'field_step_title', 'desc' => 'field_step_desc'),
            'rows' => array(
                array('icon' => 'i-drop', 'title' => 'Bước 1: Gội đầu', 'desc' => 'Làm ướt tóc bằng nước ấm. Lấy lượng dầu gội vừa đủ, tạo bọt massage nhẹ nhàng 3–5 phút rồi xả sạch.'),
                array('icon' => 'i-leaf', 'title' => 'Bước 2: Tắm sạch body', 'desc' => 'Làm ướt cơ thể, lấy lượng sữa tắm ra lòng bàn tay hoặc bông tắm. Massage kỹ vùng da lưng, ngực trong 2 phút.'),
                array('icon' => 'i-heart', 'title' => 'Bước 3: Xả sạch', 'desc' => 'Tắm lại bằng nước sạch, dùng khăn mềm lau khô nhẹ nhàng để cảm nhận làn da mịn màng và mái tóc bồng bềnh.'),
                array('icon' => 'i-root', 'title' => 'Ủ phục hồi (tuỳ chọn)', 'desc' => 'Tóc khô xơ: thoa nước ủ gừng tươi sau gội, ủ 10–15 phút rồi xả sạch.'),
            ),
        ),
        'rev_gallery' => array(
            'key' => 'field_rev_gallery',
            'subs' => array('img' => 'field_rev_gallery_img'),
            'rows' => array(
                array('img' => 'https://cdn.hstatic.net/products/200001066686/feedback-sua-tam-gung-nghe-may-may_70ad2e7919234d7384635a04cef8f022.png'),
                array('img' => 'https://cdn.hstatic.net/products/200001066686/sua-tam-giam-mun-lung-nguc-gung-nghe_e52b32f1bd2b4aa2a3285e9d07e78545.png'),
                array('img' => 'https://cdn.hstatic.net/products/200001066686/doi-tuong-dung-sua-tam-gung-nghe-may-may_9017f7a260ae4d8b83b10308909a7d54.png'),
                array('img' => 'https://cdn.hstatic.net/products/200001066686/thanh-phan-sua-tam-gung-nghe-may-may_6a0a590666174a74b14cc313dbb61bd7.png'),
            ),
        ),
        'shorts_items' => array(
            'key' => 'field_shorts_items',
            'subs' => array('title' => 'field_short_title', 'sub' => 'field_short_sub', 'src' => 'field_short_src', 'thumb' => 'field_short_thumb', 'video' => 'field_short_video'),
            'rows' => array(
                array('video' => '', 'thumb' => 'https://cdn.hstatic.net/products/200001066686/dau-goi-gung-nghe-may-may-300ml_976748158c9548e5a917d6f1037d2dbe.png', 'src' => 'TikTok', 'title' => 'Gội thử lần đầu – tóc rụng ít hẳn', 'sub' => 'Trải nghiệm dầu gội'),
                array('video' => '', 'thumb' => 'https://cdn.hstatic.net/products/200001066686/dau_goi_gung_nghe_may_may_-_dau_goi_cho_me_bau_va_me_sau_sinh_c85c9e18e5f24a9d93a1c3676d8fe1c8.jpg', 'src' => 'TikTok', 'title' => 'Mẹ bầu tắm gội an tâm mỗi ngày', 'sub' => 'Review mẹ bầu'),
                array('video' => '', 'thumb' => 'https://cdn.hstatic.net/products/200001066686/sua-tam-gung-nghe-may-may-500ml_8029728340d44067aa56b610e29f48ae.png', 'src' => 'Reels', 'title' => 'Tạm biệt mụn lưng sau 3 tuần', 'sub' => 'Trải nghiệm sữa tắm'),
                array('video' => '', 'thumb' => 'https://cdn.hstatic.net/products/200001066686/nuoc-u-toc-bang-gung-tuoi-homecare_b083a03618e0411081b79ca35482e003.jpg', 'src' => 'Shorts', 'title' => 'Đun nấu thảo dược tại xưởng', 'sub' => 'Hậu trường sản xuất'),
                array('video' => '', 'thumb' => 'https://cdn.hstatic.net/products/200001066686/nuoc-u-toc-bang-gung-tuoi_341071304a9d48dab53bca2e5363b41d.png', 'src' => 'TikTok', 'title' => 'Ủ tóc gừng tươi – tóc mềm mượt', 'sub' => 'Tuỳ chọn ủ tóc'),
            ),
        ),
        'combo_items' => array(
            'key' => 'field_combo_items',
            'subs' => array('key' => 'field_combo_key', 'name' => 'field_combo_name', 'desc' => 'field_combo_desc', 'price' => 'field_combo_price', 'img' => 'field_combo_img', 'is_hot' => 'field_combo_is_hot'),
            'rows' => array(
                array('key' => 'trai-nghiem', 'name' => 'Gói Trải Nghiệm', 'desc' => '1 Dầu gội + 1 Sữa tắm Gừng Nghệ + 1 Ủ tóc (300ML)', 'price' => '99K', 'img' => 'https://cdn.hstatic.net/products/200001066686/combo-sua-tam-dau-goi-gung-nghe-may-may_37c9f5a7dbe9474d82a53a57c114c033.png', 'is_hot' => false),
                array('key' => 'ban-chay', 'name' => 'Gói Best Seller', 'desc' => '1 Dầu gội + 1 Sữa tắm Gừng Nghệ + 1 Ủ tóc (500ML)', 'price' => '159k', 'img' => 'https://cdn.hstatic.net/products/200001066686/combo-sua-tam-dau-goi-gung-nghe-may-may_37c9f5a7dbe9474d82a53a57c114c033.png', 'is_hot' => true),
                array('key' => 'sieu-tiet-kiem', 'name' => 'Gói Tiết Kiệm', 'desc' => '1 Dầu gội + 1 Sữa tắm Gừng Nghệ + 1 Ủ tóc (1000ML)', 'price' => '299K', 'img' => 'https://cdn.hstatic.net/products/200001066686/combo-sua-tam-dau-goi-gung-nghe-may-may_37c9f5a7dbe9474d82a53a57c114c033.png', 'is_hot' => false),
            ),
        ),
        'gift_sets' => array(
            'key' => 'field_gift_sets',
            'subs' => array('name' => 'field_gset_name', 'ribbon' => 'field_gset_ribbon', 'img' => 'field_gset_img', 'items' => 'field_gset_items', 'price' => 'field_gset_price', 'data_set' => 'field_gset_data_set'),
            'rows' => array(
                array(
                    'name'     => 'Set Tri Ân 1 (300ml)',
                    'ribbon'   => 'GỢI Ý TẶNG CÔ',
                    'img'      => 'https://tamgoigungnghe.homecarevietnam.com/wp-content/uploads/2026/10/1793430464436_1660716325371320973_g464639762284770803_c84f1f1acbd3517df19d9197c3a68f7c.jpg',
                    'items'    => "1 Dầu gội Gừng Nghệ 300ml\n1 Sữa tắm Gừng Nghệ 300ml\n1 Serum Ủ tóc Gừng Tươi 300ml\n🎁 TẶNG 1 Xịt khử mùi 30ml\n🎁 TẶNG 1 Xịt dưỡng tóc 30ml\n🚚 Miễn phí vận chuyển toàn quốc",
                    'price'    => '199.000đ',
                    'data_set' => 'Set Tri Ân 1 (300ml) – 199.000đ',
                ),
                array(
                    'name'     => 'Set Tri Ân 2 (500ml)',
                    'ribbon'   => '★ BÁN CHẠY NHẤT',
                    'img'      => 'https://tamgoigungnghe.homecarevietnam.com/wp-content/uploads/2026/10/1793430464435_1660716325371320973_g464639762284770803_adbd45abc87877c9b23858367ed8f7a8.jpg',
                    'items'    => "1 Dầu gội Gừng Nghệ 500ml\n1 Sữa tắm Gừng Nghệ 500ml\n1 Serum Ủ tóc Gừng Tươi 500ml\n🎁 TẶNG 1 Xịt khử mùi 100ml\n🎁 TẶNG 1 Dung dịch vệ sinh 200ml\n🚚 Miễn phí vận chuyển toàn quốc",
                    'price'    => '349.000đ',
                    'data_set' => 'Set Tri Ân 2 (500ml) – 349.000đ',
                ),
                array(
                    'name'     => 'Set Cao Cấp (1000ml)',
                    'ribbon'   => 'TRỌN BỘ QUÀ TẶNG',
                    'img'      => 'https://tamgoigungnghe.homecarevietnam.com/wp-content/uploads/2026/10/1793430464437_1660716325371320973_g464639762284770803_b2dfd84335e12bb6b80d167cd9fee953.jpg',
                    'items'    => "1 Dầu gội Gừng Nghệ 1000ml\n1 Sữa tắm Gừng Nghệ 1000ml\n1 Serum Ủ tóc Gừng Tươi 1000ml\n🎁 TẶNG 1 Xịt khử mùi 30ml\n🎁 TẶNG 1 Xịt khử mùi 100ml\n🚚 Miễn phí vận chuyển toàn quốc",
                    'price'    => '499.000đ',
                    'data_set' => 'Set Cao Cấp (1000ml) – 499.000đ',
                ),
            ),
        ),
        'ingredients_items' => array(
            'key' => 'field_ingredients_items',
            'subs' => array('name' => 'field_ing_item_name', 'badge' => 'field_ing_item_badge', 'img' => 'field_ing_item_img', 'highlight' => 'field_ing_item_hl', 'desc' => 'field_ing_item_desc'),
            'rows' => array(
                array(
                    'name'      => 'Gừng tươi',
                    'badge'     => 'Thảo mộc tự nhiên',
                    'img'       => 'https://tamgoigungnghe.homecarevietnam.com/wp-content/themes/landing-tam-goi/assets/images/real/ing-01-gung.jpg',
                    'highlight' => 'Giữ ấm cơ thể · Tuần hoàn máu · Chắc chân tóc',
                    'desc'      => 'Giữ ấm cơ thể, hỗ trợ tăng tuần hoàn máu dưới da đầu, giảm đau nhức và nuôi dưỡng chân tóc chắc khỏe.',
                ),
                array(
                    'name'      => 'Nghệ tươi',
                    'badge'     => 'Thảo mộc tự nhiên',
                    'img'       => 'https://tamgoigungnghe.homecarevietnam.com/wp-content/themes/landing-tam-goi/assets/images/real/ing-02-nghe.jpg',
                    'highlight' => 'Kháng khuẩn · Mờ thâm nám · Chống oxy hóa',
                    'desc'      => 'Kháng khuẩn tự nhiên, hỗ trợ làm mờ vết thâm, làm sáng da và chống oxy hóa cho làn da sau sinh.',
                ),
                array(
                    'name'      => 'Chiết xuất bưởi',
                    'badge'     => 'Thảo mộc tự nhiên',
                    'img'       => 'https://tamgoigungnghe.homecarevietnam.com/wp-content/themes/landing-tam-goi/assets/images/real/ing-03-buoi.jpg',
                    'highlight' => 'Nuôi nang tóc · Kích mọc tóc · Giảm gãy rụng',
                    'desc'      => 'Nuôi dưỡng nang tóc chắc khỏe, kích mọc tóc con, giảm thiểu tình trạng tóc gãy rụng và mang lại hương thơm dễ chịu.',
                ),
                array(
                    'name'      => 'Vitamin B5',
                    'badge'     => 'Dưỡng chất vàng',
                    'img'       => 'https://tamgoigungnghe.homecarevietnam.com/wp-content/themes/landing-tam-goi/assets/images/real/ing-04-vitamin-b5.jpg',
                    'highlight' => 'Cấp ẩm sâu · Phục hồi hư tổn · Tóc bồng bềnh',
                    'desc'      => 'Cung cấp độ ẩm cho tóc và da đầu, phục hồi mái tóc khô xơ, hư tổn, giúp tóc suôn mượt và bồng bềnh.',
                ),
                array(
                    'name'      => 'Vitamin B3',
                    'badge'     => 'Dưỡng chất vàng',
                    'img'       => 'https://tamgoigungnghe.homecarevietnam.com/wp-content/themes/landing-tam-goi/assets/images/real/ing-05-vitamin-b3.jpg',
                    'highlight' => 'Bảo vệ da · Cải thiện đàn hồi · Sáng mịn da',
                    'desc'      => 'Tăng cường hàng rào bảo vệ da, cải thiện độ đàn hồi, làm đều màu da và nuôi dưỡng làn da cơ thể sáng mịn.',
                ),
                array(
                    'name'      => 'Dâu tằm',
                    'badge'     => 'Dưỡng chất vàng',
                    'img'       => 'https://tamgoigungnghe.homecarevietnam.com/wp-content/themes/landing-tam-goi/assets/images/real/ing-06-dau-tam.jpg',
                    'highlight' => 'Làm dịu da · Dưỡng ẩm mịn màng · Chống oxy hóa',
                    'desc'      => 'Làm dịu da, cung cấp các dưỡng chất chống oxy hóa tự nhiên, hỗ trợ làm sáng và duy trì độ ẩm mịn màng cho làn da.',
                ),
            ),
        ),
'order_combos' => array(
            'key' => 'field_order_combos',
            'subs' => array('val' => 'field_ocb_val', 'name' => 'field_ocb_name', 'desc' => 'field_ocb_desc', 'badge' => 'field_ocb_badge', 'chk' => 'field_ocb_chk'),
            'rows' => array(
                array('val' => 'sieu-tiet-kiem', 'name' => 'Dầu gội + Sữa Tắm 1000ml', 'desc' => 'Dùng 4-5 tháng', 'badge' => 'SIÊU TIẾT KIỆM', 'chk' => false),
                array('val' => 'dac-biet', 'name' => 'Dầu gội + Sữa tắm + Nước ủ tóc gừng tươi 1000ml', 'desc' => 'Combo đặc biệt', 'badge' => 'ĐẶC BIỆT', 'chk' => false),
                array('val' => 'trai-nghiem', 'name' => 'Combo Dầu gội + Sữa tắm 300ml', 'desc' => 'Gói dùng thử', 'badge' => 'TRẢI NGHIỆM', 'chk' => false),
                array('val' => 'ban-chay', 'name' => 'Combo Dầu gội + Sữa Tắm 500ml', 'desc' => 'Lựa chọn phổ biến nhất', 'badge' => 'BÁN CHẠY', 'chk' => true),
            ),
        ),
        'faq_items' => array(
            'key' => 'field_faq_items',
            'subs' => array('q' => 'field_faq_q', 'a' => 'field_faq_a'),
            'rows' => array(
                array('q' => 'Dầu gội và sữa tắm Gừng Nghệ Mây Mây có dùng được cho mẹ bầu và mẹ sau sinh không?', 'a' => 'Hoàn toàn dùng được! Bộ đôi được phát triển dựa trên hơn 15 năm kinh nghiệm chăm sóc mẹ bầu & sau sinh của Home Care, thành phần 100% thảo mộc tự nhiên, lành tính, không chứa hóa chất độc hại, an toàn tuyệt đối cho mẹ và bé.'),
                array('q' => 'Sản phẩm có làm bết tóc hoặc khô da không?', 'a' => 'Không. Dầu gội làm sạch dịu nhẹ, cân bằng độ pH da đầu, giúp tóc tơi phồng bồng bềnh mà không gây khô xơ. Sữa tắm chứa tinh chất nghệ và dầu thảo mộc dưỡng ẩm, giúp da mịn màng, ẩm mượt ngay sau khi tắm.'),
                array('q' => 'Dùng bao lâu thì thấy hiệu quả giảm rụng và giảm mụn lưng?', 'a' => 'Thông thường sau 1–2 tuần đầu, bạn sẽ cảm nhận da đầu sạch gàu hết ngứa, các nốt mụn lưng se lại. Từ 3–4 tuần sử dụng đều đặn, nang tóc chắc khỏe, giảm gãy rụng rõ rệt và tóc con bắt đầu mọc tua tủa.'),
                array('q' => 'Set quà 20/11 có giao tận trường không?', 'a' => 'Có. Bạn ghi địa chỉ trường và lời nhắn trên thiệp, Home Care gói quà và giao tận nơi. Đơn tập thể từ 10 set vui lòng gọi hotline để nhận giá riêng.'),
                array('q' => 'Làm sao phân biệt hàng chính hãng?', 'a' => 'Sản phẩm đã có phiếu công bố mỹ phẩm được Sở Y tế tiếp nhận, có tem chống hàng giả của Bộ Công An, tem chính hãng và thông tin trên hệ thống Mã số Mã vạch Quốc gia.'),
            ),
        ),
    );

    foreach ($repeaters as $rep_name => $rep_info) {
        $rep_key = $rep_info['key'];
        $subs    = $rep_info['subs'];
        $rows    = $rep_info['rows'];
        $opt_key = 'options_' . $rep_name;
        $existing = get_option($opt_key, '__NOT_SET__');

        if ($force || $existing === '__NOT_SET__') {
            // Sideload images inside repeater rows if any
            foreach ($rows as $i => &$row) {
                if (!empty($row['img'])) {
                    $img_src = $row['img'];
                    if (isset($attach_cache[$img_src])) {
                        $row['img'] = $attach_cache[$img_src];
                    } else {
                        $att_id = lx_sideload_theme_image($img_src, $rep_name . '_' . $i);
                        if ($att_id > 0) {
                            $attach_cache[$img_src] = $att_id;
                            $row['img'] = $att_id;
                        }
                    }
                }
                if (!empty($row['thumb'])) {
                    $img_src = $row['thumb'];
                    if (isset($attach_cache[$img_src])) {
                        $row['thumb'] = $attach_cache[$img_src];
                    } else {
                        $att_id = lx_sideload_theme_image($img_src, $rep_name . '_' . $i);
                        if ($att_id > 0) {
                            $attach_cache[$img_src] = $att_id;
                            $row['thumb'] = $att_id;
                        }
                    }
                }
            }
            unset($row);

            // Store row count and field key in wp_options
            update_option($opt_key, count($rows));
            update_option('_' . $opt_key, $rep_key);

            // Store each subfield value and subfield key in wp_options
            foreach ($rows as $i => $row) {
                foreach ($row as $sub_name => $sub_val) {
                    $sub_opt = $opt_key . '_' . $i . '_' . $sub_name;
                    $sub_key = isset($subs[$sub_name]) ? $subs[$sub_name] : '';
                    update_option($sub_opt, $sub_val);
                    if (!empty($sub_key)) {
                        update_option('_' . $sub_opt, $sub_key);
                    }
                }
            }

            if (function_exists('update_field')) {
                update_field($rep_key, $rows, 'option');
            }
        }
    }

    update_option('lx_tam_goi_content_sync_ver', $target_version);
}
add_action('init', 'lx_sync_tam_goi_landing_content', 20);
add_action('after_switch_theme', function() {
    lx_sync_tam_goi_landing_content(true);
});
