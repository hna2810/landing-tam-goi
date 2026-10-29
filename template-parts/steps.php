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
        'title' => 'Bước 1: Gội đầu:',
        'desc'  => 'Làm ướt tóc bằng nước ấm. Lấy một lượng dầu gội vừa đủ, tạo bọt rồi massage nhẹ nhàng trên da đầu từ 3-5 phút. Xả sạch lại với nước để loại bỏ hoàn toàn bọt bám.',
    ),
    array(
        'icon'  => 'i-leaf',
        'title' => 'Bước 2: Tắm sạch body:',
        'desc'  => 'Làm ướt cơ thể, lấy lượng sữa tắm ra lòng bàn tay hoặc bông tắm. Massage kỹ các vùng da dễ tích tụ mồ hôi và mụn như lưng, ngực, cánh tay trong 2 phút.',
    ),
    array(
        'icon'  => 'i-heart',
        'title' => 'Bước 3: Xả sạch:',
        'desc'  => 'Tắm lại bằng nước sạch, dùng khăn mềm lau khô nhẹ nhàng để cảm nhận làn da mịn màng và mái tóc bồng bềnh.',
    ),
    array(
        'icon'  => 'i-root',
        'title' => 'Ủ phục hồi <small style="font-family:var(--sans);font-size:12px;color:var(--ginger)">(tuỳ chọn)</small>',
        'desc'  => 'Tóc khô xơ: thoa nước ủ gừng tươi sau gội, ủ 10–15 phút rồi xả.',
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

  <section class="ltg-has-deco ltg-sec" id="cach-dung" style="background:linear-gradient(180deg,#eef1e4 0%,#f6f7ee 60%,#fffcf3 100%)">
    <div class="ltg-deco" aria-hidden="true">
      <span class="ltg-sp im-nl" style="right:5%;top:46px;width:150px;height:66px;--r:8deg;animation-delay:0s;animation-duration:11s"></span>
      <span class="ltg-sp im-gc dk" style="left:3%;top:60px;width:190px;height:135px;--r:-6deg;animation-delay:-4s;animation-duration:13s"></span>
    </div>

    <div class="ltg-wrap">
      <div class="ltg-center ltg-rv">
        <?php if (lx_has_content($steps_eyebrow)) : ?>
          <span class="ltg-eyebrow"><?php echo esc_html($steps_eyebrow); ?></span>
        <?php endif; ?>
        <?php if (lx_has_content($steps_title)) : ?>
          <h2 class="ltg-h2 ltg-h2--md"><?php echo wp_kses_post($steps_title); ?></h2>
        <?php endif; ?>
      </div>

      <?php if (!empty($steps_items) && is_array($steps_items)) : ?>
      <div class="ltg-steps ltg-steps--ic">
        <?php 
        $default_step_icons = array('i-drop', 'i-leaf', 'i-heart', 'i-root');
        foreach ($steps_items as $idx => $item) :
            if (empty($item['title'])) continue;
            $raw_icon = !empty($item['icon']) ? trim($item['icon']) : '';
            $icon = 'i-drop';
            if (!empty($raw_icon)) {
                $clean = ltrim($raw_icon, '#');
                if (in_array($clean, array('i-drop', 'i-leaf', 'i-heart', 'i-root', 'i-stp1', 'i-stp2', 'i-stp3', 'i-stp4', 'i-shield', 'i-gift', 'i-star', 'i-citrus', 'i-users', 'i-phone', 'i-truck'))) {
                    $icon = $clean;
                } elseif (strpos($clean, '1') !== false || strpos($clean, 'drop') !== false) {
                    $icon = 'i-drop';
                } elseif (strpos($clean, '2') !== false || strpos($clean, 'leaf') !== false) {
                    $icon = 'i-leaf';
                } elseif (strpos($clean, '3') !== false || strpos($clean, 'heart') !== false) {
                    $icon = 'i-heart';
                } elseif (strpos($clean, '4') !== false || strpos($clean, 'root') !== false) {
                    $icon = 'i-root';
                } else {
                    $icon = $clean;
                }
            } else {
                $icon = $default_step_icons[$idx % count($default_step_icons)];
            }
        ?>
          <div class="ltg-step ltg-rv">
            <i class="ltg-step-ic"><svg width="26" height="26"><use href="#<?php echo esc_attr($icon); ?>"/></svg></i>
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
