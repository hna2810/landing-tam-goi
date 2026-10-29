<?php
/**
 * Hero Section Template Part
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$hero_title            = lx_get_field('hero_title', 'option', "Tóc mọc tua tủa,<br>da sạch mịn màng");
$hero_subtitle         = lx_get_field('hero_subtitle', 'option', "Bộ đôi Sữa tắm & Dầu gội Gừng Nghệ Mây Mây");
$hero_benefits         = lx_get_field('hero_benefits', 'option', array(
    array('text' => 'Giảm rụng, kích mọc tóc'),
    array('text' => 'Sạch gàu, hết ngứa'),
    array('text' => 'Hỗ trợ mờ mụn lưng'),
    array('text' => 'Dùng được cho mẹ bầu & mẹ sau sinh'),
));
$hero_callout          = lx_get_field('hero_callout', 'option', "👉 Được sử dụng trong dịch vụ chăm sóc bầu, sau sinh của Home Care trên khắp 3 miền Bắc - Trung - Nam");
$hero_price_label      = lx_get_field('hero_price_label', 'option', "Combo dầu gội + sữa tắm");
$hero_price            = lx_get_field('hero_price', 'option', "399.000đ");
$hero_price_note       = lx_get_field('hero_price_note', 'option', "Freeship toàn quốc");
$hero_price_tag        = lx_get_field('hero_price_tag', 'option', "FREE<br>SHIP");
$hero_cta_pri_text     = lx_get_field('hero_cta_primary_text', 'option', "FREESHIP TOÀN QUỐC - MUA NGAY!");
$hero_cta_pri_link     = lx_get_field('hero_cta_primary_link', 'option', "#dat-hang");
$hero_cta_sec_text     = lx_get_field('hero_cta_secondary_text', 'option', "Set quà 20/11");
$hero_cta_sec_link     = lx_get_field('hero_cta_secondary_link', 'option', "#qua-20-11");
$hero_image            = lx_get_image_url('hero_image', 'https://cdn.hstatic.net/products/200001066686/combo-sua-tam-dau-goi-gung-nghe-may-may_37c9f5a7dbe9474d82a53a57c114c033.png', 'full', 'option');
$hero_trust_items      = lx_get_field('hero_trust_items', 'option', array(
    array('icon' => 'i-hosp', 'text' => 'Có mặt tại nhà thuốc, bệnh viện, phòng khám'),
    array('icon' => 'i-bar', 'text' => 'Có trên hệ thống Mã số Mã vạch Quốc gia'),
    array('icon' => 'i-shield', 'text' => 'Tem chống hàng giả Bộ Công An'),
    array('icon' => 'i-pen', 'text' => 'Đã công bố mỹ phẩm – Sở Y tế cấp số'),
));

$has_hero = lx_has_content($hero_title) || !empty($hero_image);
if (!$has_hero) {
    return;
}
?>

  <header class="ltg-hero">
    <div class="ltg-deco" aria-hidden="true" id="ltgDeco">
      <span class="ltg-blob ltg-blob--1"></span>
      <span class="ltg-blob ltg-blob--2"></span>
      <span class="ltg-lf b2" style="left:-150px;top:-170px;opacity:.45;width:210px;height:298px;--r:140deg;animation-delay:0s;animation-duration:13s"><svg><use href="#i-lf2"/></svg></span>
      <span class="ltg-lf" style="right:1.5%;top:70px;width:66px;height:220px;--r:32deg;animation-delay:-3s;animation-duration:10s"><svg><use href="#i-lf1"/></svg></span>
      <span class="ltg-lf b1" style="left:-40px;bottom:60px;width:140px;height:268px;--r:28deg;animation-delay:-5s;animation-duration:12s"><svg><use href="#i-lf3"/></svg></span>
      <span class="ltg-lf dk" style="right:7%;bottom:110px;width:104px;height:147px;--r:-38deg;animation-delay:-2s;animation-duration:9s"><svg><use href="#i-lf2"/></svg></span>
    </div>

    <div class="ltg-wrap">
      <div class="ltg-rv">
        <?php if (lx_has_content($hero_title)) : ?>
          <h1 class="lx_wow_item"><?php echo wp_kses_post($hero_title); ?></h1>
        <?php endif; ?>

        <?php if (lx_has_content($hero_subtitle)) : ?>
          <p class="ltg-sub lx_wow_item"><?php echo wp_kses_post($hero_subtitle); ?></p>
        <?php endif; ?>

        <?php if (!empty($hero_benefits) && is_array($hero_benefits)) : ?>
          <div class="ltg-benefits">
            <?php foreach ($hero_benefits as $b) :
                if (empty($b['text'])) continue;
            ?>
              <div class="lx_wow_item">
                <i><svg width="14" height="14"><use href="#i-check"/></svg></i>
                <?php echo esc_html($b['text']); ?>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <?php if (lx_has_content($hero_callout)) : ?>
          <p class="ltg-used lx_wow_item"><?php echo wp_kses_post($hero_callout); ?></p>
        <?php endif; ?>

        <?php if (lx_has_content($hero_price)) : ?>
        <div class="ltg-pricebox">
          <div class="ltg-rv ltg-z">
            <?php if (lx_has_content($hero_price_label)) : ?>
              <span><?php echo esc_html($hero_price_label); ?></span>
            <?php endif; ?>
            <b class="lx_wow_item"><?php echo esc_html($hero_price); ?></b>
            <?php if (lx_has_content($hero_price_note)) : ?>
              <small><?php echo esc_html($hero_price_note); ?></small>
            <?php endif; ?>
          </div>
          <?php if (lx_has_content($hero_price_tag)) : ?>
          <div class="ltg-tag ltg-rv ltg-z">
            <span class="lx_wow_item"><?php echo wp_kses_post($hero_price_tag); ?></span>
          </div>
          <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if (lx_has_content($hero_cta_pri_text) || lx_has_content($hero_cta_sec_text)) : ?>
        <div class="ltg-hero-btns">
          <?php if (lx_has_content($hero_cta_pri_text)) : ?>
            <a href="<?php echo esc_url($hero_cta_pri_link ?: '#dat-hang'); ?>" class="ltg-btn ltg-btn--pri lx_wow_item">
              <?php echo esc_html($hero_cta_pri_text); ?>
            </a>
          <?php endif; ?>
          <?php if (lx_has_content($hero_cta_sec_text)) : ?>
            <a href="<?php echo esc_url($hero_cta_sec_link ?: '#qua-20-11'); ?>" class="ltg-btn ltg-btn--sec lx_wow_item">
              <?php echo esc_html($hero_cta_sec_text); ?>
            </a>
          <?php endif; ?>
        </div>
        <?php endif; ?>
      </div>

      <?php if (!empty($hero_image)) : ?>
      <div class="ltg-hero-img ltg-rv">
        <div class="ltg-main">
          <img src="<?php echo esc_url($hero_image); ?>" alt="<?php echo esc_attr(strip_tags($hero_title)); ?>">
        </div>
      </div>
      <?php endif; ?>
    </div>

    <?php if (!empty($hero_trust_items) && is_array($hero_trust_items)) : ?>
    <div class="ltg-trust">
      <div class="ltg-wrap">
        <?php foreach ($hero_trust_items as $t) :
            if (empty($t['text'])) continue;
            $icon = !empty($t['icon']) ? $t['icon'] : 'i-shield';
        ?>
          <div class="lx_wow_item">
            <i><svg width="20" height="20"><use href="#<?php echo esc_attr($icon); ?>"/></svg></i>
            <?php echo esc_html($t['text']); ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>
  </header>
