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
        'q' => 'Dầu gội và sữa tắm Gừng Nghệ Mây Mây có dùng được cho mẹ bầu và mẹ sau sinh không?',
        'a' => 'Hoàn toàn dùng được! Bộ đôi được phát triển dựa trên hơn 15 năm kinh nghiệm chăm sóc mẹ bầu & sau sinh của Home Care, thành phần 100% thảo mộc tự nhiên, lành tính, không chứa hóa chất độc hại, an toàn tuyệt đối cho mẹ và bé.',
    ),
    array(
        'q' => 'Sản phẩm có làm bết tóc hoặc khô da không?',
        'a' => 'Không. Dầu gội làm sạch dịu nhẹ, cân bằng độ pH da đầu, giúp tóc tơi phồng bồng bềnh mà không gây khô xơ. Sữa tắm chứa tinh chất nghệ và dầu thảo mộc dưỡng ẩm, giúp da mịn màng, ẩm mượt ngay sau khi tắm.',
    ),
    array(
        'q' => 'Dùng bao lâu thì thấy hiệu quả giảm rụng và giảm mụn lưng?',
        'a' => 'Thông thường sau 1–2 tuần đầu, bạn sẽ cảm nhận da đầu sạch gàu hết ngứa, các nốt mụn lưng se lại. Từ 3–4 tuần sử dụng đều đặn, nang tóc chắc khỏe, giảm gãy rụng rõ rệt và tóc con bắt đầu mọc tua tủa.',
    ),
    array(
        'q' => 'Sản phẩm có đầy đủ giấy tờ công bố không?',
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
    <div class="ltg-wrap">
      <div class="ltg-center ltg-rv">
        <?php if (lx_has_content($faq_eyebrow)) : ?>
          <span class="ltg-eyebrow lx_wow_item"><?php echo esc_html($faq_eyebrow); ?></span>
        <?php endif; ?>
        <?php if (lx_has_content($faq_title)) : ?>
          <h2 class="ltg-h2 ltg-h2--md lx_wow_item"><?php echo wp_kses_post($faq_title); ?></h2>
        <?php endif; ?>
      </div>

      <?php if (!empty($faq_items) && is_array($faq_items)) : ?>
      <div class="ltg-faqs">
        <?php foreach ($faq_items as $f) :
            if (empty($f['q'])) continue;
        ?>
          <details class="ltg-faq ltg-rv">
            <summary class="lx_wow_item">
              <span><?php echo esc_html($f['q']); ?></span>
              <svg width="20" height="20"><use href="#i-chev"/></svg>
            </summary>
            <div class="ltg-faq-a lx_wow_item">
              <p><?php echo wp_kses_post($f['a']); ?></p>
            </div>
          </details>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>
  </section>
