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

      <?php if (!empty($voice_url)) : ?>
      <div class="ltg-voice-player" id="ltgVoicePlayer">
        <audio id="ltgTypeVoice" preload="metadata" src="<?php echo esc_url($voice_url); ?>"></audio>
        <button class="ltg-voice-btn" id="ltgVoiceBtn" type="button" aria-label="Phát giọng đọc của chị Mai">
          <svg class="ltg-voice-play-ic" width="22" height="22" viewBox="0 0 24 24"><path d="M8 5v14l11-7z" fill="currentColor"/></svg>
          <svg class="ltg-voice-pause-ic" width="22" height="22" viewBox="0 0 24 24" style="display:none;"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z" fill="currentColor"/></svg>
        </button>
        <div class="ltg-voice-meta">
          <div class="ltg-voice-top">
            <span class="ltg-voice-wave" id="ltgVoiceWave">
              <span></span><span></span><span></span><span></span><span></span>
            </span>
            <b class="ltg-voice-title">Lắng nghe tâm sự từ <?php echo esc_html($letter_author ?: 'Chị Mai'); ?></b>
          </div>
          <div class="ltg-voice-track">
            <div class="ltg-voice-bar" id="ltgVoiceBar" role="slider" aria-label="Thanh tiến trình âm thanh" tabindex="0">
              <div class="ltg-voice-fill" id="ltgVoiceFill"></div>
            </div>
            <div class="ltg-voice-time">
              <span id="ltgVoiceCur">00:00</span> / <span id="ltgVoiceDur">--:--</span>
            </div>
          </div>
        </div>
      </div>
      <?php endif; ?>

      <div class="ltg-type-box">
        <span class="ltg-type-quote" aria-hidden="true">“</span>
        
        <?php if (lx_has_content($letter_body)) : ?>
        <div class="ltg-type-text">
          <?php echo nl2br(esc_html($letter_body)); ?>
        </div>
        <?php endif; ?>

        <?php if (lx_has_content($letter_hl)) : ?>
        <div class="ltg-type-hl">
          <strong><?php echo esc_html($letter_hl); ?></strong>
        </div>
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
  </section>
