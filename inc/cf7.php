<?php
/**
 * Contact Form 7 Integration for Tắm Gội Gừng Nghệ Landing Theme
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

// Disable automatic <p> and <br> wrapping in Contact Form 7
add_filter('wpcf7_autop_or_not', '__return_false');

/**
 * Ensure default Contact Form 7 exists and is properly configured
 *
 * @return int|false Form ID or false
 */
function lx_ensure_cf7_form() {
    if (!class_exists('WPCF7_ContactForm')) {
        return false;
    }

    $form_title = 'Đặt Hàng Tắm Gội Gừng Nghệ';

    $form_content = '<div id="ltgFormBody">' . "\n"
        . '<div class="ltg-fields ltg-fields--lb">' . "\n"
        . '  <label>' . "\n"
        . '    <span>Họ và tên:</span>' . "\n"
        . '    [text* your-name class:input placeholder "Ví dụ: Nguyễn Thị Mai"]' . "\n"
        . '  </label>' . "\n"
        . '  <label>' . "\n"
        . '    <span>Số điện thoại:</span>' . "\n"
        . '    [tel* your-phone class:input placeholder "Ví dụ: 0912 345 678"]' . "\n"
        . '  </label>' . "\n"
        . '  <label>' . "\n"
        . '    <span>Địa chỉ nhận hàng:</span>' . "\n"
        . '    [text* your-address class:input placeholder "Số nhà, ngõ/ngách, đường, phường/xã..."]' . "\n"
        . '  </label>' . "\n"
        . '</div>' . "\n"
        . '<div class="ltg-combo-pick" id="ltgCombo">' . "\n"
        . '  <span class="ltg-flabel">Chọn combo:</span>' . "\n"
        . '  [radio combo use_label_element default:1 "&#91;CÓ QUÀ&#93; Bộ đôi Gội + Tắm 500ml – 169.000đ (tặng xịt khử mùi Gừng Cam 30ml)" "Bộ đôi Gội + Tắm 300ml – 79.000đ"]' . "\n"
        . '</div>' . "\n"
        . '<a class="ltg-nc-20link" href="https://trianthayco.homecarevietnam.com/#combo-qua" target="_blank" rel="noopener">🎁 Mua làm quà 20/11 tặng thầy cô? <b>Xem 3 combo quà →</b></a>' . "\n"
        . '<div class="ltg-fcd">' . "\n"
        . '  <b>ƯU ĐÃI SẮP KẾT THÚC</b>' . "\n"
        . '  <div class="ltg-fcd-t" id="ltgFormCd">' . "\n"
        . '    <div><b data-m>14</b><small>Phút</small></div>' . "\n"
        . '    <div><b data-s>59</b><small>Giây</small></div>' . "\n"
        . '  </div>' . "\n"
        . '</div>' . "\n"
        . '[submit class:ltg-btn class:ltg-btn--pri class:ltg-pulse "ĐẶT HÀNG NGAY - NHẬN ƯU ĐÃI!"]' . "\n"
        . '<p class="ltg-secure">' . "\n"
        . '  🔒 Thanh toán khi nhận hàng · Thông tin của bạn được bảo mật' . "\n"
        . '</p>' . "\n"
        . '</div>' . "\n"
        . '<div class="ltg-ok" id="ltgOk" style="display:none">' . "\n"
        . '  <div style="width:72px;height:72px;border-radius:50%;background:var(--butter);display:grid;place-items:center;margin:0 auto">' . "\n"
        . '    <svg width="34" height="34" style="color:var(--forest)"><use href="#i-check"/></svg>' . "\n"
        . '  </div>' . "\n"
        . '  <h3>Cảm ơn bạn đã đặt hàng!</h3>' . "\n"
        . '  <p class="ltg-hint">Home Care sẽ gọi xác nhận đơn trong thời gian sớm nhất.</p>' . "\n"
        . '</div>';

    $mail_body = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body style="margin:0;padding:24px;background:#f6f7ee;font-family:Arial,Helvetica,sans-serif;color:#2a2820;">' . "\n"
        . '<div style="max-width:620px;margin:0 auto;background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 8px 30px rgba(46,59,34,0.1);border:1px solid #efe6c8;">' . "\n"
        . '<div style="background:linear-gradient(135deg,#4a5c34 0%,#2e3b22 100%);padding:28px 24px;text-align:center;color:#fde390;">' . "\n"
        . '<h2 style="margin:0;font-size:24px;font-family:Georgia,serif;letter-spacing:0.5px;">🌿 ĐƠN ĐẶT HÀNG MỚI!</h2>' . "\n"
        . '<p style="margin:8px 0 0;font-size:14px;color:#ffffff;opacity:0.9;">Hệ thống Landing Page Tắm Gội Gừng Nghệ Mây Mây - Home Care</p>' . "\n"
        . '</div>' . "\n"
        . '<div style="padding:28px 24px;">' . "\n"
        . '<table style="width:100%;border-collapse:collapse;font-size:15px;line-height:1.6;">' . "\n"
        . '<tr><td style="padding:10px 0;border-bottom:1px solid #efe6c8;color:#77705f;width:140px;">Họ và tên:</td><td style="padding:10px 0;border-bottom:1px solid #efe6c8;font-weight:bold;color:#2e3b22;font-size:16px;">[your-name]</td></tr>' . "\n"
        . '<tr><td style="padding:10px 0;border-bottom:1px solid #efe6c8;color:#77705f;">Số điện thoại:</td><td style="padding:10px 0;border-bottom:1px solid #efe6c8;font-weight:bold;color:#b8412b;font-size:18px;"><a href="tel:[your-phone]" style="color:#b8412b;text-decoration:none;">[your-phone]</a></td></tr>' . "\n"
        . '<tr><td style="padding:10px 0;border-bottom:1px solid #efe6c8;color:#77705f;">Địa chỉ:</td><td style="padding:10px 0;border-bottom:1px solid #efe6c8;color:#2a2820;">[your-address]</td></tr>' . "\n"
        . '<tr><td style="padding:10px 0;border-bottom:1px solid #efe6c8;color:#77705f;">Combo đã chọn:</td><td style="padding:10px 0;border-bottom:1px solid #efe6c8;font-weight:bold;color:#c46a22;">[combo]</td></tr>' . "\n"
        . '<tr><td style="padding:10px 0;border-bottom:1px solid #efe6c8;color:#77705f;">Thời gian đặt:</td><td style="padding:10px 0;border-bottom:1px solid #efe6c8;color:#77705f;">[_date] [_time]</td></tr>' . "\n"
        . '<tr><td style="padding:10px 0;color:#77705f;">Trang đặt hàng:</td><td style="padding:10px 0;color:#77705f;">[_url]</td></tr>' . "\n"
        . '</table>' . "\n"
        . '<div style="margin-top:28px;text-align:center;">' . "\n"
        . '<a href="tel:[your-phone]" style="display:inline-block;padding:14px 28px;background:#2e3b22;color:#fde390;text-decoration:none;border-radius:30px;font-weight:bold;font-size:15px;letter-spacing:0.5px;">📞 GỌI XÁC NHẬN ĐƠN NGAY</a>' . "\n"
        . '</div>' . "\n"
        . '</div>' . "\n"
        . '<div style="background:#fffcf3;padding:16px;text-align:center;font-size:12px;color:#77705f;border-top:1px solid #efe6c8;">' . "\n"
        . 'Home Care Since 2008 · Hotline 0962 131 515 – 0973 871 376' . "\n"
        . '</div></div></body></html>';

    $server_name = isset($_SERVER['SERVER_NAME']) ? sanitize_text_field(wp_unslash($_SERVER['SERVER_NAME'])) : 'tamgoigungnghe.homecarevietnam.com';

    $mail_settings = array(
        'active'             => true,
        'subject'            => '[ĐƠN HÀNG MỚI] Gừng Nghệ Mây Mây - [your-name] ([your-phone])',
        'sender'             => 'Tắm Gội Gừng Nghệ Mây Mây <noreply@' . $server_name . '>',
        'recipient'          => 'danghuy.homecare@gmail.com',
        'body'               => $mail_body,
        'additional_headers' => 'Reply-To: [your-phone]',
        'attachments'        => '',
        'use_html'           => true,
        'exclude_blank'      => false,
    );

    $messages = array(
        'mail_sent_ok'             => 'Cảm ơn bạn đã đặt hàng! Home Care sẽ gọi xác nhận đơn trong thời gian sớm nhất.',
        'mail_sent_ng'             => 'Có lỗi xảy ra trong quá trình gửi đơn. Bạn vui lòng liên hệ hotline 0973.871.376 nhé.',
        'validation_error'         => 'Vui lòng kiểm tra lại thông tin và điền đầy đủ các mục bắt buộc nhé.',
        'spam'                     => 'Có lỗi xảy ra trong quá trình gửi đơn. Bạn vui lòng thử lại sau.',
        'invalid_required'         => 'Vui lòng điền thông tin vào mục này.',
        'invalid_tel'              => 'Số điện thoại không hợp lệ (10 số, bắt đầu bằng số 0).',
    );

    // Check if form already exists
    $existing = get_posts(array(
        'post_type'      => 'wpcf7_contact_form',
        'post_status'    => 'publish',
        'posts_per_page' => 1,
        'title'          => $form_title,
    ));

    if (!empty($existing)) {
        $form_id = $existing[0]->ID;
        update_post_meta($form_id, '_form', $form_content);
        update_post_meta($form_id, '_mail', $mail_settings);
        update_post_meta($form_id, '_messages', $messages);
        return (int) $form_id;
    }

    $form_id = wp_insert_post(array(
        'post_title'   => $form_title,
        'post_type'    => 'wpcf7_contact_form',
        'post_status'  => 'publish',
    ));

    if (!is_wp_error($form_id) && $form_id > 0) {
        update_post_meta($form_id, '_form', $form_content);
        update_post_meta($form_id, '_mail', $mail_settings);
        update_post_meta($form_id, '_messages', $messages);
        return (int) $form_id;
    }

    return false;
}
add_action('init', function() {
    if (class_exists('WPCF7_ContactForm')) {
        lx_ensure_cf7_form();
    }
}, 20);

/**
 * Filter to ensure combo value is correctly mapped and recipient is danghuy.homecare@gmail.com
 */
add_action('wpcf7_before_send_mail', function($contact_form) {
    if (is_object($contact_form) && method_exists($contact_form, 'prop')) {
        $mail = $contact_form->prop('mail');
        if (is_array($mail)) {
            $mail['recipient'] = 'danghuy.homecare@gmail.com';
            $contact_form->set_properties(array('mail' => $mail));
        }
    }
});

/**
 * Render Contact Form 7 or Built-in Fallback Form
 *
 * @return string HTML form
 */
function lx_render_order_form() {
    $shortcode = lx_get_field('lx_cf7_shortcode', 'option', '');
    if (!empty($shortcode)) {
        return do_shortcode($shortcode);
    }

    if (class_exists('WPCF7_ContactForm')) {
        $form_id = lx_ensure_cf7_form();
        if ($form_id) {
            return do_shortcode('[contact-form-7 id="' . $form_id . '" title="Đặt Hàng Tắm Gội Gừng Nghệ" html_class="ltg-form" html_id="ltgForm"]');
        }
    }

    // Built-in fallback form HTML identical to xem-truoc.html
    ob_start();
    ?>
    <form class="ltg-form" id="ltgForm" novalidate>
      <div id="ltgFormBody">
        <div class="ltg-fields ltg-fields--lb">
          <label>
            <span>Họ và tên:</span>
            <input name="name" type="text" placeholder="Ví dụ: Nguyễn Thị Mai" required>
          </label>
          <label>
            <span>Số điện thoại:</span>
            <input name="phone" type="tel" placeholder="Ví dụ: 0912 345 678" required>
          </label>
          <label>
            <span>Địa chỉ nhận hàng:</span>
            <input name="address" type="text" placeholder="Số nhà, ngõ/ngách, đường, phường/xã..." required>
          </label>
        </div>
        <div class="ltg-combo-pick" id="ltgCombo">
          <span class="ltg-flabel">Chọn combo:</span>
          <label class="ltg-copt is-on">
            <input type="radio" name="combo" value="[CÓ QUÀ] Bộ đôi Gội + Tắm 500ml – 169.000đ (tặng xịt khử mùi Gừng Cam 30ml)" checked>
            <span><b>[CÓ QUÀ] </b>Bộ đôi Gội + Tắm 500ml – 169.000đ (tặng xịt khử mùi Gừng Cam 30ml)</span>
          </label>
          <label class="ltg-copt">
            <input type="radio" name="combo" value="Bộ đôi Gội + Tắm 300ml – 79.000đ">
            <span>Bộ đôi Gội + Tắm 300ml – 79.000đ</span>
          </label>
        </div>
        <a class="ltg-nc-20link" href="https://trianthayco.homecarevietnam.com/#combo-qua" target="_blank" rel="noopener">🎁 Mua làm quà 20/11 tặng thầy cô? <b>Xem 3 combo quà →</b></a>
        <div class="ltg-fcd">
          <b>ƯU ĐÃI SẮP KẾT THÚC</b>
          <div class="ltg-fcd-t" id="ltgFormCd">
            <div><b data-m>14</b><small>Phút</small></div>
            <div><b data-s>59</b><small>Giây</small></div>
          </div>
        </div>
        <button class="ltg-btn ltg-btn--pri ltg-pulse" type="submit">
          ĐẶT HÀNG NGAY - NHẬN ƯU ĐÃI!
        </button>
        <p class="ltg-secure">
          🔒 Thanh toán khi nhận hàng · Thông tin của bạn được bảo mật
        </p>
      </div>
      <div class="ltg-ok" id="ltgOk" style="display:none">
        <div style="width:72px;height:72px;border-radius:50%;background:var(--butter);display:grid;place-items:center;margin:0 auto">
          <svg width="34" height="34" style="color:var(--forest)"><use href="#i-check"/></svg>
        </div>
        <h3>Cảm ơn bạn đã đặt hàng!</h3>
        <p class="ltg-hint">Home Care sẽ gọi xác nhận đơn trong thời gian sớm nhất.</p>
      </div>
    </form>
    <?php
    return ob_get_clean();
}
