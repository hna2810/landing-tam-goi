<?php
/**
 * Order Form Section Template Part
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$order_title   = lx_get_field('order_title', 'option', "Lấy lại mái tóc bồng bềnh &amp; làn da mịn màng ngay hôm nay!");
$order_lead    = lx_get_field('order_lead', 'option', "Để lại thông tin bên dưới để nhận ngay ưu đãi trải nghiệm từ Home Care.");
$hotline       = lx_get_field('hotline', 'option', "0973871376");
$hotline_disp  = lx_get_field('hotline_display', 'option', "0973 871 376");

$has_order = lx_has_content($order_title);
if (!$has_order) {
    return;
}
?>

  <section class="ltg-sec ltg-order" id="dat-hang">
    <div class="ltg-deco" aria-hidden="true">
      <span class="ltg-lf b1" style="left:-36px;top:8%;width:130px;height:249px;--r:22deg;animation-delay:0s;animation-duration:12s"><svg><use href="#i-lf3"/></svg></span>
      <span class="ltg-lf b2" style="right:-50px;bottom:6%;width:170px;height:241px;--r:-35deg;animation-delay:-4s;animation-duration:13s"><svg><use href="#i-lf2"/></svg></span>
    </div>

    <div class="ltg-wrap ltg-order-grid">
      <div class="">
        <span class="ltg-eyebrow">Đặt hàng</span>
        <h2 class="ltg-h2 ltg-h2--md"><?php echo wp_kses_post($order_title); ?></h2>
        <?php if (lx_has_content($order_lead)) : ?>
          <p class="ltg-lead"><?php echo esc_html($order_lead); ?></p>
        <?php endif; ?>

        <div class="ltg-promise">
          <div><i><svg width="16" height="16"><use href="#i-shield"/></svg></i>Chính hãng – tem chống giả Bộ Công An</div>
          <div><i><svg width="16" height="16"><use href="#i-truck"/></svg></i>Freeship toàn quốc, kiểm tra trước khi nhận</div>
          <div><i><svg width="16" height="16"><use href="#i-gift"/></svg></i>Bộ 500ml tặng kèm xịt khử mùi Gừng Cam 30ml</div>
          <div><i><svg width="16" height="16"><use href="#i-heart"/></svg></i>Tư vấn miễn phí cho mẹ bầu, sau sinh</div>
        </div>

        <a href="tel:<?php echo esc_attr(preg_replace('/[^\d]/', '', $hotline)); ?>" class="ltg-hotline">
          <i><svg width="24" height="24" style="color:var(--forest)"><use href="#i-phone"/></svg></i>
          <div>
            Hotline tư vấn
            <b><?php echo esc_html($hotline_disp); ?></b>
          </div>
        </a>
      </div>

      <?php
      if (function_exists('lx_render_order_form')) {
          echo lx_render_order_form();
      }
      ?>
    </div>
  </section>
