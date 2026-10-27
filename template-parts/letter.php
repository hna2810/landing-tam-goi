<?php
/**
 * Founder Letter / Commitment Section Template Part
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$letter_mascot = lx_get_image_url('letter_mascot', 'https://cdn.hstatic.net/products/200001066686/combo-sua-tam-dau-goi-gung-nghe-may-may_37c9f5a7dbe9474d82a53a57c114c033.png', 'medium', 'option');
$letter_title  = lx_get_field('letter_title', 'option', "MÂY MÂY -<br>TÓC SẠCH, DA THƠM");
$letter_body   = lx_get_field('letter_body', 'option', "Trải qua ba lần sinh nở trước tuổi 30, chị Mai hiểu rằng, hành trình làm mẹ không chỉ có niềm vui đón con mà còn là những tháng ngày người mẹ cần được chăm sóc và nâng niu.\n\nTừ kiến thức chuyên môn và nhiều năm tháng đồng hành cùng các thai phụ & sản phụ, chị Mai tìm về những bí quyết chăm sóc bí truyền với các nguyên liệu thân thuộc từ gừng, nghệ và thảo mộc. Nhưng việc chuẩn bị cầu kỳ mỗi ngày khiến chị trăn trở về phương pháp chăm sóc mẹ thuận tiện hơn.\n\nTừ đó, chị Mai đã tạo nên Mây Mây – thương hiệu chăm sóc mẹ từ tinh hoa thảo mộc, mong muốn mang đến những sản phẩm gần gũi, giúp mẹ chăm sóc tóc và làn da dễ dàng hơn trong kỳ ở cữ.");
$letter_hl     = lx_get_field('letter_hl', 'option', "Bởi chị hiểu, sau những tháng ngày dành trọn yêu thương cho con, mẹ cũng xứng đáng được chăm sóc và yêu thương chính mình.");
$letter_voice  = lx_get_field('letter_voice', 'option', "");

$has_letter = lx_has_content($letter_title) || lx_has_content($letter_body);
if (!$has_letter) {
    return;
}
?>

  <section class="ltg-sec ltg-type" id="loi-nhan">
    <div class="ltg-wrap">
      <div class="ltg-type-head ltg-rv">
        <?php if (!empty($letter_mascot)) : ?>
          <img src="<?php echo esc_url($letter_mascot); ?>" alt="" class="ltg-type-mascot" aria-hidden="true" loading="lazy">
        <?php endif; ?>
        <?php if (lx_has_content($letter_title)) : ?>
          <h2 class="ltg-h2 ltg-h2--md lx_wow_item"><?php echo wp_kses_post($letter_title); ?></h2>
        <?php endif; ?>
      </div>

      <div class="ltg-type-box ltg-rv" id="ltgType">
        <span class="ltg-type-quote" aria-hidden="true">“</span>
        <p class="ltg-type-text">
          <span class="ltg-type-ghost"><?php echo esc_html($letter_body); ?></span>
          <span class="ltg-type-live" id="ltgTypeBody" aria-hidden="true"></span>
        </p>
        <?php if (lx_has_content($letter_hl)) : ?>
        <p class="ltg-type-hl">
          <strong class="ltg-type-ghost"><?php echo esc_html($letter_hl); ?></strong>
          <strong class="ltg-type-live" id="ltgTypeHl" aria-hidden="true"></strong>
        </p>
        <?php endif; ?>
      </div>
    </div>
    <audio id="ltgTypeVoice" preload="auto"<?php echo !empty($letter_voice) ? ' src="' . esc_url($letter_voice) . '"' : ''; ?>></audio>
  </section>
