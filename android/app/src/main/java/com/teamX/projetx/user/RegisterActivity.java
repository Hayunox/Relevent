package com.teamX.projetx.user;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.View;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

import com.teamX.projetx.R;
import com.teamX.projetx.database.DataBase;
import com.teamX.projetx.database.UserService;

import java.io.IOException;

import retrofit2.Call;
import retrofit2.Response;
import retrofit2.Retrofit;

public class RegisterActivity extends AppCompatActivity {

    private Button register;
    private EditText nickname;
    private EditText mail;
    private EditText password;
    private ProgressBar progressBar;
    private TextView errorText;
    private CheckBox checkBoxRules;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register);
        Toolbar toolbar = (Toolbar)findViewById(R.id.toolbarUserRegister);
        setSupportActionBar(toolbar);
        if(getSupportActionBar() != null)
            getSupportActionBar().setDisplayHomeAsUpEnabled(true);

        // set up the interface
        this.register       = (Button) findViewById(R.id.buttonUserRegistrationRegister);
        this.nickname       = (EditText) findViewById(R.id.editTextUserRegistrationNickname);
        this.mail           = (EditText) findViewById(R.id.editTextUserRegistrationMail);
        this.password       = (EditText) findViewById(R.id.editTextUserRegistrationPassword);
        this.errorText      = (TextView) findViewById(R.id.textViewUserRegistrationError);
        this.progressBar    = (ProgressBar) findViewById(R.id.progressBarUserRegistration);
        this.checkBoxRules  = (CheckBox) findViewById(R.id.checkBoxUserRegistrationRules);

        // On register click
        this.register.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                progressBar.setVisibility(View.VISIBLE);
                register.setEnabled(false);
                if(checkUserRegistrationField()){
                    Retrofit restService = DataBase.getRetrofitService();
                    UserService service = restService.create(UserService.class);
                    Call<String> call = service.userRegister(nickname.getText().toString(), mail.getText().toString(), password.getText().toString());

                    call.enqueue(new retrofit2.Callback<String>() {
                        @Override
                        public void onResponse(Call<String> call, Response<String> response) {
                            if (response.isSuccessful()) {
                                Toast.makeText(getApplicationContext(), "Registred", Toast.LENGTH_SHORT).show();
                                startActivity(new Intent(RegisterActivity.this, LoginActivity.class));
                            } else {
                                try {
                                    // TODO : refactor
                                    switch (response.errorBody().string().replace("\"", "")) {
                                        case "USER_CREATE_FAILED":
                                            errorText.setText(R.string.rest_user_registration_failed);
                                            break;
                                        case "USER_NICKNAME_EXISTS":
                                            errorText.setText(R.string.rest_user_registration_nickname_exists);
                                            break;
                                        case "USER_MAIL_EXISTS":
                                            errorText.setText(R.string.rest_user_registration_mail_exists);
                                            break;
                                        default: errorText.setText(R.string.rest_user_registration_error);
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
                register.setEnabled(true);
                progressBar.setVisibility(View.INVISIBLE);
            }
        });
    }

    private boolean checkUserRegistrationField(){
        // Todo : more security check
        if(this.nickname.getText().toString().isEmpty() || this.mail.getText().toString().isEmpty() || this.password.getText().toString().isEmpty() || !this.checkBoxRules.isChecked()){
            this.errorText.setText(R.string.rest_user_registration_field_empty);
            return false;
        }
        return true;
    }
}
