<?php
/**
 * 3 Steps / How To Use Section Template Part
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$steps_eyebrow = lx_get_field('steps_eyebrow', 'option', "Cách dùng");
$steps_title   = lx_get_field('steps_title', 'option', "3 Bước để tóc sạch, da thơm mỗi ngày cùng bộ đôi Tắm Gội Gừng Nghệ");

$steps_default_items = array(
    array(
        'icon'  => 'i-drop',
        'title' => 'Bước 1: Làm ướt & tạo bọt',
        'desc'  => 'Làm ướt tóc và cơ thể bằng nước ấm. Lấy lượng vừa đủ dầu gội/sữa tắm thoa đều để tạo bọt mịn.',
    ),
    array(
        'icon'  => 'i-leaf',
        'title' => 'Bước 2: Massage thư giãn',
        'desc'  => 'Dùng đầu ngón tay massage nhẹ nhàng da đầu 2–3 phút và kỳ cọ nhẹ khắp cơ thể để dưỡng chất thẩm thấu.',
    ),
    array(
        'icon'  => 'i-heart',
        'title' => 'Bước 3: Xả sạch với nước',
        'desc'  => 'Xả sạch với nước ấm. Tận hưởng cảm giác da đầu thông thoáng nhẹ bẫng và làn da cơ thể sạch thơm mát.',
    ),
);
$steps_items = lx_get_field('steps_items', 'option', $steps_default_items);
if (!is_array($steps_items)) {
    $steps_items = array();
}

$has_steps = lx_has_content($steps_title) || (!empty($steps_items) && is_array($steps_items));
if (!$has_steps) {
    return;
}
?>

  <section class="ltg-has-deco ltg-sec ltg-steps-sec" id="cach-dung" style="background:linear-gradient(180deg,#eef1e4 0%,#f6f7ee 60%,#fffcf3 100%)">
    <div class="ltg-deco" aria-hidden="true">
      <span class="ltg-sp im-nl" style="right:5%;top:46px;width:150px;height:66px;--r:8deg;animation-delay:0s;animation-duration:11s"></span>
      <span class="ltg-sp im-gc dk" style="left:3%;top:60px;width:190px;height:135px;--r:-6deg;animation-delay:-4s;animation-duration:13s"></span>
    </div>

    <div class="ltg-wrap">
      <div class="ltg-center">
        <?php if (lx_has_content($steps_eyebrow)) : ?>
          <span class="ltg-eyebrow"><?php echo esc_html($steps_eyebrow); ?></span>
        <?php endif; ?>
        <?php if (lx_has_content($steps_title)) : ?>
          <h2 class="ltg-h2 ltg-h2--md"><?php echo wp_kses_post($steps_title); ?></h2>
        <?php endif; ?>
      </div>

      <?php if (!empty($steps_items) && is_array($steps_items)) : ?>
      <div class="ltg-steps ltg-steps--ic ltg-steps--center">
        <?php 
        foreach ($steps_items as $idx => $item) :
            if (empty($item['title'])) continue;
            $step_num = $idx + 1;
        ?>
          <div class="ltg-step ltg-step--center">
            <i class="ltg-step-ic" aria-hidden="true">
              <?php
              if ($step_num === 1) {
                  // Step 1: Làm ướt & tạo bọt
                  echo '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/><path d="M12 11a2.5 2.5 0 0 0-2.5 2.5"/></svg>';
              } elseif ($step_num === 2) {
                  // Step 2: Massage thư giãn
                  echo '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6"/></svg>';
              } elseif ($step_num === 3) {
                  // Step 3: Xả sạch với nước
                  echo '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/><path d="M12 3v2M12 19v2M3 12h2M19 12h2"/></svg>';
              } else {
                  echo '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3"/></svg>';
              }
              ?>
            </i>
            <h4><?php echo wp_kses_post($item['title']); ?></h4>
            <?php if (!empty($item['desc'])) : ?>
              <p><?php echo esc_html($item['desc']); ?></p>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="ltg-swipe">Vuốt để xem thêm <i></i></div>
      <?php endif; ?>
    </div>
  </section>
