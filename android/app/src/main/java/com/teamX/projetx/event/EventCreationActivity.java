package com.teamX.projetx.event;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

import com.teamX.projetx.R;
import com.teamX.projetx.database.DataBase;
import com.teamX.projetx.database.EventService;
import com.teamX.projetx.main.MainActivity;
import com.teamX.projetx.user.User;
import com.teamX.projetx.utils.AppPreferences;

import java.io.IOException;

import retrofit2.Call;
import retrofit2.Response;
import retrofit2.Retrofit;

public class EventCreationActivity extends AppCompatActivity {

    private EditText description;
    private EditText name;
    private EditText date;
    private EditText address;
    private EditText theme;
    private Button buttonCreate;
    private ProgressBar progressBar;
    private TextView errorText;
    private User user;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_event_creation);

        /**
         * Data
         */
        // user data
        AppPreferences appPreferences = new AppPreferences(getBaseContext());
        this.user = appPreferences.getUserData();

        // set up the interface
        this.name               = (EditText) findViewById(R.id.editTextEventCreationName);
        this.description        = (EditText) findViewById(R.id.editTextEventCreationDescription);
        this.date               = (EditText) findViewById(R.id.editTextEventCreationDate);
        this.address            = (EditText) findViewById(R.id.editTextEventCreationAddress);
        this.theme              = (EditText) findViewById(R.id.editTextEventCreationTheme);
        this.buttonCreate       = (Button) findViewById(R.id.buttonEventCreationCreate);
        this.progressBar        = (ProgressBar) findViewById(R.id.progressBarEventCreation);
        this.errorText          = (TextView) findViewById(R.id.textViewEventCreationError);

        // On register click
        this.buttonCreate.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                progressBar.setVisibility(View.VISIBLE);

                if(checkUserRegistrationField()){
                    Retrofit restService = DataBase.getRetrofitService();
                    EventService service = restService.create(EventService.class);
                    Call<String> call = service.eventCreation(user.getKey(), name.getText().toString(), description.getText().toString(), date.getText().toString(), address.getText().toString(), theme.getText().toString());

                    call.enqueue(new retrofit2.Callback<String>() {
                        @Override
                        public void onResponse(Call<String> call, Response<String> response) {
                            if (response.isSuccessful()) {
                                Toast.makeText(getApplicationContext(), "Event Created", Toast.LENGTH_SHORT).show();
                                startActivity(new Intent(EventCreationActivity.this, MainActivity.class));
                            } else {
                                try {
                                    System.out.println("ERROR = " + response.errorBody().string());
                                    // TODO : refactor
                                    switch (response.errorBody().string().replace("\"", "")) {
                                       default:
                                            errorText.setText(R.string.rest_event_creation_failed);
                                            break;
                                    }
                                } catch (IOException e) {
                                    e.printStackTrace();
                                }
                            }
                        }

                        @Override
                        public void onFailure(Call<String> call, Throwable t) {
                            t.printStackTrace();
                            errorText.setText(R.string.rest_connection_failed);
                        }
                    });
                }
                progressBar.setVisibility(View.INVISIBLE);
            }
        });
    }

    private boolean checkUserRegistrationField(){
        // Todo : more security check
        if(this.name.getText().toString().isEmpty() || this.description.getText().toString().isEmpty() || this.date.getText().toString().isEmpty()){
            this.errorText.setText(R.string.rest_event_creation_field_empty);
            return false;
        }
        return true;
    }

}
