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
        'thumb' => 'https://cdn.hstatic.net/products/200001066686/dau_goi_gung_nghe_may_may_-_dau_goi_cho_me_bau_va_me_sau_sinh_c85c9e18e5f24a9d93a1c3676d8fe1c8.jpg',
        'src'   => 'TikTok',
        'title' => 'Mẹ bỉm chia sẻ Review sau 3 tuần',
        'sub'   => 'Trải nghiệm thực tế',
    ),
    array(
        'video' => '',
        'thumb' => 'https://cdn.hstatic.net/products/200001066686/dau-goi-gung-nghe-may-may-300ml_976748158c9548e5a917d6f1037d2dbe.png',
        'src'   => 'TikTok',
        'title' => 'Chất dầu gội sánh mịn cặn gừng tươi',
        'sub'   => 'Cận cảnh sản phẩm',
    ),
    array(
        'video' => '',
        'thumb' => 'https://cdn.hstatic.net/products/200001066686/sua-tam-gung-nghe-may-may-500ml_8029728340d44067aa56b610e29f48ae.png',
        'src'   => 'Shorts',
        'title' => 'Khử sạch mùi mồ hôi & mờ mụn lưng',
        'sub'   => 'Sữa tắm Gừng Nghệ',
    ),
    array(
        'video' => '',
        'thumb' => 'https://cdn.hstatic.net/products/200001066686/nuoc-u-toc-bang-gung-tuoi-homecare_b083a03618e0411081b79ca35482e003.jpg',
        'src'   => 'Shorts',
        'title' => 'Đóng gói set quà & Hậu trường tại xưởng',
        'sub'   => 'Quy trình sản xuất',
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
      <div class="ltg-shorts-head">
        <div>
          <?php if (lx_has_content($shorts_eyebrow)) : ?>
            <span class="ltg-eyebrow"><?php echo esc_html($shorts_eyebrow); ?></span>
          <?php endif; ?>
          <?php if (lx_has_content($shorts_title)) : ?>
            <h2 class="ltg-h2"><?php echo wp_kses_post($shorts_title); ?></h2>
          <?php endif; ?>
        </div>

        <div class="ltg-social">
          <?php if (lx_has_content($shorts_tiktok)) : ?>
            <a href="<?php echo esc_url($shorts_tiktok); ?>" target="_blank" rel="noopener">
              <svg width="18" height="18"><use href="#i-tt"/></svg>TikTok
            </a>
          <?php endif; ?>
          <?php if (lx_has_content($shorts_youtube)) : ?>
            <a href="<?php echo esc_url($shorts_youtube); ?>" target="_blank" rel="noopener">
              <svg width="18" height="18"><use href="#i-yt"/></svg>YouTube
            </a>
          <?php endif; ?>
        </div>
      </div>

      <?php if (!empty($shorts_items) && is_array($shorts_items)) : 
          $fallback_thumbs = array(
              'https://cdn.hstatic.net/products/200001066686/dau_goi_gung_nghe_may_may_-_dau_goi_cho_me_bau_va_me_sau_sinh_c85c9e18e5f24a9d93a1c3676d8fe1c8.jpg',
              'https://cdn.hstatic.net/products/200001066686/dau-goi-gung-nghe-may-may-300ml_976748158c9548e5a917d6f1037d2dbe.png',
              'https://cdn.hstatic.net/products/200001066686/sua-tam-gung-nghe-may-may-500ml_8029728340d44067aa56b610e29f48ae.png',
              'https://cdn.hstatic.net/products/200001066686/nuoc-u-toc-bang-gung-tuoi-homecare_b083a03618e0411081b79ca35482e003.jpg',
          );
      ?>
      <div class="ltg-srow">
        <?php foreach ($shorts_items as $idx => $sh) :
            if (empty($sh['title'])) continue;
            $v_url = !empty($sh['video']) ? trim($sh['video']) : '';
            $thumb = '';
            if (!empty($sh['thumb'])) {
                if (is_array($sh['thumb']) && !empty($sh['thumb']['url'])) {
                    $thumb = $sh['thumb']['url'];
                } elseif (is_numeric($sh['thumb'])) {
                    $thumb = wp_get_attachment_image_url($sh['thumb'], 'full');
                } elseif (is_string($sh['thumb'])) {
                    $thumb = trim($sh['thumb']);
                }
            }
            
            // If thumb is empty, use dependable high quality product image
            if (empty($thumb)) {
                $thumb = $fallback_thumbs[$idx % count($fallback_thumbs)];
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
              <b><?php echo esc_html($sh['title']); ?></b>
              <?php if (!empty($sh['sub'])) : ?>
                <small><?php echo esc_html($sh['sub']); ?></small>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="ltg-swipe">Vuốt để xem thêm <i></i></div>
      <?php endif; ?>
    </div>
  </section>
