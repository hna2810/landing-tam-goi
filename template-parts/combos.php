<?php
/**
 * Combo Offers Section Template Part
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$combo_title = lx_get_field('combo_title', 'option', "Combo ưu đãi trải nghiệm");

$combo_default_items = array(
    array(
        'key'    => 'trai-nghiem',
        'name'   => 'Gói Trải Nghiệm',
        'desc'   => '1 Dầu gội + 1 Sữa tắm Gừng Nghệ + 1 Ủ tóc (300ML)',
        'price'  => '99K',
        'img'    => get_template_directory_uri() . '/assets/images/real/combo-01-trai-nghiem.jpg',
        'is_hot' => false,
    ),
    array(
        'key'    => 'ban-chay',
        'name'   => 'Gói Best Seller',
        'desc'   => '1 Dầu gội + 1 Sữa tắm Gừng Nghệ + 1 Ủ tóc (500ML)',
        'price'  => '159k',
        'img'    => get_template_directory_uri() . '/assets/images/real/combo-02-ban-chay.jpg',
        'is_hot' => true,
    ),
    array(
        'key'    => 'sieu-tiet-kiem',
        'name'   => 'Gói Tiết Kiệm',
        'desc'   => '1 Dầu gội + 1 Sữa tắm Gừng Nghệ + 1 Ủ tóc (1000ML)',
        'price'  => '299K',
        'img'    => get_template_directory_uri() . '/assets/images/real/combo-03-tiet-kiem.jpg',
        'is_hot' => false,
    ),
);
$combo_items = lx_get_field('combo_items', 'option', $combo_default_items);
if (!is_array($combo_items)) {
    $combo_items = array();
}

$has_combos = lx_has_content($combo_title) || (!empty($combo_items) && is_array($combo_items));
if (!$has_combos) {
    return;
}
?>

  <section class="ltg-sec ltg-pk-sec" id="combo">
    <div class="ltg-wrap">
      <?php if (lx_has_content($combo_title)) : ?>
      <div class="ltg-center">
        <h2 class="ltg-h2 ltg-h2--md"><?php echo esc_html($combo_title); ?></h2>
      </div>
      <?php endif; ?>

      <?php if (!empty($combo_items) && is_array($combo_items)) : ?>
      <div class="ltg-pks">
        <?php foreach ($combo_items as $cb) :
            if (empty($cb['name'])) continue;
            $k   = !empty($cb['key']) ? $cb['key'] : 'trai-nghiem';
            $hot = !empty($cb['is_hot']) ? ' ltg-pk--hot' : '';
            $img = !empty($cb['img']) ? (is_array($cb['img']) ? ($cb['img']['url'] ?? '') : (is_numeric($cb['img']) ? wp_get_attachment_image_url($cb['img'], 'full') : $cb['img'])) : '';
        ?>
          <a href="#dat-hang" class="ltg-pk<?php echo esc_attr($hot); ?>" data-combo="<?php echo esc_attr($k); ?>">
            <?php if (!empty($img)) : ?>
              <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($cb['name']); ?>" loading="lazy">
            <?php endif; ?>
            <h3><?php echo esc_html($cb['name']); ?></h3>
            <?php if (!empty($cb['desc'])) : ?>
              <p><?php echo esc_html($cb['desc']); ?></p>
            <?php endif; ?>
            <?php if (!empty($cb['price'])) : ?>
              <b><?php echo esc_html($cb['price']); ?></b>
            <?php endif; ?>
          </a>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>
  </section>
