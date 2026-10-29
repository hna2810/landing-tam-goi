<?php
/**
 * Story and Marquee Section Template Part
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$story_eyebrow = lx_get_field('story_eyebrow', 'option', "Câu chuyện Mây Mây");
$story_title   = lx_get_field('story_title', 'option', "Từ tinh hoa cỏ cây Việt<br>đến từng giọt gội");
$story_quote   = lx_get_field('story_quote', 'option', "“Mẹ bầu, mẹ sau sinh xứng đáng được chăm sóc bằng những gì dịu lành nhất – như cách bà, mẹ ta vẫn đun nồi nước gừng, nước bưởi ngày xưa.”");
$story_lead    = lx_get_field('story_lead', 'option', "Hơn 15 năm đồng hành cùng mẹ và bé, Home Care chọn gừng, nghệ, bưởi – những thảo dược quen thuộc của người Việt – để làm nên bộ tắm gội Mây Mây: sạch dịu, an tâm cho cả gia đình.");
$story_img_1   = lx_get_image_url('story_img_1', 'https://cdn.hstatic.net/products/200001066686/nuoc-u-toc-tu-gung_39ddc7514164454692cfd14d198b8458.jpg', 'full', 'option');
$story_img_2   = lx_get_image_url('story_img_2', 'https://cdn.hstatic.net/products/200001066686/nuoc-u-toc-bang-gung-tuoi-homecare_b083a03618e0411081b79ca35482e003.jpg', 'full', 'option');
$story_stats   = lx_get_field('story_stats', 'option', array(
    array('num' => '2008', 'suffix' => '', 'text' => 'Thành lập Home Care'),
    array('num' => '3', 'suffix' => '', 'text' => 'Dung tích linh hoạt'),
    array('num' => '100', 'suffix' => '%', 'text' => 'Tem chính hãng'),
));

$has_story = lx_has_content($story_title) || !empty($story_img_1);
if ($has_story) :
?>

  <section class="ltg-sec ltg-story">
    <div class="ltg-wrap">
      <?php if (!empty($story_img_1) || !empty($story_img_2)) : ?>
      <div class="ltg-story-imgs ltg-rv">
        <?php if (!empty($story_img_1)) : ?>
          <div class="a"><img src="<?php echo esc_url($story_img_1); ?>" alt="Home Care chăm sóc từ tinh hoa cỏ cây Việt" loading="lazy"></div>
        <?php endif; ?>
        <?php if (!empty($story_img_2)) : ?>
          <div class="b"><img src="<?php echo esc_url($story_img_2); ?>" alt="Thảo dược tươi" loading="lazy"></div>
        <?php endif; ?>
      </div>
      <?php endif; ?>

      <div class="ltg-rv">
        <?php if (lx_has_content($story_eyebrow)) : ?>
          <span class="ltg-eyebrow lx_wow_item"><?php echo esc_html($story_eyebrow); ?></span>
        <?php endif; ?>

        <?php if (lx_has_content($story_title)) : ?>
          <h2 class="ltg-h2 lx_wow_item"><?php echo wp_kses_post($story_title); ?></h2>
        <?php endif; ?>

        <?php if (lx_has_content($story_quote)) : ?>
          <p class="ltg-quote lx_wow_item"><?php echo esc_html($story_quote); ?></p>
        <?php endif; ?>

        <?php if (lx_has_content($story_lead)) : ?>
          <p class="ltg-lead lx_wow_item"><?php echo esc_html($story_lead); ?></p>
        <?php endif; ?>

        <?php if (!empty($story_stats) && is_array($story_stats)) : ?>
        <div class="ltg-stats">
          <?php foreach ($story_stats as $stat) :
              if (empty($stat['num'])) continue;
          ?>
            <div class="ltg-stat lx_wow_item">
              <span class="ltg-stat-n" data-count="<?php echo esc_attr($stat['num']); ?>" data-suffix="<?php echo esc_attr($stat['suffix'] ?? ''); ?>">0<?php echo esc_attr($stat['suffix'] ?? ''); ?></span>
              <span class="ltg-stat-l"><?php echo esc_html($stat['text'] ?? ''); ?></span>
            </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- Dải chữ chạy (Marquee) -->
  <div class="ltg-tband" aria-hidden="true">
    <div class="ltg-tband-track">
      <span>TÓC MỌC TUA TỦA</span><i>✦</i>
      <span class="o">DA SẠCH MỊN MÀNG</span><i>✦</i>
      <span>KHÔNG PARABEN</span><i>✦</i>
      <span class="o">THẢO MỘC VIỆT</span><i>✦</i>
      <span>AN TÂM CHO MẸ BẦU</span><i>✦</i>
      <span class="o">TẮM GỘI MÂY MÂY</span><i>✦</i>
      <span>TÓC MỌC TUA TỦA</span><i>✦</i>
      <span class="o">DA SẠCH MỊN MÀNG</span><i>✦</i>
      <span>KHÔNG PARABEN</span><i>✦</i>
      <span class="o">THẢO MỘC VIỆT</span><i>✦</i>
      <span>AN TÂM CHO MẸ BẦU</span><i>✦</i>
      <span class="o">TẮM GỘI MÂY MÂY</span><i>✦</i>
    </div>
  </div>

<?php endif; ?>
