<?php

/**
 * Defines field variables to be used across multiple components.
 */

namespace Flynt\FieldVariables;

function getImage() {
    return [
        [
            'label' => __('Image', 'flynt'),
            'name' => 'image',
            'type' => 'image',
            'preview_size' => 'medium',
            'instructions' => __('.jpg, .png, .svg', 'flynt'),
            'mime_types' => 'jpg,jpeg,png,svg',
            'required' => 1,
            'wrapper' => [
                'width' => '50',
            ],
        ]
    ];
}

function getLabel() {
    return [
        [
            'label' => __('Label', 'flynt'),
            'name' => 'label',
            'type' => 'text',
            'required' => 0,
            'wrapper' => [
                'width' => '50',
            ],
        ],
    ];
}

function getTitle() {
    return [
        [
            'label' => __('Title', 'flynt'),
            'name' => 'title',
            'type' => 'text',
            'required' => 0,
            'wrapper' => [
                'width' => '50',
            ],
        ],
    ];
}

function getDescription() {
    return [
        [
            'label' => __('Description', 'flynt'),
            'name' => 'description',
            'type' => 'textarea',
            'new_lines' => 'wpautop',
            'rows' => 4,
            'required' => 1
        ],
    ];
}

function getLink() {
    return [
        [
            'label' => __('Link', 'flynt'),
            'name' => 'link',
            'type' => 'link',
            'post_type' => [
                0 => 'page',
            ],
            'multiple' => 0,
            'allow_null' => 0,
            'allow_archives' => 1,
            'required' => 0,
            'wrapper' => [
                'width' => '50',
            ],
        ],
    ];
}

function getAlign() {
    return [
        [
            'label' => 'Align',
			'name' => 'align',
			'type' => 'button_group',
			'choices' => array(
                'left' => 'Left',
				'right' => 'Right',
			),
			'allow_null' => 0,
			'default_value' => '',
			'layout' => 'horizontal',
            'return_format' => 'value',
            'required' => 0,
            'wrapper' => [
                'width' => '50',
            ],
        ],
    ];
}

function getText() {
    return [
        [
            'label' => __('Text', 'flynt'),
            'name' => 'text',
            'type' => 'wysiwyg',
            'tabs' => 'visual',
            'toolbar' => 'basic',
            'media_upload' => 0,
            'delay' => 1,
            'new_lines' => 'wpautop',
            'wrapper' => [
                'class' => 'autosize',
            ],
            'required' => 0
        ]
    ];
}

function getWysiwyg() {
    return [
        [
            'label' => __('Wysiwyg', 'flynt'),
            'name' => 'wysiwyg',
            'type' => 'wysiwyg',
            'tabs' => 'all',
            'toolbar' => 'full',
            'media_upload' => 0,
            'delay' => 1,
            'new_lines' => 'wpautop',
            'wrapper' => [
                'class' => 'autosize',
            ],
            'required' => 1
        ]
    ];
}

function getRelated() {
    return [
        [
            'label' => 'Research, News',
            'name' => 'posts',
            'type' => 'relationship',
            'post_type' => array(
                0 => 'news',
                1 => 'research',
            ),
            'taxonomy' => array(
            ),
            'filters' => array(
                0 => 'search',
                1 => 'post_type',
                2 => 'taxonomy',
            ),
            'elements' => '',
            'min' => '',
            'max' => 12,
            'return_format' => 'post_object',
            'required' => 0
        ]
    ];
}
