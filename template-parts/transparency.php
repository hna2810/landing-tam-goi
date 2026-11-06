<?php
/**
 * Transparency / Certification Section Template Part
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$clear_eyebrow   = lx_get_field('clear_eyebrow', 'option', "Minh bạch – rõ nguồn gốc");
$clear_title     = lx_get_field('clear_title', 'option', "An tâm sử dụng với thông tin minh bạch, rõ ràng");
$clear_img_1     = lx_get_image_url('clear_img_1', 'https://tamgoigungnghe.homecarevietnam.com/wp-content/uploads/2026/10/scb-dau-goi-gung-nghe_b1a448ecb88540ea96a76760844ae7f8-1.png', 'full', 'option');
$clear_img_2     = lx_get_image_url('clear_img_2', 'https://tamgoigungnghe.homecarevietnam.com/wp-content/uploads/2026/10/scb-sua-tam-gung-nghe_5328535177694ee6960a310a4cb94ac8-1.png', 'full', 'option');
$clear_img_3     = lx_get_image_url('clear_img_3', get_template_directory_uri() . '/assets/images/real/combo-dau-goi-sua-tam-gung-nghe-mau-may-6-1.png', 'full', 'option');

if (empty($clear_img_1)) {
    $clear_img_1 = 'https://tamgoigungnghe.homecarevietnam.com/wp-content/uploads/2026/10/scb-dau-goi-gung-nghe_b1a448ecb88540ea96a76760844ae7f8-1.png';
}
if (empty($clear_img_2)) {
    $clear_img_2 = 'https://tamgoigungnghe.homecarevietnam.com/wp-content/uploads/2026/10/scb-sua-tam-gung-nghe_5328535177694ee6960a310a4cb94ac8-1.png';
}
if (empty($clear_img_3) || strpos($clear_img_3, 'hstatic.net') !== false) {
    $clear_img_3 = get_template_directory_uri() . '/assets/images/real/combo-dau-goi-sua-tam-gung-nghe-mau-may-6-1.png';
}

$has_clear = lx_has_content($clear_title) || !empty($clear_img_1);
if (!$has_clear) {
    return;
}
?>

  <section class="ltg-sec ltg-clear" id="minh-bach">
    <div class="ltg-wrap">
      <div class="ltg-center">
        <?php if (lx_has_content($clear_eyebrow)) : ?>
          <span class="ltg-eyebrow"><?php echo esc_html($clear_eyebrow); ?></span>
        <?php endif; ?>
        <?php if (lx_has_content($clear_title)) : ?>
          <h2 class="ltg-h2 ltg-h2--md"><?php echo wp_kses_post($clear_title); ?></h2>
        <?php endif; ?>
      </div>

      <div class="ltg-clear-grid">
        <div class="">
          <div class="ltg-clear-imgs">
            <?php if (!empty($clear_img_1)) : ?>
              <figure data-img="<?php echo esc_url($clear_img_1); ?>">
                <img src="<?php echo esc_url($clear_img_1); ?>" alt="Giấy công bố sản phẩm dầu gội" loading="lazy">
                <figcaption>Phiếu công bố – Dầu gội</figcaption>
              </figure>
            <?php endif; ?>

            <?php if (!empty($clear_img_2)) : ?>
              <figure data-img="<?php echo esc_url($clear_img_2); ?>">
                <img src="<?php echo esc_url($clear_img_2); ?>" alt="Giấy công bố sản phẩm sữa tắm" loading="lazy">
                <figcaption>Phiếu công bố – Sữa tắm</figcaption>
              </figure>
            <?php endif; ?>
          </div>
          <p class="ltg-clear-cap">Đã được Sở Y tế tiếp nhận phiếu công bố mỹ phẩm</p>
        </div>

        <div class="">
          <?php if (!empty($clear_img_3)) : ?>
            <figure data-img="<?php echo esc_url($clear_img_3); ?>" class="ltg-clear-img-right">
              <img src="<?php echo esc_url($clear_img_3); ?>" alt="Ảnh mã vạch, mã QR sản phẩm" loading="lazy">
              <figcaption>Mã số mã vạch &amp; Tem chống giả</figcaption>
            </figure>
          <?php endif; ?>
        </div>
      </div>
      <p class="ltg-hint" style="text-align:center;margin-top:16px">Bấm vào ảnh để xem bản phóng to rõ nét</p>
    </div>
  </section>
