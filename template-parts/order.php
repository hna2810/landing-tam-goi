<?php
/**
 * Order Form Section Template Part
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$order_title = lx_get_field('order_title', 'option', "Lấy lại mái tóc bồng bềnh & làn da mịn màng ngay hôm nay!");
$order_lead  = lx_get_field('order_lead', 'option', "Để lại thông tin bên dưới để nhận ngay ưu đãi trải nghiệm từ Home Care.");
$order_combos = lx_get_field('order_combos', 'option');

if (empty($order_combos) && !is_array($order_combos)) {
    $order_combos = array(
        array(
            'val'   => 'trai-nghiem',
            'name'  => 'Gói Trải Nghiệm 99K',
            'desc'  => '1 Gội + 1 Tắm + 1 Ủ (300ml) · Freeship',
            'badge' => '99K',
            'chk'   => false,
        ),
        array(
            'val'   => 'ban-chay',
            'name'  => 'Gói Best Seller 159K (Khuyên dùng)',
            'desc'  => '1 Gội + 1 Tắm + 1 Ủ (500ml) · Tiết kiệm nhất',
            'badge' => '159K',
            'chk'   => true,
        ),
        array(
            'val'   => 'sieu-tiet-kiem',
            'name'  => 'Gói Siêu Tiết Kiệm 299K',
            'desc'  => '1 Gội + 1 Tắm + 1 Ủ (1000ml) · Dùng 4-5 tháng',
            'badge' => '299K',
            'chk'   => false,
        ),
        array(
            'val'   => 'set-20-11',
            'name'  => 'Set Quà Tặng Tri Ân 20/11',
            'desc'  => 'Hộp quà cao cấp + Thiệp chúc viết tay',
            'badge' => 'Quà tặng',
            'chk'   => false,
        ),
    );
}

$has_order = lx_has_content($order_title);
if (!$has_order) {
    return;
}
?>

  <section class="ltg-sec ltg-order" id="dat-hang">
    <div class="ltg-wrap">
      <div class="ltg-order-card ltg-rv">
        <div class="ltg-order-head">
          <span class="ltg-eyebrow lx_wow_item">Đặt hàng nhanh</span>
          <h2 class="ltg-h2 lx_wow_item"><?php echo wp_kses_post($order_title); ?></h2>
          <?php if (lx_has_content($order_lead)) : ?>
            <p class="ltg-lead lx_wow_item" style="margin-top:10px;"><?php echo esc_html($order_lead); ?></p>
          <?php endif; ?>
        </div>

        <div id="ltgFormBody">
          <form id="ltgForm" class="ltg-order-form" novalidate>
            <div class="ltg-fg">
              <label class="ltg-fl lx_wow_item">Họ và tên người nhận <span style="color:var(--red)">*</span></label>
              <input type="text" name="name" class="ltg-inp" placeholder="Ví dụ: Nguyễn Thị Mai" required>
            </div>

            <div class="ltg-fg">
              <label class="ltg-fl lx_wow_item">Số điện thoại liên hệ <span style="color:var(--red)">*</span></label>
              <input type="tel" name="phone" class="ltg-inp" placeholder="Ví dụ: 0912 345 678" required>
            </div>

            <div class="ltg-fg">
              <label class="ltg-fl lx_wow_item">Địa chỉ nhận hàng chi tiết <span style="color:var(--red)">*</span></label>
              <input type="text" name="address" class="ltg-inp" placeholder="Số nhà, ngõ/ngách, đường, phường/xã, quận/huyện..." required>
            </div>

            <div class="ltg-fg">
              <label class="ltg-fl lx_wow_item">Chọn gói combo sản phẩm <span style="color:var(--red)">*</span></label>
              <div class="ltg-copts" id="ltgCombo">
                <?php foreach ($order_combos as $cb) :
                    if (empty($cb['name'])) continue;
                    $val = !empty($cb['val']) ? $cb['val'] : sanitize_title($cb['name']);
                    $is_checked = !empty($cb['chk']);
                ?>
                  <label class="ltg-copt<?php echo $is_checked ? ' is-on' : ''; ?>">
                    <input type="radio" name="combo" value="<?php echo esc_attr($val); ?>"<?php echo $is_checked ? ' checked' : ''; ?>>
                    <span class="ltg-copt-box"></span>
                    <span class="ltg-copt-txt">
                      <b class="lx_wow_item"><?php echo esc_html($cb['name']); ?></b>
                      <?php if (!empty($cb['desc'])) : ?>
                        <small class="lx_wow_item"><?php echo esc_html($cb['desc']); ?></small>
                      <?php endif; ?>
                    </span>
                    <?php if (!empty($cb['badge'])) : ?>
                      <span class="ltg-copt-tag"><?php echo esc_html($cb['badge']); ?></span>
                    <?php endif; ?>
                  </label>
                <?php endforeach; ?>
              </div>
            </div>

            <div class="ltg-fg">
              <label class="ltg-cchk">
                <input type="checkbox" id="ltgWrap" name="giftwrap" value="Có">
                <span></span>
                <span class="lx_wow_item"><b>Yêu cầu đóng gói hộp quà &amp; thiệp chúc mừng</b> (Miễn phí mùa 20/11)</span>
              </label>
            </div>

            <div class="ltg-fg" id="ltgMsg" style="display:none">
              <label class="ltg-fl lx_wow_item">Nội dung lời chúc gửi kèm thiệp (nếu có)</label>
              <textarea name="card" class="ltg-inp" rows="2" placeholder="Gửi tặng thầy/cô..."></textarea>
            </div>

            <button type="submit" class="ltg-btn ltg-btn--pri ltg-pulse lx_wow_item" style="width:100%;font-size:16px;">
              XÁC NHẬN ĐẶT HÀNG NGAY
            </button>
          </form>
        </div>

        <div id="ltgOk" class="ltg-order-ok" style="display:none;text-align:center;padding:40px 20px;">
          <div style="width:70px;height:70px;background:var(--butter);color:var(--forest);border-radius:50%;display:grid;place-items:center;margin:0 auto 20px;font-size:32px;">✓</div>
          <h3 class="ltg-h2" style="font-size:28px;color:var(--forest);margin-bottom:12px;">ĐẶT HÀNG THÀNH CÔNG!</h3>
          <p style="color:var(--muted);font-size:16px;max-width:500px;margin:0 auto 24px;line-height:1.6;">
            Cảm ơn bạn đã tin chọn <b>Home Care</b>. Chuyên viên tư vấn sẽ liên hệ với bạn trong vòng 15 phút để xác nhận đơn hàng và chuẩn bị gửi hàng sớm nhất!
          </p>
          <div style="font-size:14px;color:var(--ginger);font-weight:600;">
            Hotline hỗ trợ 24/7: 0962 131 515 – 0973 871 376
          </div>
        </div>

        <div class="ltg-order-trust">
          <div class="lx_wow_item"><svg width="18" height="18"><use href="#i-truck"/></svg> Freeship toàn quốc</div>
          <div class="lx_wow_item"><svg width="18" height="18"><use href="#i-shield"/></svg> Kiểm tra hàng trước khi thanh toán</div>
          <div class="lx_wow_item"><svg width="18" height="18"><use href="#i-check"/></svg> Đổi trả 7 ngày nếu không hài lòng</div>
        </div>
      </div>
    </div>
  </section>
