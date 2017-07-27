<?php

namespace server\database;

class DBUserContact
{
    private $user_id;
    private $new_contact_user_id;
    private $time;
    private $status_time;
    private $status;

    private $user_contact_table = 'user_contact';

    private $table_row = [
        'contact_id'                    => 'id',
        'contact_user_id'               => 'user_id',
        'contact_new_contact_user_id'   => 'new_contact_user_id',
        'contact_time'                  => 'contact_time',
        'contact_status_time'           => 'status_time',
        'contact_status'                => 'status',
    ];

    /**
     * DBUserContact constructor.
     *
     * @param $user_id
     */
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @param DBConnection $db
     * @param $new_contact_user_id
     *
     * @return array|string
     */
    public function createContact(DBConnection $db, $new_contact_user_id)
    {
        $data = [
            $this->table_row['contact_user_id']               => $this->user_id,
            $this->table_row['contact_new_contact_user_id']   => $new_contact_user_id,
            $this->table_row['contact_time']                  => time(),
            $this->table_row['contact_status_time']           => time(),
            $this->table_row['contact_status']                => UserContactAcceptation::Pending,
        ];

        // return new contact id
        return $db->getQueryBuilderHandler()->table($this->user_contact_table)->insert($data);
    }

    /**
     * @param DBConnection $db
     * @param $user_id
     *
     * @return bool
     */
    public function isContact(DBConnection $db, $user_id)
    {
        $this->new_contact_user_id = $user_id;
        $query = $db->getQueryBuilderHandler()->table($this->user_contact_table)
            ->select($this->table_row['contact_status'])
            ->where(function ($q) {
                $q->where($this->table_row['contact_user_id'], $this->new_contact_user_id);
                $q->where($this->table_row['contact_new_contact_user_id'], $this->user_id);
            })
            ->orWhere(function ($q) {
                $q->where($this->table_row['contact_new_contact_user_id'], $this->new_contact_user_id);
                $q->where($this->table_row['contact_user_id'], $this->user_id);
            });

        $result = $query->first();

        return ($result == null) ? false : $result->{$this->table_row['contact_status']};
    }

    /**
     * @param DBConnection $db
     *
     * @return null|\stdClass
     */
    public function getUserContacts(DBConnection $db)
    {
        $query = $db->getQueryBuilderHandler()->table($this->user_contact_table)
            ->where($this->table_row['contact_status'], UserContactAcceptation::Accepted)
            ->where($this->table_row['contact_user_id'], $this->user_id)
            ->orWhere($this->table_row['contact_new_contact_user_id'], $this->user_id);

        return $query->get();
    }

    /**
     * @param DBConnection $db
     * @param $user_new_contact_id
     * @param $status
     */
    public function setContactAcceptation(DBConnection $db, $user_new_contact_id, $status)
    {
        $this->new_contact_user_id = $user_new_contact_id;
        $db->getQueryBuilderHandler()->table($this->user_contact_table)
            ->where(function ($q) {
                $q->where($this->table_row['contact_user_id'], $this->new_contact_user_id);
                $q->where($this->table_row['contact_new_contact_user_id'], $this->user_id);
            })
            ->orWhere(function ($q) {
                $q->where($this->table_row['contact_new_contact_user_id'], $this->new_contact_user_id);
                $q->where($this->table_row['contact_user_id'], $this->user_id);
            })
            ->update([
                $this->table_row['contact_status']      => $status,
                $this->table_row['contact_status_time'] => time(),
            ]);
    }
}

abstract class UserContactAcceptation
{
    const Pending = 0;
    const Accepted = 1;
    const Refused = 2;
}
