package com.teamX.projetx.user;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;

import com.teamX.projetx.R;
import com.teamX.projetx.database.DataBaseUserInteraction;

public class RegisterActivity extends AppCompatActivity {

    private Button register;
    private EditText nickname;
    private EditText mail;
    private EditText password;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register);

        // set up the interfacte
        this.register   = (Button) findViewById(R.id.buttonRegister);
        this.nickname   = (EditText) findViewById(R.id.editTextNickname);
        this.mail       = (EditText) findViewById(R.id.editTextMail);
        this.password   = (EditText) findViewById(R.id.editTextPassword);


        // On register click
        this.register.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                DataBaseUserInteraction.userRegister(nickname.getText().toString(), mail.getText().toString(), password.getText().toString());
            }
        });
    }
}
