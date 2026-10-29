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
$clear_lead      = lx_get_field('clear_lead', 'option', "Dầu gội và sữa tắm Gừng Nghệ Mây Mây đều có phiếu công bố sản phẩm mỹ phẩm, tem chống hàng giả Bộ Công An và thông tin trên hệ thống Mã số Mã vạch Quốc gia.");
$clear_img_1     = lx_get_image_url('clear_img_1', 'https://cdn.hstatic.net/products/200001066686/scb-dau-goi-gung-nghe_b1a448ecb88540ea96a76760844ae7f8.png', 'full', 'option');
$clear_img_2     = lx_get_image_url('clear_img_2', 'https://cdn.hstatic.net/products/200001066686/scb-sua-tam-gung-nghe_5328535177694ee6960a310a4cb94ac8.png', 'full', 'option');
$clear_cap       = lx_get_field('clear_cap', 'option', "Đã được Sở Y tế tiếp nhận phiếu công bố mỹ phẩm");
$clear_barcode   = lx_get_image_url('clear_barcode_img', '', 'full', 'option');

$has_clear = lx_has_content($clear_title) || !empty($clear_img_1);
if (!$has_clear) {
    return;
}
?>

  <section class="ltg-sec ltg-clear" id="minh-bach">
    <div class="ltg-wrap">
      <div class="ltg-center ltg-rv">
        <?php if (lx_has_content($clear_eyebrow)) : ?>
          <span class="ltg-eyebrow"><?php echo esc_html($clear_eyebrow); ?></span>
        <?php endif; ?>
        <?php if (lx_has_content($clear_title)) : ?>
          <h2 class="ltg-h2 ltg-h2--md"><?php echo wp_kses_post($clear_title); ?></h2>
        <?php endif; ?>
        <?php if (lx_has_content($clear_lead)) : ?>
          <p class="ltg-lead"><?php echo esc_html($clear_lead); ?></p>
        <?php endif; ?>
      </div>

      <div class="ltg-clear-grid">
        <div class="ltg-rv">
          <?php if (!empty($clear_img_1) || !empty($clear_img_2)) : ?>
          <div class="ltg-clear-imgs">
            <?php if (!empty($clear_img_1)) : ?>
              <figure data-img="<?php echo esc_url($clear_img_1); ?>">
                <img src="<?php echo esc_url($clear_img_1); ?>" alt="Giấy công bố sản phẩm dầu gội" loading="lazy">
              </figure>
            <?php endif; ?>
            <?php if (!empty($clear_img_2)) : ?>
              <figure data-img="<?php echo esc_url($clear_img_2); ?>">
                <img src="<?php echo esc_url($clear_img_2); ?>" alt="Giấy công bố sản phẩm sữa tắm" loading="lazy">
              </figure>
            <?php endif; ?>
          </div>
          <?php endif; ?>

          <?php if (lx_has_content($clear_cap)) : ?>
            <p class="ltg-clear-cap"><?php echo esc_html($clear_cap); ?></p>
          <?php endif; ?>
        </div>

        <div class="ltg-rv">
          <?php if (!empty($clear_barcode)) : ?>
            <figure data-img="<?php echo esc_url($clear_barcode); ?>">
              <img src="<?php echo esc_url($clear_barcode); ?>" alt="Ảnh mã vạch, mã QR sản phẩm" loading="lazy" style="border-radius:18px;">
            </figure>
          <?php else : ?>
            <span class="ltg-ph ltg-ph--tall">Ảnh mã vạch, mã QR sản phẩm</span>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>
