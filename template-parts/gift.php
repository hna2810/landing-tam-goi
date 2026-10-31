<?php
/**
 * 20/11 Gift Sets Section Template Part
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$gift_eyebrow    = lx_get_field('gift_eyebrow', 'option', "Mùa tri ân 20/11");
$gift_title      = lx_get_field('gift_title', 'option', "Gửi thầy cô một món quà<br>chăm sóc từ thảo mộc");
$gift_lead       = lx_get_field('gift_lead', 'option', "Thay lời tri ân sâu sắc gửi đến những người lái đò thầm lặng bằng bộ quà tặng từ thảo mộc tự nhiên, gói trọn sự ấm áp và chân thành.");
$gift_count_note = lx_get_field('gift_count_note', 'option', "Đặt trước <b>17/11</b> để nhận quà kịp ngày 20/11");
$gift_mobile_img = lx_get_image_url('gift_mobile_img', get_template_directory_uri() . '/assets/images/real/gift-box-mobile.jpg', 'large', 'option');
if (empty($gift_mobile_img) || strpos($gift_mobile_img, 'hstatic.net') !== false) {
    $gift_mobile_img = get_template_directory_uri() . '/assets/images/real/gift-box-mobile.jpg';
}

$gift_default_sets = array(
    array(
        'name'     => 'Set Tri Ân 1 (300ml)',
        'ribbon'   => 'GỢI Ý TẶNG CÔ',
        'img'      => 'https://tamgoigungnghe.homecarevietnam.com/wp-content/uploads/2026/10/1793430464436_1660716325371320973_g464639762284770803_c84f1f1acbd3517df19d9197c3a68f7c.jpg',
        'items'    => "1 Dầu gội Gừng Nghệ (300ml)\n1 Sữa tắm Gừng Nghệ (300ml)\n1 Nước ủ tóc Gừng Tươi (300ml)\n🎁 TẶNG 1 Xịt khử mùi 30ml\n🎁 TẶNG 1 Xịt dưỡng tóc 30ml\nHộp quà cao cấp & Thiệp chúc mừng\n🚚 Freeship toàn quốc",
        'price'    => '199.000đ',
        'data_set' => 'Set Tri Ân 1 (300ml) – 199.000đ',
    ),
    array(
        'name'     => 'Set Tri Ân 2 (500ml)',
        'ribbon'   => '★ BÁN CHẠY NHẤT',
        'img'      => 'https://tamgoigungnghe.homecarevietnam.com/wp-content/uploads/2026/10/1793430464435_1660716325371320973_g464639762284770803_adbd45abc87877c9b23858367ed8f7a8.jpg',
        'items'    => "1 Dầu gội Gừng Nghệ (500ml)\n1 Sữa tắm Gừng Nghệ (500ml)\n1 Nước ủ tóc Gừng Tươi (500ml)\n🎁 TẶNG 1 Xịt khử mùi 100ml\n🎁 TẶNG Dung dịch vệ sinh 200ml\nHộp quà cao cấp & Thiệp chúc mừng\n🚚 Freeship toàn quốc",
        'price'    => '349.000đ',
        'data_set' => 'Set Tri Ân 2 (500ml) – 349.000đ',
    ),
    array(
        'name'     => 'Set Tri Ân 3 (1000ml)',
        'ribbon'   => 'SIÊU TIẾT KIỆM',
        'img'      => 'https://tamgoigungnghe.homecarevietnam.com/wp-content/uploads/2026/10/1793430464437_1660716325371320973_g464639762284770803_b2dfd84335e12bb6b80d167cd9fee953.jpg',
        'items'    => "1 Dầu gội Gừng Nghệ (1000ml)\n1 Sữa tắm Gừng Nghệ (1000ml)\n1 Nước ủ tóc Gừng Tươi (1000ml)\n🎁 TẶNG 1 Xịt khử mùi 30ml\n🎁 TẶNG 1 Xịt khử mùi 100ml\nHộp quà VIP cao cấp & Thiệp chúc mừng\n🚚 Freeship toàn quốc",
        'price'    => '499.000đ',
        'data_set' => 'Set Tri Ân 3 (1000ml) – 499.000đ',
    ),
);
$gift_sets = lx_get_field('gift_sets', 'option', $gift_default_sets);
if (!is_array($gift_sets)) {
    $gift_sets = array();
}

$has_gift = lx_has_content($gift_title) || (!empty($gift_sets) && is_array($gift_sets));
if (!$has_gift) {
    return;
}
?>

  <section class="ltg-sec ltg-gift" id="qua-20-11">
    <div class="ltg-wave ltg-wave--top" style="--c:#fff6dc"></div>
    <div class="ltg-wave ltg-wave--bot" style="--c:#fffcf3"></div>
    <div class="ltg-petals" aria-hidden="true">
      <i style="left:41%;animation-duration:13s;animation-delay:-12s"></i>
      <i style="left:83%;animation-duration:11s;animation-delay:-2s"></i>
      <i style="left:68%;animation-duration:12s;animation-delay:-11s"></i>
      <i style="left:74%;animation-duration:11s;animation-delay:-16s"></i>
      <i style="left:27%;animation-duration:11s;animation-delay:-2s"></i>
      <i style="left:55%;animation-duration:17s;animation-delay:-2s"></i>
      <i style="left:30%;animation-duration:12s;animation-delay:-17s"></i>
      <i style="left:54%;animation-duration:11s;animation-delay:-18s"></i>
      <i style="left:15%;animation-duration:14s;animation-delay:-18s"></i>
      <i style="left:7%;animation-duration:20s;animation-delay:-18s"></i>
      <i style="left:50%;animation-duration:11s;animation-delay:-7s"></i>
      <i style="left:5%;animation-duration:19s;animation-delay:-4s"></i>
      <i style="left:37%;animation-duration:17s;animation-delay:-4s"></i>
      <i style="left:69%;animation-duration:12s;animation-delay:-18s"></i>
      <i style="left:39%;animation-duration:19s;animation-delay:-5s"></i>
      <i style="left:13%;animation-duration:20s;animation-delay:-18s"></i>
    </div>

    <div class="ltg-wrap">
      <div class="ltg-gift-head">
        <div>
          <?php if (lx_has_content($gift_eyebrow)) : ?>
            <span class="ltg-eyebrow"><?php echo esc_html($gift_eyebrow); ?></span>
          <?php endif; ?>
          <?php if (lx_has_content($gift_title)) : ?>
            <h2 class="ltg-h2"><?php echo wp_kses_post($gift_title); ?></h2>
          <?php endif; ?>
          <?php if (lx_has_content($gift_lead)) : ?>
            <p class="ltg-lead"><?php echo esc_html($gift_lead); ?></p>
          <?php endif; ?>
        </div>

        <div>
          <div class="ltg-count" id="ltgCount">
            <div><b data-d>00</b><small>Ngày</small></div>
            <div><b data-h>00</b><small>Giờ</small></div>
            <div><b data-m>00</b><small>Phút</small></div>
            <div><b data-s>00</b><small>Giây</small></div>
          </div>
          <?php if (lx_has_content($gift_count_note)) : ?>
            <p class="ltg-count-note"><?php echo wp_kses_post($gift_count_note); ?></p>
          <?php endif; ?>
        </div>
      </div>

      <!-- Mobile Square Banner -->
      <?php if (!empty($gift_mobile_img)) : ?>
      <div class="ltg-gift-mob-banner">
        <div class="ltg-gift-mob-frame">
          <img src="<?php echo esc_url($gift_mobile_img); ?>" alt="<?php echo esc_attr(strip_tags($gift_title)); ?>" loading="lazy">
        </div>
      </div>
      <?php endif; ?>

      <?php if (!empty($gift_sets) && is_array($gift_sets)) : ?>
      <div class="ltg-sets">
        <?php foreach ($gift_sets as $set) :
            if (empty($set['name'])) continue;
            $is_hot = !empty($set['ribbon']) ? ' ltg-set--hot' : '';
            $items_arr = !empty($set['items']) ? explode("\n", str_replace("\r", "", $set['items'])) : array();
            $img = !empty($set['img']) ? (is_array($set['img']) ? ($set['img']['url'] ?? '') : (is_numeric($set['img']) ? wp_get_attachment_image_url($set['img'], 'full') : $set['img'])) : '';
            $btn_cls = !empty($set['ribbon']) ? 'ltg-btn--pri' : 'ltg-btn--ghost';
        ?>
          <div class="ltg-set<?php echo esc_attr($is_hot); ?>">
            <?php if (!empty($img)) : ?>
              <div class="ltg-set-img">
                <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($set['name']); ?>" loading="lazy">
              </div>
            <?php endif; ?>
            <div class="ltg-set-body">
              <?php if (!empty($set['ribbon'])) : ?>
                <div class="ltg-set-ribbon-wrap">
                  <span class="ltg-ribbon"><?php echo esc_html($set['ribbon']); ?></span>
                </div>
              <?php endif; ?>
              <h3><?php echo esc_html($set['name']); ?></h3>
              <?php if (!empty($items_arr)) : ?>
              <ul class="ltg-set-items">
                <?php foreach ($items_arr as $it) :
                    if (trim($it) === '') continue;
                ?>
                  <li><span><?php echo esc_html(trim($it)); ?></span></li>
                <?php endforeach; ?>
              </ul>
              <?php endif; ?>
              <?php if (!empty($set['price'])) : ?>
              <div class="ltg-set-price">
                <small>Giá niêm yết:</small>
                <b><?php echo esc_html($set['price']); ?></b>
              </div>
              <?php endif; ?>
              <a href="#dat-hang" class="ltg-btn <?php echo esc_attr($btn_cls); ?>" data-set="<?php echo esc_attr($set['data_set'] ?? $set['name']); ?>">
                Chọn set này
              </a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="ltg-swipe">Vuốt để xem thêm <i></i></div>
      <?php endif; ?>
    </div>
  </section>
