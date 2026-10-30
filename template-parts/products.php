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
$tab1_icon       = lx_get_image_url('tab1_icon', get_template_directory_uri() . '/assets/images/real/prod-dau-goi.jpg', 'thumbnail', 'option');
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
$tab1_img        = lx_get_image_url('tab1_img', get_template_directory_uri() . '/assets/images/real/prod-dau-goi.jpg', 'medium', 'option');
$tab1_quote      = lx_get_field('tab1_quote', 'option', "“Tóc mọc tua tủa – Kích mở nang tóc”");

// Tab 2: Sữa Tắm
$tab2_name       = lx_get_field('tab2_name', 'option', "Sữa Tắm Gừng Nghệ Mây Mây");
$tab2_icon       = lx_get_image_url('tab2_icon', get_template_directory_uri() . '/assets/images/real/prod-sua-tam.jpg', 'thumbnail', 'option');
$tab2_bad_h      = lx_get_field('tab2_bad_h', 'option', "Trước khi dùng");
$tab2_bad_items  = lx_get_field('tab2_bad_items', 'option', array(
    array('text' => 'Mụn viêm, mụn ẩn lan rộng ở lưng, ngực, vai.'),
    array('text' => 'Bít tắc lỗ chân lông do mồ hôi và dầu thừa.'),
    array('text' => 'Da khô căng, rát hoặc bong tróc sau khi tắm.'),
));
$tab2_good_h     = lx_get_field('tab2_good_h', 'option', "Sau khi dùng");
$tab2_good_items = lx_get_field('tab2_good_items', 'option', array(
    array('text' => 'Hỗ trợ giảm mụn lưng, mờ vết thâm mụn.'),
    array('text' => 'Len lỏi lỗ chân lông, sạch da, lỗ chân thông thoáng.'),
    array('text' => 'Da mềm mại, duy trì độ ẩm tự nhiên và thơm dịu.'),
));
$tab2_img        = lx_get_image_url('tab2_img', get_template_directory_uri() . '/assets/images/real/prod-sua-tam.jpg', 'medium', 'option');
$tab2_quote      = lx_get_field('tab2_quote', 'option', "“Da sạch, mềm mịn, mờ thâm”");

$has_products = lx_has_content($ba_title) || lx_has_content($tab1_name) || lx_has_content($tab2_name);
if (!$has_products) {
    return;
}
?>

  <section class="ltg-has-deco ltg-sec ltg-ba3" id="san-pham">
    <div class="ltg-wrap">
      <div class="ltg-center">
        <?php if (lx_has_content($ba_eyebrow)) : ?>
          <span class="ltg-eyebrow"><?php echo esc_html($ba_eyebrow); ?></span>
        <?php endif; ?>
        <?php if (lx_has_content($ba_title)) : ?>
          <h2 class="ltg-h2 ltg-h2--md"><?php echo wp_kses_post($ba_title); ?></h2>
        <?php endif; ?>
        <?php if (lx_has_content($ba_lead)) : ?>
          <p class="ltg-lead" style="font-style:italic"><?php echo esc_html($ba_lead); ?></p>
        <?php endif; ?>
      </div>

      <div class="ltg-ba3-tabs" role="tablist">
        <?php if (lx_has_content($tab1_name)) : ?>
          <button type="button" class="ltg-ba2-tab ltg-ba3-tab is-on" data-ba="goi">
            <?php if (!empty($tab1_icon)) : ?>
              <img src="<?php echo esc_url($tab1_icon); ?>" alt="">
            <?php endif; ?>
            <?php echo esc_html($tab1_name); ?>
          </button>
        <?php endif; ?>

        <?php if (lx_has_content($tab2_name)) : ?>
          <button type="button" class="ltg-ba2-tab ltg-ba3-tab <?php echo !lx_has_content($tab1_name) ? 'is-on' : ''; ?>" data-ba="tam">
            <?php if (!empty($tab2_icon)) : ?>
              <img src="<?php echo esc_url($tab2_icon); ?>" alt="">
            <?php endif; ?>
            <?php echo esc_html($tab2_name); ?>
          </button>
        <?php endif; ?>
      </div>

      <?php if (lx_has_content($tab1_name)) : ?>
      <div class="ltg-ba2-p ltg-ba3-p is-on" data-bap="goi">
        <?php if (!empty($tab1_bad_items) && is_array($tab1_bad_items)) : ?>
        <div class="ltg-ba3-side ltg-ba3-bad">
          <?php if (lx_has_content($tab1_bad_h)) : ?>
            <h4><?php echo esc_html($tab1_bad_h); ?></h4>
          <?php endif; ?>
          <ul>
            <?php foreach ($tab1_bad_items as $b) :
                if (empty($b['text'])) continue;
            ?>
              <li>
                <i><svg width="12" height="12"><use href="#i-x"/></svg></i>
                <?php echo esc_html($b['text']); ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endif; ?>

        <?php if (!empty($tab1_good_items) && is_array($tab1_good_items)) : ?>
        <div class="ltg-ba3-side ltg-ba3-good">
          <?php if (lx_has_content($tab1_good_h)) : ?>
            <h4><?php echo esc_html($tab1_good_h); ?></h4>
          <?php endif; ?>
          <ul>
            <?php foreach ($tab1_good_items as $g) :
                if (empty($g['text'])) continue;
            ?>
              <li>
                <i><svg width="12" height="12"><use href="#i-check"/></svg></i>
                <?php echo esc_html($g['text']); ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endif; ?>

        <?php if (!empty($tab1_img)) : ?>
        <div class="ltg-ba3-core">
          <span class="ltg-ba3-ring"></span>
          <div class="ltg-ba3-img">
            <img src="<?php echo esc_url($tab1_img); ?>" alt="<?php echo esc_attr($tab1_name); ?>" loading="lazy">
          </div>
          <span class="ltg-ba3-arrow">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
          </span>
        </div>
        <?php endif; ?>

        <?php if (lx_has_content($tab1_quote)) : ?>
          <p class="ltg-ba3-q"><?php echo esc_html($tab1_quote); ?></p>
        <?php endif; ?>
      </div>
      <?php endif; ?>

      <?php if (lx_has_content($tab2_name)) : ?>
      <div class="ltg-ba2-p ltg-ba3-p <?php echo !lx_has_content($tab1_name) ? 'is-on' : ''; ?>" data-bap="tam">
        <?php if (!empty($tab2_bad_items) && is_array($tab2_bad_items)) : ?>
        <div class="ltg-ba3-side ltg-ba3-bad">
          <?php if (lx_has_content($tab2_bad_h)) : ?>
            <h4><?php echo esc_html($tab2_bad_h); ?></h4>
          <?php endif; ?>
          <ul>
            <?php foreach ($tab2_bad_items as $b) :
                if (empty($b['text'])) continue;
            ?>
              <li>
                <i><svg width="12" height="12"><use href="#i-x"/></svg></i>
                <?php echo esc_html($b['text']); ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endif; ?>

        <?php if (!empty($tab2_good_items) && is_array($tab2_good_items)) : ?>
        <div class="ltg-ba3-side ltg-ba3-good">
          <?php if (lx_has_content($tab2_good_h)) : ?>
            <h4><?php echo esc_html($tab2_good_h); ?></h4>
          <?php endif; ?>
          <ul>
            <?php foreach ($tab2_good_items as $g) :
                if (empty($g['text'])) continue;
            ?>
              <li>
                <i><svg width="12" height="12"><use href="#i-check"/></svg></i>
                <?php echo esc_html($g['text']); ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endif; ?>

        <?php if (!empty($tab2_img)) : ?>
        <div class="ltg-ba3-core">
          <span class="ltg-ba3-ring"></span>
          <div class="ltg-ba3-img">
            <img src="<?php echo esc_url($tab2_img); ?>" alt="<?php echo esc_attr($tab2_name); ?>" loading="lazy">
          </div>
          <span class="ltg-ba3-arrow">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
          </span>
        </div>
        <?php endif; ?>

        <?php if (lx_has_content($tab2_quote)) : ?>
          <p class="ltg-ba3-q"><?php echo esc_html($tab2_quote); ?></p>
        <?php endif; ?>
      </div>
      <?php endif; ?>
    </div>
  </section>
