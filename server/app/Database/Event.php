<?php

namespace App\Database;

use Illuminate\Support\Facades\DB;

class Event
{
    public $event_id;
    private $event_user_id;
    private $event_name;
    private $event_description;
    private $event_creation_time;
    private $event_address;
    private $event_date;
    private $event_theme;
    private $event_secret;

    private $event_table = 'event';

    private $table_row = [
        'event_id'              => 'id',
        'event_user_id'         => 'user_id',
        'event_name'            => 'name',
        'event_description'     => 'description',
        'event_creation_time'   => 'creation_time',
        'event_address'         => 'address',
        'event_date'            => 'event_date',
        'event_theme'           => 'theme',
        'event_secret'          => 'secret',
    ];

    /**
     * Event constructor.
     *
     * @param $event_id
     */
    public function __construct($event_id)
    {
        $this->event_id = $event_id;
    }

    /**
     * @return array
     */
    public function getEventData()
    {
        $event_data = DB::table($this->event_table)->where($this->table_row['event_id'], $this->event_id)->first();

        if ($event_data != null) {
            $this->event_user_id = $event_data->{$this->table_row['event_user_id']};
            $this->event_name = $event_data->{$this->table_row['event_name']};
            $this->event_description = $event_data->{$this->table_row['event_description']};
            $this->event_creation_time = $event_data->{$this->table_row['event_creation_time']};
            $this->event_address = $event_data->{$this->table_row['event_address']};
            $this->event_date = $event_data->{$this->table_row['event_date']};
            $this->event_theme = $event_data->{$this->table_row['event_theme']};
            $this->event_secret = $event_data->{$this->table_row['event_secret']};
        }
        return $this->eventDbToArray();
    }

    /**
     * @param $eventArray
     */
    public function eventCreate($eventArray)
    {
        // return new event_id
        DB::table($this->event_table)
            ->insert([
                $this->table_row['event_user_id']         => $eventArray['event_user_id'],
                $this->table_row['event_name']            => $eventArray['event_name'],
                $this->table_row['event_description']     => $eventArray['event_description'],
                $this->table_row['event_address']         => $eventArray['event_address'],
                $this->table_row['event_date']            => $eventArray['event_date'],
                $this->table_row['event_theme']           => $eventArray['event_theme'],
                $this->table_row['event_secret']          => $eventArray['event_secret'],
                $this->table_row['event_creation_time']   => time(),
            ]);
    }

    /**
     * @param $user_id
     *
     * @return null|\stdClass
     */
    public function eventUserList($user_id)
    {
        return DB::table($this->event_table)
            ->where($this->table_row['event_user_id'], $user_id)
            ->get();
    }

    /**
     * @return array
     */
    public function eventDbToArray()
    {
        return [
            'user_id'           => $this->event_user_id,
            'name'              => $this->event_name,
            'description'       => $this->event_description,
            'creation_time'     => $this->event_creation_time,
            'address'           => $this->event_address,
            'date'              => $this->event_date,
            'theme'             => $this->event_theme,
            'secret'            => $this->event_secret,
        ];
    }
}
