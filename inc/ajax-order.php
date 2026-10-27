<?php
/**
 * AJAX Order Lead Submission Handler
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handle Order Submission
 */
function lx_handle_order_submission() {
    // Basic verification
    $name  = isset($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : '';
    $phone = isset($_POST['phone']) ? preg_replace('/[^\d]/', '', (string)$_POST['phone']) : '';
    $address = isset($_POST['address']) ? sanitize_text_field(wp_unslash($_POST['address'])) : '';
    $combo = isset($_POST['combo']) ? sanitize_text_field(wp_unslash($_POST['combo'])) : '';
    $giftwrap = isset($_POST['giftwrap']) ? sanitize_text_field(wp_unslash($_POST['giftwrap'])) : 'Không';
    $card = isset($_POST['card']) ? sanitize_textarea_field(wp_unslash($_POST['card'])) : '';

    if (empty($name) || strlen($name) < 2) {
        wp_send_json_error(array('message' => 'Vui lòng nhập họ và tên của bạn.'), 400);
    }

    if (empty($phone) || !preg_match('/^0[3|5|7|8|9]\d{8}$/', $phone)) {
        wp_send_json_error(array('message' => 'Số điện thoại không hợp lệ (10 số, bắt đầu bằng số 0).'), 400);
    }

    if (empty($address)) {
        wp_send_json_error(array('message' => 'Vui lòng nhập địa chỉ nhận hàng.'), 400);
    }

    $created_at = current_time('d/m/Y H:i:s');
    $ip = isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR'])) : '';

    $lead = array(
        'name'       => $name,
        'phone'      => $phone,
        'address'    => $address,
        'combo'      => $combo,
        'giftwrap'   => $giftwrap,
        'card'       => $card,
        'created_at' => $created_at,
        'ip'         => $ip,
    );

    // 1. Store in WordPress database (rolling list of 200 leads)
    $leads = get_option('lx_leads_list', array());
    if (!is_array($leads)) {
        $leads = array();
    }
    array_unshift($leads, $lead);
    if (count($leads) > 200) {
        $leads = array_slice($leads, 0, 200);
    }
    update_option('lx_leads_list', $leads, false);

    // 2. Email destination setting - Defaulting directly to danghuy.homecare@gmail.com as requested
    $to_email = lx_get_field('order_email', 'option', 'danghuy.homecare@gmail.com');
    if (empty($to_email) || !is_email($to_email)) {
        $to_email = 'danghuy.homecare@gmail.com';
    }

    $site_name   = 'Tắm Gội Gừng Nghệ Mây Mây';
    $host_domain = wp_parse_url(home_url(), PHP_URL_HOST);
    if (empty($host_domain)) {
        $host_domain = 'tamgoigungnghe.homecarevietnam.com';
    }
    $from_email  = 'noreply@' . $host_domain;

    $subject = sprintf('[ĐƠN HÀNG MỚI] Gừng Nghệ Mây Mây - %s (%s)', $lead['name'], $lead['phone']);

    $message  = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body style="margin:0;padding:24px;background:#f6f7ee;font-family:Arial,Helvetica,sans-serif;color:#2a2820;">';
    $message .= '<div style="max-width:620px;margin:0 auto;background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 8px 30px rgba(46,59,34,0.1);border:1px solid #efe6c8;">';
    $message .= '<div style="background:linear-gradient(135deg,#4a5c34 0%,#2e3b22 100%);padding:28px 24px;text-align:center;color:#fde390;">';
    $message .= '<h2 style="margin:0;font-size:24px;font-family:Georgia,serif;letter-spacing:0.5px;">🌿 ĐƠN ĐẶT HÀNG MỚI!</h2>';
    $message .= '<p style="margin:8px 0 0;font-size:14px;color:#ffffff;opacity:0.9;">Hệ thống Landing Page Tắm Gội Gừng Nghệ Mây Mây - Home Care</p>';
    $message .= '</div>';
    $message .= '<div style="padding:28px 24px;">';
    $message .= '<table style="width:100%;border-collapse:collapse;font-size:15px;line-height:1.6;">';
    $message .= '<tr><td style="padding:10px 0;border-bottom:1px solid #efe6c8;color:#77705f;width:140px;">Họ và tên:</td><td style="padding:10px 0;border-bottom:1px solid #efe6c8;font-weight:bold;color:#2e3b22;font-size:16px;">' . esc_html($lead['name']) . '</td></tr>';
    $message .= '<tr><td style="padding:10px 0;border-bottom:1px solid #efe6c8;color:#77705f;">Số điện thoại:</td><td style="padding:10px 0;border-bottom:1px solid #efe6c8;font-weight:bold;color:#b8412b;font-size:18px;"><a href="tel:' . esc_attr($lead['phone']) . '" style="color:#b8412b;text-decoration:none;">' . esc_html($lead['phone']) . '</a></td></tr>';
    $message .= '<tr><td style="padding:10px 0;border-bottom:1px solid #efe6c8;color:#77705f;">Địa chỉ:</td><td style="padding:10px 0;border-bottom:1px solid #efe6c8;color:#2a2820;">' . esc_html($lead['address']) . '</td></tr>';
    $message .= '<tr><td style="padding:10px 0;border-bottom:1px solid #efe6c8;color:#77705f;">Gói sản phẩm:</td><td style="padding:10px 0;border-bottom:1px solid #efe6c8;font-weight:bold;color:#c46a22;">' . esc_html($lead['combo']) . '</td></tr>';
    $message .= '<tr><td style="padding:10px 0;border-bottom:1px solid #efe6c8;color:#77705f;">Gói quà tặng:</td><td style="padding:10px 0;border-bottom:1px solid #efe6c8;color:#2a2820;">' . esc_html($lead['giftwrap']) . '</td></tr>';
    if (!empty($lead['card'])) {
        $message .= '<tr><td style="padding:10px 0;border-bottom:1px solid #efe6c8;color:#77705f;">Lời chúc / Thiệp:</td><td style="padding:10px 0;border-bottom:1px solid #efe6c8;color:#2a2820;font-style:italic;">' . nl2br(esc_html($lead['card'])) . '</td></tr>';
    }
    $message .= '<tr><td style="padding:10px 0;border-bottom:1px solid #efe6c8;color:#77705f;">Thời gian đặt:</td><td style="padding:10px 0;border-bottom:1px solid #efe6c8;color:#77705f;">' . esc_html($lead['created_at']) . '</td></tr>';
    $message .= '<tr><td style="padding:10px 0;color:#77705f;">Địa chỉ IP:</td><td style="padding:10px 0;color:#77705f;">' . esc_html($lead['ip']) . '</td></tr>';
    $message .= '</table>';
    $message .= '<div style="margin-top:28px;text-align:center;">';
    $message .= '<a href="tel:' . esc_attr($lead['phone']) . '" style="display:inline-block;padding:14px 28px;background:#2e3b22;color:#fde390;text-decoration:none;border-radius:30px;font-weight:bold;font-size:15px;letter-spacing:0.5px;">📞 GỌI XÁC NHẬN ĐƠN NGAY</a>';
    $message .= '</div>';
    $message .= '</div>';
    $message .= '<div style="background:#fffcf3;padding:16px;text-align:center;font-size:12px;color:#77705f;border-top:1px solid #efe6c8;">';
    $message .= 'Home Care Since 2008 · Hotline 0962 131 515 – 0973 871 376';
    $message .= '</div></div></body></html>';

    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . $site_name . ' <' . $from_email . '>',
    );

    @wp_mail($to_email, $subject, $message, $headers);

    wp_send_json_success(array(
        'message' => 'Đặt hàng thành công! Home Care sẽ liên hệ xác nhận trong ít phút.',
    ));
}
add_action('wp_ajax_lx_submit_order', 'lx_handle_order_submission');
add_action('wp_ajax_nopriv_lx_submit_order', 'lx_handle_order_submission');
