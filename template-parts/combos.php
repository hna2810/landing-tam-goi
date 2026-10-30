<?php
/**
 * Combo Offers Section Template Part
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$combo_title = lx_get_field('combo_title', 'option', "Combo ưu đãi trải nghiệm");

$combo_default_items = array(
    array(
        'key'    => 'c1',
        'name'   => 'Combo 1: Dầu Gội Gừng Nghệ Mây Mây',
        'desc'   => 'Dung tích 300ml · Tặng kèm túi đựng thảo mộc · Freeship toàn quốc',
        'price'  => '199.000đ',
        'img'    => get_template_directory_uri() . '/assets/images/real/combo-01-trai-nghiem.jpg',
        'is_hot' => false,
    ),
    array(
        'key'    => 'c2',
        'name'   => 'Combo 2: Sữa Tắm Gừng Nghệ Mây Mây',
        'desc'   => 'Dung tích 500ml · Tặng kèm bông tắm xơ mướp tự nhiên · Freeship toàn quốc',
        'price'  => '229.000đ',
        'img'    => get_template_directory_uri() . '/assets/images/real/combo-02-ban-chay.jpg',
        'is_hot' => false,
    ),
    array(
        'key'    => 'c3',
        'name'   => 'Combo 3: Trọn Bộ Tắm Gội Gừng Nghệ (HOT)',
        'desc'   => '1 Chai Dầu Gội 300ml + 1 Chai Sữa Tắm 500ml · Tặng trọn bộ quà tri ân · Tiết kiệm 151.000đ',
        'price'  => '399.000đ',
        'img'    => get_template_directory_uri() . '/assets/images/real/combo-03-tiet-kiem.jpg',
        'is_hot' => true,
    ),
);
$combo_items = lx_get_field('combo_items', 'option', $combo_default_items);
if (!is_array($combo_items)) {
    $combo_items = array();
}

$has_combos = lx_has_content($combo_title) || (!empty($combo_items) && is_array($combo_items));
if (!$has_combos) {
    return;
}
?>

  <section class="ltg-sec ltg-pk-sec" id="combo">
    <div class="ltg-wrap">
      <?php if (lx_has_content($combo_title)) : ?>
      <div class="ltg-center">
        <span class="ltg-eyebrow">Ưu đãi độc quyền</span>
        <h2 class="ltg-h2 ltg-h2--md"><?php echo esc_html($combo_title); ?></h2>
      </div>
      <?php endif; ?>

      <?php if (!empty($combo_items) && is_array($combo_items)) : ?>
      <div class="ltg-pks">
        <?php 
        $cb_fallbacks = array(
            0 => get_template_directory_uri() . '/assets/images/real/combo-01-trai-nghiem.jpg',
            1 => get_template_directory_uri() . '/assets/images/real/combo-02-ban-chay.jpg',
            2 => get_template_directory_uri() . '/assets/images/real/combo-03-tiet-kiem.jpg',
        );

        foreach ($combo_items as $idx => $cb) :
            if (empty($cb['name'])) continue;
            $k   = !empty($cb['key']) ? $cb['key'] : ('c' . ($idx + 1));
            $hot = (!empty($cb['is_hot']) || strpos($cb['name'], '(HOT)') !== false || $idx === 2) ? ' ltg-pk--hot' : '';
            
            // Image resolution
            $img = !empty($cb['img']) ? (is_array($cb['img']) ? ($cb['img']['url'] ?? '') : (is_numeric($cb['img']) ? wp_get_attachment_image_url($cb['img'], 'full') : $cb['img'])) : '';
            if (empty($img) || strpos($img, 'hstatic.net') !== false) {
                if (isset($cb_fallbacks[$idx])) {
                    $img = $cb_fallbacks[$idx];
                }
            }

            // Split title and tag if present (e.g. "Combo 1: Dầu Gội Gừng Nghệ Mây Mây")
            $raw_name = $cb['name'];
            $tag = 'COMBO ' . ($idx + 1);
            $clean_name = $raw_name;
            if (preg_match('/^(Combo\s*\d+)\s*:\s*(.*)$/ui', $raw_name, $matches)) {
                $tag = mb_strtoupper($matches[1], 'UTF-8');
                $clean_name = $matches[2];
            }
            if (!empty($hot) && strpos($tag, 'HOT') === false) {
                $tag .= ' · BÁN CHẠY';
            }
        ?>
          <a href="#dat-hang" class="ltg-pk<?php echo esc_attr($hot); ?>" data-combo="<?php echo esc_attr($k); ?>">
            <div class="ltg-pk-top">
              <span class="ltg-pk-tag"><?php echo esc_html($tag); ?></span>
              <h3 class="ltg-pk-name"><?php echo esc_html($clean_name); ?></h3>
            </div>

            <!-- Thay phần mô tả bằng hình ảnh thực tế của combo -->
            <div class="ltg-pk-img-box">
              <?php if (!empty($img)) : ?>
                <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($clean_name); ?>" loading="lazy" class="ltg-pk-img">
              <?php endif; ?>
            </div>

            <div class="ltg-pk-foot">
              <?php if (!empty($cb['price'])) : ?>
                <div class="ltg-pk-price">
                  <small>Giá ưu đãi:</small>
                  <b><?php echo esc_html($cb['price']); ?></b>
                </div>
              <?php endif; ?>
              <span class="ltg-pk-btn">
                Đặt ngay
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
              </span>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>
  </section>
