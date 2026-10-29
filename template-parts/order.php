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
$order_lead    = lx_get_field('order_lead', 'option', "Điền thông tin – Home Care gọi xác nhận trong 15 phút (giờ hành chính). Thanh toán khi nhận hàng.");
$hotline       = lx_get_field('hotline', 'option', "0962131515");

$order_default_combos = array(
    array('val' => 'sieu-tiet-kiem', 'name' => 'Dầu gội + Sữa Tắm 1000ml', 'badge' => 'SIÊU TIẾT KIỆM', 'chk' => false),
    array('val' => 'dac-biet', 'name' => 'Dầu gội + Sữa tắm + Nước ủ tóc gừng tươi 1000ml', 'badge' => 'ĐẶC BIỆT', 'chk' => false),
    array('val' => 'trai-nghiem', 'name' => 'Combo Dầu gội + Sữa tắm 300ml', 'badge' => 'TRẢI NGHIỆM', 'chk' => false),
    array('val' => 'ban-chay', 'name' => 'Combo Dầu gội + Sữa Tắm 500ml', 'badge' => 'BÁN CHẠY', 'chk' => true),
);
$order_combos = lx_get_field('order_combos', 'option', $order_default_combos);
if (!is_array($order_combos)) {
    $order_combos = array();
}

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
          <div><i><svg width="16" height="16"><use href="#i-gift"/></svg></i>Gói quà 20/11 &amp; thiệp viết tay miễn phí</div>
          <div><i><svg width="16" height="16"><use href="#i-heart"/></svg></i>Tư vấn miễn phí cho mẹ bầu, sau sinh</div>
        </div>

        <a class="ltg-hotline" href="tel:<?php echo esc_attr(preg_replace('/[^\d]/', '', $hotline)); ?>">
          <i><svg width="24" height="24" style="color:var(--forest)"><use href="#i-phone"/></svg></i>
          <div>
            Hotline tư vấn
            <b>0962 131 515</b>
            Tổng đài 1900 0387 · 0973 871 376
          </div>
        </a>
      </div>

      <form class="ltg-form" id="ltgForm" novalidate>
        <div id="ltgFormBody">
          <div class="ltg-fields ltg-fields--lb">
            <label>
              <span>Họ và tên:</span>
              <input type="text" name="name" required placeholder="Ví dụ: Nguyễn Thị Mai">
            </label>
            <label>
              <span>Số điện thoại:</span>
              <input type="tel" name="phone" required placeholder="Ví dụ: 0912 345 678">
            </label>
            <label>
              <span>Địa chỉ nhận hàng:</span>
              <input type="text" name="address" required placeholder="Số nhà, ngõ/ngách, đường, phường/xã...">
            </label>
          </div>

          <?php if (!empty($order_combos)) : ?>
          <div class="ltg-combo-pick" id="ltgCombo">
            <span class="ltg-flabel">Chọn combo:</span>
            <?php foreach ($order_combos as $cb) :
                if (empty($cb['name'])) continue;
                $val = !empty($cb['val']) ? $cb['val'] : sanitize_title($cb['name']);
                $badge = !empty($cb['badge']) ? '[' . $cb['badge'] . '] ' : '';
                $is_chk = !empty($cb['chk']);
            ?>
              <label class="ltg-copt<?php echo $is_chk ? ' is-on' : ''; ?>">
                <input type="radio" name="combo" value="<?php echo esc_attr($val); ?>"<?php echo $is_chk ? ' checked' : ''; ?>>
                <span><b><?php echo esc_html($badge); ?></b><?php echo esc_html($cb['name']); ?></span>
              </label>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>

          <label class="ltg-giftwrap">
            <input type="checkbox" id="ltgWrap"> 🎁 Gói làm quà 20/11 &amp; kèm thiệp (miễn phí)
          </label>

          <div class="ltg-card-msg" id="ltgMsg">
            <textarea name="card" placeholder="Lời nhắn trên thiệp, VD: Kính chúc cô luôn mạnh khoẻ, hạnh phúc!"></textarea>
          </div>

          <div class="ltg-fcd">
            <b>ƯU ĐÃI SẮP KẾT THÚC</b>
            <div class="ltg-fcd-t" id="ltgFormCd">
              <div><b data-h>00</b><small>Giờ</small></div>
              <div><b data-m>00</b><small>phút</small></div>
              <div><b data-s>00</b><small>giây</small></div>
            </div>
          </div>

          <button type="submit" class="ltg-btn ltg-btn--pri ltg-pulse">
            ĐẶT HÀNG NGAY - NHẬN ƯU ĐÃI!
          </button>

          <p class="ltg-secure">
            🔒 Thanh toán khi nhận hàng · Thông tin của bạn được bảo mật
          </p>
        </div>

        <div class="ltg-ok" id="ltgOk" style="display:none">
          <div style="width:72px;height:72px;border-radius:50%;background:var(--butter);display:grid;place-items:center;margin:0 auto">
            <svg width="34" height="34" style="color:var(--forest)"><use href="#i-check"/></svg>
          </div>
          <h3>Cảm ơn bạn đã đặt hàng!</h3>
          <p class="ltg-hint">Home Care sẽ gọi xác nhận đơn trong thời gian sớm nhất.</p>
        </div>
      </form>
    </div>
  </section>
