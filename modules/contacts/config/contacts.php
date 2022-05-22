<?php

use WezomCms\Contacts\Dashboards;
use WezomCms\Contacts\Widgets;

return [
    'widgets' => [
//        'contacts:contact-button' => Widgets\ContactButton::class,
        'contacts:phone-social-links' => Widgets\PhoneSocialLinks::class,
        'contacts:socials-widget' => Widgets\SocialsWidget::class,
        'contacts:footer' => Widgets\FooterContacts::class,
        'contacts:social-links' => Widgets\SocialLinks::class,
    ],
    'dashboards' => [
        Dashboards\ContactsDashboard::class,
    ],
];
