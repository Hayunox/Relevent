<?php

namespace server\database;

class DBEventInvitation
{
    private $user_id;
    private $guest_user_id;
    private $time;
    private $status_time;
    private $status;
    private $event_id;

    private $event_invitation_table = 'event_invit';

    private $table_row = [
        'invit_id'                => 'id',
        'invit_user_id'           => 'user_id',
        'invit_event_id'          => 'event_id',
        'invit_guest_user_id'     => 'guest_user_id',
        'invit_time'              => 'time',
        'invit_status_time'       => 'status_time',
        'invit_status'            => 'status',
    ];

    /**
     * DBEventInvitation constructor.
     * @param $user_id
     * @param $event_id
     */
    public function __construct($user_id, $event_id)
    {
        $this->user_id  = $user_id;
        $this->event_id = $event_id;
    }

    /**
     * @param DBConnection $db
     * @param $guest_user_id
     * @return array|string
     */
    public function createInvitation(DBConnection $db, $guest_user_id)
    {
        $data = [
            $this->table_row['invit_user_id']               => $this->user_id,
            $this->table_row['invit_event_id']              => $this->event_id,
            $this->table_row['invit_guest_user_id']         => $guest_user_id,
            $this->table_row['invit_time']                  => time(),
            $this->table_row['invit_status_time']           => time(),
            $this->table_row['invit_status']                => EventInvitationAcceptation::Pending,
        ];

        // return new contact id
        return $db->getQueryBuilderHandler()->table($this->event_invitation_table)->insert($data);
    }

    /**
     * @param DBConnection $db
     * @param $user_id
     * @return bool
     */
    public function isInvited(DBConnection $db, $user_id){
        $this->guest_user_id = $user_id;
        $query = $db->getQueryBuilderHandler()->table($this->event_invitation_table)
            ->select($this->table_row['invit_status'])
            ->where($this->table_row['invit_guest_user_id'], $this->guest_user_id)
            ->where($this->table_row['invit_event_id'], $this->event_id);

        $result = $query->first();
        return ($result == null) ? false : $result->{$this->table_row['invit_status']};
    }

    /**
     * @param DBConnection $db
     * @return null|\stdClass
     */
    public function getUserInvited(DBConnection $db){
        $query = $db->getQueryBuilderHandler()->table($this->event_invitation_table)
            ->where($this->table_row['invit_status'], EventInvitationAcceptation::Accepted)
            ->where($this->table_row['invit_guest_user_id'], $this->user_id);
        return $query->get();
    }

    /**
     * @param DBConnection $db
     * @param $guest_user_id
     * @param $event_id
     * @param $status
     */
    public function setInvitationAcceptation(DBConnection $db, $guest_user_id, $event_id, $status)
    {
        $this->guest_user_id    = $guest_user_id;
        $this->event_id         = $event_id;
        $db->getQueryBuilderHandler()->table($this->event_invitation_table)
            ->where($this->table_row['invit_event_id'], $this->event_id)
            ->where($this->table_row['invit_guest_user_id'], $this->guest_user_id)
            ->update(array(
                $this->table_row['invit_status'] => $status,
                $this->table_row['invit_status_time'] => time(),
            ));
    }
}

abstract class EventInvitationAcceptation
{
    const Pending   = 0;
    const Accepted  = 1;
    const Refused   = 2;
}