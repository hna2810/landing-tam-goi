<?php
/**
 * Short Videos Section Template Part
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$shorts_eyebrow = lx_get_field('shorts_eyebrow', 'option', "Video ngắn");
$shorts_title   = lx_get_field('shorts_title', 'option', "Khách hàng & hậu trường<br>trong 60 giây");
$shorts_tiktok  = lx_get_field('shorts_tiktok', 'option', "#");
$shorts_youtube = lx_get_field('shorts_youtube', 'option', "#");

$shorts_default_items = array(
    array(
        'video' => '',
        'thumb' => 'https://cdn.hstatic.net/products/200001066686/dau-goi-gung-nghe-may-may-300ml_976748158c9548e5a917d6f1037d2dbe.png',
        'src'   => 'TikTok',
        'title' => 'Gội thử lần đầu – tóc rụng ít hẳn',
        'sub'   => 'Trải nghiệm dầu gội',
    ),
    array(
        'video' => '',
        'thumb' => 'https://cdn.hstatic.net/products/200001066686/dau_goi_gung_nghe_may_may_-_dau_goi_cho_me_bau_va_me_sau_sinh_c85c9e18e5f24a9d93a1c3676d8fe1c8.jpg',
        'src'   => 'TikTok',
        'title' => 'Mẹ bầu tắm gội an tâm mỗi ngày',
        'sub'   => 'Review mẹ bầu',
    ),
    array(
        'video' => '',
        'thumb' => 'https://cdn.hstatic.net/products/200001066686/sua-tam-gung-nghe-may-may-500ml_8029728340d44067aa56b610e29f48ae.png',
        'src'   => 'Reels',
        'title' => 'Tạm biệt mụn lưng sau 3 tuần',
        'sub'   => 'Trải nghiệm sữa tắm',
    ),
    array(
        'video' => '',
        'thumb' => 'https://cdn.hstatic.net/products/200001066686/nuoc-u-toc-bang-gung-tuoi-homecare_b083a03618e0411081b79ca35482e003.jpg',
        'src'   => 'Shorts',
        'title' => 'Đun nấu thảo dược tại xưởng',
        'sub'   => 'Hậu trường sản xuất',
    ),
    array(
        'video' => '',
        'thumb' => 'https://cdn.hstatic.net/products/200001066686/nuoc-u-toc-bang-gung-tuoi_341071304a9d48dab53bca2e5363b41d.png',
        'src'   => 'TikTok',
        'title' => 'Ủ tóc gừng tươi – tóc mềm mượt',
        'sub'   => 'Tuỳ chọn ủ tóc',
    ),
);
$shorts_items = lx_get_field('shorts_items', 'option', $shorts_default_items);
if (!is_array($shorts_items)) {
    $shorts_items = array();
}

$has_shorts = lx_has_content($shorts_title) || (!empty($shorts_items) && is_array($shorts_items));
if (!$has_shorts) {
    return;
}
?>

  <section class="ltg-sec ltg-shorts">
    <div class="ltg-wrap">
      <div class="ltg-shorts-head ltg-rv">
        <div>
          <?php if (lx_has_content($shorts_eyebrow)) : ?>
            <span class="ltg-eyebrow lx_wow_item"><?php echo esc_html($shorts_eyebrow); ?></span>
          <?php endif; ?>
          <?php if (lx_has_content($shorts_title)) : ?>
            <h2 class="ltg-h2 lx_wow_item"><?php echo wp_kses_post($shorts_title); ?></h2>
          <?php endif; ?>
        </div>

        <div class="ltg-social">
          <?php if (lx_has_content($shorts_tiktok)) : ?>
            <a href="<?php echo esc_url($shorts_tiktok); ?>" target="_blank" rel="noopener" class="lx_wow_item">
              <svg width="18" height="18"><use href="#i-tt"/></svg>TikTok
            </a>
          <?php endif; ?>
          <?php if (lx_has_content($shorts_youtube)) : ?>
            <a href="<?php echo esc_url($shorts_youtube); ?>" target="_blank" rel="noopener" class="lx_wow_item">
              <svg width="18" height="18"><use href="#i-yt"/></svg>YouTube
            </a>
          <?php endif; ?>
        </div>
      </div>

      <?php if (!empty($shorts_items) && is_array($shorts_items)) : 
          $default_shorts_thumbs = array(
              'https://cdn.hstatic.net/products/200001066686/dau-goi-gung-nghe-may-may-300ml_976748158c9548e5a917d6f1037d2dbe.png',
              'https://cdn.hstatic.net/products/200001066686/dau_goi_gung_nghe_may_may_-_dau_goi_cho_me_bau_va_me_sau_sinh_c85c9e18e5f24a9d93a1c3676d8fe1c8.jpg',
              'https://cdn.hstatic.net/products/200001066686/sua-tam-gung-nghe-may-may-500ml_8029728340d44067aa56b610e29f48ae.png',
              'https://cdn.hstatic.net/products/200001066686/nuoc-u-toc-bang-gung-tuoi-homecare_b083a03618e0411081b79ca35482e003.jpg',
              'https://cdn.hstatic.net/products/200001066686/nuoc-u-toc-bang-gung-tuoi_341071304a9d48dab53bca2e5363b41d.png',
          );
      ?>
      <div class="ltg-srow">
        <?php foreach ($shorts_items as $idx => $sh) :
            if (empty($sh['title'])) continue;
            $v_url = !empty($sh['video']) ? $sh['video'] : '';
            $thumb = !empty($sh['thumb']) ? (is_array($sh['thumb']) ? ($sh['thumb']['url'] ?? '') : (is_numeric($sh['thumb']) ? wp_get_attachment_image_url($sh['thumb'], 'full') : $sh['thumb'])) : '';
            
            // Auto YouTube Shorts thumbnail fallback if not uploaded
            if (empty($thumb) && !empty($v_url)) {
                if (preg_match('/(?:shorts\/|v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $v_url, $yt_m)) {
                    $thumb = 'https://img.youtube.com/vi/' . $yt_m[1] . '/hqdefault.jpg';
                }
            }
            if (empty($thumb) && isset($default_shorts_thumbs[$idx])) {
                $thumb = $default_shorts_thumbs[$idx];
            }
            $src_lbl = !empty($sh['src']) ? $sh['src'] : 'TikTok';
        ?>
          <div class="ltg-short" data-video="<?php echo esc_attr($v_url); ?>" data-vertical="1" role="button" tabindex="0">
            <?php if (!empty($thumb)) : ?>
              <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr($sh['title']); ?>" loading="lazy">
            <?php endif; ?>
            <span class="ltg-short-src"><?php echo esc_html($src_lbl); ?></span>
            <span class="ltg-short-play"><svg width="24" height="24"><use href="#i-play"/></svg></span>
            <div class="ltg-short-cap">
              <b class="lx_wow_item"><?php echo esc_html($sh['title']); ?></b>
              <?php if (!empty($sh['sub'])) : ?>
                <small class="lx_wow_item"><?php echo esc_html($sh['sub']); ?></small>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="ltg-swipe">Vuốt để xem thêm <i></i></div>
      <?php endif; ?>
    </div>
  </section>
