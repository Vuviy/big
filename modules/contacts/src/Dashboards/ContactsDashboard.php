<?php

namespace WezomCms\Contacts\Dashboards;

use WezomCms\Contacts\Models\Contact;
use WezomCms\Core\Foundation\Dashboard\AbstractValueDashboard;

class ContactsDashboard extends AbstractValueDashboard
{
    /**
     * @var null|int - cache time in minutes.
     */
    protected $cacheTime = 5;

    /**
     * @var null|string - permission for link
     */
    protected $ability = 'contacts.view';

    /**
     * @return int
     */
    public function value(): int
    {
        return Contact::count();
    }

    /**
     * @return string
     */
    public function description(): string
    {
        return __('cms-contacts::admin.Requests');
    }

    /**
     * @return string
     */
    public function icon(): string
    {
        return 'fa-envelope';
    }

    /**
     * @return null|string
     */
    public function url(): ?string
    {
        return route('admin.contacts.index');
    }
}
