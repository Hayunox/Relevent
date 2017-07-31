package com.teamX.projetx.user;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.view.Window;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

import com.teamX.projetx.R;
import com.teamX.projetx.database.DataBase;
import com.teamX.projetx.database.UserService;
import com.teamX.projetx.main.MainActivity;
import com.teamX.projetx.utils.AppPreferences;

import java.io.IOException;

import retrofit2.Call;
import retrofit2.Response;
import retrofit2.Retrofit;

/**
 * A login screen that offers login via email/password.
 */
public class LoginActivity extends AppCompatActivity {

    private Button register;
    private Button login;
    private EditText nickname;
    private EditText password;
    private ProgressBar progressBar;
    private TextView errorText;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        setContentView(R.layout.activity_login);

        // set up the interfacte
        this.register       = (Button) findViewById(R.id.buttonUserLoginRegister);
        this.login          = (Button) findViewById(R.id.buttonUserLogin);
        this.nickname       = (EditText) findViewById(R.id.editTextUserLoginNickname);
        this.password       = (EditText) findViewById(R.id.editTextUserLoginPassword);
        this.errorText      = (TextView) findViewById(R.id.textViewUserLoginError);
        this.progressBar    = (ProgressBar) findViewById(R.id.progressBarUserLogin);


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
                progressBar.setVisibility(View.VISIBLE);

                if(checkUserLoginField()){
                    Retrofit restService = DataBase.getRetrofitService();
                    UserService service = restService.create(UserService.class);
                    Call<User> call = service.userLogin(nickname.getText().toString(), password.getText().toString());

                    call.enqueue(new retrofit2.Callback<User>() {
                        @Override
                        public void onResponse(Call<User> call, Response<User> response) {
                            System.out.println(response.body());
                            if(response.isSuccessful()){
                                User connectedUser = response.body();

                                // set user session data
                                AppPreferences appPreferences = new AppPreferences(getBaseContext());
                                appPreferences.saveUserData(connectedUser);

                                Toast.makeText(getApplicationContext(), "Connected", Toast.LENGTH_SHORT).show();
                                startActivity((new Intent(LoginActivity.this, MainActivity.class)));
                            }else{
                                try {
                                    // TODO : refactor
                                    switch(response.errorBody().string().replace("\"", "")){
                                        case "USER_LOGIN_FAILED":
                                            errorText.setText(R.string.rest_user_login_failed);
                                            break;
                                        default: errorText.setText(R.string.rest_user_login_error);
                                            break;
                                    }
                                } catch (IOException e) {
                                    e.printStackTrace();
                                }
                            }
                        }

                        @Override
                        public void onFailure(Call<User> call, Throwable t) {
                            t.printStackTrace();
                            errorText.setText(R.string.rest_connection_failed);
                        }
                    });
                }
                progressBar.setVisibility(View.INVISIBLE);
            }
        });
    }

    /**
     *
     * @return
     */
    private boolean checkUserLoginField(){
        // Todo : more security check
        if(this.nickname.getText().toString().isEmpty() || this.password.getText().toString().isEmpty()){
            this.errorText.setText(R.string.rest_user_login_field_empty);
            return false;
        }
        return true;
    }
}
