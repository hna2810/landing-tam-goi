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
$ba_title     = lx_get_field('ba_title', 'option', "Phục hồi mái tóc bồng bềnh, sạch gàu ngứa và nuôi dưỡng làn da cơ thể mịn màng <br> cùng Bộ đôi Tắm Gội Gừng Nghệ Mây Mây");
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

// Ảnh vuông ở giữa Tab 1 (Dầu Gội)
$tab1_img = lx_get_image_url('tab1_img', get_template_directory_uri() . '/assets/images/real/Combo-Dau-Goi-Sua-Tam-2.png', 'large', 'option');
if (empty($tab1_img) || strpos($tab1_img, 'hstatic.net') !== false || strpos($tab1_img, 'ba-dau-goi') !== false || strpos($tab1_img, 'prod-dau-goi') !== false) {
    $tab1_img = get_template_directory_uri() . '/assets/images/real/Combo-Dau-Goi-Sua-Tam-2.png';
}

if (empty($tab1_icon) || strpos($tab1_icon, 'hstatic.net') !== false) {
    $tab1_icon = get_template_directory_uri() . '/assets/images/real/prod-dau-goi.jpg';
}
$tab1_quote      = lx_get_field('tab1_quote', 'option', "“Tóc mọc tua tủa – Kích mở nang tóc”");

// 3 ảnh Trước - Sau thực tế ở dưới Tab 1 (Dầu Gội)
$tab1_shot_1 = lx_get_image_url('tab1_shot_1', get_template_directory_uri() . '/assets/images/real/feedback-dau-goi-gung-nghe-1.png', 'large', 'option');
$tab1_shot_2 = lx_get_image_url('tab1_shot_2', get_template_directory_uri() . '/assets/images/real/feedback-dau-goi-gung-nghe-2.png', 'large', 'option');
$tab1_shot_3 = lx_get_image_url('tab1_shot_3', get_template_directory_uri() . '/assets/images/real/feedback-dau-goi-gung-nghe-3.png', 'large', 'option');
if (empty($tab1_shot_1)) $tab1_shot_1 = get_template_directory_uri() . '/assets/images/real/feedback-dau-goi-gung-nghe-1.png';
if (empty($tab1_shot_2)) $tab1_shot_2 = get_template_directory_uri() . '/assets/images/real/feedback-dau-goi-gung-nghe-2.png';
if (empty($tab1_shot_3)) $tab1_shot_3 = get_template_directory_uri() . '/assets/images/real/feedback-dau-goi-gung-nghe-3.png';

// Tab 2: Sữa Tắm
$tab2_name       = lx_get_field('tab2_name', 'option', "Sữa Tắm Gừng Nghệ Mây Mây");
$tab2_icon       = lx_get_image_url('tab2_icon', get_template_directory_uri() . '/assets/images/real/prod-sua-tam.jpg', 'thumbnail', 'option');
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

// Ảnh vuông ở giữa Tab 2 (Sữa Tắm)
$tab2_img = lx_get_image_url('tab2_img', get_template_directory_uri() . '/assets/images/real/combo-dau-goi-sua-tam-gung-nghe-mau-may-3.png', 'large', 'option');
if (empty($tab2_img) || strpos($tab2_img, 'hstatic.net') !== false || strpos($tab2_img, 'ba-sua-tam') !== false || strpos($tab2_img, 'prod-sua-tam') !== false) {
    $tab2_img = get_template_directory_uri() . '/assets/images/real/combo-dau-goi-sua-tam-gung-nghe-mau-may-3.png';
}

if (empty($tab2_icon) || strpos($tab2_icon, 'hstatic.net') !== false) {
    $tab2_icon = get_template_directory_uri() . '/assets/images/real/prod-sua-tam.jpg';
}
$tab2_quote      = lx_get_field('tab2_quote', 'option', "“Da sạch, mềm mịn, mờ thâm”");

// 3 ảnh Trước - Sau thực tế ở dưới Tab 2 (Sữa Tắm)
$tab2_shot_1 = lx_get_image_url('tab2_shot_1', get_template_directory_uri() . '/assets/images/real/feedback-sua-tam-gung-nghe-1.png', 'large', 'option');
$tab2_shot_2 = lx_get_image_url('tab2_shot_2', get_template_directory_uri() . '/assets/images/real/feedback-sua-tam-gung-nghe-2.png', 'large', 'option');
$tab2_shot_3 = lx_get_image_url('tab2_shot_3', get_template_directory_uri() . '/assets/images/real/feedback-sua-tam-gung-nghe-3.png', 'large', 'option');
if (empty($tab2_shot_1)) $tab2_shot_1 = get_template_directory_uri() . '/assets/images/real/feedback-sua-tam-gung-nghe-1.png';
if (empty($tab2_shot_2)) $tab2_shot_2 = get_template_directory_uri() . '/assets/images/real/feedback-sua-tam-gung-nghe-2.png';
if (empty($tab2_shot_3)) $tab2_shot_3 = get_template_directory_uri() . '/assets/images/real/feedback-sua-tam-gung-nghe-3.png';

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
        <button type="button" class="ltg-ba2-tab ltg-ba3-tab is-on" data-ba="goi">
          <?php if (!empty($tab1_icon)) : ?>
            <img src="<?php echo esc_url($tab1_icon); ?>" alt="">
          <?php endif; ?>
          <?php echo esc_html($tab1_name); ?>
        </button>
        <button type="button" class="ltg-ba2-tab ltg-ba3-tab" data-ba="tam">
          <?php if (!empty($tab2_icon)) : ?>
            <img src="<?php echo esc_url($tab2_icon); ?>" alt="">
          <?php endif; ?>
          <?php echo esc_html($tab2_name); ?>
        </button>
      </div>

      <!-- Tab 1: Dầu Gội -->
      <div class="ltg-ba2-p ltg-ba3-p is-on" data-bap="goi">
        <div class="ltg-ba3-side ltg-ba3-bad">
          <h4><?php echo esc_html($tab1_bad_h); ?></h4>
          <ul>
            <?php foreach ($tab1_bad_items as $item) :
                if (empty($item['text'])) continue;
            ?>
              <li>
                <i><svg width="12" height="12"><use href="#i-x"/></svg></i>
                <?php echo esc_html($item['text']); ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <div class="ltg-ba3-side ltg-ba3-good">
          <h4><?php echo esc_html($tab1_good_h); ?></h4>
          <ul>
            <?php foreach ($tab1_good_items as $item) :
                if (empty($item['text'])) continue;
            ?>
              <li>
                <i><svg width="12" height="12"><use href="#i-check"/></svg></i>
                <?php echo esc_html($item['text']); ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <!-- Ảnh vuông chính giữa sản phẩm -->
        <div class="ltg-ba3-sq">
          <div class="ltg-ba3-sq-frame">
            <img src="<?php echo esc_url($tab1_img); ?>" alt="<?php echo esc_attr($tab1_name); ?>" loading="lazy">
          </div>
        </div>

        <!-- 3 ảnh Trước - Sau thực tế ở dưới -->
        <div class="ltg-ba3-shots">
          <?php if (!empty($tab1_shot_1)) : ?>
            <figure class="ltg-ba3-shot" data-img="<?php echo esc_url($tab1_shot_1); ?>">
              <div class="ltg-ba3-shot-wrap">
                <img src="<?php echo esc_url($tab1_shot_1); ?>" alt="<?php echo esc_attr($tab1_name); ?> - Kết quả Trước Sau 1" loading="lazy">
                <span class="ltg-ba3-shot-badge">Trước &amp; Sau</span>
              </div>
            </figure>
          <?php endif; ?>
          <?php if (!empty($tab1_shot_2)) : ?>
            <figure class="ltg-ba3-shot" data-img="<?php echo esc_url($tab1_shot_2); ?>">
              <div class="ltg-ba3-shot-wrap">
                <img src="<?php echo esc_url($tab1_shot_2); ?>" alt="<?php echo esc_attr($tab1_name); ?> - Kết quả Trước Sau 2" loading="lazy">
                <span class="ltg-ba3-shot-badge">Trước &amp; Sau</span>
              </div>
            </figure>
          <?php endif; ?>
          <?php if (!empty($tab1_shot_3)) : ?>
            <figure class="ltg-ba3-shot" data-img="<?php echo esc_url($tab1_shot_3); ?>">
              <div class="ltg-ba3-shot-wrap">
                <img src="<?php echo esc_url($tab1_shot_3); ?>" alt="<?php echo esc_attr($tab1_name); ?> - Kết quả Trước Sau 3" loading="lazy">
                <span class="ltg-ba3-shot-badge">Trước &amp; Sau</span>
              </div>
            </figure>
          <?php endif; ?>
        </div>

        <?php if (lx_has_content($tab1_quote)) : ?>
          <p class="ltg-ba3-q"><?php echo esc_html($tab1_quote); ?></p>
        <?php endif; ?>
      </div>

      <!-- Tab 2: Sữa Tắm -->
      <div class="ltg-ba2-p ltg-ba3-p" data-bap="tam">
        <div class="ltg-ba3-side ltg-ba3-bad">
          <h4><?php echo esc_html($tab2_bad_h); ?></h4>
          <ul>
            <?php foreach ($tab2_bad_items as $item) :
                if (empty($item['text'])) continue;
            ?>
              <li>
                <i><svg width="12" height="12"><use href="#i-x"/></svg></i>
                <?php echo esc_html($item['text']); ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <div class="ltg-ba3-side ltg-ba3-good">
          <h4><?php echo esc_html($tab2_good_h); ?></h4>
          <ul>
            <?php foreach ($tab2_good_items as $item) :
                if (empty($item['text'])) continue;
            ?>
              <li>
                <i><svg width="12" height="12"><use href="#i-check"/></svg></i>
                <?php echo esc_html($item['text']); ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <!-- Ảnh vuông chính giữa sản phẩm -->
        <div class="ltg-ba3-sq">
          <div class="ltg-ba3-sq-frame">
            <img src="<?php echo esc_url($tab2_img); ?>" alt="<?php echo esc_attr($tab2_name); ?>" loading="lazy">
          </div>
        </div>

        <!-- 3 ảnh Trước - Sau thực tế ở dưới -->
        <div class="ltg-ba3-shots">
          <?php if (!empty($tab2_shot_1)) : ?>
            <figure class="ltg-ba3-shot" data-img="<?php echo esc_url($tab2_shot_1); ?>">
              <div class="ltg-ba3-shot-wrap">
                <img src="<?php echo esc_url($tab2_shot_1); ?>" alt="<?php echo esc_attr($tab2_name); ?> - Kết quả Trước Sau 1" loading="lazy">
                <span class="ltg-ba3-shot-badge">Trước &amp; Sau</span>
              </div>
            </figure>
          <?php endif; ?>
          <?php if (!empty($tab2_shot_2)) : ?>
            <figure class="ltg-ba3-shot" data-img="<?php echo esc_url($tab2_shot_2); ?>">
              <div class="ltg-ba3-shot-wrap">
                <img src="<?php echo esc_url($tab2_shot_2); ?>" alt="<?php echo esc_attr($tab2_name); ?> - Kết quả Trước Sau 2" loading="lazy">
                <span class="ltg-ba3-shot-badge">Trước &amp; Sau</span>
              </div>
            </figure>
          <?php endif; ?>
          <?php if (!empty($tab2_shot_3)) : ?>
            <figure class="ltg-ba3-shot" data-img="<?php echo esc_url($tab2_shot_3); ?>">
              <div class="ltg-ba3-shot-wrap">
                <img src="<?php echo esc_url($tab2_shot_3); ?>" alt="<?php echo esc_attr($tab2_name); ?> - Kết quả Trước Sau 3" loading="lazy">
                <span class="ltg-ba3-shot-badge">Trước &amp; Sau</span>
              </div>
            </figure>
          <?php endif; ?>
        </div>

        <?php if (lx_has_content($tab2_quote)) : ?>
          <p class="ltg-ba3-q"><?php echo esc_html($tab2_quote); ?></p>
        <?php endif; ?>
      </div>
    </div>
  </section>
