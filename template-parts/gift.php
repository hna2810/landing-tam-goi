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

$gift_default_sets = array(
    array(
        'name'     => 'SET TÂM GIAO',
        'ribbon'   => '',
        'img'      => 'https://cdn.hstatic.net/products/200001066686/dau-goi-gung-nghe-may-may-300ml_976748158c9548e5a917d6f1037d2dbe.png',
        'items'    => "Dầu gội Gừng Nghệ (300ml)\nSữa tắm Gừng Nghệ (300ml)\nHộp quà cao cấp & Thiệp viết tay",
        'price'    => '199.000đ',
        'data_set' => 'Set Tâm Giao – 199.000đ',
    ),
    array(
        'name'     => 'SET AN NHIÊN',
        'ribbon'   => '★ Chọn nhiều nhất',
        'img'      => 'https://cdn.hstatic.net/products/200001066686/combo-sua-tam-dau-goi-gung-nghe-may-may_37c9f5a7dbe9474d82a53a57c114c033.png',
        'items'    => "Dầu gội Gừng Nghệ (500ml)\nSữa tắm Gừng Nghệ (500ml)\nNước ủ gừng tươi (250ml)\nHộp quà cao cấp & Thiệp viết tay",
        'price'    => '299.000đ',
        'data_set' => 'Set An Nhiên – 299.000đ',
    ),
    array(
        'name'     => 'SET TRI ÂN',
        'ribbon'   => '',
        'img'      => 'https://cdn.hstatic.net/products/200001066686/sua-tam-gung-nghe-may-may-500ml_8029728340d44067aa56b610e29f48ae.png',
        'items'    => "Dầu gội Gừng Nghệ (500ml)\nSữa tắm Gừng Nghệ (500ml)\nTinh dầu xịt dưỡng bưởi gừng (100ml)\nHộp quà VIP & Túi vải thương hiệu",
        'price'    => '399.000đ',
        'data_set' => 'Set Tri Ân – 399.000đ',
    ),
    array(
        'name'     => 'SET ĐOÀN VIÊN',
        'ribbon'   => '',
        'img'      => 'https://cdn.hstatic.net/products/200001066686/combo-sua-tam-dau-goi-gung-nghe-may-may_37c9f5a7dbe9474d82a53a57c114c033.png',
        'items'    => "Bộ đôi đại 1000ml (gội + tắm)\nNước ủ tóc gừng tươi (500ml)\nXà bông gừng nghệ thủ công\nHộp gỗ khắc tên & Thiệp lụa",
        'price'    => '499.000đ',
        'data_set' => 'Set Đoàn Viên – 499.000đ',
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
        <div class="ltg-rv">
          <?php if (lx_has_content($gift_eyebrow)) : ?>
            <span class="ltg-eyebrow lx_wow_item"><?php echo esc_html($gift_eyebrow); ?></span>
          <?php endif; ?>
          <?php if (lx_has_content($gift_title)) : ?>
            <h2 class="ltg-h2 lx_wow_item"><?php echo wp_kses_post($gift_title); ?></h2>
          <?php endif; ?>
          <?php if (lx_has_content($gift_lead)) : ?>
            <p class="ltg-lead lx_wow_item"><?php echo esc_html($gift_lead); ?></p>
          <?php endif; ?>
        </div>

        <div class="ltg-rv">
          <div class="ltg-count" id="ltgCount">
            <div><b data-d>00</b><small>Ngày</small></div>
            <div><b data-h>00</b><small>Giờ</small></div>
            <div><b data-m>00</b><small>Phút</small></div>
            <div><b data-s>00</b><small>Giây</small></div>
          </div>
          <?php if (lx_has_content($gift_count_note)) : ?>
            <p class="ltg-count-note lx_wow_item"><?php echo wp_kses_post($gift_count_note); ?></p>
          <?php endif; ?>
        </div>
      </div>

      <?php if (!empty($gift_sets) && is_array($gift_sets)) : ?>
      <div class="ltg-sets ltg-sets--4">
        <?php foreach ($gift_sets as $set) :
            if (empty($set['name'])) continue;
            $is_hot = !empty($set['ribbon']) ? ' ltg-set--hot' : '';
            $items_arr = !empty($set['items']) ? explode("\n", str_replace("\r", "", $set['items'])) : array();
            $img = !empty($set['img']) ? (is_array($set['img']) ? ($set['img']['url'] ?? '') : (is_numeric($set['img']) ? wp_get_attachment_image_url($set['img'], 'full') : $set['img'])) : '';
        ?>
          <div class="ltg-set<?php echo esc_attr($is_hot); ?> ltg-rv">
            <?php if (!empty($set['ribbon'])) : ?>
              <span class="ltg-ribbon"><?php echo esc_html($set['ribbon']); ?></span>
            <?php endif; ?>
            <?php if (!empty($img)) : ?>
              <div class="ltg-set-img">
                <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($set['name']); ?>" loading="lazy">
              </div>
            <?php endif; ?>
            <div class="ltg-set-body">
              <h3 class="lx_wow_item"><?php echo esc_html($set['name']); ?></h3>
              <?php if (!empty($items_arr)) : ?>
              <ul class="ltg-set-items">
                <?php foreach ($items_arr as $it) :
                    if (trim($it) === '') continue;
                ?>
                  <li class="lx_wow_item"><span><?php echo esc_html(trim($it)); ?></span></li>
                <?php endforeach; ?>
              </ul>
              <?php endif; ?>
              <?php if (!empty($set['price'])) : ?>
              <div class="ltg-set-price">
                <small class="lx_wow_item">Giá niêm yết:</small>
                <b class="lx_wow_item"><?php echo esc_html($set['price']); ?></b>
              </div>
              <?php endif; ?>
              <a href="#dat-hang" class="ltg-btn ltg-btn--ghost lx_wow_item" data-set="<?php echo esc_attr($set['data_set'] ?? $set['name']); ?>">
                Chọn set này
              </a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>

      <div class="ltg-gift-perks ltg-rv">
        <div class="lx_wow_item"><i><svg width="24" height="24"><use href="#i-box"/></svg></i><div><b>Hộp quà sang trọng</b><small>Thiết kế tinh tế, chỉn chu</small></div></div>
        <div class="lx_wow_item"><i><svg width="24" height="24"><use href="#i-pen"/></svg></i><div><b>Thiệp viết tay ý nghĩa</b><small>Ghi lời chúc theo yêu cầu</small></div></div>
        <div class="lx_wow_item"><i><svg width="24" height="24"><use href="#i-truck"/></svg></i><div><b>Giao hoả tốc đúng ngày</b><small>Freeship toàn quốc từ 2 set</small></div></div>
      </div>
    </div>
  </section>
