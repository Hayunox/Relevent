package com.teamX.projetx.main;

import android.Manifest;
import android.app.Activity;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.os.Bundle;
import android.os.Handler;
import android.support.v4.app.ActivityCompat;

import com.teamX.projetx.R;
import com.teamX.projetx.user.LoginActivity;

public class SplashScreenActivity extends Activity {

    // Splash screen timer
    private static int SPLASH_TIME_OUT = 1000;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_splash_screen);
        if (ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
        }

        //LocationManager locationManager = (LocationManager) this.getSystemService(this.getApplicationContext().LOCATION_SERVICE);
        //Localization loc = new Localization(locationManager);

        new Handler().postDelayed(new Runnable() {

            /*
             * Showing splash screen with a timer. This will be useful when you
             * want to show case your app logo / company
             */

            @Override
            public void run() {

                /**
                 * User already connected
                 */
                /*try{
                    AppPreferences appPreferences = new AppPreferences(getBaseContext());
                    appPreferences.getUserData();
                    Intent i = new Intent(SplashScreenActivity.this, MainActivity.class);
                    startActivity(i);
                }catch (Exception e){*/
                    Intent i = new Intent(SplashScreenActivity.this, LoginActivity.class);
                    startActivity(i);
                //}

                // close this activity
                finish();
            }
        }, SPLASH_TIME_OUT);
    }

}