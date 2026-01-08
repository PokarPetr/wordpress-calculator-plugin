<?php

class Calculator_Ajax {
    public function __construct() {
        add_action( 'wp_ajax_calculate', [ $this, 'handle' ] );
        add_action( 'wp_ajax_nopriv_calculate', [ $this, 'handle' ] );
    }

    public function handle() {

        check_ajax_referer('ajax_nonce', 'nonce');

        $request = new WP_REST_Request('POST');
        $request->set_body_params($_POST);

        $result = Calculator_Handler::handle($request);

        wp_send_json_success($result);
    }

}
