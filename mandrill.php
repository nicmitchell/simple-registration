<?php
require(dirname(__FILE__) .'/mandrill.conf.php');

function send_email($data){
    var_dump($data);
    try {
        $mandrill = new Mandrill(MANDRILL_API_KEY);
        $message = array(
            'subject' => 'Registration successful',
            'from_email' => 'registration@domain.com',
            // 'html' => '<p>this is a test message with Mandrill\'s PHP wrapper!.</p>',
            'to' => array(array(
                'email' => 'nicolas.aurelius@gmail.com', 
                'name' => $data['username']//'Nic Mitchell'
            )),
            'merge_vars' => array(array(
                'rcpt' => 'nicolas.aurelius@gmail.com',
                'vars' =>
                array(array(
                        'name' => 'USERNAME',
                        'content' => $data['username']
                ))
            ))
        );

        $template_name = 'Stationary';

        $template_content = array(array(
            'name' => 'main',
            'content' => 'Hi *|USERNAME|*, thanks for signing up.')
        );

        print_r($mandrill->messages->sendTemplate($template_name, $template_content, $message));

    } catch(Mandrill_Error $e) {
        // Mandrill errors are thrown as exceptions
        echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
        // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
        throw $e;
    }
}
?>