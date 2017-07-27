package com.teamX.projetx.event;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.widget.TextView;
import android.widget.Toast;

import com.google.gson.Gson;
import com.teamX.projetx.R;
import com.teamX.projetx.database.DataBase;
import com.teamX.projetx.database.UserService;
import com.teamX.projetx.user.User;
import com.teamX.projetx.utils.AppPreferences;

import retrofit2.Call;
import retrofit2.Response;
import retrofit2.Retrofit;

public class EventDescriptionActivity extends AppCompatActivity {

    private TextView name;
    private TextView address;
    private TextView creationTime;
    private TextView date;
    private TextView description;
    private TextView owner;
    private TextView theme;
    private Event eventData;
    private User user;
    private User ownerData;

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

        // user data
        AppPreferences appPreferences = new AppPreferences(getBaseContext());
        this.user = appPreferences.getUserData();

        // get owner data
        getUserOwnEventData(this.eventData.getOwner());

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
        this.date.append(String.valueOf(this.eventData.getDate()));
        this.description.append(this.eventData.getDescription());
        this.theme.append(this.eventData.getTheme());
    }

    /**
     *
     * @param owner_id
     */
    private void getUserOwnEventData(Integer owner_id) {
        //progressBar.setVisibility(View.VISIBLE);
        Retrofit restService = DataBase.getRetrofitService();
        UserService service = restService.create(UserService.class);
        Call<User> call = service.userGetDataById(this.user.getKey(), owner_id);

        call.enqueue(new retrofit2.Callback<User>() {
            @Override
            public void onResponse(Call<User> call, Response<User> response) {
                if (response.isSuccessful()) {
                    owner.append(response.body().getNickname());
                }
            }

            @Override
            public void onFailure(Call<User> call, Throwable t) {
                t.printStackTrace();
                Toast.makeText(getBaseContext(), "Connection failed", Toast.LENGTH_SHORT).show();
            }
        });
        //progressBar.setVisibility(View.INVISIBLE);
    }
}
