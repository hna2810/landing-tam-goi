<?php
/**
 * Process and Video Section Template Part
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$proc_eyebrow    = lx_get_field('proc_eyebrow', 'option', "Tận mắt quy trình");
$proc_title      = lx_get_field('proc_title', 'option', "Từ nồi thảo dược đến tay bạn");
$proc_lead       = lx_get_field('proc_lead', 'option', "Không giấu giếm – xem trọn quy trình đun nấu, chiết lọc và đóng chai dầu gội, sữa tắm Gừng Nghệ Mây Mây.");
$proc_video      = lx_get_field('proc_video', 'option', "");
$proc_video_thumb= lx_get_image_url('proc_video_thumb', 'https://cdn.hstatic.net/products/200001066686/nuoc-u-toc-tu-gung_39ddc7514164454692cfd14d198b8458.jpg', 'full', 'option');
$proc_video_tag  = lx_get_field('proc_video_tag', 'option', "Video thực tế");
$proc_video_h    = lx_get_field('proc_video_title', 'option', "Hành trình đun nấu Gừng Nghệ Mây Mây");
$proc_video_desc = lx_get_field('proc_video_desc', 'option', "Từ chọn nguyên liệu, nấu chiết thảo dược đến khi thành chai dầu gội, sữa tắm.");

$proc_default_steps = array(
    array(
        'num'   => '01',
        'title' => 'Chọn thảo dược',
        'desc'  => 'Gừng, nghệ, bưởi tươi được tuyển chọn',
        'img'   => 'https://cdn.hstatic.net/products/200001066686/nguyen-lieu-gung-nghe_aa75eb4c00f54ed7bda0abe067db2800.jpg',
    ),
    array(
        'num'   => '02',
        'title' => 'Sơ chế',
        'desc'  => 'Rửa sạch, cắt lát, giữ trọn tinh chất',
        'img'   => 'https://cdn.hstatic.net/products/200001066686/nuoc-u-toc-bang-gung-tuoi-homecare_b083a03618e0411081b79ca35482e003.jpg',
    ),
    array(
        'num'   => '03',
        'title' => 'Đun nấu',
        'desc'  => 'Nấu chiết thảo dược theo công thức Home Care',
        'img'   => 'https://cdn.hstatic.net/products/200001066686/nuoc-u-toc-tu-gung_39ddc7514164454692cfd14d198b8458.jpg',
    ),
    array(
        'num'   => '04',
        'title' => 'Lọc & đóng chai',
        'desc'  => 'Lọc mịn, phối vitamin, chiết rót',
        'img'   => 'https://cdn.hstatic.net/products/200001066686/ch_t_d_u_g_i_g_ng_ngh__m_y_m_y_homecare_98cc876517dc4d9bbb42e1528e91dc58.png',
    ),
    array(
        'num'   => '05',
        'title' => 'Công bố & tem',
        'desc'  => 'Sở Y tế tiếp nhận, tem chống giả',
        'img'   => 'https://cdn.hstatic.net/products/200001066686/scb-dau-goi-gung-nghe_b1a448ecb88540ea96a76760844ae7f8.png',
    ),
);
$proc_flow_steps = lx_get_field('proc_flow_steps', 'option', $proc_default_steps);
if (!is_array($proc_flow_steps)) {
    $proc_flow_steps = array();
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

      <!-- VIDEO DÀI -->
      <div class="ltg-vlong" data-video="<?php echo esc_attr($proc_video); ?>" role="button" tabindex="0" aria-label="Xem video quy trình">
        <?php if (!empty($proc_video_thumb)) : ?>
          <img src="<?php echo esc_url($proc_video_thumb); ?>" alt="<?php echo esc_attr($proc_video_h); ?>" loading="lazy">
        <?php endif; ?>
        <span class="ltg-play"><svg width="34" height="34"><use href="#i-play"/></svg></span>
        <div class="ltg-vlong-cap">
          <div>
            <?php if (lx_has_content($proc_video_tag)) : ?>
              <span class="ltg-vlong-tag"><?php echo esc_html($proc_video_tag); ?></span>
            <?php endif; ?>
            <?php if (lx_has_content($proc_video_h)) : ?>
              <h3><?php echo esc_html($proc_video_h); ?></h3>
            <?php endif; ?>
            <?php if (lx_has_content($proc_video_desc)) : ?>
              <p><?php echo esc_html($proc_video_desc); ?></p>
            <?php endif; ?>
          </div>
          <span class="ltg-dur">▶ Xem video</span>
        </div>
      </div>

      <?php if (!empty($proc_flow_steps) && is_array($proc_flow_steps)) : 
          $valid_flow_steps = array();
          foreach ($proc_flow_steps as $st) {
              if (!empty($st['title'])) {
                  $valid_flow_steps[] = $st;
              }
          }
          $flow_count = count($valid_flow_steps);
          $default_flow_imgs = array(
              'https://cdn.hstatic.net/products/200001066686/nguyen-lieu-gung-nghe_aa75eb4c00f54ed7bda0abe067db2800.jpg',
              'https://cdn.hstatic.net/products/200001066686/nuoc-u-toc-bang-gung-tuoi-homecare_b083a03618e0411081b79ca35482e003.jpg',
              'https://cdn.hstatic.net/products/200001066686/nuoc-u-toc-tu-gung_39ddc7514164454692cfd14d198b8458.jpg',
              'https://cdn.hstatic.net/products/200001066686/ch_t_d_u_g_i_g_ng_ngh__m_y_m_y_homecare_98cc876517dc4d9bbb42e1528e91dc58.png',
              'https://cdn.hstatic.net/products/200001066686/scb-dau-goi-gung-nghe_b1a448ecb88540ea96a76760844ae7f8.png',
          );
      ?>
      <div class="ltg-flow" style="--flow-cols: <?php echo max(1, min(5, $flow_count)); ?>;">
        <?php foreach ($valid_flow_steps as $idx => $step) :
            $img = !empty($step['img']) ? (is_array($step['img']) ? ($step['img']['url'] ?? '') : (is_numeric($step['img']) ? wp_get_attachment_image_url($step['img'], 'full') : $step['img'])) : '';
            if (empty($img) && isset($default_flow_imgs[$idx])) {
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
