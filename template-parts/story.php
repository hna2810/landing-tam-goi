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
$story_img_1   = lx_get_image_url('story_img_1', get_template_directory_uri() . '/assets/images/real/story-main.jpg', 'full', 'option');
$story_img_2   = lx_get_image_url('story_img_2', get_template_directory_uri() . '/assets/images/real/story-sub.jpg', 'full', 'option');
if (empty($story_img_1) || strpos($story_img_1, 'nuoc-u-toc') !== false || strpos($story_img_1, 'hstatic.net') !== false) {
    $story_img_1 = get_template_directory_uri() . '/assets/images/real/story-main.jpg';
}
if (empty($story_img_2) || strpos($story_img_2, 'hstatic.net') !== false) {
    $story_img_2 = get_template_directory_uri() . '/assets/images/real/story-sub.jpg';
}
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
      <?php if (!empty($story_img_1)) : ?>
      <div class="ltg-story-imgs">
        <div class="a"><img src="<?php echo esc_url($story_img_1); ?>" alt="Home Care chăm sóc từ tinh hoa cỏ cây Việt" loading="lazy"></div>
      </div>
      <?php endif; ?>

      <div class="">
        <?php if (lx_has_content($story_eyebrow)) : ?>
          <span class="ltg-eyebrow"><?php echo esc_html($story_eyebrow); ?></span>
        <?php endif; ?>

        <?php if (lx_has_content($story_title)) : ?>
          <h2 class="ltg-h2"><?php echo wp_kses_post($story_title); ?></h2>
        <?php endif; ?>

        <?php if (lx_has_content($story_quote)) : ?>
          <p class="ltg-story-q"><?php echo esc_html($story_quote); ?></p>
        <?php endif; ?>

        <?php if (lx_has_content($story_lead)) : ?>
          <p class="ltg-lead" style="margin-top:0"><?php echo esc_html($story_lead); ?></p>
        <?php endif; ?>

        <?php if (!empty($story_stats) && is_array($story_stats)) : ?>
        <div class="ltg-stats">
          <?php foreach ($story_stats as $stat) :
              if (empty($stat['num'])) continue;
          ?>
            <div>
              <b data-count="<?php echo esc_attr($stat['num']); ?>"<?php echo !empty($stat['suffix']) ? ' data-suffix="' . esc_attr($stat['suffix']) . '"' : ''; ?>><?php echo esc_html($stat['num']); ?><?php echo esc_html($stat['suffix'] ?? ''); ?></b>
              <?php echo esc_html($stat['text'] ?? ''); ?>
            </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </section>
<?php endif; ?>
