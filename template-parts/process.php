<?php
/**
 * Process and Video Section Template Part
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$proc_eyebrow    = lx_get_field('proc_eyebrow', 'option', "Quy trình sản xuất");
$proc_title      = lx_get_field('proc_title', 'option', "Từng giọt dầu gội ra đời như thế nào?");
$proc_lead       = lx_get_field('proc_lead', 'option', "Từ nguyên liệu gừng nghệ đến chai gội xả thơm lành trên tay.");
$proc_video      = lx_get_field('proc_video', 'option', "https://www.youtube.com/shorts/CoHucyPBjSU");
$proc_video_h    = lx_get_field('proc_video_title', 'option', "Hành trình từ đất lành đến mái tóc khoẻ – Dầu gội Gừng Nghệ Mây Mây");

// Extract YouTube ID for direct iframe embed
$youtube_id = '';
if (!empty($proc_video)) {
    if (preg_match('/(?:youtube\.com\/(?:watch\?v=|shorts\/|embed\/)|youtu\.be\/)([\w-]{6,})/', $proc_video, $matches)) {
        $youtube_id = $matches[1];
    }
}
if (empty($youtube_id)) {
    $youtube_id = 'CoHucyPBjSU';
}

$proc_default_steps = array(
    array(
        'num'   => '01',
        'title' => 'Vùng nguyên liệu',
        'desc'  => 'Gừng sẻ, nghệ vàng được thu hoạch, rửa sạch và phân loại kỹ càng.',
        'img'   => get_template_directory_uri() . '/assets/images/real/step-01-thao-duoc.jpg',
    ),
    array(
        'num'   => '02',
        'title' => 'Ủ nước cốt',
        'desc'  => 'Nấu chậm theo phương pháp truyền thống kết hợp công nghệ hiện đại, giữ trọn tinh chất quý.',
        'img'   => get_template_directory_uri() . '/assets/images/real/step-02-so-che.jpg',
    ),
    array(
        'num'   => '03',
        'title' => 'Chất dầu gội đậm đặc',
        'desc'  => 'Màu nâu vàng tự nhiên của gừng nghệ, kết cấu sánh quyện giàu dưỡng chất.',
        'img'   => get_template_directory_uri() . '/assets/images/real/step-03-dun-nau.jpg',
    ),
    array(
        'num'   => '04',
        'title' => 'Đóng chai & kiểm định',
        'desc'  => 'Đóng chai, dán tem chống hàng giả Bộ Công An, kiểm định trước khi xuất xưởng.',
        'img'   => get_template_directory_uri() . '/assets/images/real/step-04-chiet-rot.jpg',
    ),
);
$proc_flow_steps = lx_get_field('proc_flow_steps', 'option', $proc_default_steps);
if (!is_array($proc_flow_steps) || empty($proc_flow_steps)) {
    $proc_flow_steps = $proc_default_steps;
}

$has_proc = lx_has_content($proc_title) || !empty($proc_flow_steps);
if (!$has_proc) {
    return;
}
?>

  <section class="ltg-has-deco ltg-sec ltg-proc" id="quy-trinh">
    <div class="ltg-deco" aria-hidden="true">
      <span class="ltg-sp im-gc dk" style="right:3%;top:40px;width:200px;height:142px;--r:8deg;animation-delay:-2s;animation-duration:13s"></span>
      <span class="ltg-sp im-nl" style="left:5%;top:70px;width:140px;height:62px;--r:14deg;animation-delay:-5s;animation-duration:11s"></span>
    </div>

    <div class="ltg-wrap">
      <div class="ltg-center">
        <?php if (lx_has_content($proc_eyebrow)) : ?>
          <span class="ltg-eyebrow"><?php echo esc_html($proc_eyebrow); ?></span>
        <?php endif; ?>
        <?php if (lx_has_content($proc_title)) : ?>
          <h2 class="ltg-h2"><?php echo wp_kses_post($proc_title); ?></h2>
        <?php endif; ?>
        <?php if (lx_has_content($proc_lead)) : ?>
          <p class="ltg-lead"><?php echo esc_html($proc_lead); ?></p>
        <?php endif; ?>
      </div>

      <!-- VIDEO EMBED TRỰC TIẾP -->
      <div class="ltg-vlong ltg-vlong--embed" id="ltgMainVideoWrap">
        <iframe src="https://www.youtube.com/embed/<?php echo esc_attr($youtube_id); ?>?rel=0&modestbranding=1" title="<?php echo esc_attr($proc_video_h); ?>" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen loading="lazy"></iframe>
      </div>

      <!-- 2 VIDEO SHORTS -->
      <div class="ltg-nc-vids">
        <div class="ltg-nc-vid" data-video="https://www.youtube.com/shorts/RR7KrV1eiTo" data-vertical="1" role="button" tabindex="0" aria-label="Xem video Dầu gội Gừng Nghệ cho mẹ sau sinh">
          <img src="https://i.ytimg.com/vi/RR7KrV1eiTo/hqdefault.jpg" alt="Dầu gội Gừng Nghệ Mây Mây cho mẹ sau sinh" loading="lazy">
          <span class="ltg-nc-vplay"><svg width="22" height="22"><use href="#i-play"/></svg></span>
          <div>
            <b>Sau sinh tóc rụng từng búi?</b>
            <small>Dầu gội Gừng Nghệ · 30 giây (Xem video)</small>
          </div>
        </div>
        <div class="ltg-nc-vid" data-video="https://www.youtube.com/shorts/3E12F-vt77c" data-vertical="1" role="button" tabindex="0" aria-label="Xem video Xịt khử mùi Gừng Cam">
          <img src="https://i.ytimg.com/vi/3E12F-vt77c/hqdefault.jpg" alt="Xịt khử mùi Gừng Cam Mây Mây" loading="lazy">
          <span class="ltg-nc-vplay"><svg width="22" height="22"><use href="#i-play"/></svg></span>
          <div>
            <b>Xịt khử mùi Gừng Cam</b>
            <small>Quà tặng kèm bộ 500ml · 18 giây (Xem video)</small>
          </div>
        </div>
      </div>

      <!-- 4 BƯỚC QUY TRÌNH -->
      <?php if (!empty($proc_flow_steps) && is_array($proc_flow_steps)) : 
          $valid_flow_steps = array();
          foreach ($proc_flow_steps as $st) {
              if (!empty($st['title'])) {
                  $valid_flow_steps[] = $st;
              }
          }
          $flow_count = count($valid_flow_steps);
          $default_flow_imgs = array(
              get_template_directory_uri() . '/assets/images/real/step-01-thao-duoc.jpg',
              get_template_directory_uri() . '/assets/images/real/step-02-so-che.jpg',
              get_template_directory_uri() . '/assets/images/real/step-03-dun-nau.jpg',
              get_template_directory_uri() . '/assets/images/real/step-04-chiet-rot.jpg',
          );
      ?>
      <div class="ltg-flow" style="--flow-cols: <?php echo max(1, min(5, $flow_count)); ?>;">
        <?php foreach ($valid_flow_steps as $idx => $step) :
            $img = !empty($step['img']) ? (is_array($step['img']) ? ($step['img']['url'] ?? '') : (is_numeric($step['img']) ? wp_get_attachment_image_url($step['img'], 'full') : $step['img'])) : '';
            if ((empty($img) || strpos($img, 'hstatic.net') !== false) && isset($default_flow_imgs[$idx])) {
                $img = $default_flow_imgs[$idx];
            }
            $num = !empty($step['num']) ? $step['num'] : str_pad($idx + 1, 2, '0', STR_PAD_LEFT);
        ?>
          <div class="">
            <?php if (!empty($img)) : ?>
              <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($step['title']); ?>" loading="lazy">
            <?php endif; ?>
            <?php if (!empty($num)) : ?>
              <small><?php echo esc_html($num); ?></small>
            <?php endif; ?>
            <b><?php echo esc_html($step['title']); ?></b>
            <span><?php echo esc_html($step['desc'] ?? ''); ?></span>
          </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>
  </section>
