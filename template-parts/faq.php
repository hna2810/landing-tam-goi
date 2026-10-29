<?php
/**
 * FAQ Section Template Part
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$faq_eyebrow = lx_get_field('faq_eyebrow', 'option', "Hỏi đáp");
$faq_title   = lx_get_field('faq_title', 'option', "Giải đáp câu hỏi thường gặp");

$faq_default_items = array(
    array(
        'q' => '1. Sản phẩm có dùng được cho mẹ bầu và mẹ sau sinh không?',
        'a' => 'Có. Bộ đôi sản phẩm được nghiên cứu với các thành phần chiết xuất gừng, nghệ, hoa bưởi dịu nhẹ, phù hợp cho cả nam, nữ, mẹ bầu và mẹ sau sinh.',
    ),
    array(
        'q' => '2. Dùng bao lâu thì giảm tình trạng rụng tóc và gàu ngứa?',
        'a' => 'Hiệu quả cảm nhận rõ rệt sau 2–4 tuần sử dụng đều đặn hằng ngày nhờ sự kết hợp giữa gừng, nghệ, hoa bưởi và Vitamin B5 giúp làm sạch và nuôi dưỡng tóc từ sâu bên trong.',
    ),
    array(
        'q' => '3. Sữa tắm có gây khô da sau khi tắm không?',
        'a' => 'Sản phẩm chứa các thành phần dưỡng ẩm dịu nhẹ, giúp loại bỏ bã nhờn nhưng vẫn giữ lại độ ẩm tự nhiên, không gây cảm giác khô căng rát da.',
    ),
    array(
        'q' => 'Set quà 20/11 có giao tận trường không?',
        'a' => 'Có. Bạn ghi địa chỉ trường và lời nhắn trên thiệp, Home Care gói quà và giao tận nơi. Đơn tập thể từ 10 set vui lòng gọi hotline để nhận giá riêng.',
    ),
    array(
        'q' => 'Làm sao phân biệt hàng chính hãng?',
        'a' => 'Sản phẩm đã có phiếu công bố mỹ phẩm được Sở Y tế tiếp nhận, có tem chống hàng giả của Bộ Công An, tem chính hãng và thông tin trên hệ thống Mã số Mã vạch Quốc gia.',
    ),
);
$faq_items = lx_get_field('faq_items', 'option', $faq_default_items);
if (!is_array($faq_items)) {
    $faq_items = array();
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
        <?php foreach ($faq_items as $idx => $f) :
            if (empty($f['q'])) continue;
            $open = ($idx === 0) ? ' open' : '';
        ?>
          <details<?php echo esc_attr($open); ?>>
            <summary><?php echo esc_html($f['q']); ?></summary>
            <p><?php echo wp_kses_post($f['a'] ?? ''); ?></p>
          </details>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>
  </section>
