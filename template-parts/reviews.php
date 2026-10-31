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

// Hình ảnh hội thảo
$rev_workshop_h   = lx_get_field('rev_workshop_h', 'option', "Hình ảnh hội thảo");
$rev_workshop_sub = lx_get_field('rev_workshop_sub', 'option', "Khoảnh khắc các mẹ bầu &amp; mẹ sau sinh trải nghiệm thực tế bộ đôi Tắm Gội Mây Mây");

$rev_default_workshop = array(
    array('img' => get_template_directory_uri() . '/assets/images/real/workshop-01.jpg'),
    array('img' => get_template_directory_uri() . '/assets/images/real/workshop-02.jpg'),
    array('img' => get_template_directory_uri() . '/assets/images/real/workshop-03.jpg'),
    array('img' => get_template_directory_uri() . '/assets/images/real/workshop-04.jpg'),
);
$rev_workshop_gallery = lx_get_field('rev_workshop_gallery', 'option', $rev_default_workshop);
if (empty($rev_workshop_gallery) || !is_array($rev_workshop_gallery)) {
    $rev_workshop_gallery = $rev_default_workshop;
}

$rev_default_gallery = array(
    array('img' => 'https://cdn.hstatic.net/products/200001066686/feedback-sua-tam-gung-nghe-may-may_70ad2e7919234d7384635a04cef8f022.png'),
    array('img' => 'https://cdn.hstatic.net/products/200001066686/sua-tam-giam-mun-lung-nguc-gung-nghe_e52b32f1bd2b4aa2a3285e9d07e78545.png'),
    array('img' => 'https://cdn.hstatic.net/products/200001066686/doi-tuong-dung-sua-tam-gung-nghe-may-may_9017f7a260ae4d8b83b10308909a7d54.png'),
    array('img' => 'https://cdn.hstatic.net/products/200001066686/thanh-phan-sua-tam-gung-nghe-may-may_6a0a590666174a74b14cc313dbb61bd7.png'),
);
$rev_gallery = lx_get_field('rev_gallery', 'option', $rev_default_gallery);
if (!is_array($rev_gallery)) {
    $rev_gallery = array();
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
      <div class="ltg-center">
        <?php if (lx_has_content($rev_eyebrow)) : ?>
          <span class="ltg-eyebrow"><?php echo esc_html($rev_eyebrow); ?></span>
        <?php endif; ?>
        <?php if (lx_has_content($rev_title)) : ?>
          <h2 class="ltg-h2 ltg-h2--md"><?php echo wp_kses_post($rev_title); ?></h2>
        <?php endif; ?>

        <?php if (lx_has_content($rev_stat_1) || lx_has_content($rev_stat_2)) : ?>
        <div class="ltg-rstats">
          <?php if (lx_has_content($rev_stat_1)) : ?>
            <div><?php echo esc_html($rev_stat_1); ?></div>
          <?php endif; ?>
          <?php if (lx_has_content($rev_stat_2)) : ?>
            <div><?php echo esc_html($rev_stat_2); ?></div>
          <?php endif; ?>
        </div>
        <?php endif; ?>
      </div>

      <!-- Mục: Hình ảnh hội thảo -->
      <?php if (lx_has_content($rev_workshop_h)) : ?>
        <h3 class="ltg-sub-h" style="margin-top:40px"><?php echo esc_html($rev_workshop_h); ?></h3>
      <?php endif; ?>
      <?php if (lx_has_content($rev_workshop_sub)) : ?>
        <p class="ltg-sub-p"><?php echo wp_kses_post($rev_workshop_sub); ?></p>
      <?php endif; ?>

      <?php if (!empty($rev_workshop_gallery) && is_array($rev_workshop_gallery)) : ?>
      <div class="ltg-workshop-shots">
        <?php foreach ($rev_workshop_gallery as $item) :
            $src = '';
            if (is_array($item)) {
                if (!empty($item['img']['url'])) {
                    $src = $item['img']['url'];
                } elseif (!empty($item['img'])) {
                    $raw = $item['img'];
                    $src = is_numeric($raw) ? wp_get_attachment_image_url($raw, 'full') : $raw;
                }
            } elseif (is_string($item)) {
                $src = $item;
            }
            if (empty($src)) continue;
        ?>
          <figure data-img="<?php echo esc_url($src); ?>">
            <img src="<?php echo esc_url($src); ?>" alt="Hình ảnh hội thảo mẹ bầu và sau sinh Home Care" loading="lazy">
          </figure>
        <?php endforeach; ?>
      </div>
      <div class="ltg-swipe">Vuốt để xem thêm <i></i></div>
      <?php endif; ?>

      <h3 class="ltg-sub-h" style="margin-top:48px">Từ Bầu đến Sau sinh tin dùng</h3>

      <div class="ltg-rev-grid">
        <div class="ltg-rcard">
          <div class="ltg-rcard-top"><span class="ltg-ava">L</span><div><b>Mẹ Lan Anh (Hà Nội)</b></div></div>
          <p>“Tóc mình rụng thành từng nắm sau sinh khiến mình vô cùng stress. Dùng bộ đôi này được khoảng 3 tuần thì lượng tóc rụng giảm hẳn lúc chải đầu, tóc con bắt đầu mọc lởm chởm rất mừng. Sữa tắm dùng xong lưng sạch mụn hẳn, da cũng không bị khô rít.”</p>
        </div>
        <div class="ltg-rcard">
          <div class="ltg-rcard-top"><span class="ltg-ava">H</span><div><b>Mẹ Thanh Hằng (Hà Nội)</b></div></div>
          <p>“Da lưng mình bị mụn viêm lâu năm mặc đồ rất tự ti. Chuyển sang dòng sữa tắm này thấy da thông thoáng, mụn xẹp đi nhiều và không còn ngứa ngáy mỗi khi đổ mồ hôi nữa. Dầu gội thì đỉnh khỏi bàn, da đầu sạch gàu cả ngày thích lắm.”</p>
        </div>
        <div class="ltg-rcard">
          <div class="ltg-rcard-top"><span class="ltg-ava">N</span><div><b>Mẹ Bích Ngọc (TP.HCM)</b></div></div>
          <p>“Công việc căng thẳng khiến tóc gãy và dầu nhờn nhiều. Từ ngày đổi sang sản phẩm này, da đầu nhẹ hẳn, tóc bồng bềnh lâu bết hơn trước rất nhiều.”</p>
        </div>
        <div class="ltg-rcard">
          <span class="ltg-sample">MẪU</span>
          <div class="ltg-rcard-top"><span class="ltg-ava">L</span><div><b>Chị L.<span class="ltg-verified"><svg width="12" height="12"><use href="#i-check"/></svg>Đã mua</span></b><small>Giáo viên mầm non</small></div></div>
          <div class="ltg-rstars">★★★★★</div>
          <p>Năm ngoái được phụ huynh tặng set này, dùng thích nên năm nay tự mua thêm cho cả nhà. Hộp quà đẹp, sang.</p>
          <span class="ltg-rprod">Set quà An Nhiên</span>
        </div>
        <div class="ltg-rcard">
          <span class="ltg-sample">MẪU</span>
          <div class="ltg-rcard-top"><span class="ltg-ava">N</span><div><b>Chị N.<span class="ltg-verified"><svg width="12" height="12"><use href="#i-check"/></svg>Đã mua</span></b><small>Tóc uốn nhuộm</small></div></div>
          <div class="ltg-rstars">★★★★★</div>
          <p>Tóc uốn nhuộm khô xơ, gội xong ủ thêm nước gừng tươi thì tóc mềm hơn rõ. Ủ tóc không bắt buộc nhưng nên thử.</p>
          <span class="ltg-rprod">Dầu gội + Nước ủ tóc</span>
        </div>
        <div class="ltg-rcard">
          <span class="ltg-sample">MẪU</span>
          <div class="ltg-rcard-top"><span class="ltg-ava">P</span><div><b>Chị P.<span class="ltg-verified"><svg width="12" height="12"><use href="#i-check"/></svg>Đã mua</span></b><small>Mua cho mẹ</small></div></div>
          <div class="ltg-rstars">★★★★★</div>
          <p>Mua cho mẹ dùng, mẹ khen mùi dễ chịu, gội không khô tóc. Giao hàng nhanh, đóng gói cẩn thận.</p>
          <span class="ltg-rprod">Combo tắm gội</span>
        </div>
      </div>
      <div class="ltg-swipe">Vuốt để xem thêm <i></i></div>

      <h3 class="ltg-sub-h" style="margin-top:40px">Hình ảnh &amp; phản hồi thực tế</h3>
      <p class="ltg-sub-p">Bấm vào ảnh để xem lớn – cảm nhận rõ nét từ khách hàng</p>

      <?php if (!empty($rev_gallery) && is_array($rev_gallery)) : ?>
      <div class="ltg-shots">
        <?php foreach ($rev_gallery as $item) :
            $src = '';
            if (is_array($item)) {
                if (!empty($item['img']['url'])) {
                    $src = $item['img']['url'];
                } elseif (!empty($item['img'])) {
                    $raw = $item['img'];
                    $src = is_numeric($raw) ? wp_get_attachment_image_url($raw, 'full') : $raw;
                }
            } elseif (is_string($item)) {
                $src = $item;
            }
            if (empty($src)) continue;
        ?>
          <figure class="" data-img="<?php echo esc_url($src); ?>">
            <img src="<?php echo esc_url($src); ?>" alt="Hình ảnh phản hồi khách hàng" loading="lazy">
          </figure>
        <?php endforeach; ?>
      </div>
      <div class="ltg-swipe">Vuốt để xem thêm <i></i></div>
      <?php endif; ?>
    </div>
  </section>
