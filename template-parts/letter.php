<?php
/**
 * Founder Letter / Commitment Section Template Part
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$letter_mascot      = lx_get_image_url('letter_mascot', '', 'medium', 'option');
$letter_title       = lx_get_field('letter_title', 'option', "MÂY MÂY –<br>TÓC SẠCH, DA THƠM");
$letter_body        = lx_get_field('letter_body', 'option', "Trải qua ba lần sinh nở trước tuổi 30, chị Mai hiểu rằng, hành trình làm mẹ không chỉ có niềm vui đón con mà còn là những tháng ngày người mẹ cần được chăm sóc và nâng niu.\n\nTừ kiến thức chuyên môn và nhiều năm tháng đồng hành cùng các thai phụ & sản phụ, chị Mai tìm về những bí quyết chăm sóc bí truyền với các nguyên liệu thân thuộc từ gừng, nghệ và thảo mộc. Nhưng việc chuẩn bị cầu kỳ mỗi ngày khiến chị trăn trở về phương pháp chăm sóc mẹ thuận tiện hơn.\n\nTừ đó, chị Mai đã tạo nên Mây Mây – thương hiệu chăm sóc mẹ từ tinh hoa thảo mộc, mong muốn mang đến những sản phẩm gần gũi, giúp mẹ chăm sóc tóc và làn da dễ dàng hơn trong kỳ ở cữ.");
$letter_hl          = lx_get_field('letter_hl', 'option', "Bởi chị hiểu, sau những tháng ngày dành trọn yêu thương cho con, mẹ cũng xứng đáng được chăm sóc và yêu thương chính mình.");
$letter_voice       = lx_get_field('letter_voice', 'option', '');
$letter_author      = lx_get_field('letter_author', 'option', 'Chị Mai');
$letter_author_title= lx_get_field('letter_author_title', 'option', 'Nhà sáng lập Home Care · Mẹ của 3 con');

// Handle voice URL whether stored as array, ID, or URL string
$voice_url = '';
if (!empty($letter_voice)) {
    if (is_array($letter_voice) && !empty($letter_voice['url'])) {
        $voice_url = $letter_voice['url'];
    } elseif (is_numeric($letter_voice)) {
        $attachment_url = wp_get_attachment_url($letter_voice);
        if ($attachment_url) {
            $voice_url = $attachment_url;
        }
    } elseif (is_string($letter_voice)) {
        $voice_url = trim($letter_voice);
    }
}

$has_letter = lx_has_content($letter_title) || lx_has_content($letter_body);
if (!$has_letter) {
    return;
}
?>

  <section class="ltg-sec ltg-type" id="loi-nhan">
    <div class="ltg-wrap">
      <div class="ltg-type-head">
        <?php if (!empty($letter_mascot)) : ?>
          <img src="<?php echo esc_url($letter_mascot); ?>" alt="<?php echo esc_attr($letter_author ?: 'Chị Mai'); ?>" class="ltg-type-mascot" loading="lazy">
        <?php endif; ?>
        <span class="ltg-eyebrow">Tâm thư người sáng lập</span>
        <?php if (lx_has_content($letter_title)) : ?>
          <h2 class="ltg-h2 ltg-h2--md"><?php echo wp_kses_post($letter_title); ?></h2>
        <?php endif; ?>
      </div>

      <div class="ltg-type-box" id="ltgType" role="region" aria-label="Tâm thư người sáng lập">
        <span class="ltg-type-quote" aria-hidden="true">“</span>
        
        <?php if (lx_has_content($letter_body)) : ?>
        <p class="ltg-type-text">
          <span class="ltg-type-ghost" id="ltgGhostBody"><?php echo esc_html($letter_body); ?></span>
          <span class="ltg-type-live" id="ltgTypeBody" aria-hidden="true"></span>
        </p>
        <?php endif; ?>

        <?php if (lx_has_content($letter_hl)) : ?>
        <p class="ltg-type-hl">
          <strong class="ltg-type-ghost" id="ltgGhostHl"><?php echo esc_html($letter_hl); ?></strong>
          <strong class="ltg-type-live" id="ltgTypeHl" aria-hidden="true"></strong>
        </p>
        <?php endif; ?>

        <?php if (lx_has_content($letter_author)) : ?>
        <div class="ltg-type-sign">
          <div class="ltg-sign-msg">Thương mến gửi mẹ ❤️</div>
          <div class="ltg-sign-name"><?php echo esc_html($letter_author); ?></div>
          <?php if (lx_has_content($letter_author_title)) : ?>
            <div class="ltg-sign-title"><?php echo esc_html($letter_author_title); ?></div>
          <?php endif; ?>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <?php if (!empty($voice_url)) : ?>
      <audio id="ltgTypeVoice" preload="auto" playsinline webkit-playsinline src="<?php echo esc_url($voice_url); ?>"></audio>
    <?php endif; ?>
  </section>
