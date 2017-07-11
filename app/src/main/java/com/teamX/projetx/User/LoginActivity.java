package com.teamX.projetx.User;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;


import com.t.projetx.R;
import com.teamX.projetx.DataBase.DataBaseInteraction;
import com.teamX.projetx.Main.SplashScreenActivity;

/**
 * A login screen that offers login via email/password.
 */
public class LoginActivity extends AppCompatActivity {

    private Button register;
    private Button login;
    private EditText nickname;
    private EditText password;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        // set up the interfacte
        this.register   = (Button) findViewById(R.id.buttonRegister);
        this.login      = (Button) findViewById(R.id.buttonLogin);
        this.nickname   = (EditText) findViewById(R.id.editTextNickname);
        this.password   = (EditText) findViewById(R.id.editTextPassword);


        // On register click
        this.register.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent i = new Intent(LoginActivity.this, RegisterActivity.class);
                startActivity(i);
            }
        });
    }
}
