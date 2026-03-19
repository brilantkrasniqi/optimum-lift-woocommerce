<?php

if (!defined('ABSPATH')) exit;

add_action('acf/init', 'optimumlift_register_acf_fields');

function optimumlift_register_acf_fields()
{
    if (!function_exists('acf_add_local_field_group')) return;

    // -------------------------------------------------------------------------
    // Front Page Field Group
    // -------------------------------------------------------------------------
    acf_add_local_field_group([
        'key'      => 'group_optimumlift_front_page',
        'title'    => 'Front Page',
        'fields'   => [

            // -----------------------------------------------------------------
            // Hero Slider (repeater)
            // -----------------------------------------------------------------
            [
                'key'        => 'field_hero_slide_images',
                'label'      => 'Hero Slides',
                'name'       => 'hero_slide_images',
                'type'       => 'repeater',
                'min'        => 1,
                'button_label' => 'Add Slide',
                'sub_fields' => [
                    [
                        'key'           => 'field_hero_image',
                        'label'         => 'Image',
                        'name'          => 'hero_image',
                        'type'          => 'image',
                        'return_format' => 'url',
                        'preview_size'  => 'medium',
                    ],
                    [
                        'key'   => 'field_hero_heading',
                        'label' => 'Heading',
                        'name'  => 'hero_heading',
                        'type'  => 'text',
                    ],
                    [
                        'key'         => 'field_hero_highlight',
                        'label'       => 'Highlight Text',
                        'name'        => 'hero_highlight',
                        'type'        => 'text',
                        'instructions' => 'The highlighted/coloured portion of the heading.',
                    ],
                    [
                        'key'   => 'field_hero_subheading',
                        'label' => 'Subheading',
                        'name'  => 'hero_subheading',
                        'type'  => 'textarea',
                        'rows'  => 3,
                    ],
                    [
                        'key'   => 'field_hero_cta_link',
                        'label' => 'Primary CTA',
                        'name'  => 'hero_cta_link',
                        'type'  => 'link',
                    ],
                    [
                        'key'          => 'field_hero_cta_link_2',
                        'label'        => 'Secondary CTA',
                        'name'         => 'hero_cta_link_2',
                        'type'         => 'link',
                        'required'     => 0,
                    ],
                ],
            ],

            // -----------------------------------------------------------------
            // Overall Stats (repeater)
            // -----------------------------------------------------------------
            [
                'key'        => 'field_overall_stats',
                'label'      => 'Overall Stats',
                'name'       => 'overall_stats',
                'type'       => 'repeater',
                'min'        => 1,
                'button_label' => 'Add Stat',
                'sub_fields' => [
                    [
                        'key'   => 'field_stat_number',
                        'label' => 'Number / Value',
                        'name'  => 'stat_number',
                        'type'  => 'text',
                    ],
                    [
                        'key'   => 'field_stat_text',
                        'label' => 'Label',
                        'name'  => 'stat_text',
                        'type'  => 'text',
                    ],
                ],
            ],

            // -----------------------------------------------------------------
            // Problem Section (group)
            // -----------------------------------------------------------------
            [
                'key'        => 'field_problem_section',
                'label'      => 'Problem Section',
                'name'       => 'problem_section',
                'type'       => 'group',
                'layout'     => 'block',
                'sub_fields' => [
                    [
                        'key'          => 'field_problem_section_heading',
                        'label'        => 'Heading',
                        'name'         => 'section_heading',
                        'type'         => 'text',
                        'instructions' => 'Wrap text in ** to highlight it, e.g. "The **real problem**".',
                    ],
                    [
                        'key'   => 'field_problem_section_subheading',
                        'label' => 'Subheading',
                        'name'  => 'section_subheading',
                        'type'  => 'textarea',
                        'rows'  => 3,
                    ],
                    // Card 1
                    [
                        'key'        => 'field_problem_card_1',
                        'label'      => 'Problem Card 1',
                        'name'       => 'problem_card_1',
                        'type'       => 'group',
                        'layout'     => 'row',
                        'sub_fields' => [
                            [
                                'key'           => 'field_problem_card_1_icon',
                                'label'         => 'Icon',
                                'name'          => 'card_icon',
                                'type'          => 'image',
                                'return_format' => 'url',
                                'preview_size'  => 'thumbnail',
                            ],
                            [
                                'key'   => 'field_problem_card_1_title',
                                'label' => 'Title',
                                'name'  => 'card_title',
                                'type'  => 'text',
                            ],
                            [
                                'key'   => 'field_problem_card_1_content',
                                'label' => 'Content',
                                'name'  => 'card_content',
                                'type'  => 'textarea',
                                'rows'  => 3,
                            ],
                        ],
                    ],
                    // Card 2
                    [
                        'key'        => 'field_problem_card_2',
                        'label'      => 'Problem Card 2',
                        'name'       => 'problem_card_2',
                        'type'       => 'group',
                        'layout'     => 'row',
                        'sub_fields' => [
                            [
                                'key'           => 'field_problem_card_2_icon',
                                'label'         => 'Icon',
                                'name'          => 'card_icon',
                                'type'          => 'image',
                                'return_format' => 'url',
                                'preview_size'  => 'thumbnail',
                            ],
                            [
                                'key'   => 'field_problem_card_2_title',
                                'label' => 'Title',
                                'name'  => 'card_title',
                                'type'  => 'text',
                            ],
                            [
                                'key'   => 'field_problem_card_2_content',
                                'label' => 'Content',
                                'name'  => 'card_content',
                                'type'  => 'textarea',
                                'rows'  => 3,
                            ],
                        ],
                    ],
                    // Card 3
                    [
                        'key'        => 'field_problem_card_3',
                        'label'      => 'Problem Card 3',
                        'name'       => 'problem_card_3',
                        'type'       => 'group',
                        'layout'     => 'row',
                        'sub_fields' => [
                            [
                                'key'           => 'field_problem_card_3_icon',
                                'label'         => 'Icon',
                                'name'          => 'card_icon',
                                'type'          => 'image',
                                'return_format' => 'url',
                                'preview_size'  => 'thumbnail',
                            ],
                            [
                                'key'   => 'field_problem_card_3_title',
                                'label' => 'Title',
                                'name'  => 'card_title',
                                'type'  => 'text',
                            ],
                            [
                                'key'   => 'field_problem_card_3_content',
                                'label' => 'Content',
                                'name'  => 'card_content',
                                'type'  => 'textarea',
                                'rows'  => 3,
                            ],
                        ],
                    ],
                ],
            ],

            // -----------------------------------------------------------------
            // Testimonials / Before & After (group)
            // -----------------------------------------------------------------
            [
                'key'        => 'field_testimonials_home_section',
                'label'      => 'Before & After Testimonials',
                'name'       => 'testimonials_home_section',
                'type'       => 'group',
                'layout'     => 'block',
                'sub_fields' => [
                    [
                        'key'          => 'field_testimonials_heading',
                        'label'        => 'Heading',
                        'name'         => 'section_heading',
                        'type'         => 'text',
                        'instructions' => 'Wrap text in ** to highlight it.',
                    ],
                    [
                        'key'   => 'field_testimonials_description',
                        'label' => 'Description',
                        'name'  => 'section_description',
                        'type'  => 'textarea',
                        'rows'  => 3,
                    ],
                    [
                        'key'        => 'field_before_after_reviews',
                        'label'      => 'Reviews',
                        'name'       => 'before_after_reviews',
                        'type'       => 'repeater',
                        'min'        => 1,
                        'button_label' => 'Add Review',
                        'sub_fields' => [
                            [
                                'key'        => 'field_before_after_card',
                                'label'      => 'Review Card',
                                'name'       => 'before_after_card',
                                'type'       => 'group',
                                'layout'     => 'block',
                                'sub_fields' => [
                                    [
                                        'key'           => 'field_before_image',
                                        'label'         => 'Before Image',
                                        'name'          => 'before_image',
                                        'type'          => 'image',
                                        'return_format' => 'array',
                                        'preview_size'  => 'medium',
                                    ],
                                    [
                                        'key'           => 'field_after_image',
                                        'label'         => 'After Image',
                                        'name'          => 'after_image',
                                        'type'          => 'image',
                                        'return_format' => 'array',
                                        'preview_size'  => 'medium',
                                    ],
                                    [
                                        'key'   => 'field_reviewers_name',
                                        'label' => 'Reviewer Name',
                                        'name'  => 'reviewers_name',
                                        'type'  => 'text',
                                    ],
                                    [
                                        'key'   => 'field_number_of_stars',
                                        'label' => 'Stars (1–5)',
                                        'name'  => 'number_of_stars',
                                        'type'  => 'number',
                                        'min'   => 1,
                                        'max'   => 5,
                                        'step'  => 1,
                                        'default_value' => 5,
                                    ],
                                    [
                                        'key'          => 'field_number_of_weeks',
                                        'label'        => 'Number of Weeks',
                                        'name'         => 'number_of_weeks',
                                        'type'         => 'text',
                                        'instructions' => 'e.g. "8" (displayed as "8 weeks").',
                                    ],
                                    [
                                        'key'           => 'field_product_used',
                                        'label'         => 'Product Used',
                                        'name'          => 'product_used',
                                        'type'          => 'post_object',
                                        'post_type'     => ['product'],
                                        'return_format' => 'id',
                                        'required'      => 0,
                                        'allow_null'    => 1,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],

            // -----------------------------------------------------------------
            // How It Works (group)
            // -----------------------------------------------------------------
            [
                'key'        => 'field_how_it_works',
                'label'      => 'How It Works',
                'name'       => 'how_it_works',
                'type'       => 'group',
                'layout'     => 'block',
                'sub_fields' => [
                    [
                        'key'          => 'field_hiw_heading',
                        'label'        => 'Heading',
                        'name'         => 'section_heading',
                        'type'         => 'text',
                        'instructions' => 'Wrap text in ** to highlight it.',
                    ],
                    [
                        'key'   => 'field_hiw_subheading',
                        'label' => 'Subheading',
                        'name'  => 'section_subheading',
                        'type'  => 'textarea',
                        'rows'  => 3,
                    ],
                    [
                        'key'        => 'field_hiw_steps',
                        'label'      => 'Steps',
                        'name'       => 'steps',
                        'type'       => 'repeater',
                        'min'        => 1,
                        'button_label' => 'Add Step',
                        'sub_fields' => [
                            [
                                'key'   => 'field_step_title',
                                'label' => 'Title',
                                'name'  => 'step_title',
                                'type'  => 'text',
                            ],
                            [
                                'key'   => 'field_step_content',
                                'label' => 'Content',
                                'name'  => 'step_content',
                                'type'  => 'textarea',
                                'rows'  => 3,
                            ],
                        ],
                    ],
                    [
                        'key'   => 'field_hiw_cta',
                        'label' => 'CTA Button',
                        'name'  => 'section_cta',
                        'type'  => 'link',
                    ],
                ],
            ],

            // -----------------------------------------------------------------
            // Showcase / Featured Products (group)
            // -----------------------------------------------------------------
            [
                'key'        => 'field_showcase_products',
                'label'      => 'Featured Products',
                'name'       => 'showcase_products',
                'type'       => 'group',
                'layout'     => 'block',
                'sub_fields' => [
                    [
                        'key'          => 'field_showcase_heading',
                        'label'        => 'Heading',
                        'name'         => 'section_heading',
                        'type'         => 'text',
                        'instructions' => 'Wrap text in ** to highlight it.',
                    ],
                    [
                        'key'   => 'field_showcase_description',
                        'label' => 'Description',
                        'name'  => 'section_description',
                        'type'  => 'textarea',
                        'rows'  => 2,
                    ],
                    [
                        'key'           => 'field_featured_products',
                        'label'         => 'Products',
                        'name'          => 'featured_products',
                        'type'          => 'post_object',
                        'post_type'     => ['product'],
                        'return_format' => 'id',
                        'multiple'      => 1,
                        'allow_null'    => 0,
                        'ui'            => 1,
                    ],
                ],
            ],

            // -----------------------------------------------------------------
            // Benefits Section (group)
            // -----------------------------------------------------------------
            [
                'key'        => 'field_benifits_section',
                'label'      => 'Benefits Section',
                'name'       => 'benifits_section',
                'type'       => 'group',
                'layout'     => 'block',
                'sub_fields' => [
                    [
                        'key'          => 'field_benifits_title',
                        'label'        => 'Heading',
                        'name'         => 'section_title',
                        'type'         => 'text',
                        'instructions' => 'Wrap text in ** to highlight it.',
                    ],
                    [
                        'key'      => 'field_benifits_description',
                        'label'    => 'Description',
                        'name'     => 'section_description',
                        'type'     => 'textarea',
                        'rows'     => 3,
                        'required' => 0,
                    ],
                    [
                        'key'        => 'field_benifit_cards',
                        'label'      => 'Benefit Cards',
                        'name'       => 'benifit_cards',
                        'type'       => 'repeater',
                        'min'        => 1,
                        'button_label' => 'Add Benefit',
                        'sub_fields' => [
                            [
                                'key'           => 'field_benifit_card_image',
                                'label'         => 'Icon',
                                'name'          => 'card_image',
                                'type'          => 'image',
                                'return_format' => 'array',
                                'preview_size'  => 'thumbnail',
                            ],
                            [
                                'key'   => 'field_benifit_card_title',
                                'label' => 'Title',
                                'name'  => 'card_title',
                                'type'  => 'text',
                            ],
                            [
                                'key'   => 'field_benifit_card_description',
                                'label' => 'Description',
                                'name'  => 'card_description',
                                'type'  => 'textarea',
                                'rows'  => 3,
                            ],
                        ],
                    ],
                ],
            ],

            // -----------------------------------------------------------------
            // Review Testimonials (group)
            // -----------------------------------------------------------------
            [
                'key'        => 'field_review_testimonials',
                'label'      => 'Review Testimonials',
                'name'       => 'review_testimonials',
                'type'       => 'group',
                'layout'     => 'block',
                'sub_fields' => [
                    [
                        'key'          => 'field_reviews_heading',
                        'label'        => 'Heading',
                        'name'         => 'section_heading',
                        'type'         => 'text',
                        'instructions' => 'Wrap text in ** to highlight it.',
                    ],
                    [
                        'key'   => 'field_reviews_description',
                        'label' => 'Description',
                        'name'  => 'section_description',
                        'type'  => 'textarea',
                        'rows'  => 3,
                    ],
                    [
                        'key'        => 'field_review_card',
                        'label'      => 'Review Cards',
                        'name'       => 'review_card',
                        'type'       => 'repeater',
                        'min'        => 1,
                        'button_label' => 'Add Review',
                        'sub_fields' => [
                            [
                                'key'           => 'field_review_rating',
                                'label'         => 'Star Rating (1–5)',
                                'name'          => 'review_rating',
                                'type'          => 'number',
                                'min'           => 1,
                                'max'           => 5,
                                'step'          => 1,
                                'default_value' => 5,
                            ],
                            [
                                'key'   => 'field_review_card_content',
                                'label' => 'Review Text',
                                'name'  => 'card_content',
                                'type'  => 'textarea',
                                'rows'  => 4,
                            ],
                            [
                                'key'   => 'field_review_card_author',
                                'label' => 'Author Name',
                                'name'  => 'card_author',
                                'type'  => 'text',
                            ],
                            [
                                'key'          => 'field_author_additional_info',
                                'label'        => 'Author Additional Info',
                                'name'         => 'author_additional_info',
                                'type'         => 'text',
                                'instructions' => 'e.g. "Lost 12kg in 8 weeks".',
                            ],
                        ],
                    ],
                ],
            ],

            // -----------------------------------------------------------------
            // Guarantee Section (group)
            // -----------------------------------------------------------------
            [
                'key'        => 'field_guarantee_section',
                'label'      => 'Guarantee Section',
                'name'       => 'guarantee_section',
                'type'       => 'group',
                'layout'     => 'block',
                'sub_fields' => [
                    [
                        'key'          => 'field_guarantee_heading',
                        'label'        => 'Heading',
                        'name'         => 'section_heading',
                        'type'         => 'text',
                        'instructions' => 'Wrap text in ** to highlight it.',
                    ],
                    [
                        'key'      => 'field_guarantee_description',
                        'label'    => 'Description',
                        'name'     => 'section_description',
                        'type'     => 'textarea',
                        'rows'     => 4,
                        'required' => 0,
                    ],
                    [
                        'key'           => 'field_guarantee_icon',
                        'label'         => 'Icon',
                        'name'          => 'guarantee_icon',
                        'type'          => 'image',
                        'return_format' => 'url',
                        'preview_size'  => 'thumbnail',
                    ],
                ],
            ],

            // -----------------------------------------------------------------
            // FAQ Section (group)
            // -----------------------------------------------------------------
            [
                'key'        => 'field_faq_section',
                'label'      => 'FAQ Section',
                'name'       => 'faq_section',
                'type'       => 'group',
                'layout'     => 'block',
                'sub_fields' => [
                    [
                        'key'          => 'field_faq_heading',
                        'label'        => 'Heading',
                        'name'         => 'section_heading',
                        'type'         => 'text',
                        'instructions' => 'Wrap text in ** to highlight it.',
                    ],
                    [
                        'key'   => 'field_faq_description',
                        'label' => 'Description',
                        'name'  => 'section_description',
                        'type'  => 'textarea',
                        'rows'  => 3,
                    ],
                    [
                        'key'        => 'field_faq_card',
                        'label'      => 'FAQ Items',
                        'name'       => 'faq_card',
                        'type'       => 'repeater',
                        'min'        => 1,
                        'button_label' => 'Add FAQ',
                        'sub_fields' => [
                            [
                                'key'   => 'field_faq_question',
                                'label' => 'Question',
                                'name'  => 'question',
                                'type'  => 'text',
                            ],
                            [
                                'key'   => 'field_faq_answer',
                                'label' => 'Answer',
                                'name'  => 'answer',
                                'type'  => 'textarea',
                                'rows'  => 4,
                            ],
                        ],
                    ],
                ],
            ],

            // -----------------------------------------------------------------
            // CTA Section (group)
            // -----------------------------------------------------------------
            [
                'key'        => 'field_cta',
                'label'      => 'CTA Section',
                'name'       => 'cta',
                'type'       => 'group',
                'layout'     => 'block',
                'sub_fields' => [
                    [
                        'key'          => 'field_cta_heading',
                        'label'        => 'Heading',
                        'name'         => 'cta_heading',
                        'type'         => 'text',
                        'instructions' => 'Wrap text in ** to highlight it.',
                    ],
                    [
                        'key'   => 'field_cta_description',
                        'label' => 'Description',
                        'name'  => 'cta_description',
                        'type'  => 'textarea',
                        'rows'  => 3,
                    ],
                    [
                        'key'   => 'field_cta_link',
                        'label' => 'Button',
                        'name'  => 'cta_link',
                        'type'  => 'link',
                    ],
                ],
            ],

        ],
        'location' => [
            [
                ['param' => 'page_type', 'operator' => '==', 'value' => 'front_page'],
            ],
        ],
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'active'                => true,
    ]);

    // -------------------------------------------------------------------------
    // Product Fields (WooCommerce single products)
    // -------------------------------------------------------------------------
    acf_add_local_field_group([
        'key'    => 'group_optimumlift_product',
        'title'  => 'Product Details',
        'fields' => [
            [
                'key'        => 'field_duration',
                'label'      => 'Duration',
                'name'       => 'duration',
                'type'       => 'group',
                'layout'     => 'row',
                'instructions' => 'Programme duration range in weeks.',
                'sub_fields' => [
                    [
                        'key'   => 'field_duration_min',
                        'label' => 'Min Weeks',
                        'name'  => 'min',
                        'type'  => 'number',
                        'min'   => 1,
                        'step'  => 1,
                    ],
                    [
                        'key'   => 'field_duration_max',
                        'label' => 'Max Weeks',
                        'name'  => 'max',
                        'type'  => 'number',
                        'min'   => 1,
                        'step'  => 1,
                    ],
                ],
            ],
        ],
        'location' => [
            [
                ['param' => 'post_type', 'operator' => '==', 'value' => 'product'],
            ],
        ],
        'menu_order'      => 0,
        'position'        => 'normal',
        'style'           => 'default',
        'label_placement' => 'top',
        'active'          => true,
    ]);
}
