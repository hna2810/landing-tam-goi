<?php
/**
 * 6 Golden Ingredients Section Template Part
 * "Sự kết hợp hoàn hảo của các thành phần thảo mộc và dưỡng chất vàng"
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$ing_eyebrow = lx_get_field('ing_eyebrow', 'option', "CÔNG THỨC ĐỘC QUYỀN HOME CARE");
if (empty($ing_eyebrow)) {
    $ing_eyebrow = "CÔNG THỨC ĐỘC QUYỀN HOME CARE";
}

$ing_title   = lx_get_field('ing_title', 'option', "Sự kết hợp hoàn hảo của các thành phần thảo mộc và dưỡng chất vàng");
if (empty($ing_title)) {
    $ing_title = "Sự kết hợp hoàn hảo của các thành phần thảo mộc và dưỡng chất vàng";
}

$ing_lead    = lx_get_field('ing_lead', 'option', "Sự giao thoa trọn vẹn giữa bí quyết thảo mộc cổ truyền và các dưỡng chất khoa học chuyên sâu, mang lại hiệu quả phục hồi tóc và nuôi dưỡng làn da tối ưu.");
if (empty($ing_lead)) {
    $ing_lead = "Sự giao thoa trọn vẹn giữa bí quyết thảo mộc cổ truyền và các dưỡng chất khoa học chuyên sâu, mang lại hiệu quả phục hồi tóc và nuôi dưỡng làn da tối ưu.";
}

$default_ingredients = array(
    array(
        'name'      => 'Gừng tươi',
        'badge'     => 'Thảo mộc tự nhiên',
        'badge_cls' => 'ltg-ing6-badge--herb',
        'img'       => get_template_directory_uri() . '/assets/images/real/ing-01-gung.jpg',
        'desc'      => 'Giữ ấm cơ thể, hỗ trợ tăng tuần hoàn máu dưới da đầu, giảm đau nhức và nuôi dưỡng chân tóc chắc khỏe.',
        'highlight' => 'Giữ ấm cơ thể · Tuần hoàn máu · Chắc chân tóc',
    ),
    array(
        'name'      => 'Nghệ tươi',
        'badge'     => 'Thảo mộc tự nhiên',
        'badge_cls' => 'ltg-ing6-badge--herb',
        'img'       => get_template_directory_uri() . '/assets/images/real/ing-02-nghe.jpg',
        'desc'      => 'Kháng khuẩn tự nhiên, hỗ trợ làm mờ vết thâm, làm sáng da và chống oxy hóa cho làn da sau sinh.',
        'highlight' => 'Kháng khuẩn · Mờ thâm nám · Chống oxy hóa',
    ),
    array(
        'name'      => 'Chiết xuất bưởi',
        'badge'     => 'Thảo mộc tự nhiên',
        'badge_cls' => 'ltg-ing6-badge--herb',
        'img'       => get_template_directory_uri() . '/assets/images/real/ing-03-buoi.jpg',
        'desc'      => 'Nuôi dưỡng nang tóc chắc khỏe, kích mọc tóc con, giảm thiểu tình trạng tóc gãy rụng và mang lại hương thơm dễ chịu.',
        'highlight' => 'Nuôi nang tóc · Kích mọc tóc · Giảm gãy rụng',
    ),
    array(
        'name'      => 'Vitamin B5',
        'badge'     => 'Dưỡng chất vàng',
        'badge_cls' => 'ltg-ing6-badge--gold',
        'img'       => get_template_directory_uri() . '/assets/images/real/ing-04-vitamin-b5.jpg',
        'desc'      => 'Cung cấp độ ẩm cho tóc và da đầu, phục hồi mái tóc khô xơ, hư tổn, giúp tóc suôn mượt và bồng bềnh.',
        'highlight' => 'Cấp ẩm sâu · Phục hồi hư tổn · Tóc bồng bềnh',
    ),
    array(
        'name'      => 'Vitamin B3',
        'badge'     => 'Dưỡng chất vàng',
        'badge_cls' => 'ltg-ing6-badge--gold',
        'img'       => get_template_directory_uri() . '/assets/images/real/ing-05-vitamin-b3.jpg',
        'desc'      => 'Tăng cường hàng rào bảo vệ da, cải thiện độ đàn hồi, làm đều màu da và nuôi dưỡng làn da cơ thể sáng mịn.',
        'highlight' => 'Bảo vệ da · Cải thiện đàn hồi · Sáng mịn da',
    ),
    array(
        'name'      => 'Dâu tằm',
        'badge'     => 'Dưỡng chất vàng',
        'badge_cls' => 'ltg-ing6-badge--gold',
        'img'       => get_template_directory_uri() . '/assets/images/real/ing-06-dau-tam.jpg',
        'desc'      => 'Làm dịu da, cung cấp các dưỡng chất chống oxy hóa tự nhiên, hỗ trợ làm sáng và duy trì độ ẩm mịn màng cho làn da.',
        'highlight' => 'Làm dịu da · Dưỡng ẩm mịn màng · Chống oxy hóa',
    ),
);

$ingredients_items = lx_get_field('ingredients_items', 'option', $default_ingredients);

$has_valid_item = false;
if (is_array($ingredients_items) && !empty($ingredients_items)) {
    foreach ($ingredients_items as $it) {
        if (!empty($it['name'])) {
            $has_valid_item = true;
            break;
        }
    }
}
if (!$has_valid_item) {
    $ingredients_items = $default_ingredients;
}
?>

  <section class="ltg-sec ltg-ing6-sec" id="thanh-phan">
    <div class="ltg-wrap">
      
      <!-- Header Section -->
      <div class="ltg-center ltg-ing6-head">
        <?php if (lx_has_content($ing_eyebrow)) : ?>
          <span class="ltg-eyebrow"><?php echo esc_html($ing_eyebrow); ?></span>
        <?php endif; ?>
        <?php if (lx_has_content($ing_title)) : ?>
          <h2 class="ltg-h2 ltg-ing6-title"><?php echo wp_kses_post($ing_title); ?></h2>
        <?php endif; ?>
        <?php if (lx_has_content($ing_lead)) : ?>
          <p class="ltg-lead ltg-ing6-lead"><?php echo esc_html($ing_lead); ?></p>
        <?php endif; ?>
      </div>

      <!-- Grid 6 Thành phần -->
      <div class="ltg-ing6-grid">
        <?php foreach ($ingredients_items as $idx => $item) : 
            $name      = !empty($item['name']) ? $item['name'] : (isset($default_ingredients[$idx]['name']) ? $default_ingredients[$idx]['name'] : '');
            $badge     = !empty($item['badge']) ? $item['badge'] : (isset($default_ingredients[$idx]['badge']) ? $default_ingredients[$idx]['badge'] : '');
            $badge_cls = !empty($item['badge_cls']) ? $item['badge_cls'] : ($idx < 3 ? 'ltg-ing6-badge--herb' : 'ltg-ing6-badge--gold');
            $img       = !empty($item['img']) ? $item['img'] : (isset($default_ingredients[$idx]['img']) ? $default_ingredients[$idx]['img'] : '');
            
            if (is_numeric($img) && $img > 0) {
                $img = wp_get_attachment_image_url($img, 'full');
            } elseif (is_array($img) && !empty($img['url'])) {
                $img = $img['url'];
            }
            if (empty($img) && isset($default_ingredients[$idx]['img'])) {
                $img = $default_ingredients[$idx]['img'];
            }

            $desc      = !empty($item['desc']) ? $item['desc'] : (isset($default_ingredients[$idx]['desc']) ? $default_ingredients[$idx]['desc'] : '');
            $hl        = !empty($item['highlight']) ? $item['highlight'] : (isset($default_ingredients[$idx]['highlight']) ? $default_ingredients[$idx]['highlight'] : '');
            
            if (empty($name)) continue;
        ?>
          <div class="ltg-ing6-card">
            <div class="ltg-ing6-visual">
              <div class="ltg-ing6-avatar-wrap">
                <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($name); ?>" class="ltg-ing6-avatar" loading="lazy">
                <span class="ltg-ing6-num" aria-hidden="true"><?php echo esc_html(sprintf('%02d', $idx + 1)); ?></span>
              </div>
            </div>

            <div class="ltg-ing6-body">
              <div class="ltg-ing6-meta">
                <span class="ltg-ing6-badge <?php echo esc_attr($badge_cls); ?>"><?php echo esc_html($badge); ?></span>
              </div>

              <h3 class="ltg-ing6-name"><?php echo esc_html($name); ?></h3>

              <?php if (!empty($hl)) : ?>
                <div class="ltg-ing6-hl">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg>
                  <span><?php echo esc_html($hl); ?></span>
                </div>
              <?php endif; ?>

              <p class="ltg-ing6-desc"><?php echo esc_html($desc); ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Swipe indicator on mobile -->
      <div class="ltg-swipe ltg-ing6-swipe" aria-hidden="true">
        <span>Vuốt sang để xem 6 thành phần</span>
        <i></i>
      </div>

    </div>
  </section>
