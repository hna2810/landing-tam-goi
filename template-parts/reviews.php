<?php
/**
 * Customer Reviews and Feedback Gallery Section Template Part
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$rev_eyebrow = lx_get_field('rev_eyebrow', 'option', "Khách hàng nói gì");
$rev_title   = lx_get_field('rev_title', 'option', "Thư viện hàng ngàn feedback chân thực");
$rev_stat_1  = lx_get_field('rev_stat_1', 'option', "⭐⭐⭐⭐⭐ 4.9/5 sao dựa trên hơn 2.500+ đánh giá thực tế.");
$rev_stat_2  = lx_get_field('rev_stat_2', 'option', "📊 98% đánh giá phản hồi tóc bớt gãy rụng, kích thích mọc tóc và giảm thâm mụn lưng");
$rev_gallery = lx_get_field('rev_gallery', 'option');

if (empty($rev_gallery) && !is_array($rev_gallery)) {
    $rev_gallery = array(
        array('img' => 'https://cdn.hstatic.net/products/200001066686/feedback-sua-tam-gung-nghe-may-may_70ad2e7919234d7384635a04cef8f022.png'),
        array('img' => 'https://cdn.hstatic.net/products/200001066686/sua-tam-giam-mun-lung-nguc-gung-nghe_e52b32f1bd2b4aa2a3285e9d07e78545.png'),
        array('img' => 'https://cdn.hstatic.net/products/200001066686/doi-tuong-dung-sua-tam-gung-nghe-may-may_9017f7a260ae4d8b83b10308909a7d54.png'),
        array('img' => 'https://cdn.hstatic.net/products/200001066686/thanh-phan-sua-tam-gung-nghe-may-may_6a0a590666174a74b14cc313dbb61bd7.png'),
    );
}

$has_rev = lx_has_content($rev_title) || (!empty($rev_gallery) && is_array($rev_gallery));
if (!$has_rev) {
    return;
}
?>

  <section class="ltg-has-deco ltg-sec ltg-rev" id="review">
    <div class="ltg-deco" aria-hidden="true">
      <span class="ltg-sp im-nb dk edge" style="right:0;top:50px;width:190px;height:163px;--r:0deg;animation-delay:-2s;animation-duration:12s"></span>
      <span class="ltg-sp im-gc dk" style="left:3%;top:40px;width:170px;height:121px;--r:-10deg;animation-delay:-5s;animation-duration:13s"></span>
    </div>

    <div class="ltg-wrap">
      <div class="ltg-center ltg-rv">
        <?php if (lx_has_content($rev_eyebrow)) : ?>
          <span class="ltg-eyebrow lx_wow_item"><?php echo esc_html($rev_eyebrow); ?></span>
        <?php endif; ?>
        <?php if (lx_has_content($rev_title)) : ?>
          <h2 class="ltg-h2 ltg-h2--md lx_wow_item"><?php echo wp_kses_post($rev_title); ?></h2>
        <?php endif; ?>

        <?php if (lx_has_content($rev_stat_1) || lx_has_content($rev_stat_2)) : ?>
        <div class="ltg-rstats">
          <?php if (lx_has_content($rev_stat_1)) : ?>
            <div class="lx_wow_item"><?php echo esc_html($rev_stat_1); ?></div>
          <?php endif; ?>
          <?php if (lx_has_content($rev_stat_2)) : ?>
            <div class="lx_wow_item"><?php echo esc_html($rev_stat_2); ?></div>
          <?php endif; ?>
        </div>
        <?php endif; ?>
      </div>

      <?php if (!empty($rev_gallery) && is_array($rev_gallery)) : ?>
      <div class="ltg-shots">
        <?php foreach ($rev_gallery as $item) :
            $src = '';
            if (is_array($item)) {
                $src = !empty($item['img']['url']) ? $item['img']['url'] : ($item['img'] ?? '');
            } elseif (is_string($item)) {
                $src = $item;
            }
            if (empty($src)) continue;
        ?>
          <figure class="ltg-rv" data-img="<?php echo esc_url($src); ?>">
            <img src="<?php echo esc_url($src); ?>" alt="Hình ảnh phản hồi khách hàng" loading="lazy">
          </figure>
        <?php endforeach; ?>
      </div>
      <div class="ltg-swipe">Vuốt để xem thêm <i></i></div>
      <?php endif; ?>
    </div>
  </section>
