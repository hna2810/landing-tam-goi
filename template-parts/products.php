<?php
/**
 * Products / Before-After Section Template Part
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$ba_eyebrow   = lx_get_field('ba_eyebrow', 'option', "Hình ảnh trực quan (Trước &amp; Sau khi sử dụng)");
$ba_title     = lx_get_field('ba_title', 'option', "Phục hồi mái tóc bồng bềnh, sạch gàu ngứa và nuôi dưỡng làn da cơ thể mịn màng cùng Bộ đôi Tắm Gội Gừng Nghệ Mây Mây");
$ba_lead      = lx_get_field('ba_lead', 'option', "Công thức độc quyền từ tinh hoa thảo mộc Gừng, Nghệ");

// Tab 1: Dầu Gội
$tab1_name       = lx_get_field('tab1_name', 'option', "Dầu Gội Gừng Nghệ Mây Mây");
$tab1_icon       = lx_get_image_url('tab1_icon', 'https://cdn.hstatic.net/products/200001066686/dau-goi-gung-nghe-may-may-300ml_976748158c9548e5a917d6f1037d2dbe.png', 'thumbnail', 'option');
$tab1_bad_h      = lx_get_field('tab1_bad_h', 'option', "Trước khi dùng");
$tab1_bad_items  = lx_get_field('tab1_bad_items', 'option', array(
    array('text' => 'Tóc rụng từng nắm mỗi lần gội/chải, vuốt nhẹ cũng rụng.'),
    array('text' => 'Da đầu gàu ngứa, nhanh bết dính dù mới gội.'),
    array('text' => 'Mái tóc khô xơ, chẻ ngọn, lộ rõ da đầu mỏng.'),
));
$tab1_good_h     = lx_get_field('tab1_good_h', 'option', "Sau khi dùng");
$tab1_good_items = lx_get_field('tab1_good_items', 'option', array(
    array('text' => 'Giảm rụng tóc, nang tóc chắc khỏe.'),
    array('text' => 'Da đầu sạch thoáng, hết ngứa.'),
    array('text' => 'Tóc con mọc tua tủa sau 2–4 tuần sử dụng.'),
));
$tab1_img        = lx_get_image_url('tab1_img', 'https://cdn.hstatic.net/products/200001066686/dau-goi-gung-nghe-may-may-300ml_976748158c9548e5a917d6f1037d2dbe.png', 'medium', 'option');
$tab1_quote      = lx_get_field('tab1_quote', 'option', "“Tóc mọc tua tủa – Kích mở nang tóc”");

// Tab 2: Sữa Tắm
$tab2_name       = lx_get_field('tab2_name', 'option', "Sữa Tắm Gừng Nghệ Mây Mây");
$tab2_icon       = lx_get_image_url('tab2_icon', 'https://cdn.hstatic.net/products/200001066686/sua-tam-gung-nghe-may-may-500ml_8029728340d44067aa56b610e29f48ae.png', 'thumbnail', 'option');
$tab2_bad_h      = lx_get_field('tab2_bad_h', 'option', "Trước khi dùng");
$tab2_bad_items  = lx_get_field('tab2_bad_items', 'option', array(
    array('text' => 'Mụn lưng, viêm nang lông sần sùi ngứa ngáy.'),
    array('text' => 'Vết thâm mụn chi chít khắp lưng và ngực.'),
    array('text' => 'Da khô ráp, bong tróc và thiếu ẩm.'),
));
$tab2_good_h     = lx_get_field('tab2_good_h', 'option', "Sau khi dùng");
$tab2_good_items = lx_get_field('tab2_good_items', 'option', array(
    array('text' => 'Mụn lưng lặn dần, giảm viêm rõ rệt.'),
    array('text' => 'Mờ thâm mụn, da đều màu và sáng mịn.'),
    array('text' => 'Cấp ẩm sâu, da mềm mượt không còn khô căng.'),
));
$tab2_img        = lx_get_image_url('tab2_img', 'https://cdn.hstatic.net/products/200001066686/sua-tam-gung-nghe-may-may-500ml_8029728340d44067aa56b610e29f48ae.png', 'medium', 'option');
$tab2_quote      = lx_get_field('tab2_quote', 'option', "“Da sạch, mềm mịn, mờ thâm”");

$has_products = lx_has_content($ba_title) || lx_has_content($tab1_name) || lx_has_content($tab2_name);
if (!$has_products) {
    return;
}
?>

  <section class="ltg-sec ltg-ba2" id="san-pham">
    <div class="ltg-wrap">
      <div class="ltg-center ltg-rv">
        <?php if (lx_has_content($ba_eyebrow)) : ?>
          <span class="ltg-eyebrow lx_wow_item"><?php echo esc_html($ba_eyebrow); ?></span>
        <?php endif; ?>
        <?php if (lx_has_content($ba_title)) : ?>
          <h2 class="ltg-h2 ltg-h2--md lx_wow_item"><?php echo wp_kses_post($ba_title); ?></h2>
        <?php endif; ?>
        <?php if (lx_has_content($ba_lead)) : ?>
          <p class="ltg-lead lx_wow_item"><?php echo esc_html($ba_lead); ?></p>
        <?php endif; ?>
      </div>

      <div class="ltg-ba2-tabs ltg-rv">
        <?php if (lx_has_content($tab1_name)) : ?>
          <button type="button" class="ltg-ba2-tab is-on lx_wow_item" data-ba="dg">
            <?php if (!empty($tab1_icon)) : ?>
              <img src="<?php echo esc_url($tab1_icon); ?>" alt="" width="26" height="26">
            <?php endif; ?>
            <span><?php echo esc_html($tab1_name); ?></span>
          </button>
        <?php endif; ?>

        <?php if (lx_has_content($tab2_name)) : ?>
          <button type="button" class="ltg-ba2-tab <?php echo !lx_has_content($tab1_name) ? 'is-on' : ''; ?> lx_wow_item" data-ba="st">
            <?php if (!empty($tab2_icon)) : ?>
              <img src="<?php echo esc_url($tab2_icon); ?>" alt="" width="26" height="26">
            <?php endif; ?>
            <span><?php echo esc_html($tab2_name); ?></span>
          </button>
        <?php endif; ?>
      </div>

      <?php if (lx_has_content($tab1_name)) : ?>
      <div class="ltg-ba2-p is-on" data-bap="dg">
        <div class="ltg-ba2-grid">
          <?php if (!empty($tab1_bad_items) && is_array($tab1_bad_items)) : ?>
          <div class="ltg-ba2-col ltg-ba2-col--bad ltg-rv ltg-l">
            <?php if (lx_has_content($tab1_bad_h)) : ?>
              <div class="h"><span class="badge badge--bad">✕</span><?php echo esc_html($tab1_bad_h); ?></div>
            <?php endif; ?>
            <ul>
              <?php foreach ($tab1_bad_items as $item) :
                  if (empty($item['text'])) continue;
              ?>
                <li class="lx_wow_item">✕ <?php echo esc_html($item['text']); ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
          <?php endif; ?>

          <?php if (!empty($tab1_img) || lx_has_content($tab1_quote)) : ?>
          <div class="ltg-ba2-col ltg-ba2-col--mid ltg-rv ltg-z">
            <?php if (!empty($tab1_img)) : ?>
              <img src="<?php echo esc_url($tab1_img); ?>" alt="<?php echo esc_attr($tab1_name); ?>" loading="lazy">
            <?php endif; ?>
            <?php if (lx_has_content($tab1_quote)) : ?>
              <p class="ltg-ba2-quote lx_wow_item"><?php echo esc_html($tab1_quote); ?></p>
            <?php endif; ?>
          </div>
          <?php endif; ?>

          <?php if (!empty($tab1_good_items) && is_array($tab1_good_items)) : ?>
          <div class="ltg-ba2-col ltg-ba2-col--good ltg-rv ltg-r">
            <?php if (lx_has_content($tab1_good_h)) : ?>
              <div class="h"><span class="badge badge--good">✓</span><?php echo esc_html($tab1_good_h); ?></div>
            <?php endif; ?>
            <ul>
              <?php foreach ($tab1_good_items as $item) :
                  if (empty($item['text'])) continue;
              ?>
                <li class="lx_wow_item">✓ <?php echo esc_html($item['text']); ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
          <?php endif; ?>
        </div>
      </div>
      <?php endif; ?>

      <?php if (lx_has_content($tab2_name)) : ?>
      <div class="ltg-ba2-p <?php echo !lx_has_content($tab1_name) ? 'is-on' : ''; ?>" data-bap="st">
        <div class="ltg-ba2-grid">
          <?php if (!empty($tab2_bad_items) && is_array($tab2_bad_items)) : ?>
          <div class="ltg-ba2-col ltg-ba2-col--bad ltg-rv ltg-l">
            <?php if (lx_has_content($tab2_bad_h)) : ?>
              <div class="h"><span class="badge badge--bad">✕</span><?php echo esc_html($tab2_bad_h); ?></div>
            <?php endif; ?>
            <ul>
              <?php foreach ($tab2_bad_items as $item) :
                  if (empty($item['text'])) continue;
              ?>
                <li class="lx_wow_item">✕ <?php echo esc_html($item['text']); ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
          <?php endif; ?>

          <?php if (!empty($tab2_img) || lx_has_content($tab2_quote)) : ?>
          <div class="ltg-ba2-col ltg-ba2-col--mid ltg-rv ltg-z">
            <?php if (!empty($tab2_img)) : ?>
              <img src="<?php echo esc_url($tab2_img); ?>" alt="<?php echo esc_attr($tab2_name); ?>" loading="lazy">
            <?php endif; ?>
            <?php if (lx_has_content($tab2_quote)) : ?>
              <p class="ltg-ba2-quote lx_wow_item"><?php echo esc_html($tab2_quote); ?></p>
            <?php endif; ?>
          </div>
          <?php endif; ?>

          <?php if (!empty($tab2_good_items) && is_array($tab2_good_items)) : ?>
          <div class="ltg-ba2-col ltg-ba2-col--good ltg-rv ltg-r">
            <?php if (lx_has_content($tab2_good_h)) : ?>
              <div class="h"><span class="badge badge--good">✓</span><?php echo esc_html($tab2_good_h); ?></div>
            <?php endif; ?>
            <ul>
              <?php foreach ($tab2_good_items as $item) :
                  if (empty($item['text'])) continue;
              ?>
                <li class="lx_wow_item">✓ <?php echo esc_html($item['text']); ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
          <?php endif; ?>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </section>
