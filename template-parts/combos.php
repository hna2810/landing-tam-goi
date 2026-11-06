<?php
/**
 * Combo Offers Section Template Part (Combo mới 79K / 169K + Quà 20/11)
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$combo_eyebrow = lx_get_field('combo_eyebrow', 'option', "Ưu đãi tắm gội");
$combo_title   = lx_get_field('combo_title', 'option', "Chọn bộ đôi gừng nghệ cho cả nhà");
$combo_lead    = lx_get_field('combo_lead', 'option', "Dầu gội + sữa tắm Gừng Nghệ Mây Mây, 2 dung tích, 2 mức giá.");

$img_dau_goi = get_template_directory_uri() . '/assets/images/real/chai-dau-goi.webp';
$img_sua_tam = get_template_directory_uri() . '/assets/images/real/chai-sua-tam.webp';
?>

  <section class="ltg-sec ltg-nc-sec" id="combo">
    <div class="ltg-wrap">
      <div class="ltg-center">
        <?php if (lx_has_content($combo_eyebrow)) : ?>
          <span class="ltg-eyebrow"><?php echo esc_html($combo_eyebrow); ?></span>
        <?php endif; ?>
        <?php if (lx_has_content($combo_title)) : ?>
          <h2 class="ltg-h2 ltg-h2--md"><?php echo esc_html($combo_title); ?></h2>
        <?php endif; ?>
        <?php if (lx_has_content($combo_lead)) : ?>
          <p class="ltg-lead"><?php echo esc_html($combo_lead); ?></p>
        <?php endif; ?>
      </div>

      <div class="ltg-nc-grid">
        <!-- Combo 1: 300ml 79K -->
        <a href="#dat-hang" class="ltg-nc" data-combo="c300">
          <span class="ltg-nc-tag">Bộ đôi 300ml</span>
          <div class="ltg-nc-stage">
            <img src="<?php echo esc_url($img_dau_goi); ?>" alt="Dầu gội Gừng Nghệ Mây Mây" class="ltg-nc-b ltg-nc-b1" loading="lazy">
            <img src="<?php echo esc_url($img_sua_tam); ?>" alt="Sữa tắm Gừng Nghệ Mây Mây" class="ltg-nc-b ltg-nc-b2" loading="lazy">
            <span class="ltg-nc-vol">300ml<br><small>x2 chai</small></span>
          </div>
          <h3 class="ltg-nc-name">Dầu gội + Sữa tắm Gừng Nghệ 300ml</h3>
          <ul class="ltg-nc-list">
            <li>1 chai dầu gội Gừng Nghệ Mây Mây 300ml</li>
            <li>1 chai sữa tắm Gừng Nghệ Mây Mây 300ml</li>
            <li>Vừa đủ để dùng thử, hợp dùng cá nhân</li>
          </ul>
          <div class="ltg-nc-foot">
            <div class="ltg-nc-price">
              <s>218.000đ</s>
              <b>79.000đ</b>
            </div>
            <span class="ltg-nc-btn">
              Đặt ngay
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </span>
          </div>
        </a>

        <!-- Combo 2: 500ml 169K có quà -->
        <a href="#dat-hang" class="ltg-nc ltg-nc--hot" data-combo="c500">
          <span class="ltg-nc-tag">Bộ đôi 500ml · Có quà</span>
          <span class="ltg-nc-ribbon">ĐÁNG MUA NHẤT</span>
          <div class="ltg-nc-stage">
            <img src="<?php echo esc_url($img_dau_goi); ?>" alt="Dầu gội Gừng Nghệ Mây Mây" class="ltg-nc-b ltg-nc-b1" loading="lazy">
            <img src="<?php echo esc_url($img_sua_tam); ?>" alt="Sữa tắm Gừng Nghệ Mây Mây" class="ltg-nc-b ltg-nc-b2" loading="lazy">
            <span class="ltg-nc-gift">
              <img src="https://trianthayco.homecarevietnam.com/wp-content/themes/landing-20-11/img/qua-xit-khu-mui.webp" alt="Xịt khử mùi Gừng Cam 30ml" loading="lazy">
              <em>TẶNG</em>
            </span>
            <span class="ltg-nc-vol">500ml<br><small>x2 chai</small></span>
          </div>
          <h3 class="ltg-nc-name">Dầu gội + Sữa tắm Gừng Nghệ 500ml</h3>
          <ul class="ltg-nc-list">
            <li>1 chai dầu gội Gừng Nghệ Mây Mây 500ml</li>
            <li>1 chai sữa tắm Gừng Nghệ Mây Mây 500ml</li>
            <li class="is-gift"><b>Tặng:</b> 1 xịt khử mùi Gừng Cam 30ml</li>
          </ul>
          <div class="ltg-nc-foot">
            <div class="ltg-nc-price">
              <s>370.000đ</s>
              <b>169.000đ</b>
            </div>
            <span class="ltg-nc-btn">
              Đặt ngay
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </span>
          </div>
        </a>
      </div>

      <!-- Khối quà 20/11 sang trọng -->
      <div class="ltg-nc-gift20">
        <div class="ltg-nc-g-l">
          <span class="ltg-nc-g-ey">🎁 Quà tặng 20/11</span>
          <h3>Cần quà tri ân thầy cô?</h3>
          <p>Home Care có 3 combo quà trọn bộ Tắm – Gội – Ủ tóc gừng nghệ, đóng sẵn để tặng thầy cô dịp 20/11.</p>
          <a href="https://trianthayco.homecarevietnam.com/#combo-qua" target="_blank" rel="noopener" class="ltg-btn ltg-btn--gold ltg-nc-g-btn">
            Xem 3 combo quà 20/11
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
        </div>
        <div class="ltg-nc-g-r">
          <a href="https://trianthayco.homecarevietnam.com/#combo-qua" target="_blank" rel="noopener" class="ltg-nc-g-c">
            <img src="https://trianthayco.homecarevietnam.com/wp-content/themes/landing-20-11/img/m/combo-199k-480.webp" alt="Combo quà 20/11 199K" loading="lazy">
            <b>199K</b>
            <small>Bộ 300ml</small>
          </a>
          <a href="https://trianthayco.homecarevietnam.com/#combo-qua" target="_blank" rel="noopener" class="ltg-nc-g-c is-hot">
            <img src="https://trianthayco.homecarevietnam.com/wp-content/themes/landing-20-11/img/m/combo-349k-480.webp" alt="Combo quà 20/11 349K" loading="lazy">
            <b>349K</b>
            <small>Bộ 500ml</small>
          </a>
          <a href="https://trianthayco.homecarevietnam.com/#combo-qua" target="_blank" rel="noopener" class="ltg-nc-g-c">
            <img src="https://trianthayco.homecarevietnam.com/wp-content/themes/landing-20-11/img/m/combo-499k-480.webp" alt="Combo quà 20/11 499K" loading="lazy">
            <b>499K</b>
            <small>Bộ 1000ml</small>
          </a>
        </div>
      </div>
    </div>
  </section>
