<?php
/**
 * The header for our theme
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <?php wp_head(); ?>
</head>
<body <?php body_class('lx_landing_theme'); ?>>
<?php wp_body_open(); ?>

<?php get_template_part('template-parts/svg-sprite'); ?>

<div class="ltg">
  <div class="ltg-prog" id="ltgProg"></div>

  <?php
  $topbar_text = lx_get_field('topbar_text', 'option', '🚚 <b>FREESHIP TOÀN QUỐC</b> · Ưu đãi kết thúc sau');
  if (lx_has_content($topbar_text)) :
  ?>
  <div class="ltg-top">
    <?php echo wp_kses_post($topbar_text); ?>
    <span class="ltg-tc" id="ltgTop">--:--:--</span>
  </div>
  <?php endif; ?>

  <nav class="ltg-nav">
    <div class="ltg-wrap">
      <?php
      $logo_img  = lx_get_image_url('header_logo_img', '', 'full', 'option');
      $logo_text = lx_get_field('header_logo_text', 'option', 'Home Care');
      $logo_sub  = lx_get_field('header_logo_sub', 'option', 'SINCE 2008 · MÂY MÂY');
      ?>
      <a href="<?php echo esc_url(home_url('/')); ?>" class="ltg-logo">
        <?php if (!empty($logo_img)) : ?>
          <img src="<?php echo esc_url($logo_img); ?>" alt="<?php echo esc_attr($logo_text); ?>" style="max-height:42px;width:auto;">
        <?php else : ?>
          <?php if (lx_has_content($logo_text)) : ?>
            <?php echo esc_html($logo_text); ?>
          <?php endif; ?>
          <?php if (lx_has_content($logo_sub)) : ?>
            <small><?php echo esc_html($logo_sub); ?></small>
          <?php endif; ?>
        <?php endif; ?>
      </a>

      <?php
      $menu_default = array(
          array('label' => 'Sản phẩm', 'link' => '#san-pham'),
          array('label' => 'Quy trình', 'link' => '#quy-trinh'),
          array('label' => 'Review', 'link' => '#review'),
          array('label' => 'Quà 20/11', 'link' => '#qua-20-11'),
          array('label' => 'Hỏi đáp', 'link' => '#hoi-dap'),
      );
      $menu_items = lx_get_field('header_menu', 'option', $menu_default);
      if (!is_array($menu_items)) {
          $menu_items = array();
      }
      if (!empty($menu_items)) :
      ?>
      <div class="ltg-menu">
        <?php foreach ($menu_items as $item) :
            if (empty($item['label'])) continue;
            $link = !empty($item['link']) ? $item['link'] : '#';
        ?>
          <a href="<?php echo esc_url($link); ?>"><?php echo esc_html($item['label']); ?></a>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>

      <?php
      $cta_text = lx_get_field('header_cta_text', 'option', 'Đặt hàng ngay');
      $cta_link = lx_get_field('header_cta_link', 'option', '#dat-hang');
      if (lx_has_content($cta_text)) :
      ?>
      <a href="<?php echo esc_url($cta_link); ?>" class="ltg-btn ltg-btn--pri">
        <?php echo esc_html($cta_text); ?>
      </a>
      <?php endif; ?>
    </div>
  </nav>
