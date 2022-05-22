<?php

namespace WezomCms\Contacts\ModelFilters;

use EloquentFilter\ModelFilter;
use WezomCms\Contacts\Models\Contact;
use WezomCms\Core\Contracts\Filter\FilterListFieldsInterface;
use WezomCms\Core\Filter\FilterField;

/**
 * Class ContactFilter
 * @package WezomCms\Contacts\ModelFilters
 * @mixin Contact
 */
class ContactFilter extends ModelFilter implements FilterListFieldsInterface
{
    /**
     * Generate array with fields
     * @return iterable|FilterField[]
     */
    public function getFields(): iterable
    {
        return [
            FilterField::read(),
            FilterField::makeName(),
            FilterField::make()->name('email')->label(__('cms-contacts::admin.E-mail')),
            FilterField::make()->name('message')->label(__('cms-contacts::admin.Message')),
        ];
    }

    public function name($name)
    {
        $this->whereLike('name', $name);
    }

    public function phone($phone)
    {
        $this->whereRaw(
            'REPLACE(REPLACE(REPLACE(REPLACE(phone, "+", ""), "(", ""), ")", ""), " ", "") LIKE ?',
            '%' . preg_replace('/[^\d]/', '', $phone) . '%'
        );
    }

    public function email($email)
    {
        $this->whereLike('email', $email);
    }

    public function message($message)
    {
        $this->whereLike('message', $message);
    }

    public function read($read)
    {
        $this->where('read', $read);
    }
}
