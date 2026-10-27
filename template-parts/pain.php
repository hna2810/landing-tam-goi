<?php
/**
 * Pain Points Section Template Part
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$pain_title      = lx_get_field('pain_title', 'option', "Mái tóc & làn da đang làm bạn kém tự tin mỗi ngày?");
$pain_lead       = lx_get_field('pain_lead', 'option', "Tóc gãy rụng từng búi sau mỗi lần gội, da lưng lấm tấm mụn ngứa gây khó chịu?");
$pain_hair_h     = lx_get_field('pain_hair_h', 'option', "Mái tóc");
$pain_hair_items = lx_get_field('pain_hair_items', 'option');
$pain_center_img = lx_get_image_url('pain_center_img', LX_THEME_URI . '/assets/images/skin-body.webp', 'full', 'option');
$pain_skin_h     = lx_get_field('pain_skin_h', 'option', "Làn da cơ thể");
$pain_skin_items = lx_get_field('pain_skin_items', 'option');
$pain_cause_h    = lx_get_field('pain_cause_h', 'option', "NGUYÊN NHÂN DO ĐÂU?");
$pain_cause_p    = lx_get_field('pain_cause_p', 'option', "Làn da và da đầu tiếp xúc với bụi bẩn môi trường, sự thay đổi nội tiết tố hoặc do sử dụng các sản phẩm làm sạch có chất tẩy rửa quá mạnh, làm mất đi độ ẩm tự nhiên.");
$pain_cta_p      = lx_get_field('pain_cta_p', 'option', "👉👉 Đừng để những lo âu kéo dài làm ảnh hưởng đến diện mạo và tâm trạng của bạn. Khám phá ngay <b>Bộ đôi chăm sóc chuyên sâu từ Gừng & Nghệ</b> – Làm sạch dịu nhẹ, cân bằng độ ẩm và phục hồi sức sống tự nhiên cho mái tóc & làn da.");
$pain_cta_link   = lx_get_field('pain_cta_link', 'option', "#san-pham");

// Defaults if not set
if (empty($pain_hair_items) && !is_array($pain_hair_items)) {
    $pain_hair_items = array(
        array('title' => 'Tóc gãy rụng', 'desc' => 'Mỗi lần chải hay gội đầu, tóc gãy rụng vón thành từng búi khiến mái tóc ngày càng thưa.'),
        array('title' => 'Gàu ngứa dai dẳng', 'desc' => 'Da đầu nhanh bết dính, xuất hiện vảy gàu kèm cơn ngứa ngáy dữ dội, đặc biệt là khi thời tiết thay đổi.'),
        array('title' => 'Tóc khô xơ, hư tổn', 'desc' => 'Sợi tóc xơ xác, chẻ ngọn, thiếu sức sống do tác động từ hóa chất, uốn nhuộm hoặc thay đổi nội tiết tố.'),
    );
}

if (empty($pain_skin_items) && !is_array($pain_skin_items)) {
    $pain_skin_items = array(
        array('title' => 'Mụn lưng, mụn ngực', 'desc' => 'Lỗ chân lông bít tắc do bã nhờn và mồ hôi gây ngứa, sinh ra mụn đỏ, mụn viêm.'),
        array('title' => 'Da thô ráp, thiếu ẩm', 'desc' => 'Sau khi tắm, làn da bị khô căng, nứt nẻ và kém mịn màng.'),
        array('title' => 'Vết thâm kéo dài', 'desc' => 'Lưng, ngực chằng chịt thâm mụn khiến bạn mất đi sự tự tin khi diện những trang phục yêu thích.'),
    );
}

// Check if section has any content to display
$has_hair = !empty($pain_hair_items) && is_array($pain_hair_items);
$has_skin = !empty($pain_skin_items) && is_array($pain_skin_items);
if (!lx_has_content($pain_title) && !$has_hair && !$has_skin) {
    return;
}
?>

  <section class="ltg-p4" id="noi-lo">
    <div class="ltg-wrap">
      <?php if (lx_has_content($pain_title) || lx_has_content($pain_lead)) : ?>
      <div class="ltg-center ltg-rv">
        <?php if (lx_has_content($pain_title)) : ?>
          <h2 class="ltg-h2 ltg-h2--md lx_wow_item"><?php echo wp_kses_post($pain_title); ?></h2>
        <?php endif; ?>
        <?php if (lx_has_content($pain_lead)) : ?>
          <p class="ltg-lead lx_wow_item"><?php echo esc_html($pain_lead); ?></p>
        <?php endif; ?>
      </div>
      <?php endif; ?>

      <div class="ltg-p4-stage">
        <?php if ($has_hair) : ?>
        <div class="ltg-p4-col ltg-p4-col--l ltg-rv">
          <?php if (lx_has_content($pain_hair_h)) : ?>
            <h3 class="ltg-p4-h lx_wow_item"><?php echo esc_html($pain_hair_h); ?></h3>
          <?php endif; ?>
          <ul>
            <?php foreach ($pain_hair_items as $item) :
                if (empty($item['title'])) continue;
            ?>
              <li class="ltg-p4-chip" tabindex="0">
                <b class="lx_wow_item"><span class="ltg-p4-dot"></span><?php echo esc_html($item['title']); ?></b>
                <?php if (!empty($item['desc'])) : ?>
                  <p class="lx_wow_item"><?php echo esc_html($item['desc']); ?></p>
                <?php endif; ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endif; ?>

        <?php if (!empty($pain_center_img)) : ?>
        <div class="ltg-p4-center ltg-rv">
          <div class="ltg-p4-glow"></div>
          <div class="ltg-p4-bub">
            <img src="<?php echo esc_url($pain_center_img); ?>" alt="Làn da cơ thể" loading="lazy">
          </div>
        </div>
        <?php endif; ?>

        <?php if ($has_skin) : ?>
        <div class="ltg-p4-col ltg-p4-col--r ltg-rv">
          <?php if (lx_has_content($pain_skin_h)) : ?>
            <h3 class="ltg-p4-h lx_wow_item"><?php echo esc_html($pain_skin_h); ?></h3>
          <?php endif; ?>
          <ul>
            <?php foreach ($pain_skin_items as $item) :
                if (empty($item['title'])) continue;
            ?>
              <li class="ltg-p4-chip" tabindex="0">
                <b class="lx_wow_item"><span class="ltg-p4-dot"></span><?php echo esc_html($item['title']); ?></b>
                <?php if (!empty($item['desc'])) : ?>
                  <p class="lx_wow_item"><?php echo esc_html($item['desc']); ?></p>
                <?php endif; ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endif; ?>
      </div>

      <?php if (lx_has_content($pain_cause_h) || lx_has_content($pain_cta_p)) : ?>
      <div class="ltg-p3-why">
        <?php if (lx_has_content($pain_cause_h) || lx_has_content($pain_cause_p)) : ?>
        <div class="ltg-p3-cause ltg-rv">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"><circle cx="10.5" cy="10.5" r="6.5"/><path d="M15.5 15.5L21 21"/><path d="M10.5 7.5v3.5M10.5 13.6v.01"/></svg>
          <?php if (lx_has_content($pain_cause_h)) : ?>
            <h3 class="lx_wow_item"><?php echo esc_html($pain_cause_h); ?></h3>
          <?php endif; ?>
          <?php if (lx_has_content($pain_cause_p)) : ?>
            <p class="lx_wow_item"><?php echo esc_html($pain_cause_p); ?></p>
          <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if (lx_has_content($pain_cta_p)) : ?>
        <div class="ltg-p3-cta ltg-rv">
          <p class="lx_wow_item"><?php echo wp_kses_post($pain_cta_p); ?></p>
          <?php if (lx_has_content($pain_cta_link)) : ?>
            <a href="<?php echo esc_url($pain_cta_link); ?>" class="ltg-p3-down" aria-label="Xem bộ đôi">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M6 13l6 6 6-6"/></svg>
            </a>
          <?php endif; ?>
        </div>
        <?php endif; ?>
      </div>
      <?php endif; ?>
    </div>
  </section>
