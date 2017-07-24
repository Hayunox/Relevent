package com.teamX.projetx.event;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.widget.TextView;

import com.google.gson.Gson;
import com.teamX.projetx.R;

public class EventDescriptionActivity extends AppCompatActivity {

    private TextView name;
    private TextView address;
    private TextView creationTime;
    private TextView date;
    private TextView description;
    private TextView owner;
    private TextView theme;
    private Event eventData;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_event_description);

        /**
         * Get event data
         */
        Intent intent       = getIntent();
        String eventString  = intent.getStringExtra("event");
        this.eventData      = (new Gson()).fromJson(eventString, Event.class);

        /**
         * Interface
         */
        this.name           = (TextView) findViewById(R.id.event_description_textView_Name);
        this.address        = (TextView) findViewById(R.id.event_description_textView_address);
        this.creationTime   = (TextView) findViewById(R.id.event_description_textView_creation_date);
        this.date           = (TextView) findViewById(R.id.event_description_textView_date);
        this.description    = (TextView) findViewById(R.id.event_description_textView_description);
        this.owner          = (TextView) findViewById(R.id.event_description_textView_owner);
        this.theme          = (TextView) findViewById(R.id.event_description_textView_theme);

        /**
         * Set date on interface
         */
        this.name.append(this.eventData.getName());
        this.address.append(this.eventData.getAddress());
        this.creationTime.append(this.eventData.getCreationTime().toString());
        this.date.append(this.eventData.getDate().toString());
        this.description.append(this.eventData.getDescription());
        this.owner.append("");
        this.theme.append(this.eventData.getTheme());
    }
}
