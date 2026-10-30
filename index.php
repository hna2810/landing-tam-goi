<?php
/**
 * Main Landing Page Template
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

// 1. Hero & Trust Bar
get_template_part('template-parts/hero');

// 2. Nỗi lo về tóc & da
get_template_part('template-parts/pain');

// 3. Sản phẩm & Trước / Sau
get_template_part('template-parts/products');

// 4. Câu chuyện thảo mộc & Marquee
get_template_part('template-parts/story');

// 5. Quy trình đun nấu & Video
get_template_part('template-parts/process');

// 6. 6 Thành phần thảo mộc & Dưỡng chất vàng
get_template_part('template-parts/ingredients');

// 7. 3 Bước chăm sóc da & tóc
get_template_part('template-parts/steps');

// 8. Minh bạch & Hồ sơ y tế
get_template_part('template-parts/transparency');

// 9. Đánh giá khách hàng
get_template_part('template-parts/reviews');

// 10. Combo ưu đãi
get_template_part('template-parts/combos');

// 11. Quà tặng 20/11 tri ân
get_template_part('template-parts/gift');

// 12. Form đặt hàng trực tiếp
get_template_part('template-parts/order');

// 13. Hỏi đáp FAQ
get_template_part('template-parts/faq');

// 14. Lời nhắn từ nhà sáng lập Mây Mây
get_template_part('template-parts/letter');

get_footer();
