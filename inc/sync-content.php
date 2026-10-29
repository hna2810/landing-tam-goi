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
    $target_version  = '1.2.0';

    if (!$force && $current_version === $target_version && !isset($_GET['lx_force_sync'])) {
        return;
    }

    $theme_dir = defined('LX_THEME_DIR') ? LX_THEME_DIR : get_template_directory();

    // 1. SCALAR TEXT FIELDS
    $scalars = array(
        // Header & General
        'topbar_text'              => '🚚 <b>FREESHIP TOÀN QUỐC</b> · Ưu đãi kết thúc sau',
        'header_logo_text'         => 'Home Care',
        'header_logo_sub'          => 'SINCE 2008 · MÂY MÂY',
        'header_cta_text'          => 'Đặt hàng ngay',
        'header_cta_link'          => '#dat-hang',
        'order_email'              => 'danghuy.homecare@gmail.com',
        'hotline'                  => '0962131515',

        // Hero
        'hero_title'               => "Tóc mọc tua tủa,<br>da sạch mịn màng",
        'hero_subtitle'            => '<b>Bộ đôi Sữa tắm &amp; Dầu gội Gừng Nghệ Mây Mây</b>',
        'hero_callout'             => '👉 Được sử dụng trong dịch vụ chăm sóc bầu, sau sinh của Home Care trên khắp 3 miền Bắc - Trung - Nam',
        'hero_price_label'         => 'Combo dầu gội + sữa tắm',
        'hero_price'               => '399.000đ',
        'hero_price_note'          => 'Freeship toàn quốc',
        'hero_price_tag'           => "FREE<br>SHIP",
        'hero_cta_primary_text'    => 'FREESHIP TOÀN QUỐC - MUA NGAY!',
        'hero_cta_primary_link'    => '#dat-hang',
        'hero_cta_secondary_text'  => 'Set quà 20/11',
        'hero_cta_secondary_link'  => '#qua-20-11',

        // Pain
        'pain_title'               => 'Mái tóc &amp; làn da đang làm bạn kém tự tin mỗi ngày?',
        'pain_lead'                => 'Tóc gãy rụng từng búi sau mỗi lần gội, da lưng lấm tấm mụn ngứa gây khó chịu?',
        'pain_hair_h'              => 'Mái tóc',
        'pain_skin_h'              => 'Làn da cơ thể',
        'pain_cause_h'             => 'NGUYÊN NHÂN DO ĐÂU?',
        'pain_cause_p'             => 'Làn da và da đầu tiếp xúc với bụi bẩn môi trường, sự thay đổi nội tiết tố hoặc do sử dụng các sản phẩm làm sạch có chất tẩy rửa quá mạnh, làm mất đi độ ẩm tự nhiên.',
        'pain_cta_p'               => '👉👉 Đừng để những lo âu kéo dài làm ảnh hưởng đến diện mạo và tâm trạng của bạn. Khám phá ngay <b>Bộ đôi chăm sóc chuyên sâu từ Gừng &amp; Nghệ</b> – Làm sạch dịu nhẹ, cân bằng độ ẩm và phục hồi sức sống tự nhiên cho mái tóc &amp; làn da.',
        'pain_cta_link'            => '#san-pham',

        // Before & After / Products
        'ba_eyebrow'               => 'Hình ảnh trực quan (Trước &amp; Sau khi sử dụng)',
        'ba_title'                 => 'Phục hồi mái tóc bồng bềnh, sạch gàu ngứa và nuôi dưỡng làn da cơ thể mịn màng cùng Bộ đôi Tắm Gội Gừng Nghệ Mây Mây',
        'ba_lead'                  => 'Công thức độc quyền từ tinh hoa thảo mộc Gừng, Nghệ',
        'tab1_name'                => 'Dầu Gội Gừng Nghệ Mây Mây',
        'tab1_bad_h'               => 'Trước khi dùng',
        'tab1_good_h'              => 'Sau khi dùng',
        'tab1_quote'               => '“Tóc mọc tua tủa – Kích mở nang tóc”',
        'tab2_name'                => 'Sữa Tắm Gừng Nghệ Mây Mây',
        'tab2_bad_h'               => 'Trước khi dùng',
        'tab2_good_h'              => 'Sau khi dùng',
        'tab2_quote'               => '“Da sạch, mềm mịn, mờ thâm”',

        // Story
        'story_eyebrow'            => 'Câu chuyện Mây Mây',
        'story_title'              => "Từ tinh hoa cỏ cây Việt<br>đến từng giọt gội",
        'story_quote'              => '“Mẹ bầu, mẹ sau sinh xứng đáng được chăm sóc bằng những gì dịu lành nhất – như cách bà, mẹ ta vẫn đun nồi nước gừng, nước bưởi ngày xưa.”',
        'story_lead'               => 'Hơn 15 năm đồng hành cùng mẹ và bé, Home Care chọn gừng, nghệ, bưởi – những thảo dược quen thuộc của người Việt – để làm nên bộ tắm gội Mây Mây: sạch dịu, an tâm cho cả gia đình.',

        // Process
        'proc_eyebrow'             => 'Quy trình sản xuất',
        'proc_title'               => 'Từng giọt dầu gội ra đời như thế nào?',
        'proc_lead'                => 'Từ vùng nguyên liệu gừng nghệ sạch đến chai gội xả thơm lành trên tay bạn – xem trọn quy trình 4 bước chuẩn hóa.',
        'proc_video'               => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        'proc_video_tag'           => 'Video thực tế',
        'proc_video_title'         => 'Hành trình đun nấu Gừng Nghệ Mây Mây',
        'proc_video_desc'          => 'Từ chọn nguyên liệu, nấu chiết thảo dược đến khi thành chai dầu gội, sữa tắm.',

        // Steps
        'steps_eyebrow'            => 'Cách dùng',
        'steps_title'              => '3 Bước để tóc sạch, da thơm mỗi ngày cùng bộ đôi Tắm Gội Gừng Nghệ',

        // Cert / Transparency
        'clear_eyebrow'            => 'Minh bạch – rõ nguồn gốc',
        'clear_title'              => 'An tâm sử dụng với thông tin minh bạch, rõ ràng',
        'clear_lead'               => 'Dầu gội và sữa tắm Gừng Nghệ Mây Mây đều có phiếu công bố sản phẩm mỹ phẩm, tem chống hàng giả Bộ Công An và thông tin trên hệ thống Mã số Mã vạch Quốc gia.',
        'clear_cap'                => 'Đã được Sở Y tế tiếp nhận phiếu công bố mỹ phẩm',

        // Reviews
        'rev_eyebrow'              => 'Khách hàng nói gì',
        'rev_title'                => 'Thư viện hàng ngàn feedback chân thực',
        'rev_stat_1'               => '⭐⭐⭐⭐⭐ 4.9/5 sao dựa trên hơn 2.500+ đánh giá thực tế.',
        'rev_stat_2'               => '📊 98% đánh giá phản hồi tóc bớt gãy rụng, kích thích mọc tóc và giảm thâm mụn lưng',

        // Shorts
        'shorts_eyebrow'           => 'Video ngắn',
        'shorts_title'             => 'Khách hàng & hậu trường<br>trong 60 giây',
        'shorts_tiktok'            => 'https://www.tiktok.com',
        'shorts_youtube'           => 'https://www.youtube.com',

        // Combos
        'combo_title'              => 'Combo ưu đãi trải nghiệm',

        // Gift
        'gift_eyebrow'             => 'Mùa tri ân 20/11',
        'gift_title'               => 'Gửi thầy cô một món quà<br>chăm sóc từ thảo mộc',
        'gift_lead'                => 'Thay lời tri ân sâu sắc gửi đến những người lái đò thầm lặng bằng bộ quà tặng từ thảo mộc tự nhiên, gói trọn sự ấm áp và chân thành.',
        'gift_count_note'          => 'Đặt trước <b>17/11</b> để nhận quà kịp ngày 20/11',

        // Order
        'order_title'              => 'Lấy lại mái tóc bồng bềnh & làn da mịn màng ngay hôm nay!',
        'order_lead'               => 'Để lại thông tin bên dưới để nhận ngay ưu đãi trải nghiệm từ Home Care.',

        // Letter
        'letter_title'             => 'MÂY MÂY -<br>TÓC SẠCH, DA THƠM',
        'letter_body'              => "Trải qua ba lần sinh nở trước tuổi 30, chị Mai hiểu rằng, hành trình làm mẹ không chỉ có niềm vui đón con mà còn là những tháng ngày người mẹ cần được chăm sóc và nâng niu.\n\nTừ kiến thức chuyên môn và nhiều năm tháng đồng hành cùng các thai phụ & sản phụ, chị Mai tìm về những bí quyết chăm sóc bí truyền với các nguyên liệu thân thuộc từ gừng, nghệ và thảo mộc. Nhưng việc chuẩn bị cầu kỳ mỗi ngày khiến chị trăn trở về phương pháp chăm sóc mẹ thuận tiện hơn.\n\nTừ đó, chị Mai đã tạo nên Mây Mây – thương hiệu chăm sóc mẹ từ tinh hoa thảo mộc, mong muốn mang đến những sản phẩm gần gũi, giúp mẹ chăm sóc tóc và làn da dễ dàng hơn trong kỳ ở cữ.",
        'letter_hl'                => 'Bởi chị hiểu, sau những tháng ngày dành trọn yêu thương cho con, mẹ cũng xứng đáng được chăm sóc và yêu thương chính mình.',
        'letter_voice'             => '',

        // Footer & Sticky
        'footer_logo'              => 'Home Care',
        'footer_text'              => "Đẹp và Thật · Since 2008<br>Tổng đài 1900 0387 · Hotline 0962 131 515 – 0973 871 376",
        'sticky_phone'             => '0962131515',
        'sticky_price'             => '99K',
        'sticky_desc'              => 'Combo dầu gội + sữa tắm · Freeship',
        'sticky_btn_text'          => 'Đặt ngay',
        'sticky_btn_link'          => '#dat-hang',
    );

    foreach ($scalars as $key => $val) {
        $opt_key = 'options_' . $key;
        if ($force || get_option($opt_key, '__NOT_SET__') === '__NOT_SET__') {
            update_option($opt_key, $val);
            if (function_exists('update_field')) {
                update_field($key, $val, 'option');
            }
        }
    }

    // 2. IMAGE FIELDS (Sideload into WP Media Library and assign Attachment IDs)
    $images = array(
        'hero_image'       => 'https://cdn.hstatic.net/products/200001066686/combo-sua-tam-dau-goi-gung-nghe-may-may_37c9f5a7dbe9474d82a53a57c114c033.png',
        'pain_center_img'  => $theme_dir . '/assets/images/skin-body.webp',
        'tab1_icon'        => 'https://cdn.hstatic.net/products/200001066686/dau-goi-gung-nghe-may-may-300ml_976748158c9548e5a917d6f1037d2dbe.png',
        'tab1_img'         => 'https://cdn.hstatic.net/products/200001066686/dau-goi-gung-nghe-may-may-300ml_976748158c9548e5a917d6f1037d2dbe.png',
        'tab2_icon'        => 'https://cdn.hstatic.net/products/200001066686/sua-tam-gung-nghe-may-may-500ml_8029728340d44067aa56b610e29f48ae.png',
        'tab2_img'         => 'https://cdn.hstatic.net/products/200001066686/sua-tam-gung-nghe-may-may-500ml_8029728340d44067aa56b610e29f48ae.png',
        'story_img_1'      => 'https://cdn.hstatic.net/products/200001066686/nuoc-u-toc-tu-gung_39ddc7514164454692cfd14d198b8458.jpg',
        'story_img_2'      => 'https://cdn.hstatic.net/products/200001066686/nuoc-u-toc-bang-gung-tuoi-homecare_b083a03618e0411081b79ca35482e003.jpg',
        'proc_video_thumb' => 'https://cdn.hstatic.net/products/200001066686/nuoc-u-toc-tu-gung_39ddc7514164454692cfd14d198b8458.jpg',
        'clear_img_1'      => 'https://cdn.hstatic.net/products/200001066686/scb-dau-goi-gung-nghe_b1a448ecb88540ea96a76760844ae7f8.png',
        'clear_img_2'      => 'https://cdn.hstatic.net/products/200001066686/scb-sua-tam-gung-nghe_5328535177694ee6960a310a4cb94ac8.png',
        'letter_mascot'    => 'https://cdn.hstatic.net/products/200001066686/combo-sua-tam-dau-goi-gung-nghe-may-may_37c9f5a7dbe9474d82a53a57c114c033.png',
    );

    // Cache of url => attach_id so we don't import duplicate images
    $attach_cache = array();

    foreach ($images as $img_key => $img_src) {
        $opt_key = 'options_' . $img_key;
        $current_val = get_option($opt_key, '__NOT_SET__');

        if ($force || $current_val === '__NOT_SET__' || empty($current_val)) {
            $att_id = 0;
            if (isset($attach_cache[$img_src])) {
                $att_id = $attach_cache[$img_src];
            } else {
                if (file_exists($img_src)) {
                    $att_id = lx_import_local_theme_image($img_src, $img_key);
                } elseif (filter_var($img_src, FILTER_VALIDATE_URL)) {
                    $att_id = lx_sideload_theme_image($img_src, $img_key);
                }
                if ($att_id > 0) {
                    $attach_cache[$img_src] = $att_id;
                }
            }

            $final_val = ($att_id > 0) ? $att_id : $img_src;
            update_option($opt_key, $final_val);
            if (function_exists('update_field')) {
                update_field($img_key, $final_val, 'option');
            }
        }
    }

    // 3. REPEATER FIELDS
    $repeaters = array(
        'header_menu' => array(
            array('label' => 'Sản phẩm', 'link' => '#san-pham'),
            array('label' => 'Quy trình', 'link' => '#quy-trinh'),
            array('label' => 'Review', 'link' => '#review'),
            array('label' => 'Quà 20/11', 'link' => '#qua-20-11'),
            array('label' => 'Hỏi đáp', 'link' => '#hoi-dap'),
        ),
        'hero_benefits' => array(
            array('text' => 'Giảm rụng, kích mọc tóc'),
            array('text' => 'Sạch gàu, hết ngứa'),
            array('text' => 'Hỗ trợ mờ mụn lưng'),
            array('text' => 'Dùng được cho mẹ bầu & mẹ sau sinh'),
        ),
        'hero_trust_items' => array(
            array('icon' => 'i-hosp', 'text' => 'Có mặt tại nhà thuốc, bệnh viện, phòng khám'),
            array('icon' => 'i-bar', 'text' => 'Có trên hệ thống Mã số Mã vạch Quốc gia'),
            array('icon' => 'i-shield', 'text' => 'Tem chống hàng giả Bộ Công An'),
            array('icon' => 'i-pen', 'text' => 'Đã công bố mỹ phẩm – Sở Y tế cấp số'),
        ),
        'pain_hair_items' => array(
            array('title' => 'Tóc gãy rụng', 'desc' => 'Mỗi lần chải hay gội đầu, tóc gãy rụng vón thành từng búi khiến mái tóc ngày càng thưa.'),
            array('title' => 'Gàu ngứa dai dẳng', 'desc' => 'Da đầu nhanh bết dính, xuất hiện vảy gàu kèm cơn ngứa ngáy dữ dội, đặc biệt là khi thời tiết thay đổi.'),
            array('title' => 'Tóc khô xơ, hư tổn', 'desc' => 'Sợi tóc xơ xác, chẻ ngọn, thiếu sức sống do tác động từ hóa chất, uốn nhuộm hoặc thay đổi nội tiết tố.'),
        ),
        'pain_skin_items' => array(
            array('title' => 'Mụn lưng, mụn ngực', 'desc' => 'Lỗ chân lông bít tắc do bã nhờn và mồ hôi gây ngứa, sinh ra mụn đỏ, mụn viêm.'),
            array('title' => 'Da thô ráp, thiếu ẩm', 'desc' => 'Sau khi tắm, làn da bị khô căng, nứt nẻ và kém mịn màng.'),
            array('title' => 'Vết thâm kéo dài', 'desc' => 'Lưng, ngực chằng chịt thâm mụn khiến bạn mất đi sự tự tin khi diện những trang phục yêu thích.'),
        ),
        'tab1_bad_items' => array(
            array('text' => 'Tóc rụng từng nắm mỗi lần gội/chải, vuốt nhẹ cũng rụng.'),
            array('text' => 'Da đầu gàu ngứa, nhanh bết dính dù mới gội.'),
            array('text' => 'Mái tóc khô xơ, chẻ ngọn, lộ rõ da đầu mỏng.'),
        ),
        'tab1_good_items' => array(
            array('text' => 'Giảm rụng tóc, nang tóc chắc khỏe.'),
            array('text' => 'Da đầu sạch thoáng, hết ngứa.'),
            array('text' => 'Tóc con mọc tua tủa sau 2–4 tuần sử dụng.'),
        ),
        'tab2_bad_items' => array(
            array('text' => 'Mụn lưng, viêm nang lông sần sùi ngứa ngáy.'),
            array('text' => 'Vết thâm mụn chi chít khắp lưng và ngực.'),
            array('text' => 'Da khô ráp, bong tróc và thiếu ẩm.'),
        ),
        'tab2_good_items' => array(
            array('text' => 'Mụn lưng lặn dần, giảm viêm rõ rệt.'),
            array('text' => 'Mờ thâm mụn, da đều màu và sáng mịn.'),
            array('text' => 'Cấp ẩm sâu, da mềm mượt không còn khô căng.'),
        ),
        'story_stats' => array(
            array('num' => '2008', 'suffix' => '', 'text' => 'Thành lập Home Care'),
            array('num' => '3', 'suffix' => '', 'text' => 'Dung tích linh hoạt'),
            array('num' => '100', 'suffix' => '%', 'text' => 'Tem chính hãng'),
        ),
        'proc_flow_steps' => array(
            array('num' => '01', 'title' => 'Vùng nguyên liệu tuyển chọn', 'desc' => 'Gừng sẻ, nghệ vàng được thu hoạch từ vùng trồng đạt chuẩn, rửa sạch và phân loại kỹ càng.', 'img' => 'https://cdn.hstatic.net/products/200001066686/nguyen-lieu-gung-nghe_aa75eb4c00f54ed7bda0abe067db2800.jpg'),
            array('num' => '02', 'title' => 'Sơ chế & rửa sạch', 'desc' => 'Nấu chậm theo phương pháp truyền thống kết hợp công nghệ hiện đại, giữ trọn tinh chất quý.', 'img' => 'https://cdn.hstatic.net/products/200001066686/nuoc-u-toc-bang-gung-tuoi-homecare_b083a03618e0411081b79ca35482e003.jpg'),
            array('num' => '03', 'title' => 'Đun nấu chiết xuất', 'desc' => 'Màu nâu vàng tự nhiên của gừng nghệ, kết cấu sánh quyện giàu dưỡng chất nuôi tóc.', 'img' => 'https://cdn.hstatic.net/products/200001066686/nuoc-u-toc-tu-gung_39ddc7514164454692cfd14d198b8458.jpg'),
            array('num' => '04', 'title' => 'Lọc & đóng chai', 'desc' => 'Đóng gói vô trùng, dán tem chống hàng giả Bộ Công An, kiểm định an toàn trước khi xuất xưởng.', 'img' => 'https://cdn.hstatic.net/products/200001066686/ch_t_d_u_g_i_g_ng_ngh__m_y_m_y_homecare_98cc876517dc4d9bbb42e1528e91dc58.png'),
            array('num' => '05', 'title' => 'Công bố & tem', 'desc' => 'Sở Y tế tiếp nhận phiếu công bố sản phẩm mỹ phẩm, tem chính hãng.', 'img' => 'https://cdn.hstatic.net/products/200001066686/scb-dau-goi-gung-nghe_b1a448ecb88540ea96a76760844ae7f8.png'),
        ),
        'steps_items' => array(
            array('icon' => 'i-drop', 'title' => 'Bước 1: Gội đầu', 'desc' => 'Làm ướt tóc bằng nước ấm. Lấy lượng dầu gội vừa đủ, tạo bọt massage nhẹ nhàng 3–5 phút rồi xả sạch.'),
            array('icon' => 'i-leaf', 'title' => 'Bước 2: Tắm sạch body', 'desc' => 'Làm ướt cơ thể, lấy lượng sữa tắm ra lòng bàn tay hoặc bông tắm. Massage kỹ vùng da lưng, ngực trong 2 phút.'),
            array('icon' => 'i-heart', 'title' => 'Bước 3: Xả sạch', 'desc' => 'Tắm lại bằng nước sạch, dùng khăn mềm lau khô nhẹ nhàng để cảm nhận làn da mịn màng và mái tóc bồng bềnh.'),
            array('icon' => 'i-root', 'title' => 'Ủ phục hồi (tuỳ chọn)', 'desc' => 'Tóc khô xơ: thoa nước ủ gừng tươi sau gội, ủ 10–15 phút rồi xả sạch.'),
        ),
        'rev_gallery' => array(
            array('img' => 'https://cdn.hstatic.net/products/200001066686/feedback-sua-tam-gung-nghe-may-may_70ad2e7919234d7384635a04cef8f022.png'),
            array('img' => 'https://cdn.hstatic.net/products/200001066686/sua-tam-giam-mun-lung-nguc-gung-nghe_e52b32f1bd2b4aa2a3285e9d07e78545.png'),
            array('img' => 'https://cdn.hstatic.net/products/200001066686/doi-tuong-dung-sua-tam-gung-nghe-may-may_9017f7a260ae4d8b83b10308909a7d54.png'),
            array('img' => 'https://cdn.hstatic.net/products/200001066686/thanh-phan-sua-tam-gung-nghe-may-may_6a0a590666174a74b14cc313dbb61bd7.png'),
        ),
        'shorts_items' => array(
            array('title' => 'Gội thử lần đầu – tóc rụng ít hẳn', 'sub' => 'Trải nghiệm dầu gội', 'src' => 'TikTok', 'thumb' => 'https://cdn.hstatic.net/products/200001066686/dau-goi-gung-nghe-may-may-300ml_976748158c9548e5a917d6f1037d2dbe.png', 'video' => ''),
            array('title' => 'Mẹ bầu tắm gội an tâm mỗi ngày', 'sub' => 'Review mẹ bầu', 'src' => 'TikTok', 'thumb' => 'https://cdn.hstatic.net/products/200001066686/dau_goi_gung_nghe_may_may_-_dau_goi_cho_me_bau_va_me_sau_sinh_c85c9e18e5f24a9d93a1c3676d8fe1c8.jpg', 'video' => ''),
            array('title' => 'Tạm biệt mụn lưng sau 3 tuần', 'sub' => 'Trải nghiệm sữa tắm', 'src' => 'Reels', 'thumb' => 'https://cdn.hstatic.net/products/200001066686/sua-tam-gung-nghe-may-may-500ml_8029728340d44067aa56b610e29f48ae.png', 'video' => ''),
            array('title' => 'Đun nấu thảo dược tại xưởng', 'sub' => 'Hậu trường sản xuất', 'src' => 'Shorts', 'thumb' => 'https://cdn.hstatic.net/products/200001066686/nuoc-u-toc-bang-gung-tuoi-homecare_b083a03618e0411081b79ca35482e003.jpg', 'video' => ''),
            array('title' => 'Ủ tóc gừng tươi – tóc mềm mượt', 'sub' => 'Tuỳ chọn ủ tóc', 'src' => 'TikTok', 'thumb' => 'https://cdn.hstatic.net/products/200001066686/nuoc-u-toc-bang-gung-tuoi_341071304a9d48dab53bca2e5363b41d.png', 'video' => ''),
        ),
        'combo_items' => array(
            array('key' => 'trai-nghiem', 'name' => 'Gói Trải Nghiệm', 'desc' => '1 Dầu gội + 1 Sữa tắm Gừng Nghệ + 1 Ủ tóc (300ML)', 'price' => '99K', 'img' => 'https://cdn.hstatic.net/products/200001066686/combo-sua-tam-dau-goi-gung-nghe-may-may_37c9f5a7dbe9474d82a53a57c114c033.png', 'is_hot' => false),
            array('key' => 'ban-chay', 'name' => 'Gói Best Seller', 'desc' => '1 Dầu gội + 1 Sữa tắm Gừng Nghệ + 1 Ủ tóc (500ML)', 'price' => '159k', 'img' => 'https://cdn.hstatic.net/products/200001066686/combo-sua-tam-dau-goi-gung-nghe-may-may_37c9f5a7dbe9474d82a53a57c114c033.png', 'is_hot' => true),
            array('key' => 'sieu-tiet-kiem', 'name' => 'Gói Tiết Kiệm', 'desc' => '1 Dầu gội + 1 Sữa tắm Gừng Nghệ + 1 Ủ tóc (1000ML)', 'price' => '299K', 'img' => 'https://cdn.hstatic.net/products/200001066686/combo-sua-tam-dau-goi-gung-nghe-may-may_37c9f5a7dbe9474d82a53a57c114c033.png', 'is_hot' => false),
        ),
        'gift_sets' => array(
            array('name' => 'SET TÂM GIAO', 'ribbon' => '', 'img' => 'https://cdn.hstatic.net/products/200001066686/dau-goi-gung-nghe-may-may-300ml_976748158c9548e5a917d6f1037d2dbe.png', 'items' => "Dầu gội Gừng Nghệ (300ml)\nSữa tắm Gừng Nghệ (300ml)\nHộp quà cao cấp & Thiệp viết tay", 'price' => '199.000đ', 'data_set' => 'Set Tâm Giao – 199.000đ'),
            array('name' => 'SET AN NHIÊN', 'ribbon' => '★ Chọn nhiều nhất', 'img' => 'https://cdn.hstatic.net/products/200001066686/combo-sua-tam-dau-goi-gung-nghe-may-may_37c9f5a7dbe9474d82a53a57c114c033.png', 'items' => "Dầu gội Gừng Nghệ (500ml)\nSữa tắm Gừng Nghệ (500ml)\nNước ủ gừng tươi (250ml)\nHộp quà cao cấp & Thiệp viết tay", 'price' => '299.000đ', 'data_set' => 'Set An Nhiên – 299.000đ'),
            array('name' => 'SET TRI ÂN', 'ribbon' => '', 'img' => 'https://cdn.hstatic.net/products/200001066686/sua-tam-gung-nghe-may-may-500ml_8029728340d44067aa56b610e29f48ae.png', 'items' => "Dầu gội Gừng Nghệ (500ml)\nSữa tắm Gừng Nghệ (500ml)\nTinh dầu xịt dưỡng bưởi gừng (100ml)\nHộp quà VIP & Túi vải thương hiệu", 'price' => '399.000đ', 'data_set' => 'Set Tri Ân – 399.000đ'),
            array('name' => 'SET ĐOÀN VIÊN', 'ribbon' => '', 'img' => 'https://cdn.hstatic.net/products/200001066686/combo-sua-tam-dau-goi-gung-nghe-may-may_37c9f5a7dbe9474d82a53a57c114c033.png', 'items' => "Bộ đôi đại 1000ml (gội + tắm)\nNước ủ tóc gừng tươi (500ml)\nXà bông gừng nghệ thủ công\nHộp gỗ khắc tên & Thiệp lụa", 'price' => '499.000đ', 'data_set' => 'Set Đoàn Viên – 499.000đ'),
        ),
        'order_combos' => array(
            array('val' => 'trai-nghiem', 'name' => 'Gói Trải Nghiệm 99K', 'desc' => '1 Gội + 1 Tắm + 1 Ủ (300ml) · Freeship', 'badge' => '99K', 'chk' => false),
            array('val' => 'ban-chay', 'name' => 'Gói Best Seller 159K (Khuyên dùng)', 'desc' => '1 Gội + 1 Tắm + 1 Ủ (500ml) · Tiết kiệm nhất', 'badge' => '159K', 'chk' => true),
            array('val' => 'sieu-tiet-kiem', 'name' => 'Gói Siêu Tiết Kiệm 299K', 'desc' => '1 Gội + 1 Tắm + 1 Ủ (1000ml) · Dùng 4-5 tháng', 'badge' => '299K', 'chk' => false),
            array('val' => 'set-20-11', 'name' => 'Set Quà Tặng Tri Ân 20/11', 'desc' => 'Hộp quà cao cấp + Thiệp chúc viết tay', 'badge' => 'Quà tặng', 'chk' => false),
        ),
        'faq_items' => array(
            array('q' => 'Dầu gội và sữa tắm Gừng Nghệ Mây Mây có dùng được cho mẹ bầu và mẹ sau sinh không?', 'a' => 'Hoàn toàn dùng được! Bộ đôi được phát triển dựa trên hơn 15 năm kinh nghiệm chăm sóc mẹ bầu & sau sinh của Home Care, thành phần 100% thảo mộc tự nhiên, lành tính, không chứa hóa chất độc hại, an toàn tuyệt đối cho mẹ và bé.'),
            array('q' => 'Sản phẩm có làm bết tóc hoặc khô da không?', 'a' => 'Không. Dầu gội làm sạch dịu nhẹ, cân bằng độ pH da đầu, giúp tóc tơi phồng bồng bềnh mà không gây khô xơ. Sữa tắm chứa tinh chất nghệ và dầu thảo mộc dưỡng ẩm, giúp da mịn màng, ẩm mượt ngay sau khi tắm.'),
            array('q' => 'Dùng bao lâu thì thấy hiệu quả giảm rụng và giảm mụn lưng?', 'a' => 'Thông thường sau 1–2 tuần đầu, bạn sẽ cảm nhận da đầu sạch gàu hết ngứa, các nốt mụn lưng se lại. Từ 3–4 tuần sử dụng đều đặn, nang tóc chắc khỏe, giảm gãy rụng rõ rệt và tóc con bắt đầu mọc tua tủa.'),
            array('q' => 'Sản phẩm có đầy đủ giấy tờ công bố không?', 'a' => 'Sản phẩm đã có phiếu công bố mỹ phẩm được Sở Y tế tiếp nhận, có tem chống hàng giả của Bộ Công An, tem chính hãng và thông tin trên hệ thống Mã số Mã vạch Quốc gia.'),
        ),
    );

    foreach ($repeaters as $rep_key => $rows) {
        $opt_key = 'options_' . $rep_key;
        $existing = get_option($opt_key, '__NOT_SET__');

        if ($force || $existing === '__NOT_SET__' || empty($existing)) {
            // Process images inside repeater rows
            foreach ($rows as $i => &$row) {
                if (!empty($row['img'])) {
                    $img_src = $row['img'];
                    if (isset($attach_cache[$img_src])) {
                        $row['img'] = $attach_cache[$img_src];
                    } else {
                        $att_id = lx_sideload_theme_image($img_src, $rep_key . '_' . $i);
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
                        $att_id = lx_sideload_theme_image($img_src, $rep_key . '_' . $i);
                        if ($att_id > 0) {
                            $attach_cache[$img_src] = $att_id;
                            $row['thumb'] = $att_id;
                        }
                    }
                }
            }
            unset($row);

            if (function_exists('update_field')) {
                update_field($rep_key, $rows, 'option');
            }

            update_option($opt_key, count($rows));
            update_option($rep_key, $rows);

            foreach ($rows as $i => $row) {
                foreach ($row as $sub_key => $sub_val) {
                    update_option($opt_key . '_' . $i . '_' . $sub_key, $sub_val);
                }
            }
        }
    }

    update_option('lx_tam_goi_content_sync_ver', $target_version);
}
add_action('init', 'lx_sync_tam_goi_landing_content');
add_action('after_switch_theme', function() {
    lx_sync_tam_goi_landing_content(true);
});
