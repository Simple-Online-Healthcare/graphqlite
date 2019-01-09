<?php


namespace TheCodingMachine\GraphQL\Controllers\Fixtures\Integration\Controllers;


use Porpaginas\Arrays\ArrayResult;
use Psr\Http\Message\UploadedFileInterface;
use TheCodingMachine\GraphQL\Controllers\Annotations\Mutation;
use TheCodingMachine\GraphQL\Controllers\Annotations\Query;
use TheCodingMachine\GraphQL\Controllers\Fixtures\Integration\Models\Contact;
use TheCodingMachine\GraphQL\Controllers\Fixtures\Integration\Models\User;

class ContactController
{
    /**
     * @Query()
     * @return Contact[]
     */
    public function getContacts(): array
    {
        return [
            new Contact('Joe'),
            new User('Bill', 'bill@example.com'),
        ];
    }

    /**
     * @Mutation()
     * @param Contact $contact
     * @return Contact
     */
    public function saveContact(Contact $contact): Contact
    {
        return $contact;
    }

    /**
     * @Query()
     * @return Contact[]
     */
    public function getContactsIterator(): ArrayResult
    {
        return new ArrayResult([
            new Contact('Joe'),
            new User('Bill', 'bill@example.com'),
        ]);
    }
}
