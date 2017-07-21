package com.teamX.projetx.utils;

import android.content.Intent;
import android.os.Bundle;

/**
 * Created by Paul on 20/07/2017.
 */

public class IntentBundle {

    public static String getExtraParam(Bundle savedInstanceState, Intent intent, String param){
        String result = null;

        // get Extra
        if (savedInstanceState == null) {
            Bundle extras = intent.getExtras();
            if(extras != null && extras.getString(param) != null) {
                result = extras.getString(param);
            }
        } else {
            result = (String) savedInstanceState.getSerializable(param);
        }

        return result;
    }
}
