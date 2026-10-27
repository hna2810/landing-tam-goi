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
$shorts_items   = lx_get_field('shorts_items', 'option');

if (empty($shorts_items) && !is_array($shorts_items)) {
    $shorts_items = array(
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

      <?php if (!empty($shorts_items) && is_array($shorts_items)) : ?>
      <div class="ltg-srow">
        <?php foreach ($shorts_items as $sh) :
            if (empty($sh['title'])) continue;
            $v_url = !empty($sh['video']) ? $sh['video'] : '';
            $thumb = !empty($sh['thumb']) ? $sh['thumb'] : '';
            $src_lbl = !empty($sh['src']) ? $sh['src'] : 'Video';
        ?>
          <div class="ltg-short" data-video="<?php echo esc_attr($v_url); ?>" data-vertical="1" role="button" tabindex="0">
            <?php if (!empty($thumb)) : ?>
              <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr($sh['title']); ?>" loading="lazy">
            <?php endif; ?>
            <span class="ltg-short-src"><?php echo esc_html($src_lbl); ?></span>
            <span class="ltg-short-play"><svg width="22" height="22"><use href="#i-play"/></svg></span>
            <div class="ltg-short-cap">
              <span class="lx_wow_item"><?php echo esc_html($sh['title']); ?></span>
              <?php if (!empty($sh['sub'])) : ?>
                <small class="lx_wow_item"><?php echo esc_html($sh['sub']); ?></small>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>
  </section>
