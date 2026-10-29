<?php
/**
 * The footer for our theme
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$footer_logo = lx_get_field('footer_logo', 'option', 'Home Care');
$footer_text = lx_get_field('footer_text', 'option', 'Đẹp và Thật · Since 2008<br>Tổng đài 1900 0387 · Hotline 0962 131 515 – 0973 871 376');
?>

  <footer class="ltg-foot">
    <?php if (lx_has_content($footer_logo)) : ?>
      <div class="ltg-logo lx_wow_item"><?php echo esc_html($footer_logo); ?></div>
    <?php endif; ?>
    <?php if (lx_has_content($footer_text)) : ?>
      <div class="lx_wow_item"><?php echo wp_kses_post($footer_text); ?></div>
    <?php endif; ?>
  </footer>

  <!-- Lightbox Modal -->
  <div class="ltg-lb" id="ltgLb" role="dialog" aria-modal="true">
    <button class="ltg-lb-x" type="button" aria-label="Đóng">×</button>
    <div class="ltg-lb-box" id="ltgLbBox"></div>
  </div>

  <!-- Sticky Buy Bar -->
  <?php
  $sticky_phone    = lx_get_field('sticky_phone', 'option', '0962131515');
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
// Include SVG sprite icons
// SVG sprite loaded in header
wp_footer();
?>
</body>
</html>
