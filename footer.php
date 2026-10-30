<?php
/**
 * The footer for our theme
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

  <footer class="ltg-foot">
    <div class="ltg-wrap">
      <div class="ltg-foot-content">
        <h3 class="ltg-foot-title"><?php echo esc_html(lx_get_field('footer_brand_title', 'option', 'Mây Mây - Tự Tin Tỏa Sáng')); ?></h3>
        <p class="ltg-foot-line">
          Website: <a href="https://homecarevietnam.com" target="_blank" rel="noopener">homecarevietnam.com</a>
        </p>
        <p class="ltg-foot-line">
          Hotline: <a href="tel:0973871376">0973.871.376</a> - <a href="tel:0962131515">0962.131.515</a>
        </p>
        <p class="ltg-foot-company">
          CÔNG TY TNHH CHĂM SÓC MẸ VÀ BÉ TẠI NHÀ HOME CARE
        </p>
        <p class="ltg-foot-info">
          Địa chỉ: 20 Huy Du, Phường Từ Liêm, TP Hà Nội, Việt Nam.
        </p>
        <p class="ltg-foot-info">
          Mã số doanh nghiệp: 0107375668 do Sở Kế hoạch &amp; Đầu tư TP Hà Nội cấp lần đầu ngày 29/03/2016
        </p>
        <div class="ltg-foot-copy">
          &copy; 2026 Home Care. All rights reserved.
        </div>
      </div>
    </div>
  </footer>

  <!-- Lightbox Modal -->
  <div class="ltg-lb" id="ltgLb" role="dialog" aria-modal="true">
    <button class="ltg-lb-x" type="button" aria-label="Đóng">×</button>
    <div class="ltg-lb-box" id="ltgLbBox"></div>
  </div>

  <!-- Sticky Buy Bar -->
  <?php
  $sticky_phone    = lx_get_field('sticky_phone', 'option', '0973871376');
  $sticky_price    = lx_get_field('sticky_price', 'option', '99K');
  $sticky_desc     = lx_get_field('sticky_desc', 'option', 'Combo dầu gội + sữa tắm · Freeship');
  $sticky_btn_text = lx_get_field('sticky_btn_text', 'option', 'Đặt ngay');
  $sticky_btn_link = lx_get_field('sticky_btn_link', 'option', '#dat-hang');

  if (lx_has_content($sticky_price) || lx_has_content($sticky_btn_text)) :
  ?>
  <div class="ltg-sticky" id="ltgSticky">
    <?php if (lx_has_content($sticky_phone)) : ?>
      <a href="tel:<?php echo esc_attr(preg_replace('/[^\d]/', '', $sticky_phone)); ?>" class="ltg-sticky-call" aria-label="Gọi tư vấn">
        <svg width="22" height="22"><use href="#i-phone"/></svg>
      </a>
    <?php endif; ?>
    <div class="ltg-sticky-p">
      <?php if (lx_has_content($sticky_price)) : ?>
        <b><?php echo esc_html($sticky_price); ?></b>
      <?php endif; ?>
      <?php if (lx_has_content($sticky_desc)) : ?>
        <small><?php echo esc_html($sticky_desc); ?></small>
      <?php endif; ?>
    </div>
    <?php if (lx_has_content($sticky_btn_text)) : ?>
      <a href="<?php echo esc_url($sticky_btn_link); ?>" class="ltg-btn ltg-btn--pri" data-buy="combo">
        <?php echo esc_html($sticky_btn_text); ?>
      </a>
    <?php endif; ?>
  </div>
  <?php endif; ?>

</div><!-- /.ltg -->

<?php
wp_footer();
?>
</body>
</html>
