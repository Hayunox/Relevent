package com.teamX.projetx.user;

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

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register);

        // set up the interface
        this.register       = (Button) findViewById(R.id.buttonRegister);
        this.nickname       = (EditText) findViewById(R.id.editTextNickname);
        this.mail           = (EditText) findViewById(R.id.editTextMail);
        this.password       = (EditText) findViewById(R.id.editTextPassword);
        this.errorText      = (TextView) findViewById(R.id.textViewErrorRegister);
        this.progressBar    = (ProgressBar) findViewById(R.id.progressBarRegister);


        // On register click
        this.register.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                progressBar.setVisibility(View.VISIBLE);

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
                                switch (response.errorBody().string()) {
                                    case "\"USER_CREATE_FAILED\"":
                                        errorText.setText(R.string.rest_register_failed);
                                        break;
                                    case "\"USER_NICKNAME_EXISTS\"":
                                        errorText.setText(R.string.rest_register_nickname_exists);
                                        break;
                                    case "\"USER_MAIL_EXISTS\"":
                                        errorText.setText(R.string.rest_register_mail_exists);
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
                        Toast.makeText(getApplicationContext(), "Connection failed", Toast.LENGTH_SHORT).show();
                    }
                });
                progressBar.setVisibility(View.INVISIBLE);
            }
        });
    }
}
