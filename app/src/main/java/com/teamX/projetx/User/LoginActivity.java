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

        // create listenners
        this.register.setOnClickListener(this.onClick(new View.OnClickListener()));
    }

    /**
     * On click on action button
     * @param v
     */
    public void onClick(View v) {
        Intent intent = null;
        switch (v.getId()) {
            case R.id.buttonRegister:
                //Toast.makeText(getApplicationContext(), "Stop", Toast.LENGTH_SHORT).show();
                intent = new Intent(LoginActivity.this, RegisterActivity.class);
                startActivity(intent);
                break;
            case R.id.buttonLogin:
                //Toast.makeText(getApplicationContext(), "Switched", Toast.LENGTH_SHORT).show();
                // DataBaseUserInteraction.userLogin(this.nickname.getText().toString(), this.password.getText().toString());
                intent = new Intent(LoginActivity.this, MainActivity.class);
                startActivity(intent);
                break;
            default:
                break;
        }
    }

}
