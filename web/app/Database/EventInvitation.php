<?php

namespace App\Database;

use Illuminate\Support\Facades\DB;

class EventInvitation
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
        'invit_time'              => 'invit_time',
        'invit_status_time'       => 'status_time',
        'invit_status'            => 'status',
    ];

    /**
     * DBEventInvitation constructor.
     *
     * @param $user_id
     * @param $event_id
     */
    public function __construct($user_id, $event_id)
    {
        $this->user_id = $user_id;
        $this->event_id = $event_id;
    }

    /**
     * @param $guest_user_id
     *
     * @return array|string
     */
    public function createInvitation($guest_user_id)
    {
        // return new contact id
        return DB::table($this->event_invitation_table)
            ->insert([
                $this->table_row['invit_user_id']               => $this->user_id,
                $this->table_row['invit_event_id']              => $this->event_id,
                $this->table_row['invit_guest_user_id']         => $guest_user_id,
                $this->table_row['invit_time']                  => time(),
                $this->table_row['invit_status_time']           => time(),
                $this->table_row['invit_status']                => EventInvitationAcceptation::Pending,
            ]);
    }

    /**
     * @param $user_id
     *
     * @return bool
     */
    public function isInvited($user_id)
    {
        $this->guest_user_id = $user_id;
        $result = DB::table($this->event_invitation_table)
            ->where($this->table_row['invit_guest_user_id'], $this->guest_user_id)
            ->where($this->table_row['invit_event_id'], $this->event_id)
            ->first();

        return ($result == null) ? false : $result->{$this->table_row['invit_status']};
    }

    /**
     * @return null|\stdClass
     */
    public function getUserInvited()
    {
        return DB::table($this->event_invitation_table)
            ->where($this->table_row['invit_status'], EventInvitationAcceptation::Accepted)
            ->where($this->table_row['invit_guest_user_id'], $this->user_id)
            ->get();
    }

    /**
     * @param $status
     */
    public function setInvitationAcceptation($status)
    {
        DB::table($this->event_invitation_table)
            ->where($this->table_row['invit_event_id'], $this->event_id)
            ->update([
                $this->table_row['invit_status']      => $status,
                $this->table_row['invit_status_time'] => time(),
            ]);
    }
}

abstract class EventInvitationAcceptation
{
    const Pending = 2;
    const Accepted = 3;
    const Refused = 4;
}
