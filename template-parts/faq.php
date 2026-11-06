<?php
/**
 * FAQ Section Template Part
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$faq_eyebrow = lx_get_field('faq_eyebrow', 'option', "Giải đáp thắc mắc");
$faq_title   = lx_get_field('faq_title', 'option', "Giải đáp câu hỏi thường gặp");

$faq_default_items = array(
    array(
        'q' => 'Mẹ bầu và mẹ sau sinh có dùng được không?',
        'a' => 'Dùng được. Bộ đôi chiết xuất từ gừng, nghệ và thảo mộc, công thức dịu nhẹ, trên nhãn ghi rõ “Dùng cho cả nam, nữ, bầu &amp; sau sinh”. Đây cũng là sản phẩm Home Care đang dùng trong dịch vụ chăm sóc bầu, sau sinh. Nếu da đầu hoặc da đang bị tổn thương, vết mổ chưa lành, mẹ nên hỏi ý kiến bác sĩ trước khi dùng.',
    ),
    array(
        'q' => 'Mùi gừng nghệ có bị nồng, hắc không?',
        'a' => 'Không. Mùi gừng nghệ ấm và nhẹ, gội/tắm xong chỉ còn thoang thoảng, không hăng như nước gừng tự nấu. Dầu gội có thêm chiết xuất bưởi nên mùi dễ chịu hơn.',
    ),
    array(
        'q' => 'Gội xong tóc có bị khô, rít không?',
        'a' => 'Dầu gội có Vitamin B5 giúp giữ ẩm nên gội xong tóc mềm, không khô rít. Với tóc đã khô xơ do uốn, nhuộm, mẹ nên dùng thêm dầu xả hoặc ủ tóc để tóc mượt hơn.',
    ),
    array(
        'q' => 'Bao lâu thì thấy tóc bớt rụng?',
        'a' => 'Tuỳ cơ địa mỗi người. Nhiều mẹ phản hồi sau khoảng 3–4 tuần gội đều đặn thì da đầu sạch thoáng, tóc ít gãy rụng khi chải hơn. Rụng tóc sau sinh liên quan đến nội tiết nên thường kéo dài vài tháng; dầu gội giúp chăm sóc da đầu và chân tóc trong giai đoạn này, không thay thế điều trị.',
    ),
    array(
        'q' => 'Sữa tắm có giúp ích cho da lưng hay nổi mụn không?',
        'a' => 'Sữa tắm giúp làm sạch dầu thừa, mồ hôi và bụi bẩn trên da lưng, ngực – những nguyên nhân thường gặp gây bít tắc lỗ chân lông, mà không làm khô căng da. Với mụn viêm nặng hoặc kéo dài, mẹ nên đi khám da liễu.',
    ),
    array(
        'q' => 'Nên chọn bộ 300ml hay 500ml?',
        'a' => 'Bộ 300ml (79.000đ) hợp để dùng thử hoặc dùng cho 1 người. Bộ 500ml (169.000đ) dùng được lâu hơn, hợp cho cả nhà, và được tặng kèm 1 xịt khử mùi Gừng Cam 30ml.',
    ),
    array(
        'q' => 'Xịt khử mùi Gừng Cam tặng kèm dùng để làm gì?',
        'a' => 'Xịt khử mùi từ tinh dầu thiên nhiên bạc hà, trầu không, gừng cam, dùng cho vùng nách, chân và các vùng hay ra mồ hôi, giúp cơ thể khô thoáng, thơm nhẹ. Phù hợp cả với mẹ bầu và mẹ sau sinh.',
    ),
    array(
        'q' => 'Muốn mua làm quà tặng thầy cô 20/11 thì sao?',
        'a' => 'Home Care có 3 combo quà riêng cho 20/11 (199K, 349K, 499K), trọn bộ Tắm – Gội – Ủ tóc gừng nghệ. Mẹ xem chi tiết tại <a href="https://trianthayco.homecarevietnam.com/#combo-qua" target="_blank" rel="noopener" style="color:var(--ginger);font-weight:700;text-decoration:underline">trang quà tặng 20/11</a>.',
    ),
    array(
        'q' => 'Giao hàng và đổi trả thế nào?',
        'a' => 'Home Care giao hàng toàn quốc, miễn phí vận chuyển cho đơn đặt qua trang này. Mẹ được kiểm tra hàng trước khi thanh toán, và được đổi trả trong 7 ngày nếu sản phẩm có lỗi từ nhà sản xuất.',
    ),
);
$faq_items = lx_get_field('faq_items', 'option', $faq_default_items);
if (!is_array($faq_items) || empty($faq_items)) {
    $faq_items = $faq_default_items;
}

$has_faq = lx_has_content($faq_title) || (!empty($faq_items) && is_array($faq_items));
if (!$has_faq) {
    return;
}
?>

  <section class="ltg-has-deco ltg-sec" id="hoi-dap">
    <div class="ltg-deco" aria-hidden="true">
      <span class="ltg-sp im-gt lg edge" style="left:0;top:34%;width:290px;height:245px;--r:0deg;animation-delay:0s;animation-duration:13s"></span>
      <span class="ltg-sp im-nb lg edge" style="right:0;top:26%;width:210px;height:181px;--r:0deg;animation-delay:-3s;animation-duration:12s"></span>
      <span class="ltg-sp im-nl lg" style="right:6%;bottom:12%;width:160px;height:71px;--r:-10deg;animation-delay:-5s;animation-duration:11s"></span>
      <span class="ltg-sp im-nl" style="left:5%;top:30px;width:130px;height:58px;--r:6deg;animation-delay:-2s;animation-duration:11s"></span>
    </div>

    <div class="ltg-wrap">
      <div class="ltg-center">
        <?php if (lx_has_content($faq_eyebrow)) : ?>
          <span class="ltg-eyebrow"><?php echo esc_html($faq_eyebrow); ?></span>
        <?php endif; ?>
        <?php if (lx_has_content($faq_title)) : ?>
          <h2 class="ltg-h2 ltg-h2--md"><?php echo wp_kses_post($faq_title); ?></h2>
        <?php endif; ?>
      </div>

      <?php if (!empty($faq_items) && is_array($faq_items)) : ?>
      <div class="ltg-faq-list">
        <?php foreach ($faq_items as $i => $item) :
            if (empty($item['q'])) continue;
        ?>
          <details<?php echo ($i === 0) ? ' open' : ''; ?>>
            <summary><?php echo esc_html($item['q']); ?></summary>
            <p><?php echo wp_kses_post($item['a'] ?? ''); ?></p>
          </details>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>
  </section>
