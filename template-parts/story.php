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

  <!-- MARQUEE -->
  <div class="ltg-mq" aria-hidden="true">
    <div class="ltg-mq-track">
      <img src="https://cdn.hstatic.net/products/200001066686/sua-tam-gung-nghe-may-may-500ml_8029728340d44067aa56b610e29f48ae.png" alt="" loading="lazy">
      <img src="https://cdn.hstatic.net/products/200001066686/nguyen-lieu-gung-nghe_aa75eb4c00f54ed7bda0abe067db2800.jpg" alt="" loading="lazy">
      <div class="ltg-mq-word">Sạch dịu<br>từ thiên nhiên</div>
      <img src="https://cdn.hstatic.net/products/200001066686/ch_t_d_u_g_i_g_ng_ngh__m_y_m_y_homecare_98cc876517dc4d9bbb42e1528e91dc58.png" alt="" loading="lazy">
      <img src="https://cdn.hstatic.net/products/200001066686/dau-goi-gung-nghe-may-may-300ml_976748158c9548e5a917d6f1037d2dbe.png" alt="" loading="lazy">
      <div class="ltg-mq-word">Gừng · Nghệ<br>· Bưởi</div>
      <img src="https://cdn.hstatic.net/products/200001066686/nuoc-u-toc-gung-tuoi_e093b2883b2040ccb50e8e7eff9a5f4b.png" alt="" loading="lazy">
      <img src="https://cdn.hstatic.net/products/200001066686/combo-sua-tam-dau-goi-gung-nghe-may-may_37c9f5a7dbe9474d82a53a57c114c033.png" alt="" loading="lazy">
      <div class="ltg-mq-word">Lành cho<br>mẹ bầu</div>
      <img src="https://cdn.hstatic.net/products/200001066686/sua-tam-gung-nghe-may-may-500ml_8029728340d44067aa56b610e29f48ae.png" alt="" loading="lazy">
      <img src="https://cdn.hstatic.net/products/200001066686/nguyen-lieu-gung-nghe_aa75eb4c00f54ed7bda0abe067db2800.jpg" alt="" loading="lazy">
      <div class="ltg-mq-word">Sạch dịu<br>từ thiên nhiên</div>
      <img src="https://cdn.hstatic.net/products/200001066686/ch_t_d_u_g_i_g_ng_ngh__m_y_m_y_homecare_98cc876517dc4d9bbb42e1528e91dc58.png" alt="" loading="lazy">
      <img src="https://cdn.hstatic.net/products/200001066686/dau-goi-gung-nghe-may-may-300ml_976748158c9548e5a917d6f1037d2dbe.png" alt="" loading="lazy">
      <div class="ltg-mq-word">Gừng · Nghệ<br>· Bưởi</div>
      <img src="https://cdn.hstatic.net/products/200001066686/nuoc-u-toc-gung-tuoi_e093b2883b2040ccb50e8e7eff9a5f4b.png" alt="" loading="lazy">
      <img src="https://cdn.hstatic.net/products/200001066686/combo-sua-tam-dau-goi-gung-nghe-may-may_37c9f5a7dbe9474d82a53a57c114c033.png" alt="" loading="lazy">
      <div class="ltg-mq-word">Lành cho<br>mẹ bầu</div>
    </div>
  </div>

<?php endif; ?>
