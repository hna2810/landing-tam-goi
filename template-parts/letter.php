<?php
/**
 * Founder Letter / Commitment Section Template Part
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$letter_mascot      = lx_get_image_url('letter_mascot', get_template_directory_uri() . '/assets/images/real/founder-avatar.jpg', 'medium', 'option');
if (empty($letter_mascot) || strpos($letter_mascot, 'combo-sua-tam') !== false || strpos($letter_mascot, 'hstatic.net') !== false) {
    $letter_mascot = get_template_directory_uri() . '/assets/images/real/founder-avatar.jpg';
}
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

  <section class="ltg-sec ltg-type ltg-letter-sec" id="loi-nhan">
    <div class="ltg-wrap">
      <div class="ltg-letter-container">
        <!-- Top Cameo / Founder Header -->
        <div class="ltg-letter-header">
          <?php if (!empty($letter_mascot)) : ?>
            <div class="ltg-founder-avatar-wrap">
              <img src="<?php echo esc_url($letter_mascot); ?>" alt="<?php echo esc_attr($letter_author ?: 'Chị Mai'); ?>" class="ltg-founder-avatar ltg-type-mascot" loading="lazy">
              <span class="ltg-founder-badge" aria-hidden="true">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
              </span>
            </div>
          <?php endif; ?>
          <span class="ltg-eyebrow">Tâm thư người sáng lập</span>
          <?php if (lx_has_content($letter_title)) : ?>
            <h2 class="ltg-h2 ltg-h2--md"><?php echo wp_kses_post($letter_title); ?></h2>
          <?php endif; ?>
        </div>

        <!-- Luxury Letter Card with Classic Parchment Styling -->
        <div class="ltg-type-box ltg-letter-card" id="ltgType" role="region" aria-label="Tâm thư người sáng lập">
          <div class="ltg-letter-card-inner">
            <span class="ltg-type-quote ltg-letter-quote-mark" aria-hidden="true">“</span>
            
            <div class="ltg-letter-content">
              <?php if (lx_has_content($letter_body)) : ?>
              <p class="ltg-type-text">
                <span class="ltg-type-ghost" id="ltgGhostBody"><?php echo esc_html($letter_body); ?></span>
                <span class="ltg-type-live" id="ltgTypeBody" aria-hidden="true"></span>
              </p>
              <?php endif; ?>

              <?php if (lx_has_content($letter_hl)) : ?>
              <div class="ltg-letter-hl-box">
                <p class="ltg-type-hl">
                  <strong class="ltg-type-ghost" id="ltgGhostHl"><?php echo esc_html($letter_hl); ?></strong>
                  <strong class="ltg-type-live" id="ltgTypeHl" aria-hidden="true"></strong>
                </p>
              </div>
              <?php endif; ?>

              <!-- Sign-off & Authentic Seal -->
              <div class="ltg-letter-footer">
                <?php if (lx_has_content($letter_author)) : ?>
                <div class="ltg-type-sign ltg-letter-sign">
                  <div class="ltg-sign-msg">Thương mến gửi mẹ ❤️</div>
                  <div class="ltg-sign-name"><?php echo esc_html($letter_author); ?></div>
                  <?php if (lx_has_content($letter_author_title)) : ?>
                    <div class="ltg-sign-title"><?php echo esc_html($letter_author_title); ?></div>
                  <?php endif; ?>
                </div>
                <?php endif; ?>

                <div class="ltg-letter-stamp" aria-hidden="true">
                  <div class="ltg-stamp-circle">
                    <span>HOME CARE</span>
                    <small>SINCE 2008</small>
                    <i>CHĂM SÓC MẸ &amp; BÉ</i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

    <?php if (!empty($voice_url)) : ?>
      <audio id="ltgTypeVoice" preload="auto" playsinline webkit-playsinline src="<?php echo esc_url($voice_url); ?>"></audio>
    <?php endif; ?>
  </section>
