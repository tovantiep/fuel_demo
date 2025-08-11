<?php

return [
    'pagination_url' => '',
    'uri_segment' => 'page',
    'num_links' => 3,
    'per_page' => 10,
    'show_first' => true,
    'show_last' => true,
    'show_prev' => true,
    'show_next' => true,

    'template' => [
        'wrapper_start' => '<nav><ul class="pagination justify-content-center">',
        'wrapper_end' => '</ul></nav>',

        'page_start' => '<li class="page-item">',
        'page_end' => '</li>',

        'previous_start' => '<li class="page-item">',
        'previous_end' => '</li>',

        'previous_inactive_start' => '<li class="page-item disabled">',
        'previous_inactive_end' => '</li>',

        'next_start' => '<li class="page-item">',
        'next_end' => '</li>',

        'next_inactive_start' => '<li class="page-item disabled">',
        'next_inactive_end' => '</li>',

        'first_start' => '<li class="page-item">',
        'first_end' => '</li>',

        'last_start' => '<li class="page-item">',
        'last_end' => '</li>',

        'current_start' => '<li class="page-item active" aria-current="page"><span class="page-link">',
        'current_end' => '</span></li>',

        'previous_marker' => '&laquo;',
        'next_marker' => '&raquo;',
        'first_marker' => '&laquo;&laquo;',
        'last_marker' => '&raquo;&raquo;',
        'link_attributes' => ['class' => 'page-link'],
    ],
];
