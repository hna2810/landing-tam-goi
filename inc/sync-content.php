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
 * Sync all landing page default content into ACF Options
 *
 * @param bool $force Whether to force rewrite all fields.
 * @return void
 */
function lx_sync_tam_goi_landing_content($force = false) {
    $current_version = get_option('lx_tam_goi_content_sync_ver', '');
    $target_version  = '1.1.0';

    if (!$force && $current_version === $target_version && !isset($_GET['lx_force_sync'])) {
        return;
    }

    $theme_uri = defined('LX_THEME_URI') ? LX_THEME_URI : get_template_directory_uri();

    // 1. SCALAR FIELDS (Text, Number, URL, Image, Textarea)
    $scalars = array(
        // Header & General
        'topbar_text'              => '🚚 <b>FREESHIP TOÀN QUỐC</b> · Ưu đãi kết thúc sau',
        'header_logo_text'         => 'Home Care',
        'header_logo_sub'          => 'SINCE 2008 · MÂY MÂY',
        'header_logo_img'          => '',
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
        'hero_image'               => 'https://cdn.hstatic.net/products/200001066686/combo-sua-tam-dau-goi-gung-nghe-may-may_37c9f5a7dbe9474d82a53a57c114c033.png',

        // Pain
        'pain_title'               => 'Mái tóc &amp; làn da đang làm bạn kém tự tin mỗi ngày?',
        'pain_lead'                => 'Tóc gãy rụng từng búi sau mỗi lần gội, da lưng lấm tấm mụn ngứa gây khó chịu?',
        'pain_hair_h'              => 'Mái tóc',
        'pain_center_img'          => $theme_uri . '/assets/images/skin-body.webp',
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
        'tab1_icon'                => 'https://cdn.hstatic.net/products/200001066686/dau-goi-gung-nghe-may-may-300ml_976748158c9548e5a917d6f1037d2dbe.png',
        'tab1_bad_h'               => 'Trước khi dùng',
        'tab1_good_h'              => 'Sau khi dùng',
        'tab1_img'                 => 'https://cdn.hstatic.net/products/200001066686/dau-goi-gung-nghe-may-may-300ml_976748158c9548e5a917d6f1037d2dbe.png',
        'tab1_quote'               => '“Tóc mọc tua tủa – Kích mở nang tóc”',
        'tab2_name'                => 'Sữa Tắm Gừng Nghệ Mây Mây',
        'tab2_icon'                => 'https://cdn.hstatic.net/products/200001066686/sua-tam-gung-nghe-may-may-500ml_8029728340d44067aa56b610e29f48ae.png',
        'tab2_bad_h'               => 'Trước khi dùng',
        'tab2_good_h'              => 'Sau khi dùng',
        'tab2_img'                 => 'https://cdn.hstatic.net/products/200001066686/sua-tam-gung-nghe-may-may-500ml_8029728340d44067aa56b610e29f48ae.png',
        'tab2_quote'               => '“Da sạch, mềm mịn, mờ thâm”',

        // Story
        'story_eyebrow'            => 'Câu chuyện Mây Mây',
        'story_title'              => "Từ tinh hoa cỏ cây Việt<br>đến từng giọt gội",
        'story_quote'              => '“Mẹ bầu, mẹ sau sinh xứng đáng được chăm sóc bằng những gì dịu lành nhất – như cách bà, mẹ ta vẫn đun nồi nước gừng, nước bưởi ngày xưa.”',
        'story_lead'               => 'Hơn 15 năm đồng hành cùng mẹ và bé, Home Care chọn gừng, nghệ, bưởi – những thảo dược quen thuộc của người Việt – để làm nên bộ tắm gội Mây Mây: sạch dịu, an tâm cho cả gia đình.',
        'story_img_1'              => 'https://cdn.hstatic.net/products/200001066686/nuoc-u-toc-tu-gung_39ddc7514164454692cfd14d198b8458.jpg',
        'story_img_2'              => 'https://cdn.hstatic.net/products/200001066686/nuoc-u-toc-bang-gung-tuoi-homecare_b083a03618e0411081b79ca35482e003.jpg',

        // Process
        'proc_eyebrow'             => 'Quy trình sản xuất',
        'proc_title'               => 'Từng giọt dầu gội ra đời như thế nào?',
        'proc_lead'                => 'Từ vùng nguyên liệu gừng nghệ sạch đến chai gội xả thơm lành trên tay bạn – xem trọn quy trình 4 bước chuẩn hóa.',
        'proc_video'               => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        'proc_video_thumb'         => 'https://cdn.hstatic.net/products/200001066686/nguyen-lieu-gung-nghe_aa75eb4c00f54ed7bda0abe067db2800.jpg',
        'proc_video_title'         => 'Video phóng sự quy trình sản xuất Bộ đôi Gừng Nghệ Mây Mây',
        'proc_video_desc'          => 'Khám phá quy trình chọn lọc thảo dược, chiết xuất và đóng chai khép kín',

        // Steps
        'steps_eyebrow'            => 'Cách dùng',
        'steps_title'              => '3 Bước để tóc sạch, da thơm mỗi ngày cùng bộ đôi Tắm Gội Gừng Nghệ',

        // Transparency
        'clear_eyebrow'            => 'Minh bạch – rõ nguồn gốc',
        'clear_title'              => 'An tâm sử dụng với thông tin minh bạch, rõ ràng',
        'clear_lead'               => 'Dầu gội và sữa tắm Gừng Nghệ Mây Mây đều có phiếu công bố sản phẩm mỹ phẩm, tem chống hàng giả Bộ Công An và thông tin trên hệ thống Mã số Mã vạch Quốc gia.',
        'clear_img_1'              => 'https://cdn.hstatic.net/products/200001066686/scb-dau-goi-gung-nghe_b1a448ecb88540ea96a76760844ae7f8.png',
        'clear_img_2'              => 'https://cdn.hstatic.net/products/200001066686/scb-sua-tam-gung-nghe_5328535177694ee6960a310a4cb94ac8.png',
        'clear_cap'                => 'Đã được Sở Y tế tiếp nhận phiếu công bố mỹ phẩm',
        'clear_barcode_img'        => 'https://cdn.hstatic.net/products/200001066686/combo-sua-tam-dau-goi-gung-nghe-may-may_37c9f5a7dbe9474d82a53a57c114c033.png',

        // Reviews
        'rev_eyebrow'              => 'Khách hàng nói gì',
        'rev_title'                => 'Thư viện hàng ngàn feedback chân thực',
        'rev_stat_1'               => '⭐⭐⭐⭐⭐ 4.9/5 sao dựa trên hơn 2.500+ đánh giá thực tế.',
        'rev_stat_2'               => '📊 98% đánh giá phản hồi tóc bớt gãy rụng, kích thích mọc tóc và giảm thâm mụn lưng',

        // Shorts
        'shorts_eyebrow'           => 'Video ngắn',
        'shorts_title'             => "Khách hàng &amp; hậu trường<br>trong 60 giây",
        'shorts_tiktok'            => 'https://www.tiktok.com',
        'shorts_youtube'           => 'https://www.youtube.com',

        // Combos
        'combo_title'              => 'Combo ưu đãi trải nghiệm',

        // Gift
        'gift_eyebrow'             => 'Mùa tri ân 20/11',
        'gift_title'               => "Gửi thầy cô một món quà<br>chăm sóc từ thảo mộc",
        'gift_lead'                => 'Thay lời tri ân sâu sắc gửi đến những người lái đò thầm lặng bằng bộ quà tặng từ thảo mộc tự nhiên, gói trọn sự ấm áp và chân thành.',
        'gift_count_note'          => 'Đặt trước <b>17/11</b> để nhận quà kịp ngày 20/11',

        // Order
        'order_title'              => 'Lấy lại mái tóc bồng bềnh &amp; làn da mịn màng ngay hôm nay!',
        'order_lead'               => 'Để lại thông tin bên dưới để nhận ngay ưu đãi trải nghiệm từ Home Care.',

        // FAQ
        'faq_eyebrow'              => 'Giải đáp thắc mắc',
        'faq_title'                => 'Giải đáp câu hỏi thường gặp',

        // Letter
        'letter_mascot'            => 'https://cdn.hstatic.net/products/200001066686/combo-sua-tam-dau-goi-gung-nghe-may-may_37c9f5a7dbe9474d82a53a57c114c033.png',
        'letter_title'             => "MÂY MÂY -<br>TÓC SẠCH, DA THƠM",
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
            update_option($key, $val);
            if (function_exists('update_field')) {
                update_field($key, $val, 'option');
            }
        }
    }

    // 2. REPEATER FIELDS (Full default rows for every repeater)
    $repeaters = array(
        'header_menu' => array(
            array('label' => 'Sản phẩm', 'link' => '#san-pham'),
            array('label' => 'Quy trình', 'link' => '#quy-trinh'),
            array('label' => 'Review', 'link' => '#review'),
            array('label' => 'Quà 20/11', 'link' => '#qua-20-11'),
            array('label' => 'Hỏi đáp', 'link' => '#faq'),
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
            array('num' => '02', 'title' => 'Ủ nước cốt gừng tươi', 'desc' => 'Nấu chậm theo phương pháp truyền thống kết hợp công nghệ hiện đại, giữ trọn tinh chất quý.', 'img' => 'https://cdn.hstatic.net/products/200001066686/nuoc-u-toc-gung-tuoi_e093b2883b2040ccb50e8e7eff9a5f4b.png'),
            array('num' => '03', 'title' => 'Chất dầu gội đậm đặc', 'desc' => 'Màu nâu vàng tự nhiên của gừng nghệ, kết cấu sánh quyện giàu dưỡng chất nuôi tóc.', 'img' => 'https://cdn.hstatic.net/products/200001066686/ch_t_d_u_g_i_g_ng_ngh__m_y_m_y_homecare_98cc876517dc4d9bbb42e1528e91dc58.png'),
            array('num' => '04', 'title' => 'Đóng chai & kiểm định', 'desc' => 'Đóng gói vô trùng, dán tem chống hàng giả Bộ Công An, kiểm định an toàn trước khi xuất xưởng.', 'img' => 'https://cdn.hstatic.net/products/200001066686/combo-sua-tam-dau-goi-gung-nghe-may-may_37c9f5a7dbe9474d82a53a57c114c033.png'),
        ),
        'steps_items' => array(
            array('icon' => 'i-stp1', 'title' => 'Bước 1: Làm ướt & tạo bọt', 'desc' => 'Làm ướt tóc và cơ thể bằng nước ấm. Lấy lượng vừa đủ dầu gội/sữa tắm thoa đều để tạo bọt mịn.'),
            array('icon' => 'i-stp2', 'title' => 'Bước 2: Massage thư giãn', 'desc' => 'Dùng đầu ngón tay massage nhẹ nhàng da đầu 2–3 phút và kỳ cọ nhẹ khắp cơ thể để dưỡng chất thẩm thấu.'),
            array('icon' => 'i-stp3', 'title' => 'Bước 3: Xả sạch với nước', 'desc' => 'Xả sạch với nước ấm. Tận hưởng cảm giác da đầu thông thoáng nhẹ bẫng và làn da cơ thể sạch thơm mát.'),
        ),
        'rev_gallery' => array(
            array('img' => 'https://cdn.hstatic.net/products/200001066686/feedback-sua-tam-gung-nghe-may-may_70ad2e7919234d7384635a04cef8f022.png'),
            array('img' => 'https://cdn.hstatic.net/products/200001066686/sua-tam-giam-mun-lung-nguc-gung-nghe_e52b32f1bd2b4aa2a3285e9d07e78545.png'),
            array('img' => 'https://cdn.hstatic.net/products/200001066686/doi-tuong-dung-sua-tam-gung-nghe-may-may_9017f7a260ae4d8b83b10308909a7d54.png'),
            array('img' => 'https://cdn.hstatic.net/products/200001066686/thanh-phan-sua-tam-gung-nghe-may-may_6a0a590666174a74b14cc313dbb61bd7.png'),
        ),
        'shorts_items' => array(
            array('title' => 'Mẹ bỉm chia sẻ', 'sub' => 'Review sau 3 tuần', 'src' => 'TikTok', 'thumb' => 'https://cdn.hstatic.net/products/200001066686/dau_goi_gung_nghe_may_may_-_dau_goi_cho_me_bau_va_me_sau_sinh_c85c9e18e5f24a9d93a1c3676d8fe1c8.jpg', 'video' => 'https://www.youtube.com/shorts/4kOgpS5Yq5g'),
            array('title' => 'Chất dầu gội sánh mịn', 'sub' => 'Cận cảnh gừng tươi', 'src' => 'TikTok', 'thumb' => 'https://cdn.hstatic.net/products/200001066686/ch_t_d_u_g_i_g_ng_ngh__m_y_m_y_homecare_98cc876517dc4d9bbb42e1528e91dc58.png', 'video' => 'https://www.youtube.com/shorts/4kOgpS5Yq5g'),
            array('title' => 'Khử sạch mùi mồ hôi', 'sub' => 'Sữa tắm gừng nghệ', 'src' => 'Shorts', 'thumb' => 'https://cdn.hstatic.net/products/200001066686/sua-tam-gung-nghe-may-may-500ml_8029728340d44067aa56b610e29f48ae.png', 'video' => 'https://www.youtube.com/shorts/4kOgpS5Yq5g'),
            array('title' => 'Đóng gói set quà', 'sub' => 'Hậu trường đóng gói', 'src' => 'Shorts', 'thumb' => 'https://cdn.hstatic.net/products/200001066686/combo-sua-tam-dau-goi-gung-nghe-may-may_37c9f5a7dbe9474d82a53a57c114c033.png', 'video' => 'https://www.youtube.com/shorts/4kOgpS5Yq5g'),
        ),
        'combo_items' => array(
            array('key' => 'c1', 'name' => 'Combo 1: Dầu Gội Gừng Nghệ Mây Mây', 'desc' => 'Dung tích 300ml · Tặng kèm túi đựng thảo mộc · Freeship toàn quốc', 'price' => '199.000đ', 'img' => 'https://cdn.hstatic.net/products/200001066686/dau-goi-gung-nghe-may-may-300ml_976748158c9548e5a917d6f1037d2dbe.png', 'is_hot' => false),
            array('key' => 'c2', 'name' => 'Combo 2: Sữa Tắm Gừng Nghệ Mây Mây', 'desc' => 'Dung tích 500ml · Tặng kèm bông tắm xơ mướp tự nhiên · Freeship toàn quốc', 'price' => '229.000đ', 'img' => 'https://cdn.hstatic.net/products/200001066686/sua-tam-gung-nghe-may-may-500ml_8029728340d44067aa56b610e29f48ae.png', 'is_hot' => false),
            array('key' => 'c3', 'name' => 'Combo 3: Trọn Bộ Tắm Gội Gừng Nghệ (HOT)', 'desc' => '1 Chai Dầu Gội 300ml + 1 Chai Sữa Tắm 500ml · Tặng trọn bộ quà tri ân · Tiết kiệm 151.000đ', 'price' => '399.000đ', 'img' => 'https://cdn.hstatic.net/products/200001066686/combo-sua-tam-dau-goi-gung-nghe-may-may_37c9f5a7dbe9474d82a53a57c114c033.png', 'is_hot' => true),
        ),
        'gift_sets' => array(
            array('name' => 'Set Tri Ân 1', 'ribbon' => 'GỢI Ý TẶNG CÔ', 'img' => 'https://cdn.hstatic.net/products/200001066686/combo-sua-tam-dau-goi-gung-nghe-may-may_37c9f5a7dbe9474d82a53a57c114c033.png', 'items' => "1 Sữa tắm Gừng Nghệ 500ml\n1 Thiệp viết tay lời chúc\nHộp quà kraft thắt nơ lụa", 'price' => '249.000đ', 'data_set' => 'set1'),
            array('name' => 'Set Tri Ân 2 (Đặc Biệt)', 'ribbon' => 'BÁN CHẠY NHẤT', 'img' => 'https://cdn.hstatic.net/products/200001066686/combo-sua-tam-dau-goi-gung-nghe-may-may_37c9f5a7dbe9474d82a53a57c114c033.png', 'items' => "1 Dầu gội Gừng Nghệ 300ml\n1 Sữa tắm Gừng Nghệ 500ml\n1 Bông tắm xơ mướp tự nhiên\nHộp quà cứng sang trọng kèm thiệp", 'price' => '429.000đ', 'data_set' => 'set2'),
            array('name' => 'Set Cao Cấp', 'ribbon' => 'TRỌN BỘ QUÀ TẶNG', 'img' => 'https://cdn.hstatic.net/products/200001066686/combo-sua-tam-dau-goi-gung-nghe-may-may_37c9f5a7dbe9474d82a53a57c114c033.png', 'items' => "Trọn bộ Tắm & Gội Mây Mây\n1 Nước ủ gừng tươi nguyên chất\nHộp quà lót rơm gỗ cao cấp + túi xách", 'price' => '549.000đ', 'data_set' => 'set3'),
        ),
        'order_combos' => array(
            array('val' => 'c3', 'name' => 'Bộ đôi Tắm & Gội Mây Mây', 'desc' => '399.000đ (Tiết kiệm 151K + Freeship)', 'badge' => 'ƯU ĐÃI NHẤT', 'chk' => true),
            array('val' => 'c1', 'name' => 'Dầu Gội Gừng Nghệ Mây Mây 300ml', 'desc' => '199.000đ (Freeship toàn quốc)', 'badge' => '', 'chk' => false),
            array('val' => 'c2', 'name' => 'Sữa Tắm Gừng Nghệ Mây Mây 500ml', 'desc' => '229.000đ (Freeship toàn quốc)', 'badge' => '', 'chk' => false),
        ),
        'faq_items' => array(
            array('q' => 'Phụ nữ mang thai và sau sinh có dùng được không?', 'a' => 'Hoàn toàn dùng được và rất nên dùng. Bộ đôi Gừng Nghệ Mây Mây được thiết kế chuyên biệt từ thảo dược lành tính, không chứa paraben, sulfat hay hóa chất độc hại, tuyệt đối an toàn cho mẹ bầu và mẹ sau sinh.'),
            array('q' => 'Mùi gừng nghệ có bị nồng hắc hay khó chịu không?', 'a' => 'Không hề. Mùi hương gừng nghệ được phối hợp tinh tế cùng tinh dầu bưởi và thảo mộc tự nhiên, mang lại cảm giác ấm áp, thư giãn và dễ chịu như đang được chăm sóc tại spa.'),
            array('q' => 'Dầu gội có gây khô tóc không?', 'a' => 'Dầu gội Mây Mây chứa hàm lượng dưỡng chất tự nhiên dồi dào, giúp tóc suôn mềm, không làm khô xơ hay gãy rụng sau khi gội.'),
            array('q' => 'Bao lâu thì thấy tóc con mọc và giảm rụng rõ rệt?', 'a' => 'Thông thường sau khoảng 2–4 tuần sử dụng đều đặn, lượng tóc rụng khi chải đầu sẽ giảm rõ rệt và các nang tóc mới sẽ bắt đầu nhú mọc.'),
            array('q' => 'Sữa tắm có giúp giảm mụn lưng và thâm không?', 'a' => 'Có. Tinh chất nghệ vàng và gừng sẻ có tính kháng khuẩn tự nhiên cao, giúp làm sạch sâu lỗ chân lông, làm dịu các nốt mụn sưng đỏ và hỗ trợ làm mờ vết thâm lưng, ngực.'),
            array('q' => 'Chính sách giao hàng và đổi trả như thế nào?', 'a' => 'Home Care hỗ trợ MIỄN PHÍ VẬN CHUYỂN TOÀN QUỐC cho tất cả đơn hàng đặt qua landing page. Bạn được quyền kiểm tra hàng trước khi thanh toán và đổi trả trong 7 ngày nếu có lỗi từ nhà sản xuất.'),
        ),
    );

    foreach ($repeaters as $rep_key => $rows) {
        $opt_key = 'options_' . $rep_key;
        $existing = get_option($opt_key, '__NOT_SET__');

        // Only populate if not yet defined or forced
        if ($force || $existing === '__NOT_SET__' || empty($existing)) {
            if (function_exists('update_field')) {
                update_field($rep_key, $rows, 'option');
            }

            // Always write the database options row count and subfields as fallback
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
