<?php
/**
 * ACF Options Page and Fields Registration
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register ACF Options Page
 */
function lx_register_acf_options_page() {
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page(array(
            'page_title' => __('Cài đặt Landing Page Tắm Gội', 'lx-landing'),
            'menu_title' => __('Cài đặt Landing Page', 'lx-landing'),
            'menu_slug'  => 'lx-landing-settings',
            'capability' => 'edit_posts',
            'redirect'   => false,
            'icon_url'   => 'dashicons-palmtree',
            'position'   => 4,
        ));
    }
}
add_action('acf/init', 'lx_register_acf_options_page');

/**
 * Register ACF Local Field Group
 */
function lx_register_acf_landing_fields_group() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_tam_goi_landing',
        'title' => __('Cấu hình Toàn bộ Landing Page Tắm Gội Gừng Nghệ', 'lx-landing'),
        'fields' => array(
            // ==================== TAB 1: HEADER & TOPBAR ====================
            array(
                'key' => 'field_tab_header',
                'label' => 'Header & Topbar',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_topbar_text',
                'label' => 'Nội dung Topbar thông báo',
                'name' => 'topbar_text',
                'type' => 'text',
                'default_value' => '🚚 <b>FREESHIP TOÀN QUỐC</b> · Ưu đãi kết thúc sau',
                'instructions' => 'Để trống nếu muốn ẩn hoàn toàn thanh topbar trên cùng',
            ),
            array(
                'key' => 'field_header_logo_text',
                'label' => 'Tên Logo thương hiệu',
                'name' => 'header_logo_text',
                'type' => 'text',
                'default_value' => 'Home Care',
            ),
            array(
                'key' => 'field_header_logo_sub',
                'label' => 'Dòng phụ Logo',
                'name' => 'header_logo_sub',
                'type' => 'text',
                'default_value' => 'SINCE 2008 · MÂY MÂY',
            ),
            array(
                'key' => 'field_header_logo_img',
                'label' => 'Hình ảnh Logo (tuỳ chọn)',
                'name' => 'header_logo_img',
                'type' => 'image',
                'return_format' => 'url',
            ),
            array(
                'key' => 'field_header_menu',
                'label' => 'Menu điều hướng',
                'name' => 'header_menu',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Thêm mục menu',
                'sub_fields' => array(
                    array(
                        'key' => 'field_menu_label',
                        'label' => 'Tên mục',
                        'name' => 'label',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_menu_link',
                        'label' => 'Đường dẫn liên kết (#san-pham, #quy-trinh...)',
                        'name' => 'link',
                        'type' => 'text',
                    ),
                ),
            ),
            array(
                'key' => 'field_header_cta_text',
                'label' => 'Chữ nút CTA trên Header',
                'name' => 'header_cta_text',
                'type' => 'text',
                'default_value' => 'Đặt hàng ngay',
                'instructions' => 'Để trống nếu muốn ẩn nút CTA trên Header',
            ),
            array(
                'key' => 'field_header_cta_link',
                'label' => 'Link nút CTA trên Header',
                'name' => 'header_cta_link',
                'type' => 'text',
                'default_value' => '#dat-hang',
            ),

            // ==================== TAB 2: HERO & TRUST ====================
            array(
                'key' => 'field_tab_hero',
                'label' => 'Hero Banner & Cam Kết',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_hero_title',
                'label' => 'Tiêu đề chính H1 (hỗ trợ <br>, <em>)',
                'name' => 'hero_title',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => "Tóc mọc tua tủa,<br>da sạch mịn màng",
            ),
            array(
                'key' => 'field_hero_subtitle',
                'label' => 'Tiêu đề phụ',
                'name' => 'hero_subtitle',
                'type' => 'text',
                'default_value' => 'Bộ đôi Sữa tắm & Dầu gội Gừng Nghệ Mây Mây',
            ),
            array(
                'key' => 'field_hero_benefits',
                'label' => '4 Điểm nổi bật (Benefits)',
                'name' => 'hero_benefits',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Thêm ưu điểm',
                'sub_fields' => array(
                    array(
                        'key' => 'field_benefit_text',
                        'label' => 'Nội dung ưu điểm',
                        'name' => 'text',
                        'type' => 'text',
                    ),
                ),
            ),
            array(
                'key' => 'field_hero_callout',
                'label' => 'Dòng chứng nhận uy tín (Callout)',
                'name' => 'hero_callout',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => '👉 Được sử dụng trong dịch vụ chăm sóc bầu, sau sinh của Home Care trên khắp 3 miền Bắc - Trung - Nam',
            ),
            array(
                'key' => 'field_hero_price_label',
                'label' => 'Nhãn giá',
                'name' => 'hero_price_label',
                'type' => 'text',
                'default_value' => 'Combo dầu gội + sữa tắm',
            ),
            array(
                'key' => 'field_hero_price',
                'label' => 'Mức giá hiển thị',
                'name' => 'hero_price',
                'type' => 'text',
                'default_value' => '99K',
            ),
            array(
                'key' => 'field_hero_price_note',
                'label' => 'Ghi chú giá',
                'name' => 'hero_price_note',
                'type' => 'text',
                'default_value' => 'Freeship toàn quốc',
            ),
            array(
                'key' => 'field_hero_price_tag',
                'label' => 'Huy hiệu giá bên cạnh',
                'name' => 'hero_price_tag',
                'type' => 'text',
                'default_value' => 'FREE<br>SHIP',
            ),
            array(
                'key' => 'field_hero_cta_primary_text',
                'label' => 'Nút CTA chính (Mua ngay)',
                'name' => 'hero_cta_primary_text',
                'type' => 'text',
                'default_value' => 'FREESHIP TOÀN QUỐC - MUA NGAY!',
            ),
            array(
                'key' => 'field_hero_cta_primary_link',
                'label' => 'Link nút CTA chính',
                'name' => 'hero_cta_primary_link',
                'type' => 'text',
                'default_value' => '#dat-hang',
            ),
            array(
                'key' => 'field_hero_cta_secondary_text',
                'label' => 'Nút CTA phụ',
                'name' => 'hero_cta_secondary_text',
                'type' => 'text',
                'default_value' => 'Set quà 20/11',
            ),
            array(
                'key' => 'field_hero_cta_secondary_link',
                'label' => 'Link nút CTA phụ',
                'name' => 'hero_cta_secondary_link',
                'type' => 'text',
                'default_value' => '#qua-20-11',
            ),
            array(
                'key' => 'field_hero_image',
                'label' => 'Hình ảnh Hero chính',
                'name' => 'hero_image',
                'type' => 'image',
                'return_format' => 'url',
            ),
            array(
                'key' => 'field_hero_trust_items',
                'label' => 'Thanh cam kết (Trust bar 4 mục)',
                'name' => 'hero_trust_items',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Thêm cam kết',
                'sub_fields' => array(
                    array(
                        'key' => 'field_trust_icon',
                        'label' => 'Mã Icon SVG (#i-hosp, #i-bar, #i-shield, #i-pen)',
                        'name' => 'icon',
                        'type' => 'text',
                        'default_value' => 'i-shield',
                    ),
                    array(
                        'key' => 'field_trust_text',
                        'label' => 'Nội dung cam kết',
                        'name' => 'text',
                        'type' => 'text',
                    ),
                ),
            ),

            // ==================== TAB 3: NỖI LO ====================
            array(
                'key' => 'field_tab_pain',
                'label' => 'Nỗi Lo Mẹ Bầu & Sau Sinh',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_pain_title',
                'label' => 'Tiêu đề mục Nỗi lo',
                'name' => 'pain_title',
                'type' => 'text',
                'default_value' => 'Mái tóc & làn da đang làm bạn kém tự tin mỗi ngày?',
            ),
            array(
                'key' => 'field_pain_lead',
                'label' => 'Mô tả mục Nỗi lo',
                'name' => 'pain_lead',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => 'Tóc gãy rụng từng búi sau mỗi lần gội, da lưng lấm tấm mụn ngứa gây khó chịu?',
            ),
            array(
                'key' => 'field_pain_hair_h',
                'label' => 'Tiêu đề cột Mái tóc',
                'name' => 'pain_hair_h',
                'type' => 'text',
                'default_value' => 'Mái tóc',
            ),
            array(
                'key' => 'field_pain_hair_items',
                'label' => 'Danh sách vấn đề về Mái tóc',
                'name' => 'pain_hair_items',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Thêm vấn đề tóc',
                'sub_fields' => array(
                    array(
                        'key' => 'field_pain_hair_item_title',
                        'label' => 'Tên vấn đề',
                        'name' => 'title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_pain_hair_item_desc',
                        'label' => 'Chi tiết',
                        'name' => 'desc',
                        'type' => 'textarea',
                        'rows' => 2,
                    ),
                ),
            ),
            array(
                'key' => 'field_pain_center_img',
                'label' => 'Ảnh ở giữa mục Nỗi lo',
                'name' => 'pain_center_img',
                'type' => 'image',
                'return_format' => 'url',
            ),
            array(
                'key' => 'field_pain_skin_h',
                'label' => 'Tiêu đề cột Làn da cơ thể',
                'name' => 'pain_skin_h',
                'type' => 'text',
                'default_value' => 'Làn da cơ thể',
            ),
            array(
                'key' => 'field_pain_skin_items',
                'label' => 'Danh sách vấn đề về Làn da',
                'name' => 'pain_skin_items',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Thêm vấn đề da',
                'sub_fields' => array(
                    array(
                        'key' => 'field_pain_skin_item_title',
                        'label' => 'Tên vấn đề',
                        'name' => 'title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_pain_skin_item_desc',
                        'label' => 'Chi tiết',
                        'name' => 'desc',
                        'type' => 'textarea',
                        'rows' => 2,
                    ),
                ),
            ),
            array(
                'key' => 'field_pain_cause_h',
                'label' => 'Tiêu đề khối Nguyên nhân',
                'name' => 'pain_cause_h',
                'type' => 'text',
                'default_value' => 'NGUYÊN NHÂN DO ĐÂU?',
            ),
            array(
                'key' => 'field_pain_cause_p',
                'label' => 'Nội dung giải thích nguyên nhân',
                'name' => 'pain_cause_p',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Làn da và da đầu tiếp xúc với bụi bẩn môi trường, sự thay đổi nội tiết tố hoặc do sử dụng các sản phẩm làm sạch có chất tẩy rửa quá mạnh, làm mất đi độ ẩm tự nhiên.',
            ),
            array(
                'key' => 'field_pain_cta_p',
                'label' => 'Nội dung kêu gọi giải pháp',
                'name' => 'pain_cta_p',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => '👉👉 Đừng để những lo âu kéo dài làm ảnh hưởng đến diện mạo và tâm trạng của bạn. Khám phá ngay <b>Bộ đôi chăm sóc chuyên sâu từ Gừng & Nghệ</b> – Làm sạch dịu nhẹ, cân bằng độ ẩm và phục hồi sức sống tự nhiên cho mái tóc & làn da.',
            ),
            array(
                'key' => 'field_pain_cta_link',
                'label' => 'Link nút mũi tên',
                'name' => 'pain_cta_link',
                'type' => 'text',
                'default_value' => '#san-pham',
            ),

            // ==================== TAB 4: SẢN PHẨM (TRƯỚC & SAU) ====================
            array(
                'key' => 'field_tab_products',
                'label' => 'Sản Phẩm (Trước/Sau)',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_ba_eyebrow',
                'label' => 'Dòng nhãn nhỏ (Eyebrow)',
                'name' => 'ba_eyebrow',
                'type' => 'text',
                'default_value' => 'Hình ảnh trực quan (Trước & Sau khi sử dụng)',
            ),
            array(
                'key' => 'field_ba_title',
                'label' => 'Tiêu đề mục Sản phẩm',
                'name' => 'ba_title',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => 'Phục hồi mái tóc bồng bềnh, sạch gàu ngứa và nuôi dưỡng làn da cơ thể mịn màng cùng Bộ đôi Tắm Gội Gừng Nghệ Mây Mây',
            ),
            array(
                'key' => 'field_ba_lead',
                'label' => 'Dòng phụ mục Sản phẩm',
                'name' => 'ba_lead',
                'type' => 'text',
                'default_value' => 'Công thức độc quyền từ tinh hoa thảo mộc Gừng, Nghệ',
            ),
            // Tab con: Dầu gội
            array(
                'key' => 'field_tab1_name',
                'label' => 'Tên Tab 1',
                'name' => 'tab1_name',
                'type' => 'text',
                'default_value' => 'Dầu Gội Gừng Nghệ Mây Mây',
            ),
            array(
                'key' => 'field_tab1_bad_items',
                'label' => 'Tab 1: Trước khi dùng (Nhược điểm)',
                'name' => 'tab1_bad_items',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Thêm dòng trước khi dùng',
                'sub_fields' => array(
                    array(
                        'key' => 'field_tab1_bad_text',
                        'label' => 'Nội dung',
                        'name' => 'text',
                        'type' => 'text',
                    ),
                ),
            ),
            array(
                'key' => 'field_tab1_good_items',
                'label' => 'Tab 1: Sau khi dùng (Ưu điểm)',
                'name' => 'tab1_good_items',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Thêm dòng sau khi dùng',
                'sub_fields' => array(
                    array(
                        'key' => 'field_tab1_good_text',
                        'label' => 'Nội dung',
                        'name' => 'text',
                        'type' => 'text',
                    ),
                ),
            ),
            array(
                'key' => 'field_tab1_quote',
                'label' => 'Tab 1: Câu trích dẫn chốt',
                'name' => 'tab1_quote',
                'type' => 'text',
                'default_value' => '“Tóc mọc tua tủa – Kích mở nang tóc”',
            ),
            // Tab con: Sữa tắm
            array(
                'key' => 'field_tab2_name',
                'label' => 'Tên Tab 2',
                'name' => 'tab2_name',
                'type' => 'text',
                'default_value' => 'Sữa Tắm Gừng Nghệ Mây Mây',
            ),
            array(
                'key' => 'field_tab2_bad_items',
                'label' => 'Tab 2: Trước khi dùng (Nhược điểm)',
                'name' => 'tab2_bad_items',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Thêm dòng trước khi dùng',
                'sub_fields' => array(
                    array(
                        'key' => 'field_tab2_bad_text',
                        'label' => 'Nội dung',
                        'name' => 'text',
                        'type' => 'text',
                    ),
                ),
            ),
            array(
                'key' => 'field_tab2_good_items',
                'label' => 'Tab 2: Sau khi dùng (Ưu điểm)',
                'name' => 'tab2_good_items',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Thêm dòng sau khi dùng',
                'sub_fields' => array(
                    array(
                        'key' => 'field_tab2_good_text',
                        'label' => 'Nội dung',
                        'name' => 'text',
                        'type' => 'text',
                    ),
                ),
            ),
            array(
                'key' => 'field_tab2_quote',
                'label' => 'Tab 2: Câu trích dẫn chốt',
                'name' => 'tab2_quote',
                'type' => 'text',
                'default_value' => '“Da sạch, mềm mịn, mờ thâm”',
            ),

            // ==================== TAB 5: CÂU CHUYỆN ====================
            array(
                'key' => 'field_tab_story',
                'label' => 'Câu Chuyện Mây Mây',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_story_eyebrow',
                'label' => 'Nhãn nhỏ',
                'name' => 'story_eyebrow',
                'type' => 'text',
                'default_value' => 'Câu chuyện Mây Mây',
            ),
            array(
                'key' => 'field_story_title',
                'label' => 'Tiêu đề câu chuyện',
                'name' => 'story_title',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => "Từ tinh hoa cỏ cây Việt<br>đến từng giọt gội",
            ),
            array(
                'key' => 'field_story_quote',
                'label' => 'Lời tâm sự trích dẫn',
                'name' => 'story_quote',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => '“Mẹ bầu, mẹ sau sinh xứng đáng được chăm sóc bằng những gì dịu lành nhất – như cách bà, mẹ ta vẫn đun nồi nước gừng, nước bưởi ngày xưa.”',
            ),
            array(
                'key' => 'field_story_lead',
                'label' => 'Đoạn văn chi tiết',
                'name' => 'story_lead',
                'type' => 'textarea',
                'rows' => 4,
                'default_value' => 'Hơn 15 năm đồng hành cùng mẹ và bé, Home Care chọn gừng, nghệ, bưởi – những thảo dược quen thuộc của người Việt – để làm nên bộ tắm gội Mây Mây: sạch dịu, an tâm cho cả gia đình.',
            ),
            array(
                'key' => 'field_story_img_1',
                'label' => 'Ảnh câu chuyện 1',
                'name' => 'story_img_1',
                'type' => 'image',
                'return_format' => 'url',
            ),
            array(
                'key' => 'field_story_img_2',
                'label' => 'Ảnh câu chuyện 2',
                'name' => 'story_img_2',
                'type' => 'image',
                'return_format' => 'url',
            ),
            array(
                'key' => 'field_story_stats',
                'label' => 'Các con số ấn tượng',
                'name' => 'story_stats',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Thêm con số',
                'sub_fields' => array(
                    array(
                        'key' => 'field_stat_num',
                        'label' => 'Số đếm',
                        'name' => 'num',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_stat_suffix',
                        'label' => 'Đuôi (ví dụ % hoặc +)',
                        'name' => 'suffix',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_stat_text',
                        'label' => 'Nhãn giải thích',
                        'name' => 'text',
                        'type' => 'text',
                    ),
                ),
            ),

            // ==================== TAB 6: QUY TRÌNH & VIDEO ====================
            array(
                'key' => 'field_tab_proc',
                'label' => 'Quy Trình & Video',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_proc_eyebrow',
                'label' => 'Nhãn nhỏ',
                'name' => 'proc_eyebrow',
                'type' => 'text',
                'default_value' => 'Tận mắt quy trình',
            ),
            array(
                'key' => 'field_proc_title',
                'label' => 'Tiêu đề quy trình',
                'name' => 'proc_title',
                'type' => 'text',
                'default_value' => 'Từ nồi thảo dược đến tay bạn',
            ),
            array(
                'key' => 'field_proc_lead',
                'label' => 'Mô tả quy trình',
                'name' => 'proc_lead',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => 'Không giấu giếm – xem trọn quy trình đun nấu, chiết lọc và đóng chai dầu gội, sữa tắm Gừng Nghệ Mây Mây.',
            ),
            array(
                'key' => 'field_proc_video',
                'label' => 'Link video YouTube / mp4 / TikTok quy trình',
                'name' => 'proc_video',
                'type' => 'text',
                'instructions' => 'Dán link video mở trong popup khi bấm nút xem',
            ),
            array(
                'key' => 'field_proc_video_thumb',
                'label' => 'Ảnh đại diện video',
                'name' => 'proc_video_thumb',
                'type' => 'image',
                'return_format' => 'url',
            ),
            array(
                'key' => 'field_proc_video_title',
                'label' => 'Tiêu đề video',
                'name' => 'proc_video_title',
                'type' => 'text',
                'default_value' => 'Hành trình đun nấu Gừng Nghệ Mây Mây',
            ),
            array(
                'key' => 'field_proc_video_desc',
                'label' => 'Mô tả ngắn video',
                'name' => 'proc_video_desc',
                'type' => 'text',
                'default_value' => 'Từ chọn nguyên liệu, nấu chiết thảo dược đến khi thành chai dầu gội, sữa tắm.',
            ),
            array(
                'key' => 'field_proc_flow_steps',
                'label' => 'Các bước quy trình (5 bước)',
                'name' => 'proc_flow_steps',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Thêm bước quy trình',
                'sub_fields' => array(
                    array(
                        'key' => 'field_pstep_num',
                        'label' => 'Số thứ tự (01, 02...)',
                        'name' => 'num',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_pstep_title',
                        'label' => 'Tên bước',
                        'name' => 'title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_pstep_desc',
                        'label' => 'Mô tả bước',
                        'name' => 'desc',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_pstep_img',
                        'label' => 'Hình ảnh minh họa',
                        'name' => 'img',
                        'type' => 'image',
                        'return_format' => 'url',
                    ),
                ),
            ),

            // ==================== TAB 7: CÁCH DÙNG (3 BƯỚC) ====================
            array(
                'key' => 'field_tab_steps',
                'label' => 'Cách Dùng (3 Bước)',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_steps_eyebrow',
                'label' => 'Nhãn nhỏ',
                'name' => 'steps_eyebrow',
                'type' => 'text',
                'default_value' => 'Cách dùng',
            ),
            array(
                'key' => 'field_steps_title',
                'label' => 'Tiêu đề mục Cách dùng',
                'name' => 'steps_title',
                'type' => 'text',
                'default_value' => '3 Bước để tóc sạch, da thơm mỗi ngày cùng bộ đôi Tắm Gội Gừng Nghệ',
            ),
            array(
                'key' => 'field_steps_items',
                'label' => 'Danh sách các bước thực hiện',
                'name' => 'steps_items',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Thêm bước',
                'sub_fields' => array(
                    array(
                        'key' => 'field_step_icon',
                        'label' => 'Mã Icon SVG (#i-drop, #i-leaf, #i-heart, #i-root)',
                        'name' => 'icon',
                        'type' => 'text',
                        'default_value' => 'i-drop',
                    ),
                    array(
                        'key' => 'field_step_title',
                        'label' => 'Tiêu đề bước',
                        'name' => 'title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_step_desc',
                        'label' => 'Chi tiết hướng dẫn',
                        'name' => 'desc',
                        'type' => 'textarea',
                        'rows' => 3,
                    ),
                ),
            ),

            // ==================== TAB 8: MINH BẠCH & HỒ SƠ ====================
            array(
                'key' => 'field_tab_transparency',
                'label' => 'Minh Bạch Hồ Sơ Y Tế',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_clear_eyebrow',
                'label' => 'Nhãn nhỏ',
                'name' => 'clear_eyebrow',
                'type' => 'text',
                'default_value' => 'Minh bạch – rõ nguồn gốc',
            ),
            array(
                'key' => 'field_clear_title',
                'label' => 'Tiêu đề mục Minh bạch',
                'name' => 'clear_title',
                'type' => 'text',
                'default_value' => 'An tâm sử dụng với thông tin minh bạch, rõ ràng',
            ),
            array(
                'key' => 'field_clear_lead',
                'label' => 'Mô tả mục Minh bạch',
                'name' => 'clear_lead',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => 'Dầu gội và sữa tắm Gừng Nghệ Mây Mây đều có phiếu công bố sản phẩm mỹ phẩm, tem chống hàng giả Bộ Công An và thông tin trên hệ thống Mã số Mã vạch Quốc gia.',
            ),
            array(
                'key' => 'field_clear_img_1',
                'label' => 'Ảnh Giấy công bố dầu gội',
                'name' => 'clear_img_1',
                'type' => 'image',
                'return_format' => 'url',
            ),
            array(
                'key' => 'field_clear_img_2',
                'label' => 'Ảnh Giấy công bố sữa tắm',
                'name' => 'clear_img_2',
                'type' => 'image',
                'return_format' => 'url',
            ),
            array(
                'key' => 'field_clear_cap',
                'label' => 'Dòng chú thích bên dưới ảnh giấy tờ',
                'name' => 'clear_cap',
                'type' => 'text',
                'default_value' => 'Đã được Sở Y tế tiếp nhận phiếu công bố mỹ phẩm',
            ),
            array(
                'key' => 'field_clear_barcode_img',
                'label' => 'Ảnh quét mã QR / Mã vạch (tuỳ chọn)',
                'name' => 'clear_barcode_img',
                'type' => 'image',
                'return_format' => 'url',
            ),

            // ==================== TAB 9: ĐÁNH GIÁ (REVIEWS) ====================
            array(
                'key' => 'field_tab_reviews',
                'label' => 'Feedback Khách Hàng',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_rev_eyebrow',
                'label' => 'Nhãn nhỏ',
                'name' => 'rev_eyebrow',
                'type' => 'text',
                'default_value' => 'Khách hàng nói gì',
            ),
            array(
                'key' => 'field_rev_title',
                'label' => 'Tiêu đề mục Review',
                'name' => 'rev_title',
                'type' => 'text',
                'default_value' => 'Thư viện hàng ngàn feedback chân thực',
            ),
            array(
                'key' => 'field_rev_stat_1',
                'label' => 'Dòng đánh giá sao',
                'name' => 'rev_stat_1',
                'type' => 'text',
                'default_value' => '⭐⭐⭐⭐⭐ 4.9/5 sao dựa trên hơn 2.500+ đánh giá thực tế.',
            ),
            array(
                'key' => 'field_rev_stat_2',
                'label' => 'Dòng tỷ lệ hài lòng',
                'name' => 'rev_stat_2',
                'type' => 'text',
                'default_value' => '📊 98% đánh giá phản hồi tóc bớt gãy rụng, kích thích mọc tóc và giảm thâm mụn lưng',
            ),
            array(
                'key' => 'field_rev_gallery',
                'label' => 'Thư viện ảnh chụp Feedback',
                'name' => 'rev_gallery',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Thêm ảnh feedback',
                'sub_fields' => array(
                    array(
                        'key' => 'field_rev_gallery_img',
                        'label' => 'Hình ảnh feedback',
                        'name' => 'img',
                        'type' => 'image',
                        'return_format' => 'url',
                    ),
                ),
            ),

            // ==================== TAB 10: VIDEO NGẮN (SHORTS) ====================
            array(
                'key' => 'field_tab_shorts',
                'label' => 'Video Ngắn 60s',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_shorts_eyebrow',
                'label' => 'Nhãn nhỏ',
                'name' => 'shorts_eyebrow',
                'type' => 'text',
                'default_value' => 'Video ngắn',
            ),
            array(
                'key' => 'field_shorts_title',
                'label' => 'Tiêu đề',
                'name' => 'shorts_title',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => "Khách hàng & hậu trường<br>trong 60 giây",
            ),
            array(
                'key' => 'field_shorts_tiktok',
                'label' => 'Link Kênh TikTok',
                'name' => 'shorts_tiktok',
                'type' => 'text',
                'default_value' => '#',
            ),
            array(
                'key' => 'field_shorts_youtube',
                'label' => 'Link Kênh YouTube',
                'name' => 'shorts_youtube',
                'type' => 'text',
                'default_value' => '#',
            ),
            array(
                'key' => 'field_shorts_items',
                'label' => 'Danh sách video ngắn',
                'name' => 'shorts_items',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Thêm video ngắn',
                'sub_fields' => array(
                    array(
                        'key' => 'field_short_title',
                        'label' => 'Tiêu đề video',
                        'name' => 'title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_short_sub',
                        'label' => 'Ghi chú nhỏ',
                        'name' => 'sub',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_short_src',
                        'label' => 'Nguồn (TikTok / Reels / Shorts)',
                        'name' => 'src',
                        'type' => 'text',
                        'default_value' => 'TikTok',
                    ),
                    array(
                        'key' => 'field_short_thumb',
                        'label' => 'Ảnh Thumbnail',
                        'name' => 'thumb',
                        'type' => 'image',
                        'return_format' => 'url',
                    ),
                    array(
                        'key' => 'field_short_video',
                        'label' => 'Link Video',
                        'name' => 'video',
                        'type' => 'text',
                    ),
                ),
            ),

            // ==================== TAB 11: COMBO ƯU ĐÃI ====================
            array(
                'key' => 'field_tab_combo',
                'label' => 'Combo Ưu Đãi',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_combo_title',
                'label' => 'Tiêu đề mục Combo',
                'name' => 'combo_title',
                'type' => 'text',
                'default_value' => 'Combo ưu đãi trải nghiệm',
            ),
            array(
                'key' => 'field_combo_items',
                'label' => 'Các gói combo',
                'name' => 'combo_items',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Thêm gói combo',
                'sub_fields' => array(
                    array(
                        'key' => 'field_combo_key',
                        'label' => 'Mã combo (trai-nghiem, ban-chay...)',
                        'name' => 'key',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_combo_name',
                        'label' => 'Tên combo',
                        'name' => 'name',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_combo_desc',
                        'label' => 'Mô tả thành phần gói',
                        'name' => 'desc',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_combo_price',
                        'label' => 'Giá hiển thị (99K, 159k...)',
                        'name' => 'price',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_combo_img',
                        'label' => 'Hình ảnh combo',
                        'name' => 'img',
                        'type' => 'image',
                        'return_format' => 'url',
                    ),
                    array(
                        'key' => 'field_combo_is_hot',
                        'label' => 'Gói bán chạy nhất (Viền nổi bật)',
                        'name' => 'is_hot',
                        'type' => 'true_false',
                    ),
                ),
            ),

            // ==================== TAB 12: QUÀ TẶNG 20/11 ====================
            array(
                'key' => 'field_tab_gift',
                'label' => 'Set Quà Tặng 20/11',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_gift_eyebrow',
                'label' => 'Nhãn nhỏ',
                'name' => 'gift_eyebrow',
                'type' => 'text',
                'default_value' => 'Mùa tri ân 20/11',
            ),
            array(
                'key' => 'field_gift_title',
                'label' => 'Tiêu đề mục Quà tặng',
                'name' => 'gift_title',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => "Gửi thầy cô một món quà<br>chăm sóc từ thảo mộc",
            ),
            array(
                'key' => 'field_gift_lead',
                'label' => 'Lời tựa',
                'name' => 'gift_lead',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => 'Thay lời tri ân sâu sắc gửi đến những người lái đò thầm lặng bằng bộ quà tặng từ thảo mộc tự nhiên, gói trọn sự ấm áp và chân thành.',
            ),
            array(
                'key' => 'field_gift_count_note',
                'label' => 'Ghi chú đếm ngược',
                'name' => 'gift_count_note',
                'type' => 'text',
                'default_value' => 'Đặt trước <b>17/11</b> để nhận quà kịp ngày 20/11',
            ),
            array(
                'key' => 'field_gift_sets',
                'label' => 'Danh sách Set quà tặng',
                'name' => 'gift_sets',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Thêm Set quà',
                'sub_fields' => array(
                    array(
                        'key' => 'field_gset_name',
                        'label' => 'Tên set',
                        'name' => 'name',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_gset_ribbon',
                        'label' => 'Ruy băng nổi bật (ví dụ: ★ Chọn nhiều nhất)',
                        'name' => 'ribbon',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_gset_img',
                        'label' => 'Ảnh set quà',
                        'name' => 'img',
                        'type' => 'image',
                        'return_format' => 'url',
                    ),
                    array(
                        'key' => 'field_gset_items',
                        'label' => 'Danh sách sản phẩm trong set (mỗi mục 1 dòng)',
                        'name' => 'items',
                        'type' => 'textarea',
                        'rows' => 4,
                    ),
                    array(
                        'key' => 'field_gset_price',
                        'label' => 'Giá bán',
                        'name' => 'price',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_gset_data_set',
                        'label' => 'Chuỗi định danh khi bấm chọn',
                        'name' => 'data_set',
                        'type' => 'text',
                    ),
                ),
            ),

            // ==================== TAB 13: ĐẶT HÀNG & EMAIL ====================
            array(
                'key' => 'field_tab_order',
                'label' => 'Đặt Hàng & Cài Đặt Email',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_order_email',
                'label' => 'Email nhận thông báo đơn hàng mới (CRITICAL)',
                'name' => 'order_email',
                'type' => 'email',
                'default_value' => 'danghuy.homecare@gmail.com',
                'instructions' => 'Mỗi khi khách đặt đơn, hệ thống sẽ tự động gửi email thông báo chi tiết về hòm thư này.',
                'required' => 1,
            ),
            array(
                'key' => 'field_order_title',
                'label' => 'Tiêu đề khối đặt hàng',
                'name' => 'order_title',
                'type' => 'text',
                'default_value' => 'Lấy lại mái tóc bồng bềnh & làn da mịn màng ngay hôm nay!',
            ),
            array(
                'key' => 'field_order_lead',
                'label' => 'Mô tả khối đặt hàng',
                'name' => 'order_lead',
                'type' => 'text',
                'default_value' => 'Để lại thông tin bên dưới để nhận ngay ưu đãi trải nghiệm từ Home Care.',
            ),
            array(
                'key' => 'field_order_combos',
                'label' => 'Các tuỳ chọn combo trong form',
                'name' => 'order_combos',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Thêm lựa chọn combo',
                'sub_fields' => array(
                    array(
                        'key' => 'field_ocb_val',
                        'label' => 'Giá trị radio (trai-nghiem, ban-chay...)',
                        'name' => 'val',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_ocb_name',
                        'label' => 'Tên gói hiển thị',
                        'name' => 'name',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_ocb_desc',
                        'label' => 'Mô tả chi tiết',
                        'name' => 'desc',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_ocb_badge',
                        'label' => 'Huy hiệu giá bên phải (99K, 159K...)',
                        'name' => 'badge',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_ocb_chk',
                        'label' => 'Mặc định chọn sẵn',
                        'name' => 'chk',
                        'type' => 'true_false',
                    ),
                ),
            ),

            // ==================== TAB 14: HỎI ĐÁP FAQ ====================
            array(
                'key' => 'field_tab_faq',
                'label' => 'Hỏi Đáp FAQ',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_faq_eyebrow',
                'label' => 'Nhãn nhỏ',
                'name' => 'faq_eyebrow',
                'type' => 'text',
                'default_value' => 'Giải đáp thắc mắc',
            ),
            array(
                'key' => 'field_faq_title',
                'label' => 'Tiêu đề mục FAQ',
                'name' => 'faq_title',
                'type' => 'text',
                'default_value' => 'Giải đáp câu hỏi thường gặp',
            ),
            array(
                'key' => 'field_faq_items',
                'label' => 'Danh sách câu hỏi & trả lời',
                'name' => 'faq_items',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Thêm câu hỏi',
                'sub_fields' => array(
                    array(
                        'key' => 'field_faq_q',
                        'label' => 'Câu hỏi',
                        'name' => 'q',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_faq_a',
                        'label' => 'Câu trả lời',
                        'name' => 'a',
                        'type' => 'textarea',
                        'rows' => 3,
                    ),
                ),
            ),

            // ==================== TAB 15: LỜI NHẮN MÂY MÂY ====================
            array(
                'key' => 'field_tab_letter',
                'label' => 'Lời Nhắn Mây Mây',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_letter_mascot',
                'label' => 'Ảnh biểu tượng / Mascot',
                'name' => 'letter_mascot',
                'type' => 'image',
                'return_format' => 'url',
            ),
            array(
                'key' => 'field_letter_title',
                'label' => 'Tiêu đề lời nhắn',
                'name' => 'letter_title',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => "MÂY MÂY -<br>TÓC SẠCH, DA THƠM",
            ),
            array(
                'key' => 'field_letter_body',
                'label' => 'Nội dung chữ tự gõ (Đoạn chính)',
                'name' => 'letter_body',
                'type' => 'textarea',
                'rows' => 8,
                'default_value' => "Trải qua ba lần sinh nở trước tuổi 30, chị Mai hiểu rằng, hành trình làm mẹ không chỉ có niềm vui đón con mà còn là những tháng ngày người mẹ cần được chăm sóc và nâng niu.\n\nTừ kiến thức chuyên môn và nhiều năm tháng đồng hành cùng các thai phụ & sản phụ, chị Mai tìm về những bí quyết chăm sóc bí truyền với các nguyên liệu thân thuộc từ gừng, nghệ và thảo mộc. Nhưng việc chuẩn bị cầu kỳ mỗi ngày khiến chị trăn trở về phương pháp chăm sóc mẹ thuận tiện hơn.\n\nTừ đó, chị Mai đã tạo nên Mây Mây – thương hiệu chăm sóc mẹ từ tinh hoa thảo mộc, mong muốn mang đến những sản phẩm gần gũi, giúp mẹ chăm sóc tóc và làn da dễ dàng hơn trong kỳ ở cữ.",
            ),
            array(
                'key' => 'field_letter_hl',
                'label' => 'Câu chốt in đậm cuối cùng',
                'name' => 'letter_hl',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Bởi chị hiểu, sau những tháng ngày dành trọn yêu thương cho con, mẹ cũng xứng đáng được chăm sóc và yêu thương chính mình.',
            ),
            array(
                'key' => 'field_letter_voice',
                'label' => 'Link file âm thanh .mp3 đọc lời nhắn (tuỳ chọn)',
                'name' => 'letter_voice',
                'type' => 'text',
                'instructions' => 'Dán link file .mp3 để chữ tự gõ đồng bộ theo giọng đọc',
            ),

            // ==================== TAB 16: FOOTER & STICKY ====================
            array(
                'key' => 'field_tab_footer',
                'label' => 'Footer & Thanh Mua Nhanh',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_footer_logo',
                'label' => 'Logo chân trang',
                'name' => 'footer_logo',
                'type' => 'text',
                'default_value' => 'Home Care',
            ),
            array(
                'key' => 'field_footer_text',
                'label' => 'Thông tin bản quyền & Hotline chân trang',
                'name' => 'footer_text',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => 'Đẹp và Thật · Since 2008<br>Tổng đài 1900 0387 · Hotline 0962 131 515 – 0973 871 376',
            ),
            array(
                'key' => 'field_sticky_phone',
                'label' => 'Số điện thoại gọi tư vấn trên thanh cố định',
                'name' => 'sticky_phone',
                'type' => 'text',
                'default_value' => '0962131515',
            ),
            array(
                'key' => 'field_sticky_price',
                'label' => 'Mức giá trên thanh cố định',
                'name' => 'sticky_price',
                'type' => 'text',
                'default_value' => '99K',
            ),
            array(
                'key' => 'field_sticky_desc',
                'label' => 'Mô tả trên thanh cố định',
                'name' => 'sticky_desc',
                'type' => 'text',
                'default_value' => 'Combo dầu gội + sữa tắm · Freeship',
            ),
            array(
                'key' => 'field_sticky_btn_text',
                'label' => 'Chữ nút bấm thanh cố định',
                'name' => 'sticky_btn_text',
                'type' => 'text',
                'default_value' => 'Đặt ngay',
            ),
            array(
                'key' => 'field_sticky_btn_link',
                'label' => 'Link nút bấm thanh cố định',
                'name' => 'sticky_btn_link',
                'type' => 'text',
                'default_value' => '#dat-hang',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'lx-landing-settings',
                ),
            ),
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'front-page.php',
                ),
            ),
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ));
}
add_action('acf/init', 'lx_register_acf_landing_fields_group');

/**
 * Configure ACF JSON save & load points
 */
add_filter('acf/settings/save_json', function($path) {
    return LX_THEME_DIR . '/acf-json';
});
add_filter('acf/settings/load_json', function($paths) {
    $paths[] = LX_THEME_DIR . '/acf-json';
    return $paths;
});
