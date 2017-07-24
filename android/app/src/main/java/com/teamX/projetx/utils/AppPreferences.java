package com.teamX.projetx.utils;

import android.app.Activity;
import android.content.Context;
import android.content.SharedPreferences;

import com.google.gson.Gson;
import com.teamX.projetx.user.User;

/**
 * Created by Paul on 24/07/2017.
 */

public class AppPreferences {
    public static final String KEY_PREFS_USER_DATA= "user_data";
    private static final String APP_SHARED_PREFS = AppPreferences.class.getSimpleName(); //  Name of the file -.xml
    private SharedPreferences _sharedPrefs;
    private SharedPreferences.Editor _prefsEditor;

    public AppPreferences(Context context) {
        this._sharedPrefs = context.getSharedPreferences(APP_SHARED_PREFS, Activity.MODE_PRIVATE);
        this._prefsEditor = _sharedPrefs.edit();
    }

    public User getUserData() {
        String userObject = _sharedPrefs.getString(KEY_PREFS_USER_DATA, "");
        return (new Gson()).fromJson(userObject, User.class);
    }

    public void saveUserData(User user) {
        _prefsEditor.putString(KEY_PREFS_USER_DATA, (new Gson()).toJson(user));
        _prefsEditor.commit();
    }
}
