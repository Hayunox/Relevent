package com.teamX.projetx.User;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;

import com.teamX.projetx.R;
import com.teamX.projetx.Main.MainActivity;

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


        /**
         * create register button listener
         */
        this.register.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(LoginActivity.this, RegisterActivity.class));
            }
        });

        /**
         * create login button listener
         */
        this.login.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                //Toast.makeText(getApplicationContext(), "Switched", Toast.LENGTH_SHORT).show();
                // DataBaseUserInteraction.userLogin(this.nickname.getText().toString(), this.password.getText().toString());
                startActivity(new Intent(LoginActivity.this, MainActivity.class));
            }
        });
    }
}
