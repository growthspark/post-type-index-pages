<?php
global $wpsf_settings;

$wpsf_settings[] = array(
    'section_id' => 'general',
    'section_title' => '',
    'section_description' => '',
    'section_order' => 5,
    'fields' => array(
        array(
            'id' => 'api_key',
            'title' => 'Coinbase API key',
            'desc' => "You can find this on the <a href='https://coinbase.com/account/integrations'>integrations page</a>.  Note: this allows access to your account, do not share.",
            'type' => 'password',
            'std' => ''
        )
    )
);

/*
$post_types = get_post_types(array('public' => true)); 
foreach ( $post_types as $post_type ) {
    $obj = get_post_type_object($post_type);
    $post_type_id = $obj->name;
    $post_type_name = $obj->labels->name;

    $wpsf_settings[] = array(
        'section_id' => 'general',
        'section_title' => '',
        'section_description' => '',
        'section_order' => 5,
        'fields' => array(
                'id' => 'post_type_'.$post_type_id,
                'title' => $post_type_name,
                'type' => 'select',
                'choices' => array('A', 'B', 'C')
            )
    );
} */




?>