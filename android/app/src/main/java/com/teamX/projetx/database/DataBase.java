package com.teamX.projetx.database;

import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

;

/**
 * Created by Paul on 14/07/2017.
 */

public class DataBase {
    private static final String serverUrl = "http://192.168.2.82:8080/projetX/index.php/";

    public static Retrofit getRetrofitService(){
        return new Retrofit.Builder()
                .baseUrl(serverUrl)
                .addConverterFactory(GsonConverterFactory.create())
                .build();
    }
}
