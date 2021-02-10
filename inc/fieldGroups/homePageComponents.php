<?php

use ACFComposer\ACFComposer;
use Flynt\FieldVariables;
use Flynt\Components;

add_action('Flynt/afterRegisterComponents', function () {
    ACFComposer::registerFieldGroup([
        'name' => 'homePageComponents',
        'title' => 'Home Page Components',
        'style' => 'default',
        'fields' => [
            [
                'label' => __('Hero', 'flynt'),
                'name' => 'hero',
                'type' => 'group',
                'layout' => 'row',
                'endpoint' => 0,
                'sub_fields' => [
                    FieldVariables\getImage(),
                    FieldVariables\getDescription(),
                    FieldVariables\getLink(),
                ],
            ],
            [
                'label' => __('Tools', 'flynt'),
                'name' => 'tools',
                'type' => 'group',
                'layout' => 'row',
                'endpoint' => 0,
                'sub_fields' => [
                    FieldVariables\getTitle(),
                    FieldVariables\getLink(),
                    [
                        'label' => __('Tool', 'flynt'),
                        'name' => 'tool',
                        'type' => 'repeater',
                        'collapsed' => '',
                        'layout' => 'block',
                        'button_label' => 'Add',
                        'sub_fields' => [
                            FieldVariables\getImage(),
                            FieldVariables\getAlign(),
                            FieldVariables\getTitle(),
                            FieldVariables\getDescription(),
                            FieldVariables\getLink(),
                        ]
                    ]
                ],
            ],
            [
                'label' => __('Related', 'flynt'),
                'name' => 'related',
                'type' => 'group',
                'layout' => 'row',
                'endpoint' => 0,
                'sub_fields' => [
                    FieldVariables\getRelated()
                ]
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-home.php'
                ]
            ]
        ]
    ]);
});
